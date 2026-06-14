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
                    <li><a class="text-white hover:text-blue-400 transition" href="/home"><i class="fa-solid fa-house mr-1"></i> Home</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/books"><i class="fa-solid fa-book mr-1"></i> Books</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/issuebook"><i class="fa-solid fa-bookmark mr-1"></i> Issue Book</a></li>
                    <li><a class="hover:text-blue-400 transition" href="/returnbook"><i class="fa-solid fa-rotate-left mr-1"></i> Return Book</a></li>
                    @auth
                        @if(auth()->user()->isAdmin)
                            <li><a class="hover:text-blue-400 transition" href="/admin/dashboard"><i class="fa-solid fa-chart-line mr-1"></i> Admin Dashboard</a></li>
                        @endif
                    @endauth
                </ul>

            </div>

        </div>
    </nav>


    <!-- ========================================================= -->
    <!-- 2. HERO SECTION (Welcome Panel) -->
    <!-- ========================================================= -->
    <!-- relative: Required for absolute positioning of background layer, py-48: Height configuration via top/bottom padding -->
    <section class="relative bg-slate-900 text-white py-48 md:py-50 px-6 overflow-hidden">
        
        <!-- [BACKGROUND OVERLAY] - Sets library cover image, opacity-20 fades the background photo to ensure absolute readability for overlay text -->
        <div class="absolute inset-0 opacity-20 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1600&auto=format&fit=crop');"></div>
        
        <!-- [CONTENT CONTAINER] - Centers all textual element headings and action buttons using text-center -->
        <div class="relative max-w-4xl mx-auto text-center">
            <!-- text-4xl md:text-5xl: Responsive main title scaling dynamically across screens -->
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight">Modern Library Management System</h1>
            
            <!-- text-slate-400: Light gray tint applied to subheadings for visual hierarchy -->
            <p class="text-lg md:text-xl text-slate-400 mb-8 max-w-2xl mx-auto">An efficient digital solution to manage book inventories, student records, and instant borrowing tracking in one automated platform.</p>
            
            <!-- [CTA ACTION BUTTONS] - Core user landing call-to-action buttons for guests and signed-in users -->
            <div class="flex gap-4 justify-center flex-wrap">
                @guest
                    <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded shadow transition">Login</a>
                @else
                    <a href="/profile" class="bg-white text-slate-900 border border-slate-200 px-6 py-3 rounded shadow font-semibold transition hover:bg-slate-100">My Profile</a>
                @endguest
            </div>
        </div>
    </section>


    <!-- ========================================================= -->
    <!-- 3. LIBRARY STATISTICS SECTION -->
    <!-- ========================================================= -->
    <!-- py-16: Consistent padding blocks between sectional components -->
    <section class="max-w-7xl mx-auto py-16 px-6">
        
        <!-- Section Header Title & Subtitle descriptions -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-800">Library Statistics</h2>
            <p class="text-slate-500 mt-1">Real-time breakdown of our current database records</p>
        </div>
        
        <!-- grid-cols-1 sm:grid-cols-2 md:grid-cols-4: Responsive layout configurations dividing columns based on target user screen size -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            
            <!-- Card 1: Total Books counter panel (Features bottom blue border with interactive hover translate animations) -->
            <div class="bg-white p-6 rounded-lg shadow-sm text-center border-b-4 border-blue-600 hover:-translate-y-1 transition duration-300">
                <div class="text-blue-600 text-3xl mb-2"><i class="fa-solid fa-book-bookmark"></i></div>
                <h3 class="text-2xl font-bold text-slate-800">5,000+</h3>
                <p class="text-slate-500 text-sm font-medium">Total Books</p>
            </div>
            
            <!-- Card 2: Registered Students counter (Features bottom green border line accent) -->
            <div class="bg-white p-6 rounded-lg shadow-sm text-center border-b-4 border-green-600 hover:-translate-y-1 transition duration-300">
                <div class="text-green-600 text-3xl mb-2"><i class="fa-solid fa-users"></i></div>
                <h3 class="text-2xl font-bold text-slate-800">1,200+</h3>
                <p class="text-slate-500 text-sm font-medium">Registered Students</p>
            </div>
            
            <!-- Card 3: Issued Books counter (Features bottom amber border line accent) -->
            <div class="bg-white p-6 rounded-lg shadow-sm text-center border-b-4 border-amber-500 hover:-translate-y-1 transition duration-300">
                <div class="text-amber-500 text-3xl mb-2"><i class="fa-solid fa-hand-holding-hand"></i></div>
                <h3 class="text-2xl font-bold text-slate-800">350+</h3>
                <p class="text-slate-500 text-sm font-medium">Currently Issued</p>
            </div>
            
            <!-- Card 4: Categories counter (Features bottom red border line accent) -->
            <div class="bg-white p-6 rounded-lg shadow-sm text-center border-b-4 border-red-600 hover:-translate-y-1 transition duration-300">
                <div class="text-red-600 text-3xl mb-2"><i class="fa-solid fa-list-check"></i></div>
                <h3 class="text-2xl font-bold text-slate-800">25+</h3>
                <p class="text-slate-500 text-sm font-medium">Book Categories</p>
            </div>
        </div>
    </section>


    <!-- ========================================================= -->
    <!-- 4. CORE LIBRARY FEATURES SECTION -->
    <!-- ========================================================= -->
    <!-- bg-white: Clean white background layer, shadow-inner: Creates depth using soft inner shadows -->
    <section class="bg-white py-16 shadow-inner">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Core Feature section informational header titles -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800">Core Library Features</h2>
                <p class="text-slate-500 mt-1">Explore the modular functionalities available for administrators</p>
            </div>
            
            <!-- grid-cols-1 md:grid-cols-2 lg:grid-cols-4: 4-Column responsive grid layout matching standard UI dashboards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Box 1: Book Management Module (Equipped with image header and card icon) -->
                <div class="bg-slate-50 p-6 rounded-lg text-center shadow-sm flex flex-col items-center">
                    <!-- Feature Image Thumbnail (Set with uniform h-32 height and cover clipping parameters) -->
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=400&auto=format&fit=crop" alt="Book Management" class="w-full h-32 object-cover rounded mb-4 shadow-sm">
                    <div class="text-blue-600 text-4xl mb-3"><i class="fa-solid fa-swatchbook"></i></div>
                    <h5 class="text-lg font-bold text-slate-800 mb-2">Book Management</h5>
                    <p class="text-slate-500 text-xs leading-relaxed">Effortlessly add new records, search inventory data, and modify or delete books instantly.</p>
                </div>
                
                <!-- Box 2: Student Directory Module -->
                <div class="bg-slate-50 p-6 rounded-lg text-center shadow-sm flex flex-col items-center">
                    <!-- Relevant imagery contextualized for academic user profiles -->
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=400&auto=format&fit=crop" alt="Student Directory" class="w-full h-32 object-cover rounded mb-4 shadow-sm">
                    <div class="text-green-600 text-4xl mb-3"><i class="fa-solid fa-user-gear"></i></div>
                    <h5 class="text-lg font-bold text-slate-800 mb-2">Student Directory</h5>
                    <p class="text-slate-500 text-xs leading-relaxed">Track student basic profile data, university courses, and current membership status effectively.</p>
                </div>
                
                <!-- Box 3: Issue & Return Automated Module -->
                <div class="bg-slate-50 p-6 rounded-lg text-center shadow-sm flex flex-col items-center">
                    <!-- Visual banner indicating books tracking and borrowing processes -->
                    <img src="https://images.unsplash.com/photo-1506880018603-83d5b814b5a6?q=80&w=400&auto=format&fit=crop" alt="Issue & Return" class="w-full h-32 object-cover rounded mb-4 shadow-sm">
                    <div class="text-amber-500 text-4xl mb-3"><i class="fa-solid fa-clock-rotate-left"></i></div>
                    <h5 class="text-lg font-bold text-slate-800 mb-2">Issue & Return</h5>
                    <p class="text-slate-500 text-xs leading-relaxed">Automate the borrow logs, return deadlines, and manage overdue fine collection dynamically.</p>
                </div>
                
                <!-- Box 4: Analytical Data Reports Module -->
                <div class="bg-slate-50 p-6 rounded-lg text-center shadow-sm flex flex-col items-center">
                    <!-- Feature visualization image mapped for reports, charts and analytics modules -->
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=400&auto=format&fit=crop" alt="Analytics Reports" class="w-full h-32 object-cover rounded mb-4 shadow-sm">
                    <div class="text-red-600 text-4xl mb-3"><i class="fa-solid fa-chart-pie"></i></div>
                    <h5 class="text-lg font-bold text-slate-800 mb-2">Analytics Reports</h5>
                    <p class="text-slate-500 text-xs leading-relaxed">Generate detailed analytical tables regarding stock levels, log statistics, and reports.</p>
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
