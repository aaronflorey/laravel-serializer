<?php

return [
    'facade' => \Mochaka\LaravelSerializer\Facades\LaravelSerializer::class,

    // Optional
    // Path\To\Class::class => [Excluded Methods Array]
    'classes' => [
        \Mochaka\LaravelSerializer\LaravelSerializer::class,
    ],

    // Global Excluded Methods
    'excludedMethods' => [],
];
