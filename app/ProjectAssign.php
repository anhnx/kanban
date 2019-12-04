<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectAssign extends Model
{
    //
    protected $table='project_assign_tbl';
    public $timestamps = false;

    function getProjectListByUserID($userid) {
        //$prjList = collect();
        $prjList = DB::table('project_assign_tbl as A')
                             ->join('project_tbl as B', 'A.prj_id','=','B.prj_id')
                             ->where('A.member_id',$userid)
                             ->where('A.assign_status','!=', '0')
                             ->get(['A.prj_id', 'B.prj_name', 'A.role']);
        return $prjList;
    }

    function getListMemberByPrj($prjId) {
        $listMember = collect();
        $listAssign = ProjectAssign::where('prj_id', $prjId)
                                    ->where('assign_status','!=', '0')
                                    ->get();
        foreach ($listAssign as $assign) {
            $member = User::where('id', $assign->member_id)
                            ->first();
            $listMember->push($member);
        }
        return $listMember;
    }

    function getListMemberByListPrj($listPrj) {
        $prjIdArr = array();
        foreach ($listPrj as $prj) {
            array_push($prjIdArr, $prj->prj_id);
        }
        //get all member
        $listMember = array();
        $listAssign = ProjectAssign::whereIn('prj_id', $prjIdArr)
                                    ->where('assign_status','!=', '0')
                                    ->distinct()
                                    ->get('member_id');
        foreach ($listAssign as $assign) {
            $member = User::where('id', $assign->member_id)
                ->first();
            array_push($listMember,['member_id'=>$member->id,'member_name'=>$member->name]);
        }
        return $listMember;
    }

    function getListAssignMember($prjid) {
        $assignMemberList = DB::table('project_assign_tbl')
                          ->join('users','users.id','=','project_assign_tbl.member_id')
                          ->where('project_assign_tbl.prj_id','=',$prjid)
                          ->where('assign_status','!=', '0')
                          ->get(['project_assign_tbl.id as assign_id','users.id','users.name','users.email','project_assign_tbl.role']);
        return $assignMemberList;
    }
}
