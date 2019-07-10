<?php

namespace Domain\Language;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class LanguageRepository
{
    /** @var \Domain\Language\Language[]|\Illuminate\Support\Collection */
    private $languages;

    public function __construct(string $path)
    {
        /** @var \Illuminate\Support\Collection $contents */
        $this->languages = Cache::remember("languages:{$path}", 60 * 24, function () use ($path) {
            return collect(json_decode(file_get_contents($path), true))
                ->mapWithKeys(function (array $data, string $code) {
                    return [$code => new Language($code, $data['name'], $data['native'])];
                });
        });
    }

    public function all(): Collection
    {
        return $this->languages;
    }

    public function find(string $code): ?Language
    {
        return $this->languages[$code] ?? null;
    }

    public function has(string $code): bool
    {
        return $this->find($code) !== null;
    }
}
