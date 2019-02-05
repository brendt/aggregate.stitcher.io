<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostCountToSources extends Migration
{
    public function up(): void
    {
        Schema::table('sources', function (Blueprint $table): void {
            $table->unsignedInteger('post_count')->default(0);
        });
    }
}
