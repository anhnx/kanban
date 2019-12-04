<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacationTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_tbl', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->String('vacation_start_day',10);
            $table->String('vacation_end_day',10);
            $table->Char('vacation_time',1);
            $table->String('vacation_reason',100);
            $table->Char('leader_accepted',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacation_tbl');
    }
}
