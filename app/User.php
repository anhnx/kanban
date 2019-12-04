<?php

namespace App;

use DateTime;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','address','position','leader'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function getMemberLst($UserId) {
        $memberLst = User::where('leader',$UserId)
                            ->get();
        return $memberLst;
    }
    function getNameByID($userID) {
        $user = User::where('id', $userID)
            ->first();
        return $user->name;
    }

    function getPrjList($userID) {
        $prjAssignList = ProjectAssign::where('member_id', $userID)
                                    ->get();
        $prjList = collect();
        foreach ($prjAssignList as $item) {
            $prj = Project::where('prj_id', $item->prj_id)
                            ->first();
            $prjList->push($prj);
        }
        return $prjList;
    }

    function endday($endtime) {
        WorkTime::where(['member_id'=>$this->id, 'work_day'=>
            date_format(new DateTime(), 'Y-m-d')])
            ->update(['end_time'=>$endtime]);
    }

    function getAllMember() {
       return User::where('admin_flag',"!=", '1')
             ->get();
    }

}
