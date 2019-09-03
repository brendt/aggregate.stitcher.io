<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentAtColumnToTweet extends Migration
{
    public function up(): void
    {
        Schema::table('tweets', function (Blueprint $table): void {
            $table->dateTime('sent_at')->nullable();
        });
    }
}
