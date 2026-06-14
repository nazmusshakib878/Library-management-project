<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Sets the character encoding for the website (UTF-8 supports all global languages and symbols) -->
    <meta charset="UTF-8">
    
    <!-- Ensures the website is fully responsive across mobile, tablet, and desktop viewports -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Website title displayed on the browser tab -->
    <title>Library Management System</title>
    
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
                
                <!-- flex-col: Elements stack vertically on mobile, md:flex-row: Elements align horizontally on large screens -->
                <ul class="flex flex-col md:flex-row gap-4 md:gap-6 text-sm font-semibold text-slate-300">
                    <!-- Added hover effects (hover:) to smoothly change link colors to blue on mouseover -->
                    <li><a class="text-white hover:text-blue-400 transition" href="/"><i class="fa-solid fa-house mr-1"></i> Home</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/books"><i class="fa-solid fa-book mr-1"></i> Books</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/issuebook"><i class="fa-solid fa-bookmark mr-1"></i> Issue Book</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/returnbook"><i class="fa-solid fa-rotate-left mr-1"></i> Return Book</a></li>
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


<!-- ========================================================= -->
<!-- RETURN BOOK SECTION -->
<!-- ========================================================= -->
<section class="py-16 bg-slate-50">

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-6">

        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-800">
                Return Book
            </h2>

            <p class="text-slate-500 mt-2">
                Send a return notice for books that are currently issued to you.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-emerald-700 max-w-4xl mx-auto">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-red-700 max-w-4xl mx-auto">
                {{ session('error') }}
            </div>
        @endif

        @if($issuedBooks->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-10 text-center max-w-3xl mx-auto">
                <i class="fa-solid fa-book-open-reader text-5xl text-slate-300 mb-4"></i>
                <p class="text-slate-500">You do not have any issued books to return.</p>
                <a href="/books" class="inline-flex items-center gap-2 mt-5 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-semibold transition">
                    <i class="fa-solid fa-book"></i> Browse Books
                </a>
            </div>
        @else
            <div class="overflow-x-auto bg-white rounded-lg shadow-sm border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-100 text-slate-600 uppercase tracking-wide text-xs">
                        <tr>
                            <th class="px-6 py-4 text-left">Book</th>
                            <th class="px-6 py-4 text-left">Issue Date</th>
                            <th class="px-6 py-4 text-left">Due Date</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($issuedBooks as $issue)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-900">{{ $issue->book->title }}</p>
                                    <p class="text-slate-500">{{ $issue->book->author ?? 'Unknown author' }}</p>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ optional($issue->issue_date)->format('Y-m-d') ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ optional($issue->due_date)->format('Y-m-d') ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    @if($issue->status === 'pending_return')
                                        <span class="rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-xs font-semibold">Return Notice Sent</span>
                                    @else
                                        <span class="rounded-full bg-green-100 text-green-700 px-3 py-1 text-xs font-semibold">Issued</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($issue->status === 'issued')
                                        <form action="{{ route('return.request', $issue->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-white font-semibold hover:bg-green-700 transition">
                                                <i class="fa-solid fa-rotate-left"></i> Send Return Notice
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-slate-500">Waiting for admin receive</span>
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
