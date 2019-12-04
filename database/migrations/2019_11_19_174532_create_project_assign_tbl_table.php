<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAssignTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_assign_tbl', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('prj_id');
            $table->integer('member_id');
            $table->char('role',1);
            $table->char('assign_status',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_assign_tbl');
    }
}
