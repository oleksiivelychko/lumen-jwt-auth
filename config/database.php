<?php

$dbConnection = env('DB_CONNECTION', 'pgsql');
if ($dbConnection === 'pgsql') {
    $url = parse_url($dbConnection);

    $hostname   = $url['host'];
    $username   = $url['user'];
    $password   = $url['pass'];
    $database   = substr($url['path'], 1);
}

return [
    'migrations' => 'migrations',

    'default' => env('DB_CONNECTION', 'pgsql'),

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'pgsql' => [
            'driver'            => 'pgsql',
            'host'              => $hostname ?? null,
            'port'              => '5432',
            'database'          => $database ?? null,
            'username'          => $username ?? null,
            'password'          => $password ?? null,
            'charset'           => 'utf8',
            'prefix'            => '',
            'prefix_indexes'    => true,
            'search_path'       => 'public',
            'sslmode'           => 'prefer',
        ],
    ]
];
