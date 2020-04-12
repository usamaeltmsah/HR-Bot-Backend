<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('database.tables.answers'), function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->float('score')->nullable();
            $table->integer('question_id')->unsigned();
            $table->integer('interview_id')->unsigned()->nullable();
            $table->timestamps();
            
            // Indexes
            $table->foreign('interview_id')
                  ->references('id')
                  ->on(config('database.tables.interviews'))
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
        Schema::dropIfExists(config('database.tables.answers'));
    }
}
