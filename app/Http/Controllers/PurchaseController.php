<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Shopping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PurchaseController extends Controller
{
    public function creditCheckout(Request $request)
    {
        $intent = auth()->user()->createSetupIntent();

        $userId = auth()->user()->id;
        $books = User::find($userId)->booksInCart;
        $total = 0;
        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
        }

        return view('credit.checkout', compact('total', 'intent'));
    }

    public function purchase(Request $request)
    {
        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');
        $books = $user->booksInCart;

        $total = 0;
        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
        }

        try {
            Stripe::setApiKey(config('cashier.secret'));
            $user->createOrGetStripeCustomer();
            $intent = PaymentIntent::create([
                'amount' => $total * 100,
                'currency' => 'usd',
                'customer' => $user->stripe_id,
                'payment_method' => $paymentMethod,
                'off_session' => true,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);
        } catch (\Exception $exception) {
            return back()->with('error', 'حصل خطأ أثناء شراء المنتج، الرجاء التأكد من معلومات البطاقة: ' . $exception->getMessage());
        }

        foreach ($books as $book) {
            $bookPrice = $book->price;
            $purchaseTime = now();
            $user->booksInCart()->updateExistingPivot($book->id, [
                'bought' => true,
                'price' => $bookPrice,
                'created_at' => $purchaseTime,
            ]);
            $book->save();
        }

        $this->sendOrderConfirmationMail($books, $user);
        return redirect('/cart')->with('message', 'تم شراء الكتب بنجاح!');
    }

    public function sendOrderConfirmationMail($order, $user)
    {
        Mail::to($user->email)->send(new OrderMail($order, $user));
    }

    public function myProducts()
    {
        $userId = auth()->user()->id;
        $myBooks = User::find($userId)->pruchedProduct;

        return view('books.myproducts', compact('myBooks'));
    }

    public function allProducts()
    {
        $purchasedProducts = Shopping::with(['user', 'book'])->where('bought', true)->get();

        return view('admin.books.purchases', compact('purchasedProducts'));
    }
}
