<?php

return [
	'paths' => [
		'migrations' => [
			__DIR__ . '/src/App/Database/Migration'
		],
		'seeds' => [
			__DIR__ . '/src/App/Database/Seed'
		]
	],
	'environments' => [
		'default_migration_table' => 'migrations',
        'default_database'        => 'default_connection',
        'default_connection'             => [
            'adapter'   => getenv('MYSQL_ADAPTER'),
            'host'      => getenv('MYSQL_HOST'),
            'name'      => getenv('MYSQL_DATABASE'),
            'user'      => getenv('MYSQL_USER'),
            'pass'      => getenv('MYSQL_PASSWORD'),
            'charset'   => getenv('MYSQL_CHARSET'),
            'collation' => getenv('MYSQL_COLLATION')
        ]
	]	
];