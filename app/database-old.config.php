<?php

use Tempest\Database\Config\MysqlConfig;
use function Tempest\env;

return new MysqlConfig(
    host: env('DATABASE_HOST', default: 'localhost'),
    port: env('DATABASE_PORT', default: '3306'),
    username: env('DATABASE_USERNAME', default: 'root'),
    password: env('DATABASE_PASSWORD', default: ''),
    database: env('DATABASE_DATABASE_OLD'),
    tag: 'old',
);
