@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-12 py-10">
    
    {{-- Ucapan Selamat Datang --}}
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">
            Halo, {{ Auth::check() ? Auth::user()->name : 'Siswa Hebat' }}! 👋
        </h1>
        <p class="text-slate-500 text-lg">Mau belajar apa kita hari ini? Pilih aktivitasmu di bawah ini.</p>
    </div>

    {{-- Kartu Aktivitas Utama (Jelajahi Materi & Quiz) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
        
        {{-- Kartu Materi (Bisa dihilangkan jika dirasa double dengan pilihan di bawah, tapi sementara saya biarkan sesuai permintaan awal) --}}
        <a href="{{ route('progres.index') }}" class="group relative bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-indigo-200 transition-all overflow-hidden flex items-center gap-6">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
            <div class="relative z-10 w-20 h-20 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-4xl shadow-inner font-bold">
                📚
            </div>
            <div class="relative z-10">
                <h2 class="text-2xl font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition">Jelajahi Materi</h2>
                <p class="text-slate-500">Pelajari HTML, CSS, dan JavaScript dari dasar hingga mahir.</p>
            </div>
        </a>

        {{-- Kartu Quiz --}}
        <a href="/quiz" class="group relative bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:rose-200 transition-all overflow-hidden flex items-center gap-6">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-rose-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
            <div class="relative z-10 w-20 h-20 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-4xl shadow-inner font-bold">
                🎯
            </div>
            <div class="relative z-10">
                <h2 class="text-2xl font-bold text-slate-800 mb-2 group-hover:text-rose-600 transition">Uji Kemampuan</h2>
                <p class="text-slate-500">Kerjakan kuis interaktif untuk menguji pemahaman coding-mu.</p>
            </div>
        </a>

    </div>

    {{-- ============================================================== --}}
    {{-- BAGIAN PILIH MATERI (Menggantikan Materi Terbaru) --}}
    {{-- ============================================================== --}}
    <div>
        <div class="text-center mb-10 mt-8">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-slate-900">Pilih <span class="text-indigo-600">Materi</span> Belajarmu</h2>
            <p class="text-slate-500 text-lg">Mulai dari kerangka, hiasan, sampai interaksi website. Pilih dari mana kamu mau mulai.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            {{-- Kartu HTML --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full">
                <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-3xl font-bold mb-6 group-hover:scale-110 transition-transform">
                    <p>&lt;/&gt;</p>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-slate-800">HTML Dasar</h3>
                <p class="text-slate-500 mb-8 line-clamp-3 flex-grow">
                    Pelajari struktur dasar dari sebuah halaman web. Ibarat rumah, HTML adalah fondasi dan batu batanya.
                </p>
                <a href="{{ route('materi.list_per_kategori', ['category' => 'html']) }}" class="inline-block w-full text-center px-6 py-3 bg-orange-50 text-orange-600 font-bold rounded-xl group-hover:bg-orange-500 group-hover:text-white transition-colors mt-auto">
                    Mulai HTML
                </a>
            </div>

            {{-- Kartu CSS --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-3xl font-bold mb-6 group-hover:scale-110 transition-transform">
                    <p>#</p>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-slate-800">CSS Styling</h3>
                <p class="text-slate-500 mb-8 line-clamp-3 flex-grow">
                    Bikin website kamu jadi cantik. Pelajari warna, layout, dan animasi biar websitemu nggak ngebosenin.
                </p>
                <a href="{{ route('materi.list_per_kategori', 'css') }}" class="inline-block w-full text-center px-6 py-3 bg-blue-50 text-blue-600 font-bold rounded-xl group-hover:bg-blue-500 group-hover:text-white transition-colors mt-auto">
                    Mulai CSS
                </a>
            </div>

            {{-- Kartu JS --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full">
                <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-3xl font-bold mb-6 group-hover:scale-110 transition-transform">
                    <p>{}</p>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-slate-800">JavaScript</h3>
                <p class="text-slate-500 mb-8 line-clamp-3 flex-grow">
                    Tambahkan interaktivitas! Bikin tombol berfungsi, pop-up muncul, dan olah data langsung di browsermu.
                </p>
                <a href="{{ route('materi.list_per_kategori', 'javascript') }}" class="inline-block w-full text-center px-6 py-3 bg-yellow-50 text-yellow-600 font-bold rounded-xl group-hover:bg-yellow-400 group-hover:text-slate-900 transition-colors mt-auto">
                    Mulai JS
                </a>
            </div>

        </div>
    </div>

</div>
@endsection