<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        // User::where('administration_level', 0)->update(['administration_level' => 2]);
        $books = Book::paginate(12);
        $title = 'معرض الكتب';
        return view('gallery', compact('books', 'title'));
    }

    public function search(Request $request)
    {
        $term = $request->input('term');
        $books = Book::where('title', 'LIKE', '%' . $term . '%')->paginate(12);
        $title = 'نتائج البحث عن: ' . $term;
        return view('gallery', compact('books', 'title'));
    }
}
