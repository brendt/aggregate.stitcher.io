<?php

use App\Models\Post;
use App\Models\PostState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table
                ->dateTime('published_at')
                ->after('created_at')
                ->nullable();
        });

        Post::query()
            ->whereActiveSource()
            ->whereIn('state', [
                PostState::PUBLISHED,
                PostState::STARRED,
            ])
            ->each(fn (Post $post) => $post->update([
                'published_at' => $post->created_at,
            ]));
    }
};
