<?php

use App\User;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'Nina Cheng',
        	'email' => 'chengnina951@yahoo.com',
        	'password' => bcrypt('rahasialagi')
        ]);
    }
}
