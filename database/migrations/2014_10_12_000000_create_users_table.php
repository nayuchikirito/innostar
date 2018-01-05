<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('email')->unique();
            $table->string('password');
            $table->string('fname');
            $table->string('lname');
            $table->string('midname')->nullable();
            $table->string('location')->nullable();
            $table->string('contact')->nullable();
            $table->enum('user_type', ['admin', 'customer', 'secretary', 'suppliers']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
