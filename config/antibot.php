<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Habilitar AntiBot
    |--------------------------------------------------------------------------
    |
    | Define si el paquete AntiBot realizará validaciones reales o si hará
    | un bypass (útil para entornos locales o pruebas automatizadas).
    |
    */
    'enabled' => env('ANTIBOT_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Proveedor por Defecto
    |--------------------------------------------------------------------------
    |
    | Define el proveedor AntiBot por defecto.
    | Soportados: "turnstile", "recaptcha_v2", "recaptcha_v3".
    |
    */
    'default' => env('ANTIBOT_DEFAULT', 'turnstile'),

    /*
    |--------------------------------------------------------------------------
    | Configuración de Proveedores
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'turnstile' => [
            'url' => env('TURNSTILE_URL', 'https://challenges.cloudflare.com/turnstile/v0/siteverify'),
            'secret' => env('TURNSTILE_SECRET'),
            'timeout' => (int) env('TURNSTILE_TIMEOUT', 10),
        ],

        'recaptcha_v2' => [
            'url' => env('RECAPTCHA_V2_URL', 'https://www.google.com/recaptcha/api/siteverify'),
            'secret' => env('RECAPTCHA_V2_SECRET'),
            'timeout' => (int) env('RECAPTCHA_V2_TIMEOUT', 10),
        ],

        'recaptcha_v3' => [
            'url' => env('RECAPTCHA_V3_URL', 'https://www.google.com/recaptcha/api/siteverify'),
            'secret' => env('RECAPTCHA_V3_SECRET'),
            'score' => (float) env('RECAPTCHA_V3_SCORE', 0.5),
            'timeout' => (int) env('RECAPTCHA_V3_TIMEOUT', 10),
        ],
    ],
];
