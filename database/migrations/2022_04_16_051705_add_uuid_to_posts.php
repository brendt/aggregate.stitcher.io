<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable();
        });

        Post::each(fn (Post $post) => $post->update([
            'uuid' => Uuid::uuid4()->toString(),
        ]));
    }
};
