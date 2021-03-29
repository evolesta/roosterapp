<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class add_testuser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::table('users')->insert([
           'username' => 'testg',
            'password' => Hash::make('L@ngendijk11'),
            'name' => 'Test Gebruiker',
            'email' => 'erik.langendijk@gmail.com',
            'saldo' => '00:00:00',
            'role' => 'user',
            'token' => '',
        ]);*/
        /*DB::table('saldo')->insert([
           'username' => 'testg',
           'saldo' => '00:00:00'
        ]);*/
        DB::table('workhours')->insert([
           'username' => 'testg',
           'workhours' => '01:00:00'
        ]);
    }
}
