<?php

use App\Actions\ParseTweetText;
use App\Models\Tweet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tweets', function (Blueprint $table) {
            $table->longText('parsed_text')->after('text')->nullable();
        });

        Tweet::each(fn (Tweet $tweet) => (new ParseTweetText())($tweet));
    }
};
