<?php

use Tempest\Database\Config\MysqlConfig;
use function Tempest\env;

return new MysqlConfig(
    port: env('DATABASE_PORT', '3306'),
    database: 'aggregate_testing',
);