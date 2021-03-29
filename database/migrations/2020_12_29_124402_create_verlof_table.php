<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerlofTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verlof', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('username');
            $table->string('reason');
            $table->date('start');
            $table->date('end');
            $table->time('hours');
            $table->enum('status', ['concept', 'pending', 'agreed']);
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
        Schema::dropIfExists('verlof');
    }
}
