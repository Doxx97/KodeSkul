<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KodeSkul</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans">
    
    @if(session('success'))
        <div id="toast-success" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-[100] flex items-center px-6 py-3 mb-4 text-slate-900 bg-white rounded-full shadow-xl border border-slate-100 transition-all duration-500 opacity-0 translate-y-[-1rem]">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-full">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
            </div>
            <div class="ms-3 text-sm font-bold">{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div id="toast-error" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-[100] flex items-center px-6 py-3 mb-4 text-white bg-red-500 rounded-full shadow-xl transition-all duration-500 opacity-0 translate-y-[-1rem]">
        <div class="ms-3 text-sm font-bold">{{ session('error') }}</div>
    </div>
    @endif

    <nav class="w-full p-6 flex justify-between items-center bg-white shadow-sm relative z-50">
    <a href="/" class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-600">
        KodeSkul.
    </a>
    <div class="flex items-center space-x-6 font-semibold text-sm">
        <a href="{{ route('materi.pilih') }}" class="hover:text-indigo-500 transition">Materi</a>
        <a href="/quiz" class="hover:text-indigo-500 transition">Quiz</a>
        
        @guest
            <a href="/login" class="px-5 py-2 bg-slate-900 text-white rounded-full hover:bg-slate-800 transition">Login</a>
        @endguest

        @auth
            <div class="relative">
                <button id="profileBtn" class="flex items-center focus:outline-none transition transform hover:scale-105">
                    <img src="{{ auth()->user()->profile_photo_path ? asset('storage/'.auth()->user()->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=6366f1&color=fff' }}" 
                        alt="Profile" 
                        class="w-10 h-10 rounded-full border-2 border-indigo-100 shadow-sm object-cover">
                </button>
                
                <div id="profileDropdown" class="hidden absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-50 mb-1">
                        <p class="text-xs text-slate-400">Signed in as</p>
                        <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    </div>
                    <a href="/profile" class="block px-4 py-2 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">Edit Profile</a>
                    
                    <form action="/logout" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('profileBtn');
        const dropdown = document.getElementById('profileDropdown');
        
        if(btn && dropdown) {
            btn.addEventListener('click', () => {
                dropdown.classList.toggle('hidden');
            });

            // Tutup dropdown kalau klik di luar
            document.addEventListener('click', (e) => {
                if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        }
    });
    document.addEventListener('DOMContentLoaded', () => {
                const toast = document.getElementById('toast-success');
                
                // Animasi masuk (muncul)
                setTimeout(() => {
                    toast.classList.remove('opacity-0', 'translate-y-[-1rem]');
                    toast.classList.add('opacity-100', 'translate-y-0');
                }, 100);

                // Animasi keluar (hilang otomatis setelah 3 detik)
                setTimeout(() => {
                    toast.classList.remove('opacity-100', 'translate-y-0');
                    toast.classList.add('opacity-0', 'translate-y-[-1rem]');
                    
                    // Hapus elemen dari DOM setelah animasi selesai
                    setTimeout(() => {
                        toast.remove();
                    }, 500);
                }, 3000); // 3000 milidetik = 3 detik
            });
    document.addEventListener('DOMContentLoaded', () => {
            const toastErr = document.getElementById('toast-error');
            setTimeout(() => {
                toastErr.classList.remove('opacity-0', 'translate-y-[-1rem]');
                toastErr.classList.add('opacity-100', 'translate-y-0');
            }, 100);

            setTimeout(() => {
                toastErr.classList.remove('opacity-100', 'translate-y-0');
                toastErr.classList.add('opacity-0', 'translate-y-[-1rem]');
                setTimeout(() => { toastErr.remove(); }, 500);
            }, 3000);
        });
</script>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="text-center p-6 bg-slate-900 text-slate-400 text-sm mt-12">
        <p>© 2026 KodeSkul. Built with Laravel & Tailwind.</p>
    </footer>

</body>
</html>