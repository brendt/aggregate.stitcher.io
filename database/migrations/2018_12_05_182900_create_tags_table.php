<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table): void {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->unsignedInteger('topic_id')->nullable();
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('set null');

            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->string('color');

            $table->json('keywords');

            $table->timestamps();
        });
    }
}
