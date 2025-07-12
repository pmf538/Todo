<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Électronique', 'description' => 'Produits électroniques et informatiques'],
            ['name' => 'Vêtements', 'description' => 'Vêtements et accessoires'],
            ['name' => 'Livres', 'description' => 'Livres et publications'],
            ['name' => 'Sport', 'description' => 'Équipements et vêtements de sport'],
            ['name' => 'Maison', 'description' => 'Articles pour la maison et le jardin'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
 