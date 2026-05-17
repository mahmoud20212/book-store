<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $book1 = Book::create([
            'publisher_id' => Publisher::where('name', 'أكادمية حسوب')->first()->id, // Assuming this publisher exists
            'category_id' => Category::where('name', 'تكنولوجيا')->first()->id, // Assuming this category exists
            'title' => 'التوظيف عن بعد: دليل شامل',
            'description' => 'هذا الكتاب يقدم دليلاً شاملاً حول التوظيف عن بعد، حيث يغطي جميع الجوانب المتعلقة بهذا الموضوع، بدءًا من كيفية البحث عن وظائف عن بعد، إلى كيفية تحسين سيرتك الذاتية لتناسب هذا النوع من الوظائف، بالإضافة إلى نصائح حول كيفية النجاح في مقابلات العمل عن بعد وكيفية إدارة وقتك بشكل فعال أثناء العمل من المنزل.',
            'number_of_pages' => 350,
            'number_of_copies' => 10,
            'price' => 29.99,
            'cover_image' => 'images/1.jpg',
            'isbn' => '978-0451524935',
        ]);
        $book1->authors()->attach(Author::where('name', 'جورج أورويل')->first()->id); // Assuming this author exists

        $book2 = Book::create([
            'publisher_id' => Publisher::where('name', 'دار الشروق')->first()->id, // Assuming this publisher exists
            'category_id' => Category::where('name', 'روايات')->first()->id, // Assuming this category exists
            'title' => '1984',
            'description' => 'رواية ديستوبية كتبها جورج أورويل، تصور مستقبلًا مظلمًا حيث تسيطر الحكومة على كل جانب من جوانب الحياة.',
            'number_of_pages' => 328,
            'number_of_copies' => 15,
            'price' => 19.99,
            'cover_image' => 'images/2.avif',
            'isbn' => '978-0451524935',
        ]);

        $book2->authors()->attach(Author::where('name', 'جورج أورويل')->first()->id); // Assuming this author exists

        $book3 = Book::create([
            'publisher_id' => Publisher::where('name', 'دار العين')->first()->id, // Assuming this publisher exists
            'category_id' => Category::where('name', 'شعر')->first()->id, // Assuming this category exists
            'title' => 'ديوان محمود درويش',
            'description' => 'مجموعة من قصائد الشاعر الفلسطيني محمود درويش، الذي يعتبر من أبرز شعراء العرب في القرن العشرين.',
            'number_of_pages' => 200,
            'number_of_copies' => 20,
            'price' => 14.99,
            'cover_image' => 'images/3.webp',
            'isbn' => '978-0451524935',
        ]);
        $book3->authors()->attach(Author::where('name', 'محمود درويش')->first()->id); // Assuming this author exists
    }
}
