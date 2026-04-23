@extends('layouts.app')

@section('content')
<style>
    /* 1. Styling Video & Quiz (Bawaan) */
    .video-container { position: relative; }
    .quiz-timeline-marks {
        position: absolute; bottom: 45px; left: 0; right: 0; height: 12px;
        pointer-events: none; display: flex; padding: 0 10px;
    }
    .quiz-marker {
        position: absolute; width: 12px; height: 12px; background-color: #fbbf24; 
        border: 2px solid white; border-radius: 50%; transform: translateX(-50%);
        box-shadow: 0 0 8px rgba(0,0,0,0.5); z-index: 60; transition: all 0.3s ease;
    }

    /* 2. STYLING LINGKARAN PROGRESS PADA NOMOR */
    .num-progress-container {
        position: relative;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .num-circle-bg {
        fill: none;
        stroke: #e2e8f0;
        stroke-width: 3;
    }

    .num-circle-bar {
        fill: none;
        stroke: #4f46e5;
        stroke-width: 3;
        stroke-linecap: round;
        transition: stroke-dashoffset 0.1s linear;
        stroke-dasharray: 116.2;
        stroke-dashoffset: 116.2;
        transform: rotate(-90deg);
        transform-origin: center;
    }

    .num-text {
        position: absolute;
        font-weight: 800;
        font-size: 0.875rem;
    }

    /* 3. STYLING MATERI (Spasi & Koding Aman) */
    .content-materi pre {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        padding: 1.5rem !important;
        border-radius: 0.75rem !important;
        overflow-x: auto !important;
        margin: 1.5rem 0 !important;
    }
    .content-materi code {
        font-family: 'Courier New', Courier, monospace !important;
        font-size: 0.9em !important;
    }
</style>

<div class="max-w-7xl mx-auto px-6 md:px-8 lg:px-12 py-10 w-full">
    
    <div class="mb-8">
        <a href="{{ route('materi.list_per_kategori', strtolower($material->category)) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-2 transition">
            <span>&larr;</span> Kembali ke Daftar Materi {{ strtoupper($material->category) }}
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start w-full">
        
        {{-- KOLOM KIRI: KONTEN UTAMA --}}
        <div class="lg:col-span-8 w-full min-w-0">
            <h1 class="text-4xl font-extrabold text-slate-800 mb-4">{{ $material->title }}</h1>
            
            <div class="flex items-center gap-4 mb-8">
                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-lg font-bold text-xs uppercase tracking-wider">
                    {{ $material->category }}
                </span>
                <span class="text-slate-400 text-sm italic">Dipublikasikan pada {{ $material->created_at->format('d M Y') }}</span>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden w-full">
                @if($material->video_url)
                <div class="video-container aspect-video bg-black w-full">
                    <div id="player" class="w-full h-full"></div>
                    <div id="quizMarkers" class="quiz-timeline-marks"></div>
                    <div id="quizOverlay" class="absolute inset-0 z-50 flex items-center justify-center bg-slate-900/90 backdrop-blur-sm hidden p-6 text-center">
                        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl">
                            <h3 class="text-xl font-bold text-slate-800 mb-6" id="questionText">Pertanyaan...</h3>
                            <div id="optionsContainer" class="grid grid-cols-1 gap-3"></div>
                            <p id="feedback" class="mt-6 text-sm font-bold hidden"></p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="p-8 md:p-12 content-materi prose prose-indigo max-w-none w-full break-words overflow-x-auto">
                    {!! $material->content !!}
                    
                    {{-- 👇 LOGIKA POST-TEST DAN KELULUSAN DIMULAI DI SINI 👇 --}}
                    @auth
                        @php
                            $quizzes = $material->post_test ? json_decode($material->post_test, true) : null;
                            $isLulus = Auth::user()->completedMaterials()->where('material_id', $material->id)->wherePivot('is_completed', true)->exists();
                        @endphp

                        @if($isLulus)
                            <div class="mt-12 pt-8 border-t border-slate-100">
                                <div class="bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
                                    <h3 class="text-xl font-bold text-green-700">🎉 Kamu sudah menyelesaikan materi ini!</h3>
                                    
                                    @php
                                        // Ambil skor dari pivot
                                        $scoreRecord = Auth::user()->completedMaterials()->where('material_id', $material->id)->first();
                                        $score = $scoreRecord ? $scoreRecord->pivot->score : 100;
                                        
                                        // Cari materi selanjutnya
                                        $nextMaterial = \App\Models\Material::where('category', $material->category)
                                                                            ->where('id', '>', $material->id)
                                                                            ->orderBy('id', 'asc')
                                                                            ->first();
                                    @endphp
                                    
                                    @if(is_array($quizzes) && count($quizzes) > 0 && isset($quizzes[0]['pertanyaan']))
                                        <p class="text-green-600 mt-2">Nilai Post-Test kamu: <strong class="text-lg">{{ $score }}</strong>. Memenuhi syarat kelulusan.</p>
                                    @endif

                                    @if($nextMaterial)
                                        <a href="{{ route('materi.show', $nextMaterial->id) }}" class="inline-block mt-4 bg-green-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-green-700 shadow-sm transition-colors transform hover:-translate-y-1">
                                            Lanjut ke Bab Berikutnya ➡️
                                        </a>
                                    @else
                                        <a href="{{ route('materi.list_per_kategori', strtolower($material->category)) }}" class="inline-block mt-4 bg-indigo-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-indigo-700 shadow-sm transition-colors">
                                            Kembali ke Daftar Bab 📚
                                        </a>
                                    @endif
                                </div>
                            </div>

                        @elseif(is_array($quizzes) && count($quizzes) > 0 && isset($quizzes[0]['pertanyaan']))
                            <div class="mt-12 border-t-2 border-dashed border-slate-200 pt-8">
                                <h3 class="text-2xl font-extrabold text-slate-800 mb-2">📝 Post-Test Subbab</h3>
                                <p class="text-slate-500 mb-6">Untuk membuka materi selanjutnya, kamu harus mencapai skor minimal <span class="font-bold text-indigo-600">80</span>.</p>

                                @if($errors->has('quiz'))
                                    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 font-medium flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        {{ $errors->first('quiz') }}
                                    </div>
                                @endif

                                <form action="{{ route('materi.submit_quiz', $material->id) }}" method="POST" class="space-y-6">
                                    @csrf
                                    @foreach($quizzes as $index => $quiz)
                                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm">
                                            <p class="font-bold text-slate-800 mb-4 text-lg">{{ $index + 1 }}. {{ $quiz['pertanyaan'] }}</p>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                @foreach(['a', 'b', 'c', 'd'] as $opsi)
                                                    <label class="flex items-center gap-3 p-4 bg-white border border-slate-200 rounded-xl cursor-pointer hover:bg-indigo-50 hover:border-indigo-400 transition-all shadow-sm">
                                                        <input type="radio" name="jawaban_{{ $index }}" value="{{ $opsi }}" required class="text-indigo-600 focus:ring-indigo-500 w-5 h-5">
                                                        <span class="text-slate-700 font-medium">{{ $quiz['opsi_'.$opsi] }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white font-extrabold py-4 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-1 text-lg">
                                        Kirim Jawaban & Cek Hasil
                                    </button>
                                </form>
                            </div>

                        @else
                            <div class="mt-12 pt-8 border-t border-slate-100 flex justify-end">
                                <form action="{{ route('materi.complete', $material->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-10 rounded-2xl shadow-lg transition-all hover:scale-105">
                                        ✅ Tandai Selesai & Lanjut
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                    {{-- 👆 LOGIKA POST-TEST SELESAI 👆 --}}

                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DAFTAR BAB --}}
        <div class="lg:col-span-4 w-full min-w-0">
            <div class="sticky top-24 bg-white rounded-3xl border border-slate-200 p-6 shadow-sm w-full">
                <h3 class="font-black text-slate-800 mb-6 flex items-center gap-2 uppercase tracking-tight">
                    <span class="text-indigo-600">📖</span> Daftar Materi
                </h3>

                <div class="space-y-4">
                    @php
                        $completedIds = Auth::check() ? Auth::user()->completedMaterials->pluck('id')->toArray() : [];
                        $isPreviousCompleted = true; 
                    @endphp

                    @foreach($allMaterials as $index => $m)
                        @php
                            $isCompleted = in_array($m->id, $completedIds);
                            $isActive = $m->id == $material->id;
                            $isUnlocked = ($index == 0) || $isPreviousCompleted || (Auth::check() && Auth::user()->role === 'admin');
                            $isPreviousCompleted = $isCompleted;
                        @endphp

                        @if($isUnlocked)
                        <a href="{{ route('materi.show', $m->id) }}" 
                           class="group flex items-center gap-4 p-3 rounded-2xl border transition-all 
                           {{ $isActive ? 'border-indigo-500 bg-indigo-50/30 ring-2 ring-indigo-500/10' : 'border-slate-100 hover:border-indigo-200 hover:bg-slate-50' }}">
                            
                            <div class="num-progress-container shrink-0">
                                <svg class="w-full h-full" viewBox="0 0 40 40">
                                    <circle class="num-circle-bg" cx="20" cy="20" r="18.5"/>
                                    <circle class="num-circle-bar" id="{{ $isActive ? 'activeCircleBar' : '' }}" 
                                            cx="20" cy="20" r="18.5"
                                            style="{{ $isCompleted && !$isActive ? 'stroke-dashoffset: 0; stroke: #10b981;' : '' }}"/>
                                </svg>
                                <span class="num-text {{ $isActive ? 'text-indigo-700' : ($isCompleted ? 'text-green-600' : 'text-slate-400') }}">
                                    @if($isCompleted && !$isActive) ✓ @else {{ $index + 1 }} @endif
                                </span>
                            </div>

                            <h4 class="text-sm font-bold {{ $isActive ? 'text-indigo-900' : 'text-slate-600' }} line-clamp-2">
                                {{ $m->title }}
                            </h4>
                        </a>
                        @else
                        <div class="flex items-center gap-4 p-3 rounded-2xl border border-slate-50 bg-slate-50/50 opacity-60 grayscale cursor-not-allowed">
                            <div class="num-progress-container shrink-0">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-xs text-slate-400">🔒</div>
                            </div>
                            <h4 class="text-sm font-bold text-slate-400 line-clamp-2">{{ $m->title }}</h4>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
    const circle = document.getElementById('activeCircleBar');
    const circumference = 116.2;

    function updateCircleProgress() {
        if (!circle) return;
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = height > 0 ? (winScroll / height) * 100 : 0;
        const percent = Math.min(Math.round(scrolled), 100);
        const offset = circumference - (percent / 100 * circumference);
        circle.style.strokeDashoffset = offset;
    }

    window.addEventListener('scroll', updateCircleProgress);
    document.addEventListener('DOMContentLoaded', updateCircleProgress);
