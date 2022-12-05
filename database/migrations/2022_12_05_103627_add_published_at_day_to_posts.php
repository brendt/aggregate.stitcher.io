<?php

use App\Models\Post;
use App\Models\PostState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table
                ->date('published_at_day')
                ->after('published_at')
                ->nullable();
        });

        Post::query()
            ->whereActiveSource()
            ->whereIn('state', [
                PostState::PUBLISHED,
                PostState::STARRED,
            ])
            ->each(fn (Post $post) => $post->update([
                'published_at_day' => $post->published_at,
            ]));
    }
};
