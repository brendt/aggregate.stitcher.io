<?php

use Domain\Post\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageColumnToPost extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->string('language')->nullable();
        });

        Post::all()->each(function (Post $post): void {
            $post->language = $post->source->language;

            $post->save();
        });
    }
}
