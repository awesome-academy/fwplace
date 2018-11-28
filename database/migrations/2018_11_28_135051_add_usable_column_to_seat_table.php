<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsableColumnToSeatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seats', function (Blueprint $table) {
            $table->tinyInteger('usable')->nullable();
            $table->integer('position_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seats', function (Blueprint $table) {
            $table->dropColumn('usable');
            $table->dropColumn('position_id');
        });
    }
}
