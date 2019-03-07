<?php

use Domain\Source\Models\Source;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsValidatedToSources extends Migration
{
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->boolean('is_validated')->after('is_active')->default(0);
        });

        /** @var \Domain\Source\Models\Source $source */
        foreach (Source::all() as $source) {
            $source->is_validated = true;

            $source->save();
        }
    }
}
