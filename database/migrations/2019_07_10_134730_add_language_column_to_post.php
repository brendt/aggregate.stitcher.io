<?php

use Domain\Post\Models\Post;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLanguageColumnToPost extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('language')->nullable();
        });

        Post::all()->each(function (Post $post) {
            $post->language = $post->source->language;

            $post->save();
        });
    }
}
