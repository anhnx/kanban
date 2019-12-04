<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table='project_tbl';
    public $timestamps = false;

    function getProjectList($userID) {
        $prjList = collect();

        $prjList = Project::where('leader_id', $userID)
                            ->where(function($query) {
                                $today = date_format(new \DateTime(),'Y-m-d');
                                $query->where('prj_end_time','>=',$today)
                                      ->orWhereNull('prj_end_time');
                            })
                            ->where('status','!=', '0')
                            ->get();
        return $prjList;
    }

    function getLeaderName() {
        $leaderName = User::where('id', $this->leader_id)
                            ->first('name');
        return $leaderName['name'];
    }

    function getStatus() {
        if($this->status == '0') {
            return "Closed";
        } else {
            return "Opening";
        }
    }

}
