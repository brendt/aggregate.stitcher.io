<?php

use App\Console\Jobs\UpdateViewCountJob;
use App\Console\Jobs\UpdateVoteCountJob;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWeeklyCountColumnsToPosts extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger('view_count_weekly')
                ->default(0)
                ->after('view_count');

            $table->unsignedInteger('vote_count_weekly')
                ->default(0)
                ->after('vote_count');
        });

        dispatch(app(UpdateViewCountJob::class));

        dispatch(app(UpdateVoteCountJob::class));
    }
}
