<?php

namespace App\Posts\Migrations;

use App\Posts\PostState;
use Tempest\Database\MigratesUp;
use Tempest\Database\QueryStatement;
use Tempest\Database\QueryStatements\CreateTableStatement;

final class CreatePostsTable implements MigratesUp
{
    public string $name = '2025-09-17-001_create_posts_table';

    public function up(): QueryStatement
    {
        return new CreateTableStatement('posts')
            ->primary()
            ->string('title')
            ->string('uri')
            ->datetime('createdAt')
            ->integer('visits', unsigned: true, default: 0)
            ->enum('state', PostState::class)
            ->belongsTo('posts.source_id', 'sources.id');
    }
}
