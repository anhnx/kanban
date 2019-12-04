<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    protected $table='work_time_tbl';
    public $timestamps = false;

    function getWorkingTime($userid, $start, $end) {
        $workingTimeList = WorkTime::where('member_id', $userid)
                                     ->where('work_day', '>=', $start)
                                     ->where('work_day', '<=', $end)
                                     ->get();
        return $workingTimeList;
    }

}
