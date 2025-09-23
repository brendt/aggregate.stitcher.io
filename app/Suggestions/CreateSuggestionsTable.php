<?php

namespace App\Suggestions;

use Tempest\Database\MigratesUp;
use Tempest\Database\QueryStatement;
use Tempest\Database\QueryStatements\CreateTableStatement;

final class CreateSuggestionsTable implements MigratesUp
{
    public string $name = '2025-09-20_create_suggestions_table';

    public function up(): QueryStatement
    {
        return new CreateTableStatement('suggestions')
            ->primary()
            ->string('uri')
            ->string('feedUri', nullable: true)
            ->datetime('suggestedAt')
            ->text('suggestedBy');
    }
}