<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostCountToSources extends Migration
{
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->unsignedInteger('post_count')->default(0);
        });
    }
}
