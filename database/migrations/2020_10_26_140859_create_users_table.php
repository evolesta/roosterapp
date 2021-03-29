<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /*public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 6);
            $table->string('password', 64);
            $table->string('name');
            $table->string('email');
            $table->string('saldo');
            $table->enum('role', ['user', 'manager', 'admin']);
            $table->string('token');

            $table->timestamps(0);

            $table->index('id');
        });
    }*/

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
