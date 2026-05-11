<div class="bg-slate-900 rounded-[2.5rem] p-8 md:p-12 text-white border-4 border-blue-500/20 shadow-2xl relative overflow-hidden">
    {{-- Header Game --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-black text-blue-400 uppercase tracking-tighter">CSS Memory Challenge</h2>
            <p class="text-slate-400 text-sm">Pasangkan istilah CSS dengan penjelasan yang tepat!</p>
        </div>
        <div class="flex gap-4 font-mono">
            {{-- Tambahan Live Score --}}
            <div class="bg-slate-800 px-4 py-2 rounded-xl border border-blue-500/30">
                <span class="text-slate-500 text-[10px] uppercase block leading-none mb-1">Skor</span>
                <span id="live-score-css" class="text-xl font-bold text-emerald-400">100</span>
            </div>
            <div class="bg-slate-800 px-4 py-2 rounded-xl border border-slate-700">
                <span class="text-slate-500 text-[10px] uppercase block leading-none mb-1">Langkah</span>
                <span id="moves" class="text-xl font-bold text-blue-400">0</span>
            </div>
            <div class="bg-slate-800 px-4 py-2 rounded-xl border border-slate-700">
                <span class="text-slate-500 text-[10px] uppercase block leading-none mb-1">Waktu</span>
                <span id="timer" class="text-xl font-bold text-blue-400">0</span><span class="text-blue-400 text-xs">s</span>
            </div>
        </div>
    </div>

    {{-- Board Game --}}
    <div id="gameBoard" class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
        {{-- Card akan di-generate oleh JavaScript --}}
    </div>

    <div class="mt-8 text-center flex justify-center gap-6 items-center">
        <button onclick="location.reload()" class="text-slate-500 hover:text-white text-xs font-bold uppercase tracking-widest transition underline decoration-2 underline-offset-4">Reset Permainan</button>
    </div>
</div>

<style>
    .card-css { height: 120px; perspective: 1000px; cursor: pointer; }
    .card-inner { 
        position: relative; width: 100%; height: 100%; 
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); 
        transform-style: preserve-3d; 
    }
    .card-css.flip .card-inner { transform: rotateY(180deg); }
    .card-front, .card-back { 
        position: absolute; width: 100%; height: 100%; 
        backface-visibility: hidden; border-radius: 16px; 
        display: flex; align-items: center; justify-content: center; 
        padding: 15px; text-align: center; font-weight: bold;
    }
    .card-front { 
        background: #f8fafc; color: #1e293b; 
        transform: rotateY(180deg); border: 4px solid #3b82f6;
        font-size: 0.85rem; line-height: 1.2;
    }
    .card-back { 
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); 
        color: #3b82f6; font-size: 2.5rem; border: 2px solid #334155;
        box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.1);
    }
    .card-css.matched .card-front {
        background: #10b981; color: white; border-color: #059669;
        animation: pulse-green 0.5s ease-in-out;
    }
    @keyframes pulse-green {
        0% { transform: rotateY(180deg) scale(1); }
        50% { transform: rotateY(180deg) scale(1.05); }
        100% { transform: rotateY(180deg) scale(1); }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function initExam() {
        const cardsData = [
            { id: 1, text: "Selector", pair: "A" }, { id: 2, text: "Memilih elemen yang ingin dihias", pair: "A" },
            { id: 3, text: "Color", pair: "B" }, { id: 4, text: "Mengubah warna teks", pair: "B" },
            { id: 5, text: "Background", pair: "C" }, { id: 6, text: "Mengubah latar belakang", pair: "C" },
            { id: 7, text: "Padding", pair: "D" }, { id: 8, text: "Ruang di dalam elemen", pair: "D" }
        ];

        let firstCard = null, secondCard = null;
        let lockBoard = false;
        let matchedPairs = 0;
        let moves = 0;
        let time = 0;
        let score = 100;
        let timerInterval;

        const board = document.getElementById('gameBoard');
        const scoreDisplay = document.getElementById('live-score-css');
        
        // Start Timer
        timerInterval = setInterval(() => {
            time++;
            document.getElementById('timer').innerText = time;
        }, 1000);

        // Shuffle & Create Cards
        cardsData.sort(() => Math.random() - 0.5).forEach(data => {
            const card = document.createElement('div');
            card.className = 'card-css';
            card.dataset.pair = data.pair;
            card.innerHTML = `
                <div class="card-inner">
                    <div class="card-front">${data.text}</div>
                    <div class="card-back">{ }</div>
                </div>
            `;
            card.addEventListener('click', flipCard);
            board.appendChild(card);
        });

        function flipCard() {
            if (lockBoard || this === firstCard || this.classList.contains('matched')) return;

            this.classList.add('flip');

            if (!firstCard) {
                firstCard = this;
                return;
            }

            secondCard = this;
            moves++;
            document.getElementById('moves').innerText = moves;
            checkMatch();
        }

        function checkMatch() {
            let isMatch = firstCard.dataset.pair === secondCard.dataset.pair;
            if (isMatch) {
                disableCards();
            } else {
                // PENALTI: Jika salah, kurangi skor 5 poin
                score -= 5;
                if (score < 0) score = 0;
                updateScoreUI();
                unflipCards();
            }
        }

        function updateScoreUI() {
            scoreDisplay.innerText = score;
            if (score < 80) {
                scoreDisplay.classList.replace('text-emerald-400', 'text-red-500');
            } else if (score < 90) {
                scoreDisplay.classList.replace('text-emerald-400', 'text-yellow-400');
            }
        }

        function disableCards() {
            firstCard.classList.add('matched');
            secondCard.classList.add('matched');
            matchedPairs++;
            resetBoard();

            if (matchedPairs === 4) {
                clearInterval(timerInterval);
                finishCSSExam();
            }
        }

        function unflipCards() {
            lockBoard = true;
            setTimeout(() => {
                firstCard.classList.remove('flip');
                secondCard.classList.remove('flip');
                resetBoard();
            }, 1000);
        }

        function resetBoard() {
            [firstCard, secondCard, lockBoard] = [null, null, false];
        }

        async function finishCSSExam() {
            if (score >= 80) {
                confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 } });

                // --- TAMBAHKAN KODE INI ---
                await fetch("{{ route('exams.saveScore') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ category: 'CSS', score: score })
                });
                // --------------------------

                Swal.fire({
                    title: 'CSS MASTER! 🎓',
                    html: `<p>Skor Akhir: <b class="text-emerald-500 text-2xl">${score}</b></p>`,
                    icon: 'success',
                    confirmButtonText: 'Klaim Sertifikat'
                }).then(() => { window.location.href = "{{ route('profile') }}"; });
            } else {
                Swal.fire({
                    title: 'SKOR TIDAK CUKUP ❌',
                    html: `<p>Skor Anda: <b class="text-red-500 text-2xl">${score}</b></p>
                           <p class="text-sm text-slate-500 mt-2">Minimal skor kelulusan adalah <b>80</b>.</p>`,
                    icon: 'error',
                    confirmButtonText: 'Coba Lagi'
                }).then(() => {
                    location.reload();
                });
            }
        }
    }
</script>