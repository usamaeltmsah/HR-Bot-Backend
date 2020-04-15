<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PositionSkill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('database.tables.position_skill'), function (Blueprint $table) {
            $table->integer('position_id')->unsigned();
            $table->integer('skill_id')->unsigned();
            $table->timestamps();

            // Indexes
            $table->foreign('position_id')
                ->references('id')
                ->on(config('database.tables.jobs'))
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('skill_id')
                ->references('id')
                ->on(config('database.tables.skills'))
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
        Schema::dropIfExists(config('database.tables.position_skill'));
    }
}
