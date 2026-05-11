@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-12 py-12 max-w-7xl">
    
    {{-- Header Section dengan Welcome Banner yang lebih "Pop" --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 to-purple-700 rounded-[2.5rem] p-8 md:p-12 mb-12 shadow-2xl shadow-indigo-200">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-indigo-400/20 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-center md:text-left">
                <span class="inline-block px-4 py-1.5 bg-indigo-500/30 border border-indigo-300/30 rounded-full text-indigo-50 text-sm font-bold tracking-widest uppercase mb-4 shadow-sm backdrop-blur-md">
                    Dashboard Belajar 🚀
                </span>
                <h1 class="text-4xl md:text-6xl font-black text-white mb-4 tracking-tighter leading-tight italic">
                    Halo, {{ Auth::check() ? Auth::user()->name : 'Siswa Hebat' }}!
                </h1>
                <p class="text-indigo-100 text-lg md:text-xl max-w-xl opacity-90 font-medium">
                    "Web development itu bukan cuma koding, tapi seni membangun masa depan." Ready untuk naik level hari ini?
                </p>
            </div>
            <div class="hidden lg:block animate-bounce-slow">
                <div class="text-8xl">👨‍💻</div>
            </div>
        </div>
    </div>

    {{-- Grid Aktivitas Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
        
        {{-- Card Materi --}}
        <a href="{{ route('blog.index') }}" class="group relative bg-white p-1 rounded-[2.5rem] transition-all hover:scale-[1.02] active:scale-95 shadow-xl shadow-slate-100 border border-slate-100">
            <div class="bg-white p-8 rounded-[2.3rem] flex items-center gap-6 h-full overflow-hidden">
                <div class="w-20 h-20 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center text-4xl shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shrink-0">
                    📚
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 mb-1 group-hover:text-indigo-600 transition tracking-tight uppercase italic">E-Learning Materi</h2>
                    <p class="text-slate-500 text-sm leading-relaxed">Akses modul pembelajaran lengkap berbasis teks untuk pemahaman teori mendalam.</p>
                </div>
            </div>
        </a>

        {{-- Card Quiz --}}
        <a href="/quiz" class="group relative bg-white p-1 rounded-[2.5rem] transition-all hover:scale-[1.02] active:scale-95 shadow-xl shadow-slate-100 border border-slate-100">
            <div class="bg-white p-8 rounded-[2.3rem] flex items-center gap-6 h-full overflow-hidden">
                <div class="w-20 h-20 bg-rose-50 text-rose-600 rounded-3xl flex items-center justify-center text-4xl shadow-inner group-hover:bg-rose-600 group-hover:text-white transition-all duration-500 shrink-0">
                    🎯
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 mb-1 group-hover:text-rose-600 transition tracking-tight uppercase italic">Quiz Live Code</h2>
                    <p class="text-slate-500 text-sm leading-relaxed">Uji seberapa jago logika coding kamu dengan kuis interaktif yang menantang.</p>
                </div>
            </div>
        </a>
    </div>

    {{-- Roadmap / Pilih Materi Section --}}
    <div class="space-y-12">
        <div class="flex flex-col items-center text-center max-w-2xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 leading-none mb-4">
                PILIH <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">MATERI</span> KAMU
            </h2>
            <div class="h-2 w-24 bg-indigo-600 rounded-full mb-6"></div>
            <p class="text-slate-500 text-lg font-medium">Video interaktif yang bikin kamu paham sampai ke akar-akarnya. Fokus, praktek, lalu kuasai!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            
            {{-- Card HTML --}}
            <div class="bg-white p-2 rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-100 group transition-all hover:-translate-y-4">
                <div class="p-8 h-full flex flex-col">
                    <div class="w-20 h-20 bg-orange-50 text-orange-600 rounded-[2rem] flex items-center justify-center text-4xl font-black mb-8 group-hover:rotate-12 transition-transform shadow-sm">
                        &lt;/&gt;
                    </div>
                    <h3 class="text-3xl font-black mb-4 text-slate-800 tracking-tighter uppercase italic">HTML 5</h3>
                    <p class="text-slate-500 mb-10 flex-grow leading-relaxed font-medium">
                        Pelajari struktur dasar halaman web. Fondasi kuat untuk karir developer masa depanmu.
                    </p>
                    <a href="{{ route('materi.list_per_kategori', ['category' => 'html']) }}" class="flex items-center justify-center gap-2 w-full py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-orange-500 transition-all shadow-lg active:scale-95 uppercase tracking-widest text-sm">
                        MULAI BELAJAR 🚀
                    </a>
                </div>
            </div>

            {{-- Card CSS --}}
            <div class="bg-white p-2 rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-100 group transition-all hover:-translate-y-4">
                <div class="p-8 h-full flex flex-col">
                    <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-[2rem] flex items-center justify-center text-4xl font-black mb-8 group-hover:rotate-12 transition-transform shadow-sm text-center">
                        #
                    </div>
                    <h3 class="text-3xl font-black mb-4 text-slate-800 tracking-tighter uppercase italic">CSS 3</h3>
                    <p class="text-slate-500 mb-10 flex-grow leading-relaxed font-medium">
                        Sulap struktur kaku jadi tampilan estetik. Warna, layout, dan animasi ada di sini!
                    </p>
                    <a href="{{ route('materi.list_per_kategori', ['category' => 'css']) }}" class="flex items-center justify-center gap-2 w-full py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-blue-600 transition-all shadow-lg active:scale-95 uppercase tracking-widest text-sm">
                        MULAI BELAJAR 🚀
                    </a>
                </div>
            </div>

            {{-- Card JS --}}
            <div class="bg-white p-2 rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-100 group transition-all hover:-translate-y-4">
                <div class="p-8 h-full flex flex-col">
                    <div class="w-20 h-20 bg-yellow-50 text-yellow-600 rounded-[2rem] flex items-center justify-center text-4xl font-black mb-8 group-hover:rotate-12 transition-transform shadow-sm">
                        { }
                    </div>
                    <h3 class="text-3xl font-black mb-4 text-slate-800 tracking-tighter uppercase italic">JavaScript</h3>
                    <p class="text-slate-500 mb-10 flex-grow leading-relaxed font-medium">
                        Hidupkan websitemu! Tambahkan interaksi kompleks dan logika yang bikin website jadi "pintar".
                    </p>
                    <a href="{{ route('materi.list_per_kategori', ['category' => 'javascript']) }}" class="flex items-center justify-center gap-2 w-full py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-yellow-400 hover:text-slate-900 transition-all shadow-lg active:scale-95 uppercase tracking-widest text-sm">
                        MULAI BELAJAR 🚀
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8,0,1,1); }
        50% { transform: none; animation-timing-function: cubic-bezier(0,0,0.2,1); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 3s infinite;
    }
</style>
@endsection