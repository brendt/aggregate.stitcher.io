<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->unsignedInteger('source_id');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');

            $table->string('url');
            $table->string('title');
            $table->text('teaser')->nullable();

            $table->integer('vote_count')->default(0);
            $table->integer('view_count')->default(0);

            $table->dateTime('date_created');

            $table->timestamps();
        });
    }
}
