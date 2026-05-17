<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'روايات']);
        Category::create(['name' => 'شعر']);
        Category::create(['name' => 'مسرح']);
        Category::create(['name' => 'تاريخ']);
        Category::create(['name' => 'فلسفة']);
        Category::create(['name' => 'علوم']);
        Category::create(['name' => 'تكنولوجيا']);
        Category::create(['name' => 'طب']);
        Category::create(['name' => 'رياضة']);
        Category::create(['name' => 'سير ذاتية']);
    }
}
