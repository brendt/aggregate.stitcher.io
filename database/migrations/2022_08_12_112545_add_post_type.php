<?php

use App\Models\PostType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('type')->after('state')->default(PostType::BLOG->value);
            $table->string('body')->after('title')->nullable();
        });
    }
};
