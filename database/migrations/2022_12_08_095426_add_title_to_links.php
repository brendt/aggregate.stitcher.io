<?php

use App\Models\Link;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->string('title')->nullable()->after('url');
        });

        Link::each(fn (Link $link) => $link->save());
    }
};
