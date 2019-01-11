<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            $table->boolean('verified')->default(0);
            $table->string('verification_token');

            $table->rememberToken();
            $table->timestamps();
        });
    }
}
