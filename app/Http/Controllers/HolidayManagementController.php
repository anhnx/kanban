<?php

namespace App\Http\Controllers;

use App\CalendarJP;
use App\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayManagementController extends Controller
{
    //
    function display() {
        $calendar = new CalendarJP();
        $userId = Auth::user()->id;
        //ket thuc ngay
        if (isset($_GET['confirm']) && ($_GET['confirm'] == '1')) {
            //update db
           $end_time = $_GET['end-day'];
           Auth::user()->endday($end_time);
        }
        //Get my vacation list
        $vacation = new Vacation();
        $vacationList = $vacation->getMyVacationLst($userId);

        //get confirm vacation List
        $confirmHolidaysLst = $vacation->getConfirmHoliday($userId);
        //return dashboard view
        return view("holidayManagement",['calendar'=>$calendar,'vacation'=>$vacationList,
            'holidayConfirmLst'=>$confirmHolidaysLst]);
    }

    function AddHoliday(Request $request) {
        $action = $request->get('action');
        if ($action == 'register') {
            $vacation = new Vacation();
            $vacation->member_id = Auth::user()->id;
            $vacation->vacation_start_day = $request->get('start_date');
            $vacation->vacation_end_day = $request->get('end_date');
            $vacation->vacation_time = $request->get('vacation-time');
            $vacation->vacation_reason = $request->get('vacation-reason');
            $vacation->leader_accepted = ' ';
            $vacation->save();
        } else if($action == 'delete') {
            $checkedLst = $request->get('my-holiday');
            if (!empty($checkedLst)) {
                foreach ($checkedLst as $item) {
                    Vacation::where('id',$item)
                        ->delete();
                }
            }
        }
        return redirect('/holidaymanagement');
    }

    function ConfirmHoliday(Request $request) {
        $action = $request->get('action');
        $checkedLst = $request->get('holiday-confirm');
        if ($action == 'accept') {
            foreach ($checkedLst as $item) {
                Vacation::where('id',$item)
                    ->update(['leader_accepted'=>'1']);
            }
        } else if($action == 'decline') {
            $checkedLst = $request->get('holiday-confirm');
            if (!empty($checkedLst)) {
                foreach ($checkedLst as $item) {
                    Vacation::where('id',$item)
                        ->update(['leader_accepted'=>'0']);
                }
            }
        }
        return redirect('/holidaymanagement');
    }

}
