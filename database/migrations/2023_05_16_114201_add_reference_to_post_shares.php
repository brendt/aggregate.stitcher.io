<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('post_shares', function (Blueprint $table) {
            $table->longText('reference')->nullable()->after('shared_at');
        });
    }
};
