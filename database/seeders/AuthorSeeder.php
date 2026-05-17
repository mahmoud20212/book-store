<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create(['name' => 'جورج أورويل']);
        Author::create(['name' => 'محمد الشريف']);
        Author::create(['name' => 'سوسن الشاعر']);
        Author::create(['name' => 'علاء الدين']);
        Author::create(['name' => 'أحمد خالد توفيق']);
        Author::create(['name' => 'نجيب محفوظ']);
        Author::create(['name' => 'طه حسين']);
        Author::create(['name' => 'جبران خليل جبران']);
        Author::create(['name' => 'إبراهيم الكوني']);
        Author::create(['name' => 'محمود درويش']);
        Author::create(['name' => 'أحمد شوقي']);
        Author::create(['name' => 'مصطفى صادق الرافعي']);
    }
}
