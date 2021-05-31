<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
        	'name'         =>'shajib',
        	'email'        =>'shajib@gmail.com',
        	'phone'        =>'01781557594',
        	'address'      =>'Kurigram',
        	'designation'  =>'Software Engineer',
        	'photo'        =>'default.jpg',
        	'department'   =>'Software',
        	'joining_date' =>'2019-11-23'
        ]);
    }
}
