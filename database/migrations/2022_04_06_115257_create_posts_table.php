<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('source_id');
            $table->foreign('source_id')->references('id')->on('sources');

            $table->string('title');
            $table->string('url');

            $table->timestamps();

            $table->index(['source_id', 'url']);
        });
    }
};
