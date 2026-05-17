<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $book = Book::find($request->input('id'));
        $quantity = $request->input('quantity');

        if (auth()->user()->booksInCart->contains($book)) {
            $newQuantity = $quantity + auth()->user()->booksInCart()->where('book_id', $book->id)->first()->pivot->number_of_copies;

            if ($newQuantity > $book->number_of_copies) {
                session()->flash(
                    'warning_message',
                    'لم يتم إضافة الكتاب إالى السلة، لقد تجاوزت عدد النسخ الموجودة لدينا، أقصى عدد موجود بإمكانك حجزه هو ' . ($book->number_of_copies - auth()->user()->booksInCart()->where('book_id', $book->id)->first()->pivot->number_of_copies) . ' نسخة'
                );
                return redirect()->back();
            } else {
                auth()->user()->booksInCart()->updateExistingPivot($book->id, ['number_of_copies' => $newQuantity]);
            }
        } else {
            auth()->user()->booksInCart()->attach($book->id, ['number_of_copies' => $quantity]);
        }

        $numOfProducts = auth()->user()->booksInCart()->count();
        return response()->json(['num_of_products' => $numOfProducts]);
    }

    public function viewCart()
    {
        $items = auth()->user()->booksInCart;
        return view('cart', compact('items'));
    }

    public function removeOne(Book $book)
    {
        $oldQuantity = auth()->user()->booksInCart()->where('book_id', $book->id)->first()->pivot->number_of_copies;

        if ($oldQuantity > 1) {
            auth()->user()->booksInCart()->updateExistingPivot($book->id, ['number_of_copies' => --$oldQuantity]);
        } else {
            auth()->user()->booksInCart()->detach($book->id);
        }
        

        return redirect()->back();
    }

    public function updateAll(Book $book)
    {
        auth()->user()->booksInCart()->detach($book->id);
        return redirect()->back();
    }
}
