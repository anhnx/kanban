<?php

namespace App\Exports;

use App\User;
use App\WorkTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportWorkingTime implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $member = null;
    private $startDay = null;
    private $endday = null;
    private $titleSheet = null;

    public function __Construct($member, $startDay, $endday, $titleSheet) {
        $this->member = $member;
        $this->startDay = $startDay;
        $this->endday = $endday;
        $this->titleSheet = $titleSheet;
    }
    public function collection()
    {
        //get working time
        $workTime = new WorkTime();
        $user = new User();
        $workingTimeList = $workTime->getWorkingTime($this->member, $this->startDay, $this->endday);
        $workingTimeArray = array();
        $i = 1;
        foreach ($workingTimeList as $item) {
            array_push($workingTimeArray,['№'=>$i, 'Working Day'=>$item->work_day,
                'Name'=>$user->getNameByID($item->member_id),'Login Time'=>$item->start_time,
                'End Time'=>$item->end_time,'Late Minutes'=>$item->late_time]);
            $i++;
        }
        return collect($workingTimeArray);

    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            '№',
            'Working Day',
            'Name',
            'Login Time',
            'End Time',
            'Late Minutes'
        ];

    }

    public function title(): string
    {
        // TODO: Implement title() method.
        return $this->titleSheet;
    }
}
