<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublishersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishers = Publisher::all();
        return view('admin.publishers.index', compact('publishers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.publishers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Publisher::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
        ]);

        session()->flash('flash_message', 'تم إضافة الناشر بنجاح.');

        return redirect()->route('publishers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $publisher->name = $request->input('name');
        $publisher->address = $request->input('address');
        $publisher->save();

        session()->flash('flash_message', 'تم تعديل الناشر بنجاح.');

        return redirect()->route('publishers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        session()->flash('flash_message', 'تم حذف الناشر بنجاح.');
        return redirect()->route('publishers.index');
    }

    public function result(Publisher $publisher)
    {
        $books = $publisher->books()->paginate(12);
        $title = 'الكتب التابعة للناشر: ' . $publisher->name;
        return view('gallery', compact('books', 'title'));
    }

    public function list()
    {
        $publishers = Publisher::all()->sortBy('name');
        $title = 'الناشرون';
        return view('publishers.index', compact('publishers', 'title'));
    }

    public function search(Request $request)
    {
        $term = $request->input('term');
        $publishers = Publisher::where('name', 'LIKE', '%' . $term . '%')->get()->sortBy('name');
        $title = 'نتائج البحث عن: ' . $term;
        return view('publishers.index', compact('publishers', 'title'));
    }
}
