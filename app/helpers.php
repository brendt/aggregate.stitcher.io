<?php

use App\Support\Filterable;
use Domain\User\Models\User;
use Faker\Factory;
use Faker\Generator;
use Spatie\QueryString\QueryString;

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

function filter(string $name, Filterable $filterable = null): QueryString
{
    $queryFilter = app(QueryString::class);

    return $queryFilter
        ->disable('page')
        ->filter(
            $name,
            $filterable ? $filterable->getFilterValue() : null
        );
}

function filter_active(string $name, Filterable $filterable = null): bool
{
    $queryFilter = app(QueryString::class);

    return $queryFilter->isActive(
        $queryFilter->resolveFilterName($name),
        $filterable ? $filterable->getFilterValue() : null
    );
}

function clear_filter(string $name): string
{
    $queryFilter = app(QueryString::class);

    return $queryFilter->clear($name);
}
