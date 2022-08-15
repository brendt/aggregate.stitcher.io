<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mutes', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->timestamps();
        });
    }
};
