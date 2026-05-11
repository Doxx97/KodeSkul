@extends('layouts.app')

@section('content')
<style>
    /* 1. Styling Video Container - PENTING agar video muncul */
    .video-container { 
        position: relative; 
        width: 100%;
        background-color: #000;
        border-radius: 1.5rem;
        overflow: hidden;
        aspect-ratio: 16 / 9; /* Memastikan container punya tinggi */
    }

    #player {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    /* 2. Styling Kuis & Marker */
    .quiz-timeline-marks {
        position: absolute; bottom: 45px; left: 0; right: 0; height: 12px;
        pointer-events: none; display: flex; padding: 0 10px;
    }
    .quiz-marker {
        position: absolute; width: 12px; height: 12px; background-color: #fbbf24; 
        border: 2px solid white; border-radius: 50%; transform: translateX(-50%);
        box-shadow: 0 0 8px rgba(0,0,0,0.5); z-index: 60; transition: all 0.3s ease;
    }

    /* 3. Styling Sidebar Progress */
    .num-progress-container { position: relative; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; }
    .num-circle-bg { fill: none; stroke: #e2e8f0; stroke-width: 3; }
    .num-circle-bar {
        fill: none; stroke: #4f46e5; stroke-width: 3; stroke-linecap: round;
        transition: stroke-dashoffset 0.1s linear; stroke-dasharray: 116.2;
        stroke-dashoffset: 116.2; transform: rotate(-90deg); transform-origin: center;
    }
    .num-text { position: absolute; font-weight: 800; font-size: 0.875rem; }

    /* 4. Styling Isi Materi */
    .content-materi pre {
        background-color: #1e293b !important; color: #f8fafc !important;
        padding: 1.5rem !important; border-radius: 0.75rem !important;
        overflow-x: auto !important; margin: 1.5rem 0 !important;
    }
</style>

<div class="max-w-7xl mx-auto px-6 md:px-8 lg:px-12 py-10 w-full">
    <div class="mb-8">
        <a href="{{ route('materi.list_per_kategori', strtolower($material->category)) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-2 transition">
            <span>&larr;</span> Kembali ke Daftar Materi {{ strtoupper($material->category) }}
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start w-full">
        <div class="lg:col-span-8 w-full min-w-0">
            <h1 class="text-4xl font-extrabold text-slate-800 mb-4">{{ $material->title }}</h1>
            
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden w-full">
                @if($material->video_url)
                <div class="video-container">
                    <div id="player"></div>
                    
                    <div id="quizMarkers" class="quiz-timeline-marks"></div>
                    
                    <div id="quizOverlay" class="absolute inset-0 z-50 flex items-center justify-center bg-slate-900/90 backdrop-blur-sm hidden p-6 text-center">
                        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl">
                            <h3 class="text-xl font-bold text-slate-800 mb-6" id="questionText">Pertanyaan...</h3>
                            <div id="optionsContainer" class="grid grid-cols-1 gap-3 max-h-64 overflow-y-auto pr-2"></div>
                            <p id="feedback" class="mt-6 text-sm font-bold hidden"></p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="p-8 md:p-12 content-materi prose prose-indigo max-w-none w-full break-words">
                    {!! $material->content !!}
                    
                    @auth
                        @php
                            $isCompleted = Auth::user()->completedMaterials()->where('material_id', $material->id)->wherePivot('is_completed', true)->exists();
                        @endphp

                        <div id="completionSection" class="mt-12 pt-8 border-t border-slate-100">
                            @if($isCompleted)
                                <div class="bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
                                    <h3 class="text-xl font-bold text-green-700">🎉 Materi Selesai!</h3>
                                    @php
                                        $nextMaterial = \App\Models\Material::where('category', $material->category)
                                            ->where('id', '>', $material->id)->orderBy('id', 'asc')->first();
                                    @endphp
                                    @if($nextMaterial)
                                        <a href="{{ route('materi.show', $nextMaterial->id) }}" class="inline-block mt-4 bg-indigo-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-indigo-700 transition">Lanjut ke Bab Berikutnya ➡️</a>
                                    @else
                                        <p class="text-slate-500 mt-2">Selamat! Kamu telah menyelesaikan semua materi di kategori ini.</p>
                                    @endif
                                </div>
                            @else
                                <div id="lockMessage" class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center">
                                    <h3 class="text-lg font-bold text-amber-700 flex items-center justify-center gap-2">
                                        <span>🔒</span> Selesaikan Video & Evaluasi untuk Melanjutkan
                                    </h3>
                                    <p class="text-amber-600 text-sm mt-1">Tonton video sampai habis dan kerjakan evaluasi akhir untuk membuka materi selanjutnya.</p>
                                </div>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 w-full min-w-0">
            <div class="sticky top-24 bg-white rounded-3xl border border-slate-200 p-6 shadow-sm w-full">
                <h3 class="font-black text-slate-800 mb-6 flex items-center gap-2 uppercase tracking-tight">
                    <span class="text-indigo-600">📖</span> Daftar Materi
                </h3>
                <div class="space-y-4">
                    @php
                        $completedIds = Auth::check() ? Auth::user()->completedMaterials->pluck('id')->toArray() : [];
                        $isPrevCompleted = true; 
                    @endphp
                    @foreach($allMaterials as $index => $m)
                        @php
                            $isDone = in_array($m->id, $completedIds);
                            $isActive = $m->id == $material->id;
                            $isUnlocked = ($index == 0) || $isPrevCompleted || (Auth::check() && Auth::user()->role === 'admin');
                            $isPrevCompleted = $isDone;
                        @endphp
                        @if($isUnlocked)
                            <a href="{{ route('materi.show', $m->id) }}" class="flex items-center gap-4 p-3 rounded-2xl border transition {{ $isActive ? 'border-indigo-500 bg-indigo-50/30' : 'border-slate-100 hover:bg-slate-50' }}">
                                <div class="num-progress-container shrink-0">
                                    <svg class="w-full h-full" viewBox="0 0 40 40">
                                        <circle class="num-circle-bg" cx="20" cy="20" r="18.5"/>
                                        <circle class="num-circle-bar" id="{{ $isActive ? 'activeCircleBar' : '' }}" cx="20" cy="20" r="18.5" style="{{ $isDone && !$isActive ? 'stroke-dashoffset: 0; stroke: #10b981;' : '' }}"/>
                                    </svg>
                                    <span class="num-text {{ $isActive ? 'text-indigo-700' : ($isDone ? 'text-green-600' : 'text-slate-400') }}">
                                        @if($isDone && !$isActive) ✓ @else {{ $index + 1 }} @endif
                                    </span>
                                </div>
                                <h4 class="text-sm font-bold {{ $isActive ? 'text-indigo-900' : 'text-slate-600' }}">{{ $m->title }}</h4>
                            </a>
                        @else
                            <div class="flex items-center gap-4 p-3 rounded-2xl border border-slate-50 bg-slate-50/50 opacity-60 grayscale cursor-not-allowed">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-xs">🔒</div>
                                <h4 class="text-sm font-bold text-slate-400">{{ $m->title }}</h4>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://www.youtube.com/iframe_api"></script>
<script>
    // Ambil Data Kuis
    var quizPoints = {!! json_encode($material->interactive_quiz ?? []) !!};
    if (typeof quizPoints === 'string') {
        try { quizPoints = JSON.parse(quizPoints); } catch(e) { quizPoints = []; }
    }

    var player;
    var currentQuizIndex = -1;
    var quizzesAnswered = 0; 
    var quizResults = []; 

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            videoId: "{{ $material->video_url }}",
            playerVars: { 
                'rel': 0, 
                'modestbranding': 1, 
                'origin': window.location.origin,
                'playsinline': 1 
            },
            events: { 
                'onReady': onPlayerReady, 
                'onStateChange': onPlayerStateChange 
            }
        });
    }

    function onPlayerReady(event) {
        var duration = player.getDuration();
        var markerContainer = document.getElementById('quizMarkers');
        if (duration > 0 && Array.isArray(quizPoints)) {
            markerContainer.innerHTML = '';
            quizPoints.forEach(function(quiz) {
                var marker = document.createElement('div');
                marker.className = 'quiz-marker';
                marker.style.left = (quiz.time / duration * 100) + '%';
                markerContainer.appendChild(marker);
            });
        }
    }

    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING) {
            var checkInterval = setInterval(function() {
                if (player.getPlayerState() !== YT.PlayerState.PLAYING) { 
                    clearInterval(checkInterval); 
                    return; 
                }
                var currentTime = Math.floor(player.getCurrentTime());
                var quizIdx = quizPoints.findIndex(function(q, index) {
                    return currentTime >= q.time && index > currentQuizIndex;
                });

                if (quizIdx !== -1) {
                    currentQuizIndex = quizIdx;
                    showQuiz(quizPoints[quizIdx]);
                    clearInterval(checkInterval);
                }
            }, 500);
        }

        if (event.data == YT.PlayerState.ENDED) {
            if (quizzesAnswered >= quizPoints.length) {
                showFinalEvaluation();
            } else {
                alert("Harap jawab semua kuis interaktif yang muncul di video.");
            }
        }
    }

    function showQuiz(quiz) {
        player.pauseVideo();
        var overlay = document.getElementById('quizOverlay');
        var container = document.getElementById('optionsContainer');
        var feedback = document.getElementById('feedback');

        document.getElementById('questionText').innerText = quiz.question;
        container.innerHTML = '';
        feedback.classList.add('hidden');
        overlay.classList.remove('hidden');

        quiz.options.forEach(function(opt, index) {
            var btn = document.createElement('button');
            btn.className = "p-4 rounded-2xl border-2 border-slate-100 hover:border-indigo-500 font-bold text-sm text-left flex items-center gap-3 w-full transition-all";
            btn.innerHTML = '<span>' + String.fromCharCode(65 + index) + '.</span> ' + opt;
            btn.onclick = function() {
                feedback.classList.remove('hidden');
                if(index == quiz.correct) {
                    if(!quizResults.find(r => r.question === quiz.question)) {
                        quizResults.push({ question: quiz.question, answer: opt });
                    }
                    quizzesAnswered++;
                    feedback.innerText = "Jawaban Benar! 🎯";
                    feedback.className = "mt-6 text-green-600 font-bold text-center";
                    setTimeout(function() { 
                        overlay.classList.add('hidden'); 
                        player.playVideo(); 
                    }, 1500);
                } else {
                    feedback.innerText = "Salah, coba lagi! ❌";
                    feedback.className = "mt-6 text-red-500 font-bold text-center";
                }
            };
            container.appendChild(btn);
        });
    }

    function showFinalEvaluation() {
        var overlay = document.getElementById('quizOverlay');
        var container = document.getElementById('optionsContainer');
        var feedback = document.getElementById('feedback');

        document.getElementById('questionText').innerText = "📋 Evaluasi Akhir";
        feedback.classList.add('hidden');
        container.innerHTML = `<p class="text-slate-500 mb-4 text-sm">Selamat! Kamu telah menonton video dan menjawab semua kuis. Berikut ringkasannya:</p>`;
        
        quizResults.forEach(function(res, i) {
            var item = document.createElement('div');
            item.className = "text-left p-4 bg-slate-50 rounded-2xl mb-2 border border-slate-100";
            item.innerHTML = `
                <p class="text-xs font-bold text-slate-400 mb-1">PERTANYAAN ${i+1}</p>
                <p class="text-sm font-bold text-slate-700 mb-1">${res.question}</p>
                <p class="text-sm text-green-600 font-bold flex items-center gap-1">
                    <span>✓</span> ${res.answer}
                </p>
            `;
            container.appendChild(item);
        });

        var finishBtn = document.createElement('button');
        finishBtn.className = "mt-6 w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl hover:bg-indigo-700 shadow-xl transition-all";
        finishBtn.innerText = "Selesaikan Materi & Simpan Progres";
        finishBtn.onclick = function() {
            finishBtn.disabled = true;
            finishBtn.innerText = "Menyimpan...";
            markAsComplete();
        };
        
        container.appendChild(finishBtn);
        overlay.classList.remove('hidden');
    }

    function markAsComplete() {
        fetch("{{ route('materi.complete', $material->id) }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        }).then(response => {
            if(response.ok) { 
                location.reload(); 
            } else {
                alert("Gagal menyimpan progres. Pastikan tabel pivot dan relasi User sudah benar.");
                location.reload();
            }
        });
    }

    // Progress Scroll Circle
    const circleBar = document.getElementById('activeCircleBar');
    const circum = 116.2;
    function updateScroll() {
        if (!circleBar) return;
        const winScroll = document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = height > 0 ? (winScroll / height) * 100 : 0;
        circleBar.style.strokeDashoffset = circum - (scrolled / 100 * circum);
    }
    window.addEventListener('scroll', updateScroll);
</script>
@endsection