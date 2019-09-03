<?php

use Domain\Log\Models\ErrorLog;
use Domain\Mute\Models\Mute;
use Domain\Tweet\Models\Tweet;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Migrations\Migration;

class AddMorphMap extends Migration
{
    public function up(): void
    {
        $map = collect(Relation::$morphMap)
            ->mapWithKeys(function ($class, $name) {
                return [$class => $name];
            });

        ErrorLog::all()
            ->each(function (ErrorLog $errorLog) use ($map): void {
                $errorLog->loggable_type = $map[$errorLog->loggable_type] ?? $errorLog->loggable_type;

                $errorLog->save();
            });

        Mute::all()
            ->each(function (Mute $mute) use ($map): void {
                $mute->muteable_type = $map[$mute->muteable_type] ?? $mute->muteable_type;

                $mute->save();
            });

        Tweet::all()
            ->each(function (Tweet $tweet) use ($map): void {
                $tweet->tweetable_type = $map[$tweet->tweetable_type] ?? $tweet->tweetable_type;

                $tweet->save();
            });
    }
}
