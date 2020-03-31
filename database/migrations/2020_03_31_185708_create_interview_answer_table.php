<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('database.tables.interview_answer'), function (Blueprint $table) {
            $table->integer('interview_id')->unsigned();
            $table->integer('answer_id')->unsigned();
            $table->timestamps();

            // Indexes
            $table->foreign('interview_id')
                  ->references('id')
                  ->on(config('database.tables.interviews'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('answer_id')
                  ->references('id')
                  ->on(config('database.tables.answers'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('database.tables.interview_answer'));
    }
}
