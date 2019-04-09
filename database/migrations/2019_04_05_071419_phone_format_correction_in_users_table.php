<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhoneFormatCorrectionInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'phone')) {
//            Schema::table('users', function (Blueprint $table) {
            DB::statement('ALTER TABLE users CHANGE phone phone INT(10) UNSIGNED ZEROFILL NOT NULL');
            DB::statement('ALTER TABLE users ADD UNIQUE (ID)');
//            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedInteger('phone')->unique();
            });
        }
    }
}
