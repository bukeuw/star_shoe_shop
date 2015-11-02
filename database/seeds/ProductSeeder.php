<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
        	// 1
        	[
        	    'name' => 'Ardiles ARD ADVENTURA',
        	    'description' => 'Tersedia ukuran 37-42',
        	    'stock' => 500,
        	    'unit' => 'lusin',
        	    'price' => 245000,
        	    'img_name' => 'Ardiles ARD ADVENTURA'
			],
			// 2
			[
        	    'name' => 'Ardiles ARD PURITY',
        	    'description' => 'Tersedia ukuran 37-42',
        	    'stock' => 500,
        	    'unit' => 'lusin',
        	    'price' => 204000,
        	    'img_name' => 'Ardiles ARD PURITY'
			],
			// 3
			[
        	    'name' => 'Ardiles Cartoon',
        	    'description' => 'Tersedia ukuran 36-40',
        	    'stock' => 500,
        	    'unit' => 'lusin',
        	    'price' => 215000,
        	    'img_name' => 'Ardiles Cartoon'
			],
			// 4
			[
        	    'name' => 'Carwil EDWARD-M',
        	    'description' => 'Tersedia ukuran 38-42',
        	    'stock' => 500,
        	    'unit' => 'lusin',
        	    'price' => 450000,
        	    'img_name' => 'Carwil EDWARD-M'
			],
			// 5
			[
        	    'name' => 'Carwil Folkus-03 M',
        	    'description' => 'Tersedia ukuran 36-42',
        	    'stock' => 500,
        	    'unit' => 'lusin',
        	    'price' => 445000,
        	    'img_name' => 'Carwil Folkus-03 M'
			],
			// 6
        	[
        	    'name' => 'Clarudo CL 2083 (Hak)',
        	    'description' => 'Tersedia ukuran 37-40',
        	    'stock' => 500,
        	    'unit' => 'lusin',
        	    'price' => 220000,
        	    'img_name' => 'Clarudo CL 2083 (Hak)'
			],
			// 7
			[
        	    'name' => 'DE-Klik',
        	    'description' => 'Tersedia ukuran 38-42',
        	    'stock' => 500,
        	    'unit' => 'lusin',
        	    'price' => 90000,
        	    'img_name' => 'DE-Klik'
			],
			// 8
			[
        	    'name' => 'DULUX 088B',
        	    'description' => 'Tersedia ukuran 36-40',
        	    'stock' => 500,
        	    'unit' => 'lusin',
        	    'price' => 252000,
        	    'img_name' => 'DULUX 088B'
			],
			// 9
			[
        	    'name' => 'DULUX 109C',
        	    'description' => 'Tersedia ukuran 28-34',
        	    'stock' => 500,
        	    'unit' => 'lusin',
        	    'price' => 352000,
        	    'img_name' => 'DULUX 109C'
			],
			// 10
			[
        	    'name' => 'DULUX 120D',
        	    'description' => 'Tersedia ukuran 25-30',
        	    'stock' => 500,
        	    'unit' => 'lusin',
        	    'price' => 365000,
        	    'img_name' => 'DULUX 120D'
			]
        ];

        foreach($products as $product) {
        	Product::create($product);
        }
    }
}
