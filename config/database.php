<?php

if (env('DB_CONNECTION') === 'pgsql' && env('DATABASE_URL')) {
    $url = parse_url(env('DATABASE_URL'));
    if ($url['scheme'] === 'postgres') {
        $host   = $url['host'];
        $port   = $url['port'];
        $user   = $url['user'];
        $pass   = $url['pass'];
        $path   = substr($url['path'], 1);
    }
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
            'host'              => $host ?? null,
            'port'              => $port ?? null,
            'database'          => $path ?? null,
            'username'          => $user ?? null,
            'password'          => $pass ?? null,
            'charset'           => 'utf8',
            'prefix'            => '',
            'prefix_indexes'    => true,
            'search_path'       => 'public',
            'sslmode'           => 'prefer',
        ],
    ]
];
