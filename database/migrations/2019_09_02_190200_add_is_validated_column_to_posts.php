<?php

use Domain\Post\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsValidatedColumnToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->boolean('is_validated')->default(false);
        });

        Post::all()->each(function (Post $post): void {
            $post->is_validated = true;

            $post->save();
        });
    }
}
