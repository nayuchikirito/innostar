<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinations', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('date');
            $table->enum('status', ['blocked', 'pending']);
            $table->decimal('balance', 8, 2);

            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');

            $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');

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
        Schema::dropIfExists('coordinations');
    }
}
