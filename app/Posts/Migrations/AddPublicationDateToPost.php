<?php

namespace App\Posts\Migrations;

use Tempest\Database\MigratesUp;
use Tempest\Database\QueryStatement;
use Tempest\Database\QueryStatements\AlterTableStatement;
use Tempest\Database\QueryStatements\DatetimeStatement;

final class AddPublicationDateToPost implements MigratesUp
{
    public string $name = '2025-09-18-003_add_publication_date_to_posts_table';

    public function up(): QueryStatement
    {
        return new AlterTableStatement('posts')
            ->add(new DatetimeStatement('publicationDate', nullable: true));
    }
}