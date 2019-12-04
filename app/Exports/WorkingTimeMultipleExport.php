<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WorkingTimeMultipleExport implements WithMultipleSheets
{
    private $memberList = null;
    private $startDay = null;
    private $endday = null;

    function __Construct($memberList,$startDay, $endday) {
        $this->memberList = $memberList;
        $this->startDay = $startDay;
        $this->endday = $endday;
    }
    public function sheets(): array
    {
        // TODO: Implement sheets() method.
        $sheets = [];
        foreach($this->memberList as $member) {
            $sheets[] = new ExportWorkingTime($member->id, $this->startDay,$this->endday,$member->name);
        }
        return $sheets;
    }
}
