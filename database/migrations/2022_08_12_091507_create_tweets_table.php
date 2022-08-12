<?php

use App\Models\TweetState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tweet_id')->unique();

            $table->string('state')->default(TweetState::PENDING->value);

            $table->string('text');
            $table->string('user_name');

            $table->json('payload');
            $table->timestamps();
        });
    }
};
