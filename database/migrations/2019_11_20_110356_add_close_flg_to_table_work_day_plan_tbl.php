<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCloseFlgToTableWorkDayPlanTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_day_plan_tbl', function (Blueprint $table) {
            //
            $table->char('close_flag',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_day_plan_tbl', function (Blueprint $table) {
            //
        });
    }
}
