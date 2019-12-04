<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkDayPlanTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_day_plan_tbl', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('member_id');
            $table->Integer('prj_id');
            $table->String('task_name',100);
            $table->Char('task_level',1);
            $table->String('task_start_day',10);
            $table->String('task_end_day',10);
            $table->Integer('task_estimate_time',3);
            $table->Integer('task_actual_time',3)->nullable();
            $table->char('task_status',1);
            $table->char('task_type',1);
            $table->char('leader_accepted',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_day_plan_tbl');
    }
}
