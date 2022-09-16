<?php

use App\Models\TweetFeedType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tweets', function (Blueprint $table) {
            $table
                ->string('feed_type')
                ->after('state')
                ->default(TweetFeedType::LIST->value);
        });
    }
};
