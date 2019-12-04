<?php

namespace App\Http\Controllers;

use App\CalendarJP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberManagementController extends Controller
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
        return view('MemberManagement',['calendar'=>$calendar]);
    }
}
