<?php

use Domain\User\Models\User;
use Faker\Factory;
use Faker\Generator;
use Spatie\QueryString\QueryString;
use Support\Filterable;
use Illuminate\Support\Facades\Cache;

function locale()
{
    return config('app.locale');
}

function faker(): Generator
{
    return Factory::create();
}

function current_user(): ?User
{
    return Auth::user();
}

/**
 * @param string $name
 * @param \Support\Filterable|string|null $filterValue
 *
 * @return \Spatie\QueryString\QueryString
 */
function filter(string $name, $filterValue = null): QueryString
{
    if ($filterValue instanceof Filterable) {
        $filterValue = $filterValue->getFilterValue();
    }

    $queryString = app(QueryString::class);

    return $queryString
        ->disable('page')
        ->filter($name, $filterValue);
}

/**
 * @param string $name
 * @param \Support\Filterable|string|null $filterValue
 *
 * @return bool
 */
function filter_active(string $name, $filterValue = null): bool
{
    if ($filterValue instanceof Filterable) {
        $filterValue = $filterValue->getFilterValue();
    }

    $queryString = app(QueryString::class);

    return $queryString->isActive(
        $queryString->resolveFilterName($name),
        $filterValue
    );
}

function query_sort(string $value): QueryString
{
    $queryString = app(QueryString::class);

    return $queryString->sort($value);
}

function query_sort_active(string $value): bool
{
    $queryString = app(QueryString::class);

    return $queryString->isActive('sort', $value);
}

function query_string(): QueryString
{
    return app(QueryString::class);
}

function clear_filter(string $name): string
{
    $queryString = app(QueryString::class);

    return $queryString->clear($name);
}

function is_link_active(string $href): bool
{
    $request = app(\Illuminate\Http\Request::class);

    $uriPath = parse_url($request->getUri(), PHP_URL_PATH) ?? '/';

    $hrefPath = parse_url($href, PHP_URL_PATH) ?? '/';

    return  $uriPath === $hrefPath;
}
