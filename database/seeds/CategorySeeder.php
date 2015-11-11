<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
        	'title' => 'Sandal'
        ]);

        Category::create([
        	'title' => 'Sepatu'
        ]);

        Category::create([
            'title' => 'Sandal Pria',
            'parent_id' => 1
        ]);

        Category::create([
            'title' => 'Sandal Wanita',
            'parent_id' => 1
        ]);

        Category::create([
            'title' => 'Sandal Anak-anak',
            'parent_id' => 1
        ]);

        Category::create([
            'title' => 'Sepatu Pria',
            'parent_id' => 2
        ]);

        Category::create([
            'title' => 'Sepatu Wanita',
            'parent_id' => 2
        ]);

        Category::create([
            'title' => 'Sepatu Anak-anak',
            'parent_id' => 2
        ]);
    }
}
