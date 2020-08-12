<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('database.tables.interviews'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->integer('applicant_id')->unsigned();
            $table->dateTime('submitted_at');
            $table->float('score')->nullable()->default(0);
            $table->enum('status', ['under consideration', 'selected', 'not selected'])->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();

            // Indexes
            $table->unique(['job_id', 'applicant_id'], 'job_applicant_unique');
            
            $table->foreign('job_id')
                  ->references('id')
                  ->on(config('database.tables.jobs'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('applicant_id')
               ->references('id')
               ->on('users')
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
        Schema::dropIfExists(config('database.tables.interviews'));
    }
}
