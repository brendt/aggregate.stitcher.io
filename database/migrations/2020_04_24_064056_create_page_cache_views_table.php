<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageCacheViewsTable extends Migration
{
    public function up()
    {
        Schema::create('page_cache_views', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('url');
            $table->dateTime('viewed_at');
            $table->boolean('is_cache_hit');

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }
}
