<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FuzzyFilter implements Filter
{
    /** @var string[] */
    protected $fields;

    public function __construct(string ...$fields)
    {
        $this->fields = $fields;
    }

    public function __invoke(Builder $builder, $values, string $property): Builder
    {
        $builder->where(function (Builder $builder) use ($values) {
            foreach ($this->fields as $field) {
                $values = (array) $values;

                foreach ($values as $value) {
                    $builder->orWhere($field, 'LIKE', "%{$value}%");
                }
            }
        });

        return $builder;
    }
}
