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
        $this->languages = Cache::remember("languages:{$path}", 60 * 60 * 24, fn() => collect(json_decode(file_get_contents($path), true))
            ->mapWithKeys(fn(array $data, string $code) => [$code => new Language($code, $data['name'], $data['native'])]));
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
