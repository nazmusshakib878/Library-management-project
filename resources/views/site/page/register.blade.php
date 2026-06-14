<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System | Register</title>
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
                    <li><a class="hover:text-blue-400 transition" href="/issuebook"><i class="fa-solid fa-bookmark mr-1"></i> Issue Book</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/returnbook"><i class="fa-solid fa-rotate-left mr-1"></i> Return Book</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="min-h-screen flex items-center justify-center py-16 px-6">
        <div class="max-w-6xl w-full grid gap-10 lg:grid-cols-[1.2fr_1fr] items-center">
            <div class="bg-blue-600 text-white p-10 rounded-3xl shadow-2xl overflow-hidden relative">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.24),_transparent_40%)]"></div>
                <div class="relative z-10">
                    <h1 class="text-4xl font-extrabold mb-4">Start your library journey</h1>
                    <p class="text-slate-200 leading-relaxed">Create your account to manage student records, track books, and issue or return books with ease.</p>
                    <div class="mt-10 grid gap-4 sm:grid-cols-2">
                        <div class="bg-white/10 border border-white/10 rounded-3xl p-5">
                            <div class="text-white text-4xl mb-3"><i class="fa-solid fa-user-plus"></i></div>
                            <h3 class="font-bold text-lg">Secure Access</h3>
                            <p class="text-slate-200 text-sm mt-2">Built-in protection for your library admin portal.</p>
                        </div>
                        <div class="bg-white/10 border border-white/10 rounded-3xl p-5">
                            <div class="text-white text-4xl mb-3"><i class="fa-solid fa-layer-group"></i></div>
                            <h3 class="font-bold text-lg">Easy Management</h3>
                            <p class="text-slate-200 text-sm mt-2">One place for books, students and borrowing workflows.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 sm:p-10">
                <div class="mb-8 text-center">
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-blue-600 mb-4">
                        <i class="fa-solid fa-user-circle text-2xl"></i>
                    </span>
                    <h2 class="text-3xl font-bold text-slate-900">Create your account</h2>
                    <p class="text-slate-500 mt-2">Fill in your details below to register.</p>
                </div>

                @if(session('success'))
                    <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-4 text-red-700">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/register" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Full name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500 outline-none" placeholder="Your full name">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500 outline-none" placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                        <input id="password" name="password" type="password" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500 outline-none" placeholder="Enter a secure password">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500 outline-none" placeholder="Repeat your password">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-2xl px-4 py-3 transition">Create Account</button>
                </form>

                <div class="mt-8 text-center text-slate-500 text-sm">
                    <p>Already have an account? <a href="/login" class="text-blue-600 hover:text-blue-700 font-semibold">Login here</a></p>
                </div>
            </div>
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
