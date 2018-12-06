<?php

namespace App\Support;

use Illuminate\Http\Request;

final class QueryFilter
{
    /** @var string */
    private $url;

    /** @var array */
    private $query = [];

    public function __construct(Request $request)
    {
        $query = parse_url($request->getUri(), PHP_URL_QUERY) ?? '';

        $queryParts = explode('&', $query);

        foreach ($queryParts as $queryPart) {
            if (strpos($query, '=')) {
                [$name, $value] = explode('=', $queryPart);
            } else {
                $name = $queryPart;
                $value = null;
            }

            $this->query[urldecode($name)] = urldecode($value);
        }

        [$url] = explode('?', $request->getUri());

        $this->url = $url;
    }

    public function filter(string $name, Filterable $filterable): string
    {
        $name = $this->resolveName($name);

        if ($this->isActive($name, $filterable)) {
            unset($this->query[$name]);
        } else {
            $this->query[$name] = $filterable->getFilterValue();
        }

        $query = [];

        foreach ($this->query as $key => $value) {
            if ($key === null || $key === '') {
                continue;
            }

            if ($value === null || $value === '') {
                $query[$key] = $key;
            } else {
                $query[$key] = "{$key}={$value}";
            }
        }
        return $this->url . '?' . implode('&', $query);
    }

    public function isActive(string $name, Filterable $filterable): bool
    {
        $name = $this->resolveName($name);

        return ($this->query[$name] ?? null) === $filterable->getFilterValue();
    }

    private function resolveName(string $name): string
    {
        if (strpos($name, 'filter[') !== 0) {
            $name = "filter[{$name}]";
        }

        return $name;
    }
}
