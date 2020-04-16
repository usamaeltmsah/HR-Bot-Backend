<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('database.tables.jobs'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->dateTime('accepts_interviews_from datetime');
            $table->dateTime('accepts_interviews_until');
            $table->integer('interview_duration');
            $table->string('status');
            $table->integer('recruiter_id')->unsigned()->nullable();
            $table->timestamps();

            // Indexes
//            $table->foreign('recruiter_id')
//                ->references('id')
//                ->on(config('database.tables.recruiters'))
////                ->onDelete('cascade')
//                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('database.tables.jobs'));
    }
}
