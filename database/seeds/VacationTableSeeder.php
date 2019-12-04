<?php

use App\Vacation;
use Illuminate\Database\Seeder;

class VacationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Vacation::create([
            'member_id'            => 1,
            'vacation_start_day'   => '2019-11-15',
            'vacation_end_day'     => '2019-11-15',
            'vacation_time'        => '1',
            'vacation_reason'      => 'nghỉ việc riêng',
            'leader_accepted'      => ' '
        ]);
    }
}
