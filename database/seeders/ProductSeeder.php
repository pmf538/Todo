<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Smartphone Galaxy S23',
                'description' => 'Smartphone Samsung Galaxy S23 avec écran 6.1"',
                'price' => 899.99,
                'stock' => 15,
                'category_id' => 1,
            ],
            [
                'name' => 'Laptop Dell Inspiron',
                'description' => 'Ordinateur portable Dell Inspiron 15"',
                'price' => 1299.99,
                'stock' => 8,
                'category_id' => 1,
            ],
            [
                'name' => 'T-shirt Basic',
                'description' => 'T-shirt en coton 100%',
                'price' => 19.99,
                'stock' => 50,
                'category_id' => 2,
            ],
            [
                'name' => 'Jeans Classic',
                'description' => 'Jeans coupe classique',
                'price' => 49.99,
                'stock' => 25,
                'category_id' => 2,
            ],
            [
                'name' => 'Laravel en Action',
                'description' => 'Livre sur le framework Laravel',
                'price' => 39.99,
                'stock' => 12,
                'category_id' => 3,
            ],
            [
                'name' => 'Ballon de Football',
                'description' => 'Ballon de football professionnel',
                'price' => 29.99,
                'stock' => 30,
                'category_id' => 4,
            ],
            [
                'name' => 'Lampe de Bureau',
                'description' => 'Lampe de bureau LED moderne',
                'price' => 79.99,
                'stock' => 3,
                'category_id' => 5,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 