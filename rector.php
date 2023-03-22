<?php

return static function (\Rector\Config\RectorConfig $config): void {
    $config->import(__DIR__ . '/vendor/buckhamduffy/coding-standards/rector.php');
    $config->paths([
        __DIR__ . '/src/',
        __DIR__ . '/config/',
    ]);
};
