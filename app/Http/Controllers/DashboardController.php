<?php

namespace App\Http\Controllers;

use App\Project;
use App\ProjectAssign;
use App\User;
use App\Vacation;
use App\WorkDayPlan;
use App\WorkTime;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    function test() {
        return view("test");
    }

}
