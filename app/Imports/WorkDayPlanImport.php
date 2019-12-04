<?php

namespace App\Imports;

use App\WorkDayPlan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WorkDayPlanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new WorkDayPlan([
            //
            'member_id'            => $row['member'],
            'prj_id'               => $row['project'],
            'task_name'            => $row['task_name'],
            'task_level'           => $row['task_level'],
            'task_start_day'       => $row['task_start_day'],
            'task_end_day'         => $row['task_end_day'],
            'task_estimate_time'   => $row['task_estimate_time'],
            'task_status'          => $row['task_status'],
            'task_type'            => $row['task_type'],
            'leader_accepted'      => '1',
            'close_flag'           => '0'
        ]);
    }
}
