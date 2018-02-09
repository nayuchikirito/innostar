<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientNotificationCoordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_notification_coords', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('coordination_id');
            $table->foreign('coordination_id')->references('id')->on('coordinations');

            $table->enum('status', ['approved', 'declined', 'pending'])->default('pending');
            $table->enum('type', ['cancellation', 'change']);

            $table->datetime('change_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_notification_coords');
    }
}
