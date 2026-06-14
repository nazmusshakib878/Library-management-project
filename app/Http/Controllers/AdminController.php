<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (! Auth::user() || ! Auth::user()->isAdmin) {
                abort(403);
            }

            return $next($request);
        });
    }

    public function dashboard()
    {
        $studentsCount = User::where('isAdmin', false)->count();
        $booksCount = Book::count();
        $issuedCount = BookIssue::where('status', 'issued')->count();
        $pendingIssueCount = BookIssue::where('status', 'pending_issue')->count();
        $pendingReturnCount = BookIssue::where('status', 'pending_return')->count();

        return view('site.page.admin-dashboard', compact(
            'studentsCount',
            'booksCount',
            'issuedCount',
            'pendingIssueCount',
            'pendingReturnCount'
        ));
    }

    public function createBook()
    {
        return view('site.page.admin-add-book');
    }

    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:books,isbn',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'image_url' => 'nullable|url|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'] ?? null,
            'price' => $validated['price'],
            'image_url' => $validated['image_url'] ?? null,
            'copies_total' => $validated['quantity'],
            'copies_available' => $validated['quantity'],
        ]);

        return redirect()->route('admin.books')->with('success', 'Book added successfully.');
    }

    public function books()
    {
        $books = Book::orderBy('title')->get();

        return view('site.page.admin-books', compact('books'));
    }

    public function editBook(Book $book)
    {
        return view('site.page.admin-edit-book', compact('book'));
    }

    public function updateBook(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:books,isbn,'.$book->id,
            'price' => 'required|numeric|min:0|max:99999999.99',
            'image_url' => 'nullable|url|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $issuedCopies = max(0, $book->copies_total - $book->copies_available);

        $book->update([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'] ?? null,
            'price' => $validated['price'],
            'image_url' => $validated['image_url'] ?? null,
            'copies_total' => $validated['quantity'],
            'copies_available' => max(0, $validated['quantity'] - $issuedCopies),
        ]);

        return redirect()->route('admin.books')->with('success', 'Book updated successfully.');
    }

    public function deleteBook(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books')->with('success', 'Book deleted successfully.');
    }

    public function students()
    {
        $students = User::where('isAdmin', false)->orderBy('name')->get();

        return view('site.page.admin-students', compact('students'));
    }

    public function pendingIssueRequests()
    {
        $requests = BookIssue::with(['student', 'book'])
            ->where('status', 'pending_issue')
            ->orderByDesc('created_at')
            ->get();

        return view('site.page.admin-requests', compact('requests'));
    }

    public function acceptIssueRequest(BookIssue $bookIssue)
    {
        if (! $bookIssue->isPendingIssue()) {
            return back()->with('error', 'Only pending issue requests can be accepted.');
        }

        if (! $bookIssue->book || ! $bookIssue->book->is_available) {
            return back()->with('error', 'This book is not available for issue.');
        }

        $bookIssue->update([
            'status' => 'issued',
            'admin_id' => Auth::id(),
            'issue_date' => now()->toDateString(),
            'due_date' => now()->addWeeks(2)->toDateString(),
            'fine_per_day' => 10,
            'fine_amount' => 0,
        ]);

        $bookIssue->book->decrement('copies_available');

        return back()->with('success', 'Issue request accepted successfully.');
    }

    public function pendingReturns()
    {
        $returns = BookIssue::with(['student', 'book'])
            ->where('status', 'pending_return')
            ->orderByDesc('created_at')
            ->get();

        return view('site.page.admin-returns', compact('returns'));
    }

    public function markReturnReceived(BookIssue $bookIssue)
    {
        if (! $bookIssue->isPendingReturn()) {
            return back()->with('error', 'Only pending returns can be marked as received.');
        }

        $returnDate = now();
        $overdueDays = $bookIssue->due_date && $returnDate->toDateString() > $bookIssue->due_date->toDateString()
            ? $bookIssue->due_date->diffInDays($returnDate)
            : 0;
        $fineAmount = $overdueDays * (float) $bookIssue->fine_per_day;

        $bookIssue->update([
            'status' => 'returned',
            'admin_id' => Auth::id(),
            'return_date' => $returnDate->toDateString(),
            'fine_amount' => $fineAmount,
        ]);

        if ($bookIssue->book) {
            $bookIssue->book->increment('copies_available');
        }

        $message = 'Book return marked as received successfully.';

        if ($fineAmount > 0) {
            $message .= ' Late fine: Tk '.number_format($fineAmount, 2).' ('.$overdueDays.' day'.($overdueDays > 1 ? 's' : '').' late).';
        }

        return back()->with('success', $message);
    }
}
