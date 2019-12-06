<?php

require_once __DIR__ . '/vendor/autoload.php';

class Preloader
{
    private array $ignores = [];

    private static int $count = 0;

    private array $paths;

    private array $fileMap;

    public function __construct(string ...$paths)
    {
        $this->paths = $paths;
        $classMap = require __DIR__ . '/vendor/composer/autoload_classmap.php';
        $this->fileMap = array_flip($classMap);
    }

    public function paths(string ...$paths): Preloader
    {
        $this->paths = array_merge(
            $this->paths,
            $paths
        );

        return $this;
    }

    public function ignore(string ...$names): Preloader
    {
        $this->ignores = array_merge(
            $this->ignores,
            $names
        );

        return $this;
    }

    public function load(): void
    {
        foreach ($this->paths as $path) {
            $this->loadPath(rtrim($path, '/'));
        }

        $count = self::$count;

        echo "[Preloader] Preloaded {$count} classes" . PHP_EOL;
    }

    private function loadPath(string $path): void
    {
        if (is_dir($path)) {
            $this->loadDir($path);

            return;
        }

        $this->loadFile($path);
    }

    private function loadDir(string $path): void
    {
        $handle = opendir($path);

        while ($file = readdir($handle)) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $this->loadPath("{$path}/{$file}");
        }

        closedir($handle);
    }

    private function loadFile(string $path): void
    {
        $class = $this->fileMap[$path] ?? null;

        if ($this->shouldIgnore($class)) {
            return;
        }

        require_once($path);

        self::$count++;

        echo "[Preloader] Preloaded `{$class}`" . PHP_EOL;
    }

    private function shouldIgnore(?string $name): bool
    {
        if ($name === null) {
            return true;
        }

        foreach ($this->ignores as $ignore) {
            if (strpos($name, $ignore) === 0) {
                return true;
            }
        }

        return false;
    }
}

(new Preloader())
    ->paths(
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Auth',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Broadcasting',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Cache',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Config',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Container',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Contracts',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Cookie',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Database',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Encryption',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Events',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Filesystem',
//        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Foundation',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Hashing',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Http',
//        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Log',
//        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Mail',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Notifications',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Pagination',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Pipeline',
//        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Queue',
//        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Redis',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Routing',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Session',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Support',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Translation',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Validation',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/View',
    )
    ->ignore(
        \PHPUnit\Framework\TestCase::class,
        \Illuminate\Filesystem\Cache::class,
        \Illuminate\Log\LogManager::class,
        \Illuminate\Http\Testing\File::class,
        \Illuminate\Http\UploadedFile::class,
        \Illuminate\Support\Carbon::class,
        )
    ->load();
