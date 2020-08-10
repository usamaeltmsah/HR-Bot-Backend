<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuestionsTableAddSkillId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('database.tables.questions'), function (Blueprint $table) {
            $table->integer('skill_id')->unsigned();
            
            // Index
            $table->foreign('skill_id')
                            ->references('id')
                            ->on('skills')
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
        Schema::table(config('database.tables.questions'), function (Blueprint $table) {
            $table->dropForeign('questions_skill_id_foreign');
            $table->dropColumn('skill_id');
        });
    }
}
