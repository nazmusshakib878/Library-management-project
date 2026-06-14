<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Sets the character encoding for the website (UTF-8 supports all global languages and symbols) -->
    <meta charset="UTF-8">
    
    <!-- Ensures the website is fully responsive across mobile, tablet, and desktop viewports -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Website title displayed on the browser tab -->
    <title>Library Management System 1</title>
    
    <!-- Tailwind CSS Framework integration via CDN link -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Linkup for using icons throughout the website -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 antialiased">
    <!-- bg-slate-50: Light ash background, antialiased: Smooths out fonts for better readability -->

    <!-- ========================================================= -->
    <!-- 1. NAVIGATION BAR (Navbar Section) -->
    <!-- ========================================================= -->
    <!-- bg-slate-900: Dark background, text-white: White text color, py-4: Vertical padding, px-6: Horizontal padding -->
    <nav class="bg-slate-900 text-white py-4 px-6 md:px-12 shadow-md">
        
        <!-- max-w-7xl: Maximum width limit, mx-auto: Centers the container, flex: Flexbox layout, justify-between: Keeps logo on left and links on right -->
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            
            <!-- [LOGO] - Main brand identity placed on the LEFT side with a bold blue text style -->
            <a class="text-2xl font-bold text-blue-500 tracking-wide flex items-center" href="/">
                Library<span class="text-white">MS</span> <i class="fa-solid fa-book-open-reader ml-2"></i>
            </a>

            <!-- [MOBILE TOGGLE BUTTON] - 3-Dot menu icon visible only on mobile screens (hidden on desktop via md:hidden) -->
            <div class="md:hidden">
                <button id="menu-btn" class="text-white text-2xl focus:outline-none">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
            </div>
            
            <!-- [NAVIGATION LINKS] - Menu items placed on the RIGHT side (hidden on mobile by default, flex on desktop) -->
            <div id="nav-links" class="hidden md:flex md:items-center md:gap-6 absolute md:static bg-slate-900 w-full md:w-auto left-0 top-16 p-6 md:p-0 z-50">
                <ul class="flex flex-col md:flex-row gap-4 md:gap-6 text-sm font-semibold text-slate-300">
                    <li><a class="text-white hover:text-blue-400 transition" href="/"><i class="fa-solid fa-house mr-1"></i> Home</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/admin/books"><i class="fa-solid fa-book mr-1"></i> Books</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/admin/books/create"><i class="fa-solid fa-plus mr-1"></i> Add Book</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/admin/requests"><i class="fa-solid fa-bookmark mr-1"></i> Requests</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/admin/returns"><i class="fa-solid fa-rotate-left mr-1"></i> Returns</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/admin/students"><i class="fa-solid fa-graduation-cap mr-1"></i> Students</a></li>
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

