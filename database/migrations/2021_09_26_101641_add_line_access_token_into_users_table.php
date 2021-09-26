<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLineAccessTokenIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('line_auth_token')->after('remember_token')->nullable();
            $table->string('line_access_token')->after('line_auth_token')->nullable();
            $table->dateTime('line_access_token_expired_at')->after('line_access_token')->nullable();
            $table->string('line_refresh_token')->after('line_access_token_expired_at')->nullable();
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
            $table->dropColumn('line_auth_token');
            $table->dropColumn('line_access_token');
            $table->dropColumn('line_access_token_expired_at');
            $table->dropColumn('line_refresh_token');
        });
    }
}
