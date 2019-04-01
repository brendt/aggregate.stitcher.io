<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValidationFailedAtToSources extends Migration
{
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->dateTime('validation_failed_at')->after('is_validated')->nullable();
        });
    }
}
