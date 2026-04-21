@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 max-w-6xl">
    
    <div class="text-center mb-16">
        <h2 class="text-4xl font-extrabold mb-4 text-slate-900">Pilih <span class="text-indigo-600">Materi</span> Belajarmu</h2>
        <p class="text-slate-500 text-lg">Mulai dari kerangka, hiasan, sampai interaksi website. Pilih dari mana kamu mau mulai.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
            <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-3xl font-bold mb-6 group-hover:scale-110 transition-transform">
                <p>&lt;/&gt;</p>
            </div>
            <h3 class="text-2xl font-bold mb-3 text-slate-800">HTML Dasar</h3>
            <p class="text-slate-500 mb-8 line-clamp-3">
                Pelajari struktur dasar dari sebuah halaman web. Ibarat rumah, HTML adalah fondasi dan batu batanya.
            </p>
            <a href="{{ route('materi.list_per_kategori', ['category' => 'html']) }}" class="inline-block w-full text-center px-6 py-3 bg-orange-50 text-orange-600 font-bold rounded-xl group-hover:bg-orange-500 group-hover:text-white transition-colors">
                Mulai HTML
            </a>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-3xl font-bold mb-6 group-hover:scale-110 transition-transform">
                <p>#</p>
            </div>
            <h3 class="text-2xl font-bold mb-3 text-slate-800">CSS Styling</h3>
            <p class="text-slate-500 mb-8 line-clamp-3">
                Bikin website kamu jadi cantik. Pelajari warna, layout, dan animasi biar websitemu nggak ngebosenin.
            </p>
            <a href="{{ route('materi.list_per_kategori', 'css') }}" class="inline-block w-full text-center px-6 py-3 bg-blue-50 text-blue-600 font-bold rounded-xl group-hover:bg-blue-500 group-hover:text-white transition-colors">
                Mulai CSS
            </a>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
            <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-3xl font-bold mb-6 group-hover:scale-110 transition-transform">
                <p>{}</p>
            </div>
            <h3 class="text-2xl font-bold mb-3 text-slate-800">JavaScript</h3>
            <p class="text-slate-500 mb-8 line-clamp-3">
                Tambahkan interaktivitas! Bikin tombol berfungsi, pop-up muncul, dan olah data langsung di browsermu.
            </p>
            <a href="{{ route('materi.list_per_kategori', 'javascript') }}" class="inline-block w-full text-center px-6 py-3 bg-yellow-50 text-yellow-600 font-bold rounded-xl group-hover:bg-yellow-400 group-hover:text-slate-900 transition-colors">
                Mulai JS
            </a>
        </div>

    </div>
</div>
@endsection