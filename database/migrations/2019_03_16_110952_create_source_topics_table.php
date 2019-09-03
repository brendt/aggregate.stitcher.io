<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourceTopicsTable extends Migration
{
    public function up(): void
    {
        Schema::create('source_topics', function (Blueprint $table): void {
            $table->increments('id');

            $table->unsignedInteger('source_id');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');

            $table->unsignedInteger('topic_id');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');


            $table->timestamps();
        });
    }
}
