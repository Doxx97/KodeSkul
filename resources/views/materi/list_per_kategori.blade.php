@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container mx-auto px-4 py-10 max-w-5xl">
    
    {{-- 1. HEADER & NAVIGATION --}}
    <div class="mb-8" id="header-section">
        <a href="{{ url('/beranda') }}" class="text-blue-500 hover:text-blue-700 font-medium flex items-center gap-2 w-fit transition-all hover:-translate-x-1">
            <span>&larr;</span> Kembali ke Pilihan Materi
        </a>
        <h1 class="text-3xl font-bold mt-4 text-gray-800">Materi {{ $categoryName }}</h1>
        <p class="text-gray-600 mt-2 text-sm">Selesaikan materi untuk membuka Ujian Akhir dan dapatkan sertifikat.</p>
    </div>

    {{-- 2. LOGIKA PROGRES --}}
    @php
        $completedIds = Auth::check() ? Auth::user()->completedMaterials->pluck('id')->toArray() : [];
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';
        
        $totalMaterials = $materials->count();
        $countCompleted = $materials->filter(fn($m) => in_array($m->id, $completedIds))->count();
        $isAllFinished = ($totalMaterials > 0 && $totalMaterials === $countCompleted);
        
        $isPreviousCompleted = true; 
    @endphp

    {{-- 3. DAFTAR MATERI --}}
    <div id="materi-list-container" class="space-y-4 mb-10 transition-all duration-500">
        @forelse($materials as $index => $item)
            @php
                $isCompleted = in_array($item->id, $completedIds);
                $isUnlocked = ($index == 0) || $isPreviousCompleted || $isAdmin;
                $isPreviousCompleted = $isCompleted;
                $score = $isCompleted ? (Auth::user()->completedMaterials->where('id', $item->id)->first()->pivot->score ?? 0) : 0;
            @endphp

            @if($isUnlocked)
                <div class="group flex flex-col md:flex-row items-center justify-between p-4 bg-white border-2 {{ $isCompleted ? 'border-green-500 bg-green-50/10' : 'border-gray-100' }} rounded-2xl transition-all duration-300 shadow-sm">
                    <div class="flex items-center gap-4 w-full">
                        <div class="w-12 h-12 shrink-0 rounded-xl flex items-center justify-center {{ $isCompleted ? 'bg-green-500 text-white shadow-lg' : 'bg-blue-50 text-blue-600' }}">
                            @if($isCompleted)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <span class="font-bold text-lg">{{ $index + 1 }}</span>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-lg group-hover:text-blue-600 transition-colors">{{ $item->title }}</h3>
                            <div class="text-sm">
                                @if($isCompleted)
                                    <span class="text-green-600 font-semibold italic">Materi telah selesai dipelajari</span>
                                @else
                                    <span class="text-gray-500 line-clamp-1 text-xs">{{ $item->description }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="ml-4 shrink-0">
                            <a href="{{ route('materi.show', $item->id) }}" 
                               class="inline-block px-6 py-2.5 rounded-xl font-bold text-sm transition-all active:scale-95 {{ $isCompleted ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                                 {{ $isCompleted ? 'Pelajari Ulang' : 'Buka Materi' }}
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-between p-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl opacity-60 select-none">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 shrink-0 bg-gray-200 text-gray-400 rounded-xl flex items-center justify-center">🔒</div>
                        <div>
                            <h3 class="font-bold text-gray-400 text-lg">{{ $item->title }}</h3>
                            <p class="text-xs text-gray-400 italic">Selesaikan materi sebelumnya untuk membuka.</p>
                        </div>
                    </div>
                    <button disabled class="px-6 py-2.5 bg-gray-200 text-gray-400 font-bold text-sm rounded-xl cursor-not-allowed">Terkunci</button>
                </div>
            @endif
        @empty
            <div class="text-center py-10 bg-gray-50 rounded-2xl border-2 border-dashed">Materi belum tersedia.</div>
        @endforelse
    </div>

    {{-- 4. TOMBOL ENTRY UJIAN AKHIR --}}
    @if($isAllFinished)
    <div id="exam-entry-card" class="mt-12 transition-all duration-500">
        <div class="group flex flex-col md:flex-row items-center justify-between p-6 bg-white border-2 border-amber-400 bg-amber-50/10 rounded-2xl shadow-xl shadow-amber-100">
            <div class="flex items-center gap-5 w-full">
                <div class="w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg animate-bounce">
                    <span class="text-3xl">🏆</span>
                </div>
                <div class="flex-1">
                    <h3 class="font-black text-gray-900 text-xl tracking-tight uppercase italic">Ujian Akhir {{ $categoryName }}</h3>
                    <p class="text-amber-700 text-sm font-medium">Kamu telah menyelesaikan semua materi! Siap untuk tantangan terakhir?</p>
                </div>
                <button onclick="startFinalExam()" class="px-10 py-4 bg-slate-900 text-white rounded-xl font-black text-sm transition-all hover:bg-black hover:scale-105 active:scale-95 uppercase tracking-widest shadow-lg">
                    Mulai Kerjakan 🚀
                </button>
            </div>
        </div>
    </div>

    {{-- 5. AREA GAME UJIAN AKHIR (DIPISAH BERDASARKAN KATEGORI) --}}
    <div id="final-exam-game" class="hidden mt-6 opacity-0 translate-y-10 transition-all duration-700">
        @if($categoryName == 'HTML')
            @include('exams.html')
        @elseif($categoryName == 'CSS')
            @include('exams.css')
        @elseif($categoryName == 'Javascript')
            @include('exams.javascript')
        @endif
    </div>
    @endif
</div>

<script>
    function startFinalExam() {
        document.getElementById('header-section').classList.add('hidden');
        document.getElementById('materi-list-container').classList.add('hidden');
        document.getElementById('exam-entry-card').classList.add('hidden');
        
        const gameContainer = document.getElementById('final-exam-game');
        gameContainer.classList.remove('hidden');
        
        // Trigger animasi CSS
        setTimeout(() => {
            gameContainer.classList.add('opacity-100', 'translate-y-0');
        }, 50);

        // Menjalankan fungsi initGame yang ada di dalam file yang di-include (jika ada)
        if (typeof initExam === "function") {
            initExam();
        }
    }
</script>
@endsection