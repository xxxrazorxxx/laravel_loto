<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('game_number')->default(0);
            $table->binary('ticket_data');
            $table->string('ticket_hash');
            $table->string('name');
            $table->string('surname');
            $table->integer('prize')->default(0);
            $table->timestamps();
        });

        DB::update('ALTER TABLE clients AUTO_INCREMENT = 10000000;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
