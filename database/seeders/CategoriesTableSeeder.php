<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'High Tech',
            'slug' => 'high-tech',
        ]);

        Category::create([
            'name' => 'Science',
            'slug' => 'science',
        ]);
        
        Category::create([
            'name' => 'Livre',
            'slug' => 'livre',
        ]);

        Category::create([
            'name' => 'Meuble',
            'slug' => 'meuble',
        ]);

        Category::create([
            'name' => 'Jeux',
            'slug' => 'jeux',
        ]);
    }
}
