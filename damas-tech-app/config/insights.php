<?php

return [
    'preset' => 'laravel',

    'ide' => 'phpstorm',

    'exclude' => [
        'bootstrap',
        'storage',
        'resources',
        'node_modules',
        'vendor',
        'database',
    ],

    'add' => [
        // Aqui você pode adicionar insights específicos se quiser
    ],

    'remove' => [
        // Exemplo: desabilitar alguns insights muito rígidos para começar mais leve
        NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh::class,
        NunoMaduro\PhpInsights\Domain\Insights\ClassMethodAverageCyclomaticComplexityIsHigh::class,
    ],

    'config' => [
        // Exemplo de configuração extra (opcional)
    ],
];
