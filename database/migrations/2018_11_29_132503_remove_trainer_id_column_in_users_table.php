<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTrainerIdColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'trainer_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('trainer_id');
            });
        }

        if (Schema::hasColumn('users', 'seat_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('seat_id');
            });
        }

        if (Schema::hasColumn('users', 'images')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('images');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('trainer_id');
            $table->unsignedInteger('seat_id');
            $table->string('images');
        });
    }
}
