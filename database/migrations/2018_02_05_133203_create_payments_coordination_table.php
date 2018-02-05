<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsCoordinationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_coordinations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('details');
            $table->decimal('amount', 8, 2);
            $table->enum('type', ['Bank', 'Cash']);

            $table->unsignedInteger('coordination_id');
            $table->foreign('coordination_id')->references('id')->on('coordinations');
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
        Schema::dropIfExists('payment_coordinations');
    }
}
