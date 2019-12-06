<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SourceLanguageDefault extends Migration
{
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->string('language')->nullable()->change();
        });
    }
}
