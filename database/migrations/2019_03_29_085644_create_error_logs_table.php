<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErrorLogsTable extends Migration
{
    public function up()
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->morphs('loggable');

            $table->text('message');
            $table->longText('body');

            $table->timestamps();
        });
    }
}
