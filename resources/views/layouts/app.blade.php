<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KodeSkul E-Learning</title>
    
    {{-- Memanggil Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Font tambahan agar terlihat lebih modern --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-100 selection:text-indigo-900">

    {{-- ================= NAVBAR MULAI DI SINI ================= --}}
    <nav class="flex justify-between items-center px-6 lg:px-12 py-4 bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        
        {{-- BAGIAN KIRI: Logo & Menu Navigasi --}}
        <div class="flex items-center gap-10">
            {{-- Logo --}}
            <a href="/" class="text-2xl font-extrabold text-indigo-600 tracking-tight flex items-center gap-2">
                <span class="w-8 h-8 bg-indigo-600 text-white rounded-lg flex items-center justify-center text-sm">{"}</span>
                KodeSkul.
            </a>

            {{-- Menu Navigasi dengan Penanda Aktif & Animasi --}}
        <div class="hidden md:flex items-center gap-8 font-semibold text-sm">
            
           {{-- MENU BERANDA --}}
{{-- Aktif jika URL adalah /beranda ATAU diawali dengan /materi-list/ --}}
<a href="/beranda" class="relative py-2 group {{ request()->is('beranda') || request()->is('materi-list*') ? 'text-indigo-600 font-bold' : 'text-slate-500 hover:text-indigo-600' }} transition-colors duration-300 font-medium">
    Beranda
    <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 h-[3px] bg-indigo-600 rounded-t-full transition-all duration-300 {{ request()->is('beranda') || request()->is('materi-list*') ? 'w-full' : 'w-0 group-hover:w-full opacity-50 group-hover:opacity-100' }}"></span>
</a>

{{-- MENU PROGRES (Pengganti Materi) --}}
{{-- Hanya aktif jika URL adalah /progres --}}
<a href="/progres" class="relative py-2 group {{ request()->is('progres*') ? 'text-indigo-600 font-bold' : 'text-slate-500 hover:text-indigo-600' }} transition-colors duration-300 font-medium">
    Progres
    <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 h-[3px] bg-indigo-600 rounded-t-full transition-all duration-300 {{ request()->is('progres*') ? 'w-full' : 'w-0 group-hover:w-full opacity-50 group-hover:opacity-100' }}"></span>
</a>

{{-- MENU QUIZ --}}
<a href="/quiz" class="relative py-2 group {{ request()->is('quiz*') ? 'text-indigo-600 font-bold' : 'text-slate-500 hover:text-indigo-600' }} transition-colors duration-300 font-medium">
    Quiz
    <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 h-[3px] bg-indigo-600 rounded-t-full transition-all duration-300 {{ request()->is('quiz*') ? 'w-full' : 'w-0 group-hover:w-full opacity-50 group-hover:opacity-100' }}"></span>
</a>

        </div>
        </div>

        {{-- BAGIAN KANAN: Avatar / Profil / Login --}}
        <div class="flex items-center gap-4">
            @auth
                {{-- Jika Admin, tampilkan link ke Dashboard --}}
                @if(Auth::user()->role === 'admin')
                    <a href="/admin/dashboard" class="hidden md:block text-sm font-bold text-slate-400 hover:text-indigo-600 transition mr-2">
                        Dashboard Admin
                    </a>
                @endif

                {{-- Area Profil User --}}
                <div class="flex items-center gap-3">
                    <a href="/profile" class="flex items-center gap-3 cursor-pointer group">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-slate-700 leading-none group-hover:text-indigo-600 transition">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-slate-400 mt-1 capitalize">{{ Auth::user()->role ?? 'Siswa' }}</p>
                        </div>
                        <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=e0e7ff&color=4f46e5' }}" 
                             alt="Profile" 
                             class="w-10 h-10 rounded-full object-cover border-2 border-indigo-50 group-hover:border-indigo-300 transition">
                    </a>
                </div>
                
                {{-- Tombol Logout --}}
                <form action="{{ route('logout') }}" method="POST" class="ml-1 pl-4 border-l border-slate-200">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition rounded-xl hover:bg-red-50" title="Keluar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            @else
                {{-- Jika Belum Login --}}
                <a href="/login" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                    Masuk / Daftar
                </a>
            @endauth
        </div>

    </nav>
    {{-- ================= NAVBAR SELESAI ================= --}}

    {{-- AREA KONTEN UTAMA DARI VIEW LAIN (Misal: index.blade.php) --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-slate-200 py-8 mt-12 text-center text-sm text-slate-500">
        <p>&copy; {{ date('Y') }} KodeSkul E-Learning SMK. Dibuat dengan ❤️ untuk pembelajaran.</p>
    </footer>

</body>
</html>