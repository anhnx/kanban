<?php

namespace App\Http\Controllers;

use App\CalendarJP;
use App\User;
use DateTime;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\WorkTime;

class LoginController extends Controller
{
    function index() {
        return view("login");
    }

    function checklogin(Request $request)
    {
        $login_time = null;
        $standard_date_time = new DateTime();
        date_time_set($standard_date_time,8,30,00);
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:3'
        ]);

        $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
        );

        if(Auth::attempt($user_data))
        {
            if(Auth::user()->admin_flag == 1) {
                return redirect('/projectadmin');
            }
            //get logged time
            $login_time = new DateTime();
            $interval = $login_time->diff($standard_date_time);
            if ($interval->invert > 0) {
                $lateTime = $interval->h*60 + $interval->i;
            } else {
                $lateTime = 0;
            }
            //insert in DB
            //if not login yet then insert to DB

            $workTime = WorkTime::where(['member_id'=>Auth::user()->id, 'work_day'=>
                                                                        date_format($login_time, 'Y-m-d')])
                                    ->first();
            if ($workTime == null) {
                $workTime = new WorkTime();
                $workTime->member_id = Auth::user()->id;
                $workTime->work_day = date_format($login_time, 'Y-m-d');
                $workTime->start_time = date_format($login_time, 'H:i:s');
                $workTime->late_time = $lateTime;
                $workTime->save();
            } else {
                $lateTime = $workTime->late_time;
            }
            if ($lateTime > 0) {
                $msg = "You logged in late ".$lateTime." minutes. ";
            } else {
                $msg = "";
            }
            $msg .= "Have a nice day!";
            session(['msg' => $msg]);
            return redirect('/taskmanagement');
        }
        else
        {
            return back()->with('error', 'Email or Password is not correct!');
        }
    }

    function ChangePass() {
        $calendar = new CalendarJP();
        return view('ChangePassword',['calendar'=>$calendar]);
    }

    function ActionChange(Request $request) {
        $newPass = $request->get('password');
        $newPassConfirm = $request->get('password-confirm');
        if ($newPass == $newPassConfirm) {
            User::where('id', Auth::user()->id)
                  ->update(['password'=>Hash::make($newPass)]);
            $status = "OK";
        } else {
            $status = "Not";
        }
        return redirect('/changepassword')->with('status',$status);
    }

    function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/');
    }
}
