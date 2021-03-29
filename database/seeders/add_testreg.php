<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class add_testreg extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('registrations')->insert([
           'username' => 'testg',
            'date' => '2020-10-27',
            'start' => '08:30',
            'end' => '17:00',
            'workedHours' => '08:30',
            'extraHours' => '00:00',
            'calc' => 1
        ]);
    }
}
