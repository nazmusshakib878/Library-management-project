<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function home()
    {
        return view('site.page.home');
    }

    public function profile()
    {
        $user = Auth::user();
        $borrowedBooks = BookIssue::where('user_id', $user->id)
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('site.page.student-profile', [
            'user' => $user,
            'borrowedBooks' => $borrowedBooks,
        ]);
    }

    public function book()
    {
        $books = Book::all();

        return view('site.page.book', ['books' => $books]);
    }

    public function issuebook()
    {
        $books = Book::where('is_active', true)->orderBy('title')->get();

        return view('site.page.issue-book', [
            'books' => $books,
        ]);
    }

    public function returnBook()
    {
        $issuedBooks = BookIssue::where('user_id', Auth::id())
            ->whereIn('status', ['issued', 'pending_return'])
            ->with('book')
            ->orderByDesc('created_at')
            ->get();

        return view('site.page.return-book', [
            'issuedBooks' => $issuedBooks,
        ]);
    }

    public function borrowRequest(Request $request, Book $book)
    {
        $user = Auth::user();

        // Check if book already requested or issued
        $existing = BookIssue::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending_issue', 'issued'])
            ->first();

        if ($existing) {
            return back()->with('error', 'You already have a pending request or active issue for this book.');
        }

        // Check if book is available
        if (! $book->is_available) {
            return back()->with('error', 'This book is not available at the moment.');
        }

        // Create borrow request
        BookIssue::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'request_type' => 'issue',
            'status' => 'pending_issue',
        ]);

        return back()->with('success', 'Borrow request submitted successfully!');
    }

    public function returnRequest(BookIssue $bookIssue)
    {
        if ($bookIssue->user_id !== Auth::id()) {
            abort(403);
        }

        if ($bookIssue->status === 'pending_return') {
            return back()->with('error', 'You already submitted a return notice for this book.');
        }

        if ($bookIssue->status !== 'issued') {
            return back()->with('error', 'Only issued books can be returned.');
        }

        $bookIssue->update([
            'request_type' => 'return',
            'status' => 'pending_return',
        ]);

        return back()->with('success', 'Return notice submitted. Admin will receive and confirm the book.');
    }
}
