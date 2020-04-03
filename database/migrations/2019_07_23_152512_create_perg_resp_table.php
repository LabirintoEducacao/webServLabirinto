<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePergRespTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perg_resp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('perg_id')->unsigned()->nullable();
            $table->bigInteger('resp_id')->unsigned()->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        
        Schema::table('perg_resp', function($table) {
            $table->foreign('perg_id')->references('id')->on('perguntas')->onDelete('cascade');
            $table->foreign('resp_id')->references('id')->on('respostas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perg_resp');
    }
}
