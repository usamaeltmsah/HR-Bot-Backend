<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterScoresColumnsMakeItsDefaultAsZero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('database.tables.interviews'), function (Blueprint $table) {
            $table->float('score')->default(0)->change();
        });

        Schema::table(config('database.tables.answers'), function (Blueprint $table) {
            $table->float('score')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
