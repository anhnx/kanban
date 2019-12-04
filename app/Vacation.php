<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Array_;

class Vacation extends Model
{
    protected $table='vacation_tbl';
    public $timestamps = false;

    function getMyVacationLst($UserId) {
        $vacation = collect();
        $vacation = Vacation::where('member_id',$UserId)
                                ->get();
        return $vacation;
    }

    function getConfirmHoliday($userId) {
        $holidayConfirmLst = collect();
        $memberLst = array();
        $user = new User();
        //get member list
        $memberLst = $user->getMemberLst($userId);
        //get holidays of all member
        foreach ($memberLst as $member) {
            $memberHoliday = $this->getMyVacationLst($member->id);
            foreach ($memberHoliday as $memberHol) {
                $holidayConfirmLst->push($memberHol);
            }
        }
        //
        return $holidayConfirmLst;
    }

    function getHolidaysList($userId, $start, $end) {
        return Vacation::where('member_id', $userId)
                         ->where('vacation_start_day', '>=', $start)
                         ->where('vacation_end_day', '<=', $end)
                         ->where('leader_accepted','=', '1')
                         ->orderBy('vacation_start_day','ASC')
                         ->get();
    }

}
