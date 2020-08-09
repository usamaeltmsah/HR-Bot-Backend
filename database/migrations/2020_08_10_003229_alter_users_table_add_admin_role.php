<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddAdminRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE users CHANGE COLUMN role role ENUM('applicant', 'recruiter', 'admin') NOT NULL DEFAULT 'applicant'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE users CHANGE COLUMN role role ENUM('applicant', 'recruiter') NOT NULL DEFAULT 'applicant'");
    }
}
