<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePergRefTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perg_ref', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('perg_id')->unsigned();
            $table->bigInteger('ref_id')->unsigned()->nullable();
            $table->timestamp('created_at')->useCurrent();
            
        });
        
        Schema::table('perg_ref', function($table) {
           $table->foreign('perg_id')->references('id')->on('perguntas')->onDelete('cascade');
           $table->foreign('ref_id')->references('id')->on('perguntas')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perg_ref');
    }
}
