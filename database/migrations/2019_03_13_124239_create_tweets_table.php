<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetsTable extends Migration
{
    public function up(): void
    {
        Schema::create('tweets', function (Blueprint $table): void {
            $table->increments('id');

            $table->morphs('tweetable');

            $table->text('status');

            $table->timestamps();
        });
    }
}
