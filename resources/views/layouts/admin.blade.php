<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KodeSkul</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans flex h-screen overflow-hidden">

    <aside class="w-64 bg-slate-900 text-white flex flex-col hidden md:flex">
        <div class="p-6 text-center border-b border-slate-800">
            <a href="/" class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500">
                KodeSkul Admin
            </a>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 bg-indigo-600 rounded-xl font-bold transition">
                <span>📚</span> Kelola Materi
            </a>
            <a href="/" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-800 rounded-xl font-semibold text-slate-400 hover:text-white transition">
                <span>🌍</span> Lihat Website
            </a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 bg-red-500/10 text-red-500 font-bold rounded-lg hover:bg-red-500 hover:text-white transition">
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <header class="bg-white shadow-sm p-6 flex justify-between items-center z-10">
            <h2 class="text-xl font-bold text-slate-800">Dashboard Control Panel</h2>
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-slate-500">Halo, {{ auth()->user()->name }} 👑</span>
            </div>
        </header>

        <div class="p-6 md:p-10 flex-1">
            @yield('content')
        </div>
    </main>

</body>
</html>