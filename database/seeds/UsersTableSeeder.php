<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name'      => 'Nguyễn Xuân Anh',
            'email'     => 'xuananh512@gmail.com',
            'password'  => Hash::make('123456123'),
            'address'   => 'Ha Noi',
            'position'  => 'L',
            'leader'    => 0,
            'remember_token' => Str::random(10)
        ]);
    }
}
