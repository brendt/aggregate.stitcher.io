<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSentAtColumnToTweet extends Migration
{
    public function up()
    {
        Schema::table('tweets', function (Blueprint $table) {
            $table->dateTime('sent_at')->nullable();
        });
    }
}
