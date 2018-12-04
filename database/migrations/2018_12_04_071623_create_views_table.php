<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsTable extends Migration
{
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

            $table->timestamps();
        });
    }
}
