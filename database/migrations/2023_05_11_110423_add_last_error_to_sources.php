<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->dateTime('last_error_at')->nullable();
            $table->longText('last_error')->nullable();
        });
    }
};
