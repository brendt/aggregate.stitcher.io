<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'post_reports',
            function (Blueprint $table) {
                $table->increments('id');
                $table->uuid('uuid')->unique();
                $table->text('report');
                $table->unsignedInteger('source_id');
                $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
                $table->unsignedInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->timestamps();
            });
    }


}
