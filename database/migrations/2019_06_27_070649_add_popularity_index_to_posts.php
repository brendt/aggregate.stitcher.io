<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPopularityIndexToPosts extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('popularity_index')->default(0)->after('view_count_weekly');
        });
    }
}
