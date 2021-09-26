<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastnamePhoneFieldIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname')->after('name');
            $table->string('phone', 11)->after('lastname');
            $table->renameColumn('name', 'firstname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('firstname', 'name');
            $table->dropColumn('lastname');
            $table->dropColumn('phone');
        });
    }
}
