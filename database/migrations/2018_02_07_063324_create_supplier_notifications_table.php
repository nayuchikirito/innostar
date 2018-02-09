<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->unsignedInteger('reservation_detail_id')->nullable();
            $table->foreign('reservation_detail_id')->references('id')->on('reservation_details');

            $table->string('status')->nullable(); //accepted, pending, declined, closed, ignored
            $table->boolean('seen')->nullable(); //1:seen, 0:unseen
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
        Schema::dropIfExists('supplier_notifications');
    }
}
