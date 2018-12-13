<?php

return [
    'default_connection'             => [
        'driver'   => getenv('MYSQL_DRIVER'),
        'host'      => getenv('MYSQL_HOST'),
        'dbname'      => getenv('MYSQL_DATABASE'),
        'user'      => getenv('MYSQL_USER'),
        'password'      => getenv('MYSQL_PASSWORD')
    ]
];