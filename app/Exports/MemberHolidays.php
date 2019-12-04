<?php

namespace App\Exports;

use App\User;
use App\Vacation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MemberHolidays implements FromCollection, WithHeadings, WithTitle
{
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

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function collection()
    {
        //
        $holiday = new Vacation();
        $user = new User();
        $holidaysList = $holiday->getHolidaysList($this->member, $this->startDay, $this->endday);
        $HolidaysArray = array();
        $i = 1;
        foreach ($holidaysList as $item) {
            if ($item->vacation_start_day == $item->vacation_end_day) {
                array_push($HolidaysArray,['№'=>$i, 'Name'=>$user->getNameByID($item->member_id),
                    'Day Off'=>$item->vacation_start_day, 'Time'=>$this->getTime($item->vacation_time),
                    'Reason'=>$item->vacation_reason]);
                 $i++;
            }else {
                $startDay = new \DateTime($item->vacation_start_day);
                $endDay = new \DateTime($item->vacation_end_day);
                $interval = $endDay->diff($startDay);
                for($j = 0; $j <= $interval->d; $j++) {
                    $datetemp = $startDay;
                    array_push($HolidaysArray,['№'=>$i, 'Name'=>$user->getNameByID($item->member_id),
                        'Day Off'=>date_format($datetemp,'Y-m-d'), 'Time'=>$this->getTime($item->vacation_time),
                        'Reason'=>$item->vacation_reason]);
                    $datetemp->modify('+1 day');
                    $i++;
                }
            }
        }
        return collect($HolidaysArray);
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return ['№',
            'Name',
            'Day Off',
            'Time',
            'Reason'];
    }

    function getTime($time) {
        $name = "";
        switch ($time) {
            case '1': $name = 'All Day';
                break;
            case '2': $name = 'Morning';
                break;
            case '3': $name = 'Afternoon';
                break;
        }
        return $name;
    }

    public function title(): string
    {
        return $this->titleSheet;
    }
}
