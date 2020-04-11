<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('database.tables.job_question'), function (Blueprint $table) {
            $table->integer('job_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->timestamps();

            // Indexes
            $table->foreign('job_id')
                  ->references('id')
                  ->on(config('database.tables.jobs'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('question_id')
                  ->references('id')
                  ->on(config('database.tables.questions'))
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
        Schema::dropIfExists(config('database.tables.job_question'));
    }
}
