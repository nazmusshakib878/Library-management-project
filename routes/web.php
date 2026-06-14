<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudentController::class, 'home']);
Route::get('/home', [StudentController::class, 'home'])->name('home');

Route::redirect('/Home', '/home');
Route::redirect('/Admindashboard', '/admin/dashboard');
Route::redirect('/Register', '/register');
Route::redirect('/Login', '/login');
Route::redirect('/Books', '/books');
Route::redirect('/Issuebook', '/issuebook');
Route::redirect('/Returnbook', '/returnbook');

Route::get('/books', [StudentController::class, 'book']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
    Route::post('/books/{book}/borrow', [StudentController::class, 'borrowRequest'])->name('borrow.request');
    Route::post('/issues/{bookIssue}/return', [StudentController::class, 'returnRequest'])->name('return.request');
    Route::get('/issuebook', [StudentController::class, 'issuebook'])->name('student.issuebook');
    Route::get('/returnbook', [StudentController::class, 'returnBook'])->name('student.returnbook');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/books', [AdminController::class, 'books'])->name('books');
    Route::get('/books/create', [AdminController::class, 'createBook'])->name('books.create');
    Route::post('/books', [AdminController::class, 'storeBook'])->name('books.store');
    Route::get('/books/{book}/edit', [AdminController::class, 'editBook'])->name('books.edit');
    Route::put('/books/{book}', [AdminController::class, 'updateBook'])->name('books.update');
    Route::delete('/books/{book}', [AdminController::class, 'deleteBook'])->name('books.destroy');
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::get('/requests', [AdminController::class, 'pendingIssueRequests'])->name('requests');
    Route::post('/requests/{bookIssue}/accept', [AdminController::class, 'acceptIssueRequest'])->name('requests.accept');
    Route::get('/returns', [AdminController::class, 'pendingReturns'])->name('returns');
    Route::post('/returns/{bookIssue}/receive', [AdminController::class, 'markReturnReceived'])->name('returns.receive');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
