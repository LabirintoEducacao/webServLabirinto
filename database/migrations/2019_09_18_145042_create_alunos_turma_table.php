<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunosTurmaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos_turma', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('aluno_id');
            $table->unsignedBigInteger('turmas_id');
            $table->timestamps();


           $table->foreign('turmas_id')->references('id')->on('turmas')->onDelete('cascade');;
       });


       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alunos_turma');
    }
}
