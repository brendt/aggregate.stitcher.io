<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageToSource extends Migration
{
    public function up(): void
    {
        Schema::table('sources', function (Blueprint $table): void {
            $table->string('language')->default('en');
        });
    }
}
