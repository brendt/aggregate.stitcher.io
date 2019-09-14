<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SourceLanguageDefault extends Migration
{
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->string('language')->nullable()->change();
        });
    }
}
