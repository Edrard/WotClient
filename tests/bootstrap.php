<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

// Until the three unpublished major versions are tagged, use sibling checkout sources.
spl_autoload_register(static function (string $class): void {
    foreach ([
        'edrard\\WgApi\\' => __DIR__.'/../../WgApi/src/WgApi/',
        'edrard\\WgGetter\\' => __DIR__.'/../../WgDataGetter/src/WgGetter/',
    ] as $prefix => $directory) {
        if (str_starts_with($class, $prefix)) {
            $path = $directory.str_replace('\\', '/', substr($class, strlen($prefix))).'.php';
            if (is_file($path)) {
                require $path;
            }
            return;
        }
    }
}, prepend: true);
