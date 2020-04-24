<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageCacheReportsTable extends Migration
{
    public function up()
    {
        Schema::create('page_cache_reports', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('day');

            $table->integer('cache_hits')->default(0);
            $table->integer('authenticated_cache_hits')->default(0);
            $table->integer('guest_cache_hits')->default(0);

            $table->integer('cache_misses')->default(0);
            $table->integer('authenticated_cache_misses')->default(0);
            $table->integer('guest_cache_misses')->default(0);

            $table->timestamps();
        });
    }
}
