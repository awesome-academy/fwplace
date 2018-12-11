<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorkspaceIdInDesignDiagramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('design_diagram', function (Blueprint $table) {
            $table->unsignedInteger('workspace_id');
            $table->dropColumn('diagram');
            $table->string('name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('design_diagram', function (Blueprint $table) {
            $table->dropColumn('workspace_id');
            $table->string('diagram');
            $table->string('name')->change();
        });
    }
}
