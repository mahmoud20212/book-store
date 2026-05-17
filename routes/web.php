<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PublishersController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/search', [GalleryController::class, 'search'])->name('search');
Route::get('/book/{book}', [BooksController::class, 'details'])->name('book.details');
Route::post('/book/{book}/rate', [BooksController::class, 'rate'])->name('book.rate');

Route::get('/categories', [CategoriesController::class, 'list'])->name('gallery.categories.index');
Route::get('/categories/search', [CategoriesController::class, 'search'])->name('gallery.categories.search');
Route::get('/categories/{category}', [CategoriesController::class, 'result'])->name('gallery.categories.show');

Route::get('/publishers', [PublishersController::class, 'list'])->name('gallery.publishers.index');
Route::get('/publishers/search', [PublishersController::class, 'search'])->name('gallery.publishers.search');
Route::get('/publishers/{publisher}', [PublishersController::class, 'result'])->name('gallery.publishers.show');

Route::get('/authors', [AuthorsController::class, 'list'])->name('gallery.authors.index');
Route::get('/authors/search', [AuthorsController::class, 'search'])->name('gallery.authors.search');
Route::get('/authors/{author}', [AuthorsController::class, 'result'])->name('gallery.authors.show');

Route::prefix('/admin')->middleware('can:update-books')->group(function () {
    Route::get('/', [AdminsController::class, 'index'])->name('admin.index');
    Route::resource('/books', BooksController::class);
    Route::resource('/categories', CategoriesController::class);
    Route::resource('/publishers', PublishersController::class);
    Route::resource('/authors', AuthorsController::class);
    Route::resource('/users', UsersController::class)->middleware('can:update-users');
    route::get('/purchases', [PurchaseController::class, 'allProducts'])->name('all.products')->middleware('can:update-users');
});

Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add')->middleware('auth');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/removeOne/{book}', [CartController::class, 'removeOne'])->name('cart.remove_one');
Route::post('/cart/removeAll/{book}', [CartController::class, 'updateAll'])->name('cart.remove_all');

Route::get('/checkout', [PurchaseController::class, 'creditCheckout'])->name('credit.checkout');
Route::post('/checkout', [PurchaseController::class, 'purchase'])->name('products.purchase');

Route::get('/myproducts', [PurchaseController::class, 'myProducts'])->name('my.products')->middleware('auth');

// Route::get('/admin', [AdminsController::class, 'index'])->name('admin.index')->middleware('can:update-books');
// Route::get('/admin/books', [BooksController::class, 'index'])->name('books.index');
// Route::get('/admin/books/create', [BooksController::class, 'create'])->name('books.create');
// Route::post('/admin/books', [BooksController::class, 'store'])->name('books.store');
// Route::get('/admin/books/{book}', [BooksController::class, 'show'])->name('books.show');
// Route::get('/admin/books/{book}/edit', [BooksController::class, 'edit'])->name('books.edit');
// Route::patch('/admin/books/{book}', [BooksController::class, 'update'])->name('books.update');
// Route::delete('/admin/books/{book}', [BooksController::class, 'destroy'])->name('books.destroy');
// Route::resource('/admin/books', BooksController::class);
// Route::resource('/admin/categories', CategoriesController::class);
// Route::resource('/admin/publishers', PublishersController::class);
// Route::resource('/admin/authors', AuthorsController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [GalleryController::class, 'index'])->name('dashboard');
});

