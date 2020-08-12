<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('database.tables.model_answers'), function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->integer('question_id')->unsigned();
            $table->timestamps();
            
            // Indexes
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
        Schema::dropIfExists('model_answers');
    }
}
