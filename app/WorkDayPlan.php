<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkDayPlan extends Model
{
    protected $table='work_day_plan_tbl';
    public $timestamps = false;
    protected $fillable = [
        'member_id', 'prj_id', 'task_name','task_level','task_start_day','task_end_day','task_estimate_time'
        ,'task_status','task_type','leader_accepted','close_flag'
    ];

    function getTaskList($userId, $prjID,$period_start, $period_end) {
        $task = new WorkDayPlan();
        $taskLst = collect();
        $taskLst = WorkDayPlan::where('member_id', $userId)
                                ->where('prj_id', $prjID)
                                ->where('close_flag','!=','1')
                                ->where('task_status','!=','3')
                                ->where(function($query) use ($period_start, $period_end){
                                    if($period_start != null) {
                                        $query->where('task_start_day', '>=', $period_start);
                                    }
                                    if($period_end != null) {
                                        $query->where('task_start_day', '<=', $period_end);
                                    }
                                })
                                ->get();
        //return
        return $taskLst;
    }

    function getTaskListByPrj($prjid,$period_start, $period_end) {
        $task = new WorkDayPlan();
        $taskLst = collect();
        $taskLst = WorkDayPlan::where('prj_id', $prjid)
                                ->where('close_flag','!=','1')
                                ->where('task_status','!=','3')
                                ->where(function($query) use ($period_start, $period_end){
                                    if($period_start != null) {
                                        $query->where('task_start_day', '>=', $period_start);
                                    }
                                    if($period_end != null) {
                                        $query->where('task_start_day', '<=', $period_end);
                                    }
                                })
                                ->get();
        //return
        return $taskLst;
    }

    function getTaskName($type) {
        $name = "";
        switch ($type) {
            case '1' :
                $name = "Design";
                break;
            case '2' :
                $name = "Code";
                break;
            case '3' :
                $name = "Test";
                break;
            case '4' :
                $name = "Review";
                break;
            case '5' :
                $name = "Other";
                break;
        }
        return $name;
    }

    function getLevelTask($level) {
        $class = "";
        switch ($level) {
            case '3' :
                $class = "easy-task";
                break;
            case '2' :
                $class = "medium-task";
                break;
            case '1' :
                $class = "difficult-task";
                break;
        }
        return $class;
    }
}
