<?php

use App\Console\Jobs\UpdateViewCountJob;
use App\Console\Jobs\UpdateVoteCountJob;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWeeklyCountColumnsToPosts extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
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
