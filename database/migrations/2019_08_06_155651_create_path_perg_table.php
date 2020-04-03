<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePathPergTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('path_perg', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('perg_id')->unsigned()->nullable();
            $table->bigInteger('path_id')->unsigned()->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        Schema::table('path_perg', function($table) {
            $table->foreign('perg_id')->references('id')->on('perguntas')->onDelete('cascade');
            $table->foreign('path_id')->references('id')->on('paths')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('path_perg');
    }
}
