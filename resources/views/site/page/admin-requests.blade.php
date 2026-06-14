<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pending Issue Requests</title>
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
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Pending Issue Requests</h1>
                <p class="text-slate-500 mt-2">Review student book issue requests and accept them from here.</p>
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
                            <th class="px-6 py-4 text-left">Student</th>
                            <th class="px-6 py-4 text-left">Book</th>
                            <th class="px-6 py-4 text-left">Requested On</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($requests as $request)
                            <tr>
                                <td class="px-6 py-4 text-slate-800 font-medium">{{ $request->student->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $request->book->title }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $request->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-amber-100 text-amber-700 px-3 py-1 text-xs font-semibold">{{ ucfirst(str_replace('_', ' ', $request->status)) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="/admin/requests/{{ $request->id }}/accept" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">Accept</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">There are no pending issue requests right now.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
