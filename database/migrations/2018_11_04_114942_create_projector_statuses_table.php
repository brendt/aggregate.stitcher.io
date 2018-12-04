<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectorStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('projector_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('projector_name');
            $table->string('stream')->nullable();
            $table->boolean('has_received_all_events')->default(false);
            $table->integer('last_processed_event_id')->default(0);
            $table->timestamps();

            $table->index(['projector_name', 'stream']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('projector_statuses');
    }
}
