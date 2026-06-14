<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Book List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 antialiased">
    <nav class="bg-slate-900 text-white py-4 px-6 md:px-12 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a class="text-2xl font-bold text-blue-500 tracking-wide flex items-center" href="/home">
                Library<span class="text-white">MS</span> <i class="fa-solid fa-book-open-reader ml-2"></i>
            </a>
            <div class="flex items-center gap-3 text-sm font-semibold text-slate-200">
                <a href="/admin/dashboard" class="hover:text-blue-300 transition">Dashboard</a>
                <a href="/admin/books" class="hover:text-blue-300 transition">Books</a>
                <a href="/admin/books/create" class="hover:text-blue-300 transition">Add Book</a>
                <a href="/admin/students" class="hover:text-blue-300 transition">Students</a>
                <a href="/admin/requests" class="hover:text-blue-300 transition">Requests</a>
                <a href="/admin/returns" class="hover:text-blue-300 transition">Returns</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-slate-200 hover:text-white transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">All Books</h1>
                    <p class="text-slate-500 mt-2">View and manage the full library inventory.</p>
                </div>
                <a href="/admin/books/create" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-white font-semibold hover:bg-blue-700 transition">
                    <i class="fa-solid fa-plus"></i> Add Book
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-lg bg-emerald-100 border border-emerald-200 text-emerald-700 px-5 py-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 rounded-lg bg-rose-100 border border-rose-200 text-rose-700 px-5 py-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto bg-white rounded-3xl shadow-sm border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-100 text-slate-600 uppercase tracking-wide text-xs">
                        <tr>
                            <th class="px-6 py-4 text-left">Title</th>
                            <th class="px-6 py-4 text-left">Author</th>
                            <th class="px-6 py-4 text-left">ISBN</th>
                            <th class="px-6 py-4 text-left">Available</th>
                            <th class="px-6 py-4 text-left">Total</th>
                            <th class="px-6 py-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($books as $book)
                            <tr>
                                <td class="px-6 py-4 text-slate-800 font-medium">{{ $book->title }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $book->author }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $book->isbn ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $book->copies_available }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $book->copies_total }}</td>
                                <td class="px-6 py-4 flex flex-col gap-2 sm:flex-row">
                                    <a href="/admin/books/{{ $book->id }}/edit" class="inline-flex items-center gap-2 rounded-xl border border-blue-600 px-4 py-2 text-blue-600 hover:bg-blue-50 transition">Edit</a>
                                    <form action="/admin/books/{{ $book->id }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-4 py-2 text-white hover:bg-rose-700 transition">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">No books registered yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
