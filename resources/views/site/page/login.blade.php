<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System | Login</title>
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
            <div class="bg-slate-900 text-white p-10 rounded-3xl shadow-2xl overflow-hidden relative">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(96,165,250,0.25),_transparent_45%)]"></div>
                <div class="relative z-10">
                    <h1 class="text-4xl font-extrabold mb-4">Welcome Back</h1>
                    <p class="text-slate-300 leading-relaxed">Sign in to access your library dashboard, manage books, students, and tracking features securely.</p>
                    <div class="mt-10 grid gap-4 sm:grid-cols-2">
                        <div class="bg-white/10 border border-white/10 rounded-3xl p-5">
                            <div class="text-blue-400 text-4xl mb-3"><i class="fa-solid fa-book"></i></div>
                            <h3 class="font-bold text-lg">Browse Books</h3>
                            <p class="text-slate-300 text-sm mt-2">Explore inventory, availability and categories instantly.</p>
                        </div>
                        <div class="bg-white/10 border border-white/10 rounded-3xl p-5">
                            <div class="text-amber-400 text-4xl mb-3"><i class="fa-solid fa-user-graduate"></i></div>
                            <h3 class="font-bold text-lg">Student Records</h3>
                            <p class="text-slate-300 text-sm mt-2">View student registration details and borrowing history.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 sm:p-10">
                <div class="mb-8 text-center">
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <i class="fa-solid fa-right-to-bracket text-2xl"></i>
                    </span>
                    <h2 class="text-3xl font-bold text-slate-900">Login to Your Account</h2>
                    <p class="text-slate-500 mt-2">Enter your credentials below to continue.</p>
                </div>

                <?php if($errors->any()): ?>
                    <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-4 text-red-700 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="flex items-center justify-end text-sm text-slate-500">
                        <a href="#" class="hover:text-blue-600">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-2xl px-4 py-3 transition">Login</button>
                </form>

                <div class="mt-8 text-center text-slate-500 text-sm">
                    <p>New here? <a href="/register" class="text-blue-600 hover:text-blue-700 font-semibold">Create account</a></p>
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