</script>

@if($material->video_url)
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let player;
    // Pengecekan aman: Jika quiz points bukan format video, jadikan array kosong agar JS tidak error
    let quizPoints = {!! $material->interactive_quiz ?? '[]' !!};
    let currentQuizIndex = -1;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            videoId: "{{ $material->video_url }}",
            playerVars: { 'rel': 0, 'modestbranding': 1, 'autoplay': 0, 'origin': window.location.origin },
            events: { 'onReady': onPlayerReady, 'onStateChange': onPlayerStateChange }
        });
    }

    function onPlayerReady(event) {
        setTimeout(() => {
            const duration = player.getDuration();
            const markerContainer = document.getElementById('quizMarkers');
            if (duration > 0 && quizPoints.length > 0) {
                quizPoints.forEach(quiz => {
                    let position = (quiz.time / duration) * 100;
                    let marker = document.createElement('div');
                    marker.className = 'quiz-marker';
                    marker.style.left = `${position}%`;
                    markerContainer.appendChild(marker);
                });
            }
        }, 1500); 
    }

    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING) {
            let checkInterval = setInterval(() => {
                let currentTime = Math.floor(player.getCurrentTime());
                let quiz = quizPoints.find((q, index) => q.time == currentTime && index > currentQuizIndex);
                if (quiz) {
                    currentQuizIndex = quizPoints.indexOf(quiz);
                    showQuiz(quiz);
                    clearInterval(checkInterval);
                }
                if (player.getPlayerState() !== YT.PlayerState.PLAYING) { clearInterval(checkInterval); }
            }, 1000);
        }
    }

    function showQuiz(quiz) {
        player.pauseVideo();
        const overlay = document.getElementById('quizOverlay');
        const questionText = document.getElementById('questionText');
        const optionsContainer = document.getElementById('optionsContainer');
        const feedback = document.getElementById('feedback');

        questionText.innerText = quiz.question;
        optionsContainer.innerHTML = '';
        feedback.classList.add('hidden');
        overlay.classList.remove('hidden');

        quiz.options.forEach((opt, index) => {
            let btn = document.createElement('button');
            btn.className = "p-4 rounded-2xl border-2 border-slate-100 hover:border-indigo-500 hover:bg-indigo-50 transition-all font-bold text-slate-700 text-sm text-left flex items-center gap-3";
            btn.innerHTML = `<span class="w-6 h-6 bg-indigo-100 text-indigo-600 rounded flex items-center justify-center text-[10px]">${String.fromCharCode(65 + index)}</span> ${opt}`;
            btn.onclick = () => {
                feedback.classList.remove('hidden');
                if(index == quiz.correct) {
                    feedback.innerText = "Jawaban Benar! 🎯";
                    feedback.className = "mt-6 text-green-600 font-bold";
                    setTimeout(() => { overlay.classList.add('hidden'); player.playVideo(); }, 1500);
                } else {
                    feedback.innerText = "Salah, coba lagi! ❌";
                    feedback.className = "mt-6 text-red-500 font-bold";
                }
            };
            optionsContainer.appendChild(btn);
        });
    }
</script>

@endif
@endsection
