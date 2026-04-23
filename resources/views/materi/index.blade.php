@extends('layouts.app')

@section('content')
<style>
    .video-container { position: relative; }
    .quiz-timeline-marks {
        position: absolute;
        bottom: 45px; 
        left: 0;
        right: 0;
        height: 12px;
        pointer-events: none; 
        display: flex;
        padding: 0 10px; /* Jeda sedikit agar tidak terlalu mepet pinggir */
    }
    .quiz-marker {
        position: absolute;
        width: 12px;
        height: 12px;
        background-color: #fbbf24; 
        border: 2px solid white;
        border-radius: 50%;
        transform: translateX(-50%);
        box-shadow: 0 0 8px rgba(0,0,0,0.5);
        z-index: 60;
        transition: all 0.3s ease;
    }
</style>

<div class="container mx-auto px-4 py-10">
    <div class="max-w-4xl mx-auto">
        {{-- Tombol Kembali --}}
        <a href="{{ route('materi.list_per_kategori', strtolower($material->category)) }}" class="text-blue-500 hover:underline flex items-center gap-2">
            <span>←</span> Kembali ke Daftar Materi {{ $material->category }}
        </a>

        {{-- Judul Materi --}}
        <h1 class="text-4xl font-bold mt-6 mb-4">{{ $material->title }}</h1>
        
        <div class="flex items-center text-sm text-gray-500 mb-8">
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full mr-3">{{ $material->category }}</span>
            <span>Dipublikasikan pada {{ $material->created_at->format('d M Y') }}</span>
        </div>

        {{-- BAGIAN VIDEO --}}
        @if($material->video_url)
        <div class="mb-10 video-container aspect-video rounded-3xl overflow-hidden shadow-2xl bg-black border-4 border-white">
            <div id="player" class="w-full h-full"></div>
            
            {{-- Container untuk Titik-Titik Kuis --}}
            <div id="quizMarkers" class="quiz-timeline-marks"></div>
            
            {{-- Overlay Kuis --}}
            <div id="quizOverlay" class="absolute inset-0 z-50 flex items-center justify-center bg-slate-900/95 backdrop-blur-sm hidden p-6 text-center">
                <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl">
                    <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">❓</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-6" id="questionText">Pertanyaan muncul di sini...</h3>
                    <div id="optionsContainer" class="grid grid-cols-1 gap-3">
                        {{-- Tombol jawaban akan muncul di sini via JS --}}
                    </div>
                    <p id="feedback" class="mt-6 text-sm font-bold hidden"></p>
                </div>
            </div>
        </div>
        @endif

        {{-- Isi Materi Teks --}}
        <div class="prose max-w-none bg-white p-8 shadow-sm rounded-xl border border-gray-100">
            {!! $material->content !!}
        </div>
    </div>
</div>

{{-- Script YouTube API --}}
@if($material->video_url)
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let player;
    let quizPoints = {!! $material->interactive_quiz ?? '[]' !!};
    let currentQuizIndex = -1;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            videoId: "{{ $material->video_url }}",
            playerVars: { 
                'rel': 0, 
                'modestbranding': 1, 
                'autoplay': 0,
                'origin': window.location.origin 
            },
            events: { 
                'onReady': onPlayerReady, // PENTING: Didaftarkan agar marker muncul
                'onStateChange': onPlayerStateChange 
            }
        });
    }
    
    function onPlayerReady(event) {
        // Beri jeda sedikit agar durasi video siap dibaca
        setTimeout(() => {
            const duration = player.getDuration();
            const markerContainer = document.getElementById('quizMarkers');
            
            if (duration > 0 && quizPoints.length > 0) {
                quizPoints.forEach(quiz => {
                    let position = (quiz.time / duration) * 100;
                    
                    let marker = document.createElement('div');
                    marker.className = 'quiz-marker';
                    marker.style.left = `${position}%`;
                    marker.title = `Kuis: ${quiz.question}`;
                    
                    markerContainer.appendChild(marker);
                });
            }
        }, 1500); 
    }

    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING) {
            let checkInterval = setInterval(() => {
                let currentTime = Math.floor(player.getCurrentTime());
                
                // Cari kuis yang waktunya cocok dan belum dijawab
                let quiz = quizPoints.find((q, index) => q.time == currentTime && index > currentQuizIndex);
                
                if (quiz) {
                    currentQuizIndex = quizPoints.indexOf(quiz);
                    showQuiz(quiz);
                    clearInterval(checkInterval);
                }
                
                if (player.getPlayerState() !== YT.PlayerState.PLAYING) {
                    clearInterval(checkInterval);
                }
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
            btn.innerHTML = `<span class="w-6 h-6 bg-slate-100 rounded-lg flex items-center justify-center text-[10px]">${String.fromCharCode(65 + index)}</span> ${opt}`;
            
            btn.onclick = () => {
                feedback.classList.remove('hidden');
                // Admin secara default set correct ke 0 (pilihan pertama)
                if(index == quiz.correct) {
                    feedback.innerText = "Luar Biasa! Jawaban kamu benar. 🎯";
                    feedback.className = "mt-6 text-green-600 font-bold animate-bounce";
                    setTimeout(() => { 
                        overlay.classList.add('hidden'); 
                        player.playVideo(); 
                    }, 2000);
                } else {
                    feedback.innerText = "Ups! Jawaban kurang tepat. Coba lagi ya! ❌";
                    feedback.className = "mt-6 text-red-600 font-bold";
                }
            };
            optionsContainer.appendChild(btn);
        });
    }
</script>
@endif
@endsection