<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmaSalasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turma_salas', function (Blueprint $table) {
            $table->BigInteger('id_t')->unsigned();
            $table->foreign('id_t')->references('id')->on('turmas')->onDelete('cascade');
            $table->BigInteger('id_s')->unsigned();
            $table->foreign('id_s')->references('id')->on('salas')->onDelete('cascade');
             $table->primary(['id_t', 'id_s']);
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
        Schema::dropIfExists('turma_salas');
    }
}
