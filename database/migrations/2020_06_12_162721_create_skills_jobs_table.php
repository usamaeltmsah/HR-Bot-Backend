<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills_jobs', function (Blueprint $table) {
            $table->integer('skill_id')->unsigned();
            $table->integer('job_id')->unsigned();
            $table->timestamps();

            $table->foreign('skill_id')
                ->references('id')
                ->on('skills')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('job_id')
                ->references('id')
                ->on('jobs')
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
        Schema::dropIfExists('skills_jobs');
    }
}
