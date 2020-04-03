<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataGuestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_guest', function (Blueprint $table) {
              $table->bigIncrements('id');
              $table->integer('maze_id')->nullable();
              $table->string('event')->nullable();
              $table->integer('question_id')->nullable();
              $table->integer('answer_id')->nullable();
              $table->integer('wrong_count')->nullable();
              $table->integer('correct_count')->nullable();
              $table->boolean('correct')->nullable();
              $table->integer('start')->nullable();
              $table->integer('elapsed_time')->nullable();
              $table->integer('answers_read_count')->nullable();
              $table->Timestamp('async_timestamp')->nullable();
              $table->timestamp('created_at')->useCurrent();
              $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_guest');
    }
}
