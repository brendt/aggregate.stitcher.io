<?php

use App\Models\Source;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->unsignedBigInteger('visits')->default(0)->after('state');
        });

        Source::each(function (Source $source) {
            $source->update([
                'visits' => $source->posts()->sum('visits'),
            ]);
        });
    }
};
