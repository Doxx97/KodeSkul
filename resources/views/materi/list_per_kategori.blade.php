@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-4xl mx-auto">
        
        {{-- Tombol Kembali --}}
        <div class="mb-8">
            <a href="{{ url('/beranda') }}" class="text-blue-500 hover:text-blue-700 font-medium flex items-center gap-2 w-fit transition-all hover:-translate-x-1">
                <span>&larr;</span> Kembali ke Pilihan Materi
            </a>
            <h1 class="text-3xl font-bold mt-4 text-gray-800">Materi {{ $categoryName }}</h1>
            <p class="text-gray-600 mt-2">Selesaikan kuis dengan skor minimal **80** untuk membuka materi berikutnya.</p>
        </div>

        {{-- Alert Sukses / Error --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Daftar Materi --}}
        <div class="space-y-4">
            
            @php
                // Ambil ID materi yang sudah lulus (skor >= 80)
                $completedIds = Auth::check() ? Auth::user()->completedMaterials->pluck('id')->toArray() : [];
                
                // Cek apakah user adalah Admin
                $isAdmin = Auth::check() && Auth::user()->role === 'admin';
                
                // Variabel bantuan untuk melacak status materi sebelumnya dalam loop
                $isPreviousCompleted = true; 
            @endphp

            @forelse($materials as $index => $item)
                @php
                    // 1. Cek apakah materi ini sudah selesai
                    $isCompleted = in_array($item->id, $completedIds);

                    // 2. Tentukan apakah materi ini terbuka (Materi #1, atau materi sebelumnya selesai, atau dia Admin)
                    $isUnlocked = ($index == 0) || $isPreviousCompleted || $isAdmin;

                    // 3. Simpan status materi ini untuk pengecekan materi berikutnya di loop selanjutnya
                    $isPreviousCompleted = $isCompleted; 
                @endphp

                @if($isUnlocked)
                    {{-- TAMPILAN MATERI TERBUKA --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border {{ $isCompleted ? 'border-green-300 bg-green-50/30' : 'border-gray-200 hover:border-blue-400 hover:shadow-md' }} flex items-center justify-between transition group">
                        
                        <div class="flex items-center space-x-4">
                            {{-- Angka atau Ceklis --}}
                            <div class="w-12 h-12 shrink-0 {{ $isCompleted ? 'bg-green-500 text-white' : 'bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white' }} rounded-xl flex items-center justify-center font-bold text-lg transition-colors">
                                @if($isCompleted)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                            
                            {{-- Judul & Deskripsi --}}
                            <div>
                                <h3 class="font-bold text-lg text-gray-800 group-hover:text-blue-700 transition-colors">{{ $item->title }}</h3>
                                <div class="text-sm">
                                    @if($isCompleted)
                                        @php
                                            $score = Auth::user()->completedMaterials->where('id', $item->id)->first()->pivot->score ?? 0;
                                        @endphp
                                        <span class="text-green-600 font-semibold italic">Lulus dengan Skor: {{ $score }}</span>
                                    @else
                                        <span class="text-gray-500 line-clamp-1">{{ $item->description }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Buka --}}
                        <a href="{{ route('materi.show', $item->id) }}" 
                           class="{{ $isCompleted ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm transition transform active:scale-95 shrink-0">
                            {{ $isCompleted ? 'Pelajari Ulang' : 'Buka Materi' }}
                        </a>
                        
                    </div>
                @else
                    {{-- TAMPILAN MATERI TERKUNCI --}}
                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 flex items-center justify-between opacity-75 grayscale select-none">
                        
                        <div class="flex items-center space-x-4">
                            {{-- Ikon Gembok --}}
                            <div class="w-12 h-12 shrink-0 bg-gray-200 text-gray-400 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            
                            <div>
                                <h3 class="font-bold text-lg text-gray-400">{{ $item->title }}</h3>
                                <p class="text-xs text-gray-400">⚠️ Selesaikan materi sebelumnya dengan skor 80+ untuk membuka.</p>
                            </div>
                        </div>

                        {{-- Tombol Terkunci --}}
                        <button disabled class="bg-gray-200 text-gray-400 px-6 py-2.5 rounded-lg text-sm font-bold cursor-not-allowed border border-gray-300 shadow-inner">
                            Terkunci
                        </button>
                        
                    </div>
                @endif

            @empty
                <div class="text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                    <span class="text-6xl mb-4 block">📂</span>
                    <h3 class="text-xl font-bold text-gray-800">Materi Belum Tersedia</h3>
                    <p class="text-gray-500 mt-2">Sabar ya, Admin sedang menyiapkan materi terbaik untuk kategori ini.</p>
                </div>
            @endforelse
            
        </div>
    </div>
</div>
@endsection