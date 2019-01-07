<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableSomeColumnsOnWorkspacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workspaces', function (Blueprint $table) {
            $table->integer('seat_per_column')->default(0)->change();
            $table->integer('seat_per_row')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workspaces', function (Blueprint $table) {
            $table->integer('seat_per_column')->change();
            $table->integer('seat_per_row')->change();
        });
    }
}
