<?php

namespace App\Http\Controllers;

use App\CalendarJP;
use App\Imports\WorkDayPlanImport;
use App\Project;
use App\ProjectAssign;
use App\Vacation;
use App\WorkDayPlan;
use App\WorkTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TaskManagementController extends Controller
{
    //
    function display(Request $request) {
        $calendar = new CalendarJP();
        $userId = Auth::user()->id;
        //ket thuc ngay
        if (isset($_GET['confirm']) && ($_GET['confirm'] == '1')) {
            //update db
            $end_time = $_GET['end-day'];
            Auth::user()->endday($end_time);
        }
        //get Project List
        $projectAssign = new ProjectAssign();
        $prjList = $projectAssign->getProjectListByUserID($userId);
        //get member list by project

        $memberAssignPrjList = array();
        foreach ($prjList as $prj) {
            $memberList = array();
            $memberAssignLst = $projectAssign->getListMemberByPrj($prj->prj_id);
            foreach ($memberAssignLst as $assign) {
                array_push($memberList, ['member_id'=>$assign->id,'member_name'=>$assign->name]);
            }
            array_push($memberAssignPrjList,['prj_id'=>$prj->prj_id, 'member_lst'=>$memberList]);
        }
        $allMember = $projectAssign->getListMemberByListPrj($prjList);
        \JavaScript::put([
            'memberAssignPrjList'  => $memberAssignPrjList,
            'allMember'           => $allMember
        ]);
        //get task list
        //get period parameter
        $period_start = session('period_start');
        $period_end = session('period_end');
        $workPlan = new WorkDayPlan();
        $myTaskList = collect();
        foreach ($prjList as $prj) {
            if($prj->role == "1") {
                $taskLst = $workPlan->getTaskListByPrj($prj->prj_id,$period_start,$period_end);
            } else {
                $taskLst = $workPlan->getTaskList($userId, $prj->prj_id,$period_start,$period_end);
            }
            foreach ($taskLst as $item) {
                $myTaskList->push($item);
            }
        }
        //return dashboard view
        return view("taskManagement",['calendar'=>$calendar, 'myTaskList'=>$myTaskList,'prjList'=>$prjList,
                                            'memberAssignPrjList'=>$memberAssignPrjList,'allMember'=>$allMember]);
    }
    function AddTask(Request $request) {
        $action = $request->get('action');
        $task = new WorkDayPlan();
        //get data from request
        $member_id = Auth::user()->id;
        $prj_id = $request->get('project-id');
        $task_name = $request->get('task-name');
        $task_level = $request->get('task-level');
        $task_start_day = $request->get('task-start-day');
        $task_end_day = $request->get('task-end-day');
        $task_estimate_time = $request->get('estimate-time');
        $task_actual_time = $request->get('actual-time');
        $task_status = $request->get('task-status');
        $task_type = $request->get('task-type');
        //add or update
        if($action == 'add') {
            $task->member_id = $member_id;
            $task->prj_id = $prj_id;
            $task->task_name = $task_name;
            $task->task_level = $task_level;
            $task->task_start_day = $task_start_day;
            $task->task_end_day = $task_end_day;
            $task->task_estimate_time = $task_estimate_time;
            $task->task_actual_time = $task_actual_time;
            $task->task_status = $task_status;
            $task->task_type = $task_type;
            $task->leader_accepted = '1';
            $task->close_flag = '0';
            $task->save();
        } elseif($action == 'update') {
            $taskID = $request->get('task-id');
            WorkDayPlan::where('id', $taskID)
                       ->update([
                           'task_start_day'     =>$task_start_day,
                           'task_end_day'       =>$task_end_day,
                           'task_estimate_time' =>$task_estimate_time,
                           'task_actual_time'   =>$task_actual_time,
                           'task_level'         =>$task_level,
                           'task_status'        =>$task_status,
                       ]);
        }

        return redirect('/taskmanagement');
    }
    //assign task
    function AssignTask(Request $request) {
        $action = $request->get('action');
        $task = new WorkDayPlan();
        //get data from request
        $task->prj_id = $request->get('assign-project-id');
        $task->member_id = $request->get('assign-member');
        $task->task_name = $request->get('assign-task-name');
        $task->task_level = $request->get('assign-task-level');
        $task->task_start_day = $request->get('assign-task-start-day');
        $task->task_end_day = $request->get('assign-task-end-day');
        $task->task_estimate_time = $request->get('assign-estimate-time');
        $task->task_actual_time = $request->get('assign-actual-time');
        $task->task_status = $request->get('assign-task-status');
        $task->task_type = $request->get('assign-task-type');
        $task->leader_accepted = '1';
        $task->close_flag = '0';
        $task->save();

        return redirect('/taskmanagement');
    }

    function Search (Request $request) {
        $period_start = $request->get('period-start-day');
        $period_end = $request->get('period-end-day');
        //set session
        $request->session()->put('period_start',$period_start);
        $request->session()->put('period_end',$period_end);
        //return dashboard view
        return redirect('/taskmanagement');
    }

    function Upload(Request $request) {
        $this->validate($request, [
            'plan-assign-file'  => 'required|mimes:xls,xlsx,csv'
        ]);
        Excel::import(new WorkDayPlanImport, $request->file('plan-assign-file'));
        return redirect('/taskmanagement')->with('result_msg','Plan has been imported successful!');
    }

    function CloseTask(Request $request) {
        $task_id = $request->get('task_detail_id');
        WorkDayPlan::where('id', $task_id)
                     ->update(['close_flag'=>'1']);
        return redirect('/taskmanagement');
    }
}
