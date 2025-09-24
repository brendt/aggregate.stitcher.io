<?php

namespace App\Posts\Migrations;

use Tempest\Database\MigratesUp;
use Tempest\Database\QueryStatement;
use Tempest\Database\QueryStatements\RawStatement;

final class MakeSourceNullable implements MigratesUp
{
    public string $name = '2025-09-25_make_source_nullable';

    public function up(): QueryStatement
    {
        return new RawStatement('ALTER TABLE posts MODIFY COLUMN source_id INT NULL;');
    }
}