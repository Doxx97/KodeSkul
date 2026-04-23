@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-12 py-12 max-w-7xl">
    
    {{-- Header Halaman --}}
    <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">
            Kumpulan <span class="text-indigo-600">Materi</span> Belajar
        </h1>
        <p class="text-slate-500 text-lg max-w-2xl mx-auto">
            Jelajahi semua materi terstruktur dari HTML, CSS, hingga JavaScript. Mulai perjalanan coding-mu dari sini secara berurutan.
        </p>
    </div>

    {{-- Looping Per Kategori --}}
    @forelse($materiPerKategori as $kategori => $materis)
        <div class="mb-16">
            
            {{-- Judul Kategori dengan Warna Dinamis --}}
            <div class="flex items-center gap-4 mb-8 border-b-2 border-slate-100 pb-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-xl font-black uppercase text-white shadow-md
                    {{ strtolower($kategori) == 'html' ? 'bg-orange-500' : (strtolower($kategori) == 'css' ? 'bg-blue-500' : 'bg-yellow-500') }}
                ">
                    {{ substr($kategori, 0, 2) }}
                </div>
                <h2 class="text-3xl font-bold text-slate-800 uppercase tracking-wide">
                    Materi {{ $kategori }}
                </h2>
                <span class="ml-auto bg-slate-100 text-slate-600 py-1 px-3 rounded-full text-sm font-bold">
                    {{ $materis->count() }} Bab
                </span>
            </div>

            {{-- Daftar Materi di Kategori Ini --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @php
                    // Ambil ID materi yang sudah diselesaikan siswa saat ini
                    $completedIds = Auth::check() ? Auth::user()->completedMaterials->pluck('id')->toArray() : [];
                    
                    // Pengecualian agar Admin / Guru bisa melihat semua materi tanpa terkunci
                    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
                    
                    $isPreviousCompleted = true; // Materi ke-1 (index 0) selalu terbuka secara default
                @endphp

                @foreach($materis as $index => $materi)
                    @php
                        // Cek status materi saat ini
                        $isCompleted = in_array($materi->id, $completedIds);
                        
                        // Materi TERBUKA jika: Ini materi pertama, atau materi sebelumnya selesai, atau user adalah Admin
                        $isUnlocked = ($index == 0) || $isPreviousCompleted || $isAdmin;
                        
                        // Simpan status materi ini untuk jadi syarat buka materi selanjutnya
                        $isPreviousCompleted = $isCompleted;
                    @endphp

                    @if($isUnlocked)
                        {{-- KARTU MATERI TERBUKA (Bisa Diklik) --}}
                        <a href="{{ route('materi.show', $materi->id) }}" class="bg-white p-6 rounded-2xl shadow-sm border {{ $isCompleted ? 'border-green-200 bg-green-50/30' : 'border-slate-200' }} hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex items-start gap-4 relative overflow-hidden">
                            
                            {{-- Nomor Urut / Ceklis Jika Selesai --}}
                            <div class="w-12 h-12 shrink-0 {{ $isCompleted ? 'bg-green-500 text-white' : 'bg-slate-50 text-slate-400 group-hover:bg-indigo-600 group-hover:text-white' }} rounded-xl flex items-center justify-center font-bold text-xl transition-colors z-10">
                                {!! $isCompleted ? '✓' : $index + 1 !!}
                            </div>

                            <div class="flex-1 z-10">
                                <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition line-clamp-2">
                                    {{ $materi->title }}
                                </h3>
                                <p class="text-slate-500 text-sm line-clamp-2 mb-4">
                                    {{ $materi->description ?? 'Pelajari lebih lanjut tentang topik ini.' }}
                                </p>
                                <div class="{{ $isCompleted ? 'text-green-600' : 'text-indigo-600' }} font-bold text-sm flex items-center gap-1">
                                    {{ $isCompleted ? 'Sudah Dipelajari' : 'Buka Materi' }} <span class="group-hover:translate-x-2 transition-transform duration-300">&rarr;</span>
                                </div>
                            </div>
                        </a>
                    @else
                        {{-- KARTU MATERI TERKUNCI (Tidak Bisa Diklik, Tampilan Pudar) --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 opacity-70 flex items-start gap-4 cursor-not-allowed select-none">
                            
                            {{-- Ikon Gembok --}}
                            <div class="w-12 h-12 shrink-0 bg-slate-200 text-slate-400 rounded-xl flex items-center justify-center font-bold text-xl">
                                🔒
                            </div>

                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-slate-500 mb-2 line-clamp-2">
                                    {{ $materi->title }}
                                </h3>
                                <p class="text-slate-400 text-xs mb-4">
                                    Selesaikan kuis pada materi sebelumnya untuk membuka bab ini.
                                </p>
                                <div class="text-slate-400 font-bold text-sm flex items-center gap-1">
                                    Materi Terkunci
                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach
            </div>

        </div>
    @empty
        {{-- Jika Database Materi Masih Kosong --}}
        <div class="text-center py-20 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
            <div class="text-5xl mb-4">📚</div>
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Belum Ada Materi</h3>
            <p class="text-slate-500 text-lg">Materi belajar akan segera diunggah ke sistem.</p>
        </div>
    @endforelse

</div>
@endsection