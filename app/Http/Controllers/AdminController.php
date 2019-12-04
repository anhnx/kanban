<?php

namespace App\Http\Controllers;

use App\CalendarJP;
use App\Exports\ExportHolidaysMultipleMember;
use App\Exports\ExportWorkingTime;
use App\Exports\MemberHolidays;
use App\Exports\WorkingTimeMultipleExport;
use App\Project;
use App\ProjectAssign;
use App\User;
use App\Vacation;
use App\WorkTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    //
    function display() {
        $calendar = new CalendarJP();
        //get list project
        $prjList = Project::all();
        //get list member
        $memberList = User::all();
        //get member assign for project
        $prjid = session('selected_prjid');
        $assign = new ProjectAssign();
        $listMemberAssign = $assign->getListAssignMember($prjid);
        return view('Admin',['calendar'=>$calendar, 'prjList'=>$prjList,'memberList'=>$memberList,
               'assignList'=>$listMemberAssign]);
    }

    function AddProject(Request $request) {
        $project = new Project();
        $project->prj_id = $request->get('project-id');
        $project->prj_name = $request->get('project-name');
        $project->prj_start_time = $request->get('start_date');
        $project->prj_end_time = $request->get('end_date');
        $project->leader_id = $request->get('leader-id');
        $project->status = '1';
        $project->save();

        return redirect('/projectadmin');
    }

    function DeleteProject(Request $request) {
        $checkedLst = $request->get('project-list');
        if (!empty($checkedLst)) {
            foreach ($checkedLst as $item) {
                Project::where('prj_id',$item)
                    ->delete();
            }
        }

        return redirect('/projectadmin');
    }

    function DisplayMember() {
        $calendar = new CalendarJP();
        //get list project
        $memberList = User::all();
        return view('MemberManagement',['calendar'=>$calendar,'memberList'=>$memberList]);
    }

    function AddMember(Request $request)
    {
        $user = new User();
        $user->name = $request->get('member-name');
        $user->email = $request->get('member-email');
        $user->password = Hash::make('123456123');
        $user->address = $request->get('member-address');
        $user->birthday = $request->get('birthday');
        if ($request->get('position') == 1) {
            $user->position = 'M';
        } elseif ($request->get('position') == 2) {
            $user->position = 'L';
        }
        $user->leader = $request->get('leader-id');
        $user->admin_flag = '0';
        $user->save();
        return redirect('/memberadmin');
    }

    function DeleteMember(Request $request) {
        $checkedLst = $request->get('member-list');
        if (!empty($checkedLst)) {
            foreach ($checkedLst as $item) {
                User::where('id',$item)
                    ->delete();
            }
        }

        return redirect('/memberadmin');
    }

    function ListMember(Request $request) {
        $action = $request->get('action');
        if ($action == 'Member List') {
            $prjid = $request->get('project');
            $request->session()->put('selected_prjid',$prjid);
        } elseif($action == 'delete') {
            $checkedLst = $request->get('member-list');
            if (!empty($checkedLst)) {
                foreach ($checkedLst as $item) {
                    ProjectAssign::where('id',$item)
                                   ->update(['assign_status'=>'0']);
                }
            }
        }
        return redirect('/projectadmin');
    }

    function MemberAssign(Request $request) {
        $checkedList = $request->get('assign-list');
        $roleList = $request->get('role');
        if (!empty($checkedList)) {
            for ($i = 0; $i < count($checkedList); $i++) {
                $assign = new ProjectAssign();
                $assign->prj_id = $request->get('project-assign');
                $assign->member_id = $checkedList[$i];
                $assign->role = $roleList[$i];
                $assign->assign_status = '1';
                $assign->save();
            }
        }
        return redirect('/projectadmin');
    }

    function Export(Request $request) {
        //get data from request
        $member = $request->get('member-select');
        $request->session()->put('member-select',$member);
        $start_day = $request->get('start-day');
        $request->session()->put('start-day',$start_day);
        $end_day = $request->get('end-day');
        $request->session()->put('end-day',$end_day);
        $export_type = $request->get('export-type');
        $request->session()->put('export-type',$export_type);
        $workTime = new WorkTime();
        $user = new User();
        //export Excel file
        if ($member == 0) {
            //export all member
            $memberList = $user->getAllMember();
            if($export_type == '1') {
                //export working time
                //get list all member
                return Excel::download(new WorkingTimeMultipleExport($memberList, $start_day, $end_day),
                    'AllMemberWorkingTime.xlsx');
            } else {
                //export holidays
                return Excel::download(new ExportHolidaysMultipleMember($memberList, $start_day, $end_day),
                    'AllMemberHolidays.xlsx');
            }
        } else {
            //export selected member
            if($export_type == '1') {
                //export working time
                return Excel::download(new ExportWorkingTime($member,$start_day,$end_day,'Working Time'),
                    'WorkingTime.xlsx');
            } else {
                //export holidays
                return Excel::download(new MemberHolidays($member, $start_day,$end_day,'Holidays List'),
                    'HolidaysList.xlsx');
            }
        }
    }

}
