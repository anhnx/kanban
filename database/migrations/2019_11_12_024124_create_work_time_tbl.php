<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkTimeTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_time_tbl', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->String('work_day',10);
            $table->String('start_time',10);
            $table->String('end_time',10)->nullable();
            $table->integer('late_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_time_tbl');
    }
}
