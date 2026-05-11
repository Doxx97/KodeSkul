@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-12 py-12 max-w-7xl">
    
    {{-- Header Halaman --}}
    <div class="relative overflow-hidden bg-white rounded-[2.5rem] p-10 md:p-16 mb-16 shadow-xl shadow-slate-100 border border-slate-100 text-center">
        <div class="absolute top-0 left-0 w-32 h-32 bg-indigo-50 rounded-full -ml-16 -mt-16 blur-2xl"></div>
        <div class="relative z-10">
            <span class="inline-block px-4 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-black uppercase tracking-widest mb-4">
                Learning Path 🗺️
            </span>
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 mb-6 tracking-tighter uppercase">
                Progress <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Materi</span> Belajar
            </h1>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto font-medium leading-relaxed">
                Selesaikan setiap bab secara berurutan. Dapatkan lencana dan buka sertifikat keahlianmu di akhir perjalanan!
            </p>
        </div>
    </div>

    {{-- Looping Per Kategori --}}
    @forelse($materiPerKategori as $kategori => $materis)
        <div class="mb-20">
            
            {{-- Judul Kategori --}}
            <div class="flex items-center gap-6 mb-10 group">
                <div class="w-16 h-16 rounded-[1.5rem] flex items-center justify-center text-2xl font-black uppercase text-white shadow-lg transform group-hover:rotate-6 transition-transform
                    {{ strtolower($kategori) == 'html' ? 'bg-orange-500 shadow-orange-200' : (strtolower($kategori) == 'css' ? 'bg-blue-500 shadow-blue-200' : 'bg-yellow-500 shadow-yellow-200') }}
                ">
                    {{ substr($kategori, 0, 2) }}
                </div>
                <div>
                    <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter italic">
                        Materi {{ $kategori }}
                    </h2>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">
                        Total {{ $materis->count() }} Modul Pembelajaran
                    </p>
                </div>
                <div class="hidden md:block flex-grow h-[2px] bg-slate-100 ml-4 rounded-full"></div>
            </div>

            {{-- Daftar Materi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @php
                    $completedIds = Auth::check() ? Auth::user()->completedMaterials->pluck('id')->toArray() : [];
                    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
                    $isPreviousCompleted = true; 
                @endphp

                @foreach($materis as $index => $materi)
                    @php
                        $isCompleted = in_array($materi->id, $completedIds);
                        $isUnlocked = ($index == 0) || $isPreviousCompleted || $isAdmin;
                        $isPreviousCompleted = $isCompleted;
                    @endphp

                    @if($isUnlocked)
                        {{-- KARTU MATERI TERBUKA --}}
                        <a href="{{ route('materi.show', $materi->id) }}" class="group relative bg-white p-2 rounded-[2.5rem] shadow-xl shadow-slate-100 border border-slate-100 transition-all hover:-translate-y-2 hover:shadow-2xl">
                            <div class="p-6 h-full flex flex-col">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="w-12 h-12 {{ $isCompleted ? 'bg-green-500 shadow-green-100' : 'bg-slate-900' }} text-white rounded-2xl flex items-center justify-center font-black text-xl shadow-lg transition-colors">
                                        {!! $isCompleted ? '✓' : $index + 1 !!}
                                    </div>
                                    @if($isCompleted)
                                        <span class="px-3 py-1 bg-green-100 text-green-600 text-[10px] font-black uppercase rounded-full">Completed</span>
                                    @endif
                                </div>

                                <h3 class="text-xl font-black text-slate-800 mb-2 group-hover:text-indigo-600 transition tracking-tight leading-tight uppercase italic">
                                    {{ $materi->title }}
                                </h3>
                                <p class="text-slate-500 text-sm line-clamp-2 mb-6 font-medium">
                                    {{ $materi->description ?? 'Tekan tombol di bawah untuk mempelajari modul ini.' }}
                                </p>
                                
                                <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                                    <span class="text-xs font-black {{ $isCompleted ? 'text-green-600' : 'text-indigo-600' }} uppercase tracking-widest">
                                        {{ $isCompleted ? 'Review Kembali' : 'Mulai Belajar' }}
                                    </span>
                                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                        <span class="text-lg">&rarr;</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @else
                        {{-- KARTU MATERI TERKUNCI --}}
                        <div class="bg-slate-50/50 p-8 rounded-[2.5rem] border border-dashed border-slate-200 flex flex-col h-full grayscale opacity-60">
                            <div class="w-12 h-12 bg-slate-200 text-slate-400 rounded-2xl flex items-center justify-center font-black text-xl mb-6">
                                🔒
                            </div>
                            <h3 class="text-xl font-black text-slate-400 mb-2 tracking-tight uppercase italic">
                                {{ $materi->title }}
                            </h3>
                            <p class="text-slate-400 text-xs font-medium leading-relaxed">
                                Modul ini masih terkunci. Selesaikan bab sebelumnya untuk melanjutkan quest.
                            </p>
                        </div>
                    @endif

                @endforeach
            </div>

        </div>
    @empty
        <div class="text-center py-24 bg-white rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-100">
            <div class="text-7xl mb-6">🏜️</div>
            <h3 class="text-3xl font-black text-slate-800 mb-2 uppercase italic">Belum Ada Quest</h3>
            <p class="text-slate-500 font-medium">Sabar ya, guru-guru sedang menyiapkan materi terbaik buat kamu.</p>
        </div>
    @endforelse

</div>
@endsection