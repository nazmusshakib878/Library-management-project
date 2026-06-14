
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System | Books</title>
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

                    @auth
                        <li><a class="hover:text-blue-400 transition" href="/profile"><i class="fa-solid fa-user mr-1"></i> Profile</a></li>
                        @if(auth()->user()->isAdmin)
                            <li><a class="hover:text-blue-400 transition" href="/admin/dashboard"><i class="fa-solid fa-chart-line mr-1"></i> Admin Dashboard</a></li>
                        @endif
                    @endauth
                    
                    @guest
                        <li><a class="hover:text-blue-400 transition" href="/issuebook"><i class="fa-solid fa-bookmark mr-1"></i> Issue Book</a></li>
                        <li><a class="hover:text-blue-400 transition" href="/returnbook"><i class="fa-solid fa-rotate-left mr-1"></i> Return Book</a></li>
                    @endguest
                </ul>

                @auth
                    <form action="/logout" method="POST" class="mt-4 md:mt-0 md:ml-6">
                        @csrf
                        <button type="submit" class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold transition">
                            <i class="fa-solid fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <div class="mt-4 md:mt-0 md:ml-6 flex flex-col md:flex-row gap-2">
                        <a class="bg-white hover:bg-slate-100 text-slate-900 px-4 py-2 rounded font-semibold transition text-center" href="/login">
                            <i class="fa-solid fa-right-to-bracket mr-1"></i> Login
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto mt-6 px-6">
            <div class="rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-emerald-700 flex items-center gap-3">
                <i class="fa-solid fa-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto mt-6 px-6">
            <div class="rounded-lg bg-red-50 border border-red-200 p-4 text-red-700 flex items-center gap-3">
                <i class="fa-solid fa-exclamation-circle text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Books Section -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Section Heading -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800">
                    <i class="fa-solid fa-book mr-2"></i>Books Collection
                </h2>
                <p class="text-slate-500 mt-2">
                    Browse our available books and submit borrow requests
                </p>
            </div>

            @if($books->isEmpty())
                <div class="text-center py-12">
                    <div class="text-slate-400 text-5xl mb-4">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <p class="text-slate-500 text-lg">No books available at the moment</p>
                </div>
            @else
                <!-- Books Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($books as $book)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:-translate-y-1 transition duration-300">
                            <!-- Book Image -->
                            <div class="w-full h-64 bg-slate-100 flex items-center justify-center overflow-hidden">
                                @if($book->image_url)
                                    <img src="{{ $book->image_url }}" alt="{{ $book->title }} cover" class="w-full h-full object-cover object-center">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-400 to-slate-600 flex items-center justify-center text-white text-6xl">
                                        <i class="fa-solid fa-book"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Book Details -->
                            <div class="p-5">
                                <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded font-semibold">
                                    {{ $book->category ?? 'General' }}
                                </span>

                                <h3 class="text-lg font-bold text-slate-800 mt-3 line-clamp-2">
                                    {{ $book->title }}
                                </h3>

                                <p class="text-slate-500 text-sm mt-1">
                                    Author: {{ $book->author }}
                                </p>

                                <p class="text-slate-600 text-sm mt-2">
                                    ISBN: {{ $book->isbn }}
                                </p>

                                <p class="text-slate-600 text-sm mt-2">
                                    @if($book->copies_available > 0)
                                        <span class="text-green-600 font-semibold">
                                            <i class="fa-solid fa-check"></i> {{ $book->copies_available }}/{{ $book->copies_total }} Available
                                        </span>
                                    @else
                                        <span class="text-red-600 font-semibold">
                                            <i class="fa-solid fa-times"></i> Not Available
                                        </span>
                                    @endif
                                </p>

                                @auth
                                    @if($book->copies_available > 0)
                                        <form action="{{ route('borrow.request', $book->id) }}" method="POST" class="mt-4">
                                            @csrf
                                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-semibold transition">
                                                <i class="fa-solid fa-bookmark mr-1"></i> Borrow Request
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full bg-slate-300 text-slate-600 py-2 rounded font-semibold cursor-not-allowed mt-4">
                                            <i class="fa-solid fa-times-circle mr-1"></i> Unavailable
                                        </button>
                                    @endif
                                @endauth

                                @guest
                                    <a href="/login" class="w-full block mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-semibold text-center transition">
                                        <i class="fa-solid fa-bookmark mr-1"></i> Borrow Request
                                    </a>
                                @endguest
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 text-center py-6 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-sm">&copy; 2026 Library Management System. All Rights Reserved.</p>
            <p class="text-xs text-slate-600 mt-1">Designed securely with Laravel & Tailwind CSS</p>
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
