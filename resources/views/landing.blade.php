<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KodeSkul - E-Learning Masa Kini</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* 1. Animasi Masuk (Fade In + Slide Up) */
        .animate-fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(40px);
        }
        
        /* Jeda waktu animasi agar elemen muncul bergantian */
        .delay-100 { animation-delay: 0.2s; }
        .delay-200 { animation-delay: 0.4s; }
        .delay-300 { animation-delay: 0.6s; }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 2. Animasi Background Melayang */
        .floating-shape {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
    </style>
</head>
<body class="bg-slate-50 overflow-hidden relative flex items-center justify-center min-h-screen selection:bg-indigo-100 selection:text-indigo-900">

    {{-- Efek Latar Belakang Estetik (Blob Colors) --}}
    <div class="absolute top-[-10%] left-[-10%] w-[30rem] h-[30rem] bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 floating-shape"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[30rem] h-[30rem] bg-rose-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 floating-shape" style="animation-delay: 2s;"></div>

    {{-- Konten Utama Hero --}}
    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
        
        {{-- Badge Animasi --}}
        <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/80 backdrop-blur-md text-indigo-700 font-bold text-sm mb-8 animate-fade-in-up border border-indigo-100 shadow-sm">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-600"></span>
            </span>
            E-Learning SMK Interaktif
        </div>
        
        {{-- Judul Utama --}}
        <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 mb-6 tracking-tight animate-fade-in-up delay-100 leading-tight">
            Belajar Coding Lebih <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-rose-500">Seru & Menyenangkan</span>
        </h1>
        
        {{-- Deskripsi Singkat --}}
        <p class="text-lg md:text-xl text-slate-600 mb-12 leading-relaxed max-w-2xl mx-auto animate-fade-in-up delay-200 font-medium">
            Tinggalkan cara lama! Di KodeSkul, kamu akan menguasai HTML, CSS, dan JavaScript lewat video interaktif dan sistem kuis yang langsung muncul saat kamu menonton.
        </p>
        
        {{-- Tombol Aksi (Otomatis menyesuaikan status login) --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-5 animate-fade-in-up delay-300">
            @auth
                {{-- Jika User SUDAH Login --}}
                <a href="/beranda" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white font-extrabold rounded-2xl hover:bg-indigo-700 hover:shadow-2xl hover:shadow-indigo-200 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                    🚀 Lanjut Belajar Yuk!
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-500 font-bold rounded-2xl hover:text-red-500 hover:bg-red-50 transition-all">
                        Logout
                    </button>
                </form>
            @else
                {{-- Jika User BELUM Login --}}
                <a href="/login" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white font-extrabold rounded-2xl hover:bg-indigo-700 hover:shadow-2xl hover:shadow-indigo-200 transition-all transform hover:-translate-y-1">
                    Masuk Sekarang
                </a>
                <a href="/register" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl border-2 border-slate-200 hover:border-indigo-600 hover:text-indigo-600 transition-all transform hover:-translate-y-1">
                    Daftar Akun Baru
                </a>
            @endauth
        </div>
    </div>

</body>
</html>