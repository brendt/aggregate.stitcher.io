<?php

namespace Domain\Analytics;

use Spatie\DataTransferObject\DataTransferObject;

class PreloadStatus extends DataTransferObject
{
    public int $classes_loaded;

    public int $functions_loaded;

    public string $memory_consumption;

    public static function make(array $opcacheStatus): PreloadStatus
    {
        return new self([
            'classes_loaded' => count($opcacheStatus['preload_statistics']['classes']),
            'functions_loaded' => count($opcacheStatus['preload_statistics']['functions']),
            'memory_consumption' => round($opcacheStatus['preload_statistics']['memory_consumption'] / 1000000, 2) . 'MB',
        ]);
    }
}
