<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
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
        <div class="max-w-5xl mx-auto px-6">
            <div class="bg-white rounded-3xl shadow-sm p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900">Edit Book</h1>
                        <p class="text-slate-500 mt-2">Update the book details and inventory quantity.</p>
                    </div>
                    <a href="/admin/books" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-5 py-3 text-slate-700 hover:bg-slate-200 transition">
                        <i class="fa-solid fa-arrow-left"></i> Return to List
                    </a>
                </div>

                @if($errors->any())
                    <div class="mb-6 rounded-lg bg-rose-100 border border-rose-200 text-rose-700 px-5 py-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/admin/books/{{ $book->id }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Title</label>
                        <input type="text" name="title" value="{{ old('title', $book->title) }}" required class="mt-2 w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Author</label>
                        <input type="text" name="author" value="{{ old('author', $book->author) }}" required class="mt-2 w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="mt-2 w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Cover Image URL (optional)</label>
                        <input type="url" name="image_url" value="{{ old('image_url', $book->image_url) }}" placeholder="https://example.com/cover.jpg" class="mt-2 w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Quantity</label>
                        <input type="number" name="quantity" value="{{ old('quantity', $book->copies_total) }}" min="1" required class="mt-2 w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl px-5 py-3 transition">Save Changes</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
