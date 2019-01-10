<?php

namespace App\Support;

use Illuminate\Support\Str;

final class QueryFilter
{
    /** @var string */
    private $url;

    /** @var array */
    private $query = [];

    public function __construct(string $uri)
    {
        if (strpos($uri, '?') === false) {
            $uri = "{$uri}?";
        }

        [$url, $query] = explode('?', $uri);

        $this->url = $url;

        $queryParts = explode('&', $query);

        foreach ($queryParts as $queryPart) {
            if (strpos($queryPart, '=') !== false) {
                [$name, $value] = explode('=', $queryPart);
            } else {
                $name = $queryPart;
                $value = null;
            }

            $name = urldecode($name);
            $value = urldecode($value);

            if ($this->isMultiple($name)) {
                $multipleName = $this->resolveName($name);

                $this->query[$multipleName][] = $value;
            } else {
                $this->query[$name] = $value;
            }
        }

        unset($this->query['page']);
    }

    public function isActive(
        string $name,
        ?Filterable $filterable = null
    ): bool {
        $isMultiple = $this->isMultiple($name);

        $name = $this->resolveName($name);

        if ($filterable === null) {
            return isset($this->query[$name]);
        }

        if ($isMultiple) {
            $match = array_search($filterable->getFilterValue(), $this->query[$name] ?? []);

            return $match !== false;
        }

        return ($this->query[$name] ?? null) === $filterable->getFilterValue();
    }

    public function filter(
        string $name,
        ?Filterable $filterable = null
    ): string {
        $isMultiple = $this->isMultiple($name);

        $name = $this->resolveName($name);

        $query = $this->query;

        if (! $filterable) {
            $query = $this->filterWithoutValue($query, $name);
        } else if ($isMultiple) {
            $query = $this->filterMultiple($query, $name, $filterable);
        } else {
            $query = $this->filterSingle($query, $name, $filterable);
        }

        return $this->buildUrl($query);
    }

    public function clear(string $name): string
    {
        $name = $this->resolveName($name);

        $query = $this->query;

        unset($query[$name]);

        return $this->buildUrl($query);
    }

    private function filterWithoutValue(array $query, string $name): array
    {
        if (isset($query[$name])) {
            unset($query[$name]);
        } else {
            $query[$name] = '';
        }

        return $query;
    }

    private function filterSingle(array $query, string $name, Filterable $filterable): array
    {
        if (isset($query[$name]) && $query[$name] === $filterable->getFilterValue()) {
            unset($query[$name]);
        } else {
            $query[$name] = $filterable->getFilterValue();
        }

        return $query;
    }

    private function filterMultiple(array $query, string $name, Filterable $filterable): array
    {
        $filter = $query[$name] ?? [];

        if (! is_array($filter)) {
            $filter = [];
        }

        $filterValue = $filterable->getFilterValue();

        $match = array_search($filterValue, $filter);

        if ($match !== false) {
            unset($filter[$match]);
        } else {
            $filter[] = $filterValue;
        }

        $query[$name] = $filter;

        return $query;
    }

    private function buildUrl(array $query): string
    {
        $newQuery = [];

        foreach ($query as $key => $value) {
            if ($key === null || $key === '') {
                continue;
            }

            if ($value === null || $value === '') {
                $newQuery[] = $key;
            } elseif (is_array($value)) {
                $subQuery = [];

                foreach ($value as $filterValue) {
                    $subQuery[] = "{$key}[]={$filterValue}";
                }

                $newQuery[] = implode('&', $subQuery);
            } else {
                $newQuery[] = "{$key}={$value}";
            }
        }

        return $this->url . '?' . implode('&', $newQuery);
    }

    private function resolveName(string $name): string
    {
        if ($this->isMultiple($name)) {
            $name = Str::replaceLast('[]', '', $name);
        }

        if (strpos($name, 'filter[') !== 0) {
            $name = "filter[{$name}]";
        }

        return $name;
    }

    private function isMultiple(string $name): bool
    {
        return Str::endsWith($name, ['[]']);
    }
}
