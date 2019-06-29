<?php

namespace Domain\Source\DTO;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

final class LanguageRepository
{
    /** @var Language[] */
    private $languages;

    /**
     * LanguageRepository constructor.
     * @param string $path
     * @throws Exception
     */
    public function __construct(string $path)
    {
        $contents = Cache::remember("languages_contents:{$path}", 60 * 24, function () use ($path) {
            return @file_get_contents($path);
        });

        if (! $contents) {
            throw new Exception('Languages file not found');
        }

        $contents_array = json_decode($contents, true);

        $this->languages = array_map(function (array $language, string $code) {
            return new Language($code, $language['name'], $language['native']);
        }, $contents_array, array_keys($contents_array));
    }

    public function all(): array
    {
        return $this->languages;
    }

    public function find(string $code): ?Language
    {
        return Arr::first($this->languages, function (Language $language) use ($code) {
            return $language->getCode() === $code;
        });
    }

    public function has(string $code): bool
    {
        return $this->find($code) !== null;
    }
}
