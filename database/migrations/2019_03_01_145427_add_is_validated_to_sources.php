<?php

use Domain\Source\Models\Source;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsValidatedToSources extends Migration
{
    public function up(): void
    {
        Schema::table('sources', function (Blueprint $table): void {
            $table->boolean('is_validated')->after('is_active')->default(0);
        });

        /** @var \Domain\Source\Models\Source $source */
        foreach (Source::all() as $source) {
            $source->is_validated = true;

            $source->save();
        }
    }
}
