<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('is_active')->default(0);

            $table->string('url');

            $table->timestamps();
        });
    }
}
