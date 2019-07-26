<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table): void {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->string('slug')->unique();
            $table->string('name')->unique();

            $table->timestamps();
        });
    }
}
