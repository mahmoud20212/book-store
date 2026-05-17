<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    public function index()
    {
        $numberOfBooks = Book::count();
        $numberOfAuthors = Author::count();
        $numberOfCategories = Category::count();
        $numberOfPublishers = Publisher::count();
        return view('admin.index', compact('numberOfBooks', 'numberOfAuthors', 'numberOfCategories', 'numberOfPublishers'));
    }
}