<!-- ========================================================= -->
<!-- ADMIN DASHBOARD SECTION -->
<!-- ========================================================= -->
<section class="py-16 bg-slate-50">

    <div class="max-w-7xl mx-auto px-6">

        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-800">
                Admin Dashboard
            </h2>

            <p class="text-slate-500 mt-2">
                Monitor books, students, and library activities in real time.
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-10">

            <!-- Total Books -->
            <div class="bg-white p-6 rounded-lg shadow-sm text-center border-b-4 border-blue-600">
                <i class="fa-solid fa-book text-3xl text-blue-600 mb-2"></i>
                <h3 class="text-2xl font-bold text-slate-800">{{ $booksCount }}</h3>
                <p class="text-slate-500 text-sm">Total Books</p>
            </div>

            <!-- Students -->
            <div class="bg-white p-6 rounded-lg shadow-sm text-center border-b-4 border-green-600">
                <i class="fa-solid fa-users text-3xl text-green-600 mb-2"></i>
                <h3 class="text-2xl font-bold text-slate-800">{{ $studentsCount }}</h3>
                <p class="text-slate-500 text-sm">Registered Students</p>
            </div>

            <!-- Issued Books -->
            <div class="bg-white p-6 rounded-lg shadow-sm text-center border-b-4 border-amber-500">
                <i class="fa-solid fa-bookmark text-3xl text-amber-500 mb-2"></i>
                <h3 class="text-2xl font-bold text-slate-800">{{ $issuedCount }}</h3>
                <p class="text-slate-500 text-sm">Issued Books</p>
            </div>

            <!-- Pending Returns -->
            <div class="bg-white p-6 rounded-lg shadow-sm text-center border-b-4 border-red-600">
                <i class="fa-solid fa-rotate-left text-3xl text-red-600 mb-2"></i>
                <h3 class="text-2xl font-bold text-slate-800">{{ $pendingReturnCount }}</h3>
                <p class="text-slate-500 text-sm">Pending Returns</p>
            </div>

        </div>

        <!-- Quick Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <a href="/admin/books" class="group block rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-blue-600 text-3xl"><i class="fa-solid fa-book"></i></div>
                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold uppercase text-blue-700">Books</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Manage Books</h3>
                <p class="text-slate-500 text-sm">Add, edit, or remove book inventory and update availability.</p>
            </a>

            <a href="/admin/students" class="group block rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-green-600 text-3xl"><i class="fa-solid fa-graduation-cap"></i></div>
                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold uppercase text-green-700">Students</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Student List</h3>
                <p class="text-slate-500 text-sm">View and manage registered student accounts.</p>
            </a>

            <a href="/admin/requests" class="group block rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-amber-600 text-3xl"><i class="fa-solid fa-bookmark"></i></div>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase text-amber-700">Requests</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Issue Requests</h3>
                <p class="text-slate-500 text-sm">Review and accept pending borrow requests from students.</p>
            </a>

            <a href="/admin/returns" class="group block rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-red-600 text-3xl"><i class="fa-solid fa-rotate-right"></i></div>
                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold uppercase text-red-700">Returns</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Return Notices</h3>
                <p class="text-slate-500 text-sm">Mark returned books as received and update availability.</p>
            </a>
        </div>

        <!-- Recent Activity Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">

            <!-- Table Header -->
            <div class="p-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-800">
                    Recent Issue Records
                </h3>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="p-3">Student</th>
                            <th class="p-3">Book</th>
                            <th class="p-3">Issue Date</th>
                            <th class="p-3">Return Date</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr class="border-b">
                            <td class="p-3">Ahmed Rahman</td>
                            <td class="p-3">Clean Code</td>
                            <td class="p-3">2026-06-01</td>
                            <td class="p-3">2026-06-10</td>
                            <td class="p-3">
                                <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                                    Returned
                                </span>
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="p-3">Fatema Akter</td>
                            <td class="p-3">The Universe</td>
                            <td class="p-3">2026-06-05</td>
                            <td class="p-3">2026-06-15</td>
                            <td class="p-3">
                                <span class="bg-amber-100 text-amber-600 px-2 py-1 rounded text-xs">
                                    Issued
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="p-3">Hasan Ali</td>
                            <td class="p-3">Database Systems</td>
                            <td class="p-3">2026-06-07</td>
                            <td class="p-3">2026-06-17</td>
                            <td class="p-3">
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">
                                    Overdue
                                </span>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</section>

    <!-- ========================================================= -->
    <!-- 5. FOOTER SECTION -->
    <!-- ========================================================= -->
    <!-- border-t border-slate-800: Visually isolates the footer with a clean, thin top border separator line -->
    <footer class="bg-slate-900 text-slate-400 text-center py-6 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Standard Copyright legal notification text -->
            <p class="text-sm">&copy; 2026 Library Management System. All Rights Reserved.</p>
            <!-- Subtitle detailing engine and style frameworks used -->
            <p class="text-xs text-slate-600 mt-1">Designed securely with Laravel & Tailwind CSS</p>
        </div>
    </footer>


    <!-- ========================================================= -->
    <!-- 6. JAVASCRIPT CODE (For Responsive Mobile Navbar Toggle Operations) -->
    <!-- ========================================================= -->
    <script>
        // Catching target HTML nodes dynamically using unique Element ID string identifiers
        const menuBtn = document.getElementById('menu-btn');
        const navLinks = document.getElementById('nav-links');

        // Attaches event listeners watching active user click signals to dynamically alternate hidden layout utility styles
        menuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('hidden');
        });
    </script>
</body>
</html>