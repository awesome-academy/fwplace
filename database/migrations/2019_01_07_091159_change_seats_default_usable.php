<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSeatsDefaultUsable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seats', function (Blueprint $table) {
            $table->integer('usable')->default(config('site.default.usable'))->change();
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
            $table->integer('usable')->nullable()->change();
        });
    }
}
