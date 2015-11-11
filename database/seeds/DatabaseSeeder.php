<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AdminSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CategorySeeder::class);

        Model::reguard();
    }
}
