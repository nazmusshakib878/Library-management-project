<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System | Student Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 antialiased">
    <nav class="bg-slate-900 text-white py-4 px-6 md:px-12 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a class="text-2xl font-bold text-blue-500 tracking-wide flex items-center" href="/">
                Library<span class="text-white">MS</span> <i class="fa-solid fa-book-open-reader ml-2"></i>
            </a>
            <div class="md:hidden">
                <button id="menu-btn" class="text-white text-2xl focus:outline-none">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
            </div>
            <div id="nav-links" class="hidden md:flex md:items-center md:gap-6 absolute md:static bg-slate-900 w-full md:w-auto left-0 top-16 p-6 md:p-0 z-50">
                <ul class="flex flex-col md:flex-row gap-4 md:gap-6 text-sm font-semibold text-slate-300">
                    <li><a class="text-white hover:text-blue-400 transition" href="/"><i class="fa-solid fa-house mr-1"></i> Home</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/books"><i class="fa-solid fa-book mr-1"></i> Books</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/profile"><i class="fa-solid fa-user mr-1"></i> Profile</a></li>
                </ul>
                <form action="/logout" method="POST" class="mt-4 md:mt-0 md:ml-6">
                    @csrf
                    <button type="submit" class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold transition">
                        <i class="fa-solid fa-sign-out-alt mr-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <section class="max-w-7xl mx-auto py-12 px-6">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-emerald-700 flex items-center gap-3">
                <i class="fa-solid fa-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-red-700 flex items-center gap-3">
                <i class="fa-solid fa-exclamation-circle text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="grid gap-8 lg:grid-cols-3 mb-12">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-user text-4xl text-blue-600"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h1>
                    <p class="text-slate-500 mt-1">{{ $user->email }}</p>
                    <p class="text-sm text-slate-400 mt-4">Member since {{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Account Information</h2>
                    
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Full Name</label>
                            <p class="mt-2 text-slate-900 font-semibold">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Email Address</label>
                            <p class="mt-2 text-slate-900 font-semibold">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Role</label>
                            <p class="mt-2">
                                <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-1 text-sm font-semibold text-blue-600">
                                    <i class="fa-solid fa-graduation-cap"></i> Student
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Account Status</label>
                            <p class="mt-2">
                                <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-1 text-sm font-semibold text-green-600">
                                    <i class="fa-solid fa-check-circle"></i> Active
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrowed Books Section -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">
                <i class="fa-solid fa-book mr-2"></i>Your Requests & Borrowed Books
            </h2>
            <p class="text-sm text-slate-500 mb-4">Track which books you have requested, which ones are issued, and their current status.</p>

            @if($borrowedBooks->isEmpty())
                <div class="text-center py-12">
                    <div class="text-slate-400 text-5xl mb-4">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <p class="text-slate-500 text-lg">No borrowed books yet</p>
                    <a href="/books" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold transition">
                        Browse Books
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-100 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-6 py-3 font-semibold text-slate-900">Book Title</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-900">Author</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-900">Request Type</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-900">Status</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-900">Request Date</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-900">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($borrowedBooks as $borrow)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $borrow->book->title }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $borrow->book->author }}</td>
                                    <td class="px-6 py-4 text-slate-600">
                                        @if($borrow->request_type === 'issue')
                                            Borrow Request
                                        @elseif($borrow->request_type === 'return')
                                            Return Request
                                        @else
                                            {{ ucfirst($borrow->request_type) }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($borrow->status == 'pending_issue')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-600">
                                                <i class="fa-solid fa-hourglass-half"></i> Pending
                                            </span>
                                        @elseif($borrow->status == 'issued')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-600">
                                                <i class="fa-solid fa-check-circle"></i> Issued
                                            </span>
                                        @elseif($borrow->status == 'pending_return')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-600">
                                                <i class="fa-solid fa-rotate-left"></i> Return Notice Sent
                                            </span>
                                        @elseif($borrow->status == 'returned')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-600">
                                                <i class="fa-solid fa-undo"></i> Returned
                                            </span>
                                        @elseif($borrow->status == 'declined')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-600">
                                                <i class="fa-solid fa-times-circle"></i> Declined
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $borrow->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">
                                        @if($borrow->status === 'issued')
                                            <form action="{{ route('return.request', $borrow->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-white text-sm font-semibold hover:bg-green-700 transition">
                                                    <i class="fa-solid fa-rotate-left"></i> Return
                                                </button>
                                            </form>
                                        @elseif($borrow->status === 'pending_return')
                                            <span class="text-sm text-slate-500">Waiting for admin</span>
                                        @else
                                            <span class="text-sm text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 text-center py-6 border-t border-slate-800 mt-12">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-sm">&copy; 2026 Library Management System. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const navLinks = document.getElementById('nav-links');
        menuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('hidden');
        });
    </script>
</body>
</html>
