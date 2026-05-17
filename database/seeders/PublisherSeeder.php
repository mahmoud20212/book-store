<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Publisher::create(['name' => 'أكادمية حسوب']);
        Publisher::create(['name' => 'دار الشروق']);
        Publisher::create(['name' => 'دار العين']);
        Publisher::create(['name' => 'دار المدى']);
        Publisher::create(['name' => 'دار الساقي']);
        Publisher::create(['name' => 'دار الفارابي']);
        Publisher::create(['name' => 'دار التنوير']);
        Publisher::create(['name' => 'دار الآداب']);
        Publisher::create(['name' => 'دار المشرق']);
        Publisher::create(['name' => 'دار الحكمة']);
    }
}
