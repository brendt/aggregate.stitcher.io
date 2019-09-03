<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogsTable extends Migration
{
    public function up(): void
    {
        Schema::create('error_logs', function (Blueprint $table): void {
            $table->increments('id');

            $table->morphs('loggable');

            $table->text('message');
            $table->longText('body');

            $table->timestamps();
        });
    }
}
