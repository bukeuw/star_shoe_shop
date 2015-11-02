<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' 		=> 'Admin',
        	'email' 	=> 'dina.cheng@yahoo.com',
        	'password' 	=> bcrypt('rahasia123'),
        	'is_admin' 	=> true
        ]);
    }
}
