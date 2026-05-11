<div class="p-1 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 rounded-[2.5rem] shadow-2xl">
    <div class="bg-white rounded-[2.4rem] p-8 md:p-12 text-center relative overflow-hidden">
        
        {{-- Top Bar Progres --}}
        <div class="flex justify-between mb-8">
            <div class="bg-slate-100 px-6 py-2 rounded-2xl font-bold text-slate-700 shadow-sm border border-slate-200">
                Live Score: <span id="score-display" class="text-emerald-600">100</span>
            </div>
            <div class="bg-slate-100 px-6 py-2 rounded-2xl font-bold text-slate-700 shadow-sm border border-slate-200">
                Soal: <span id="level" class="text-indigo-600">1</span>/5
            </div>
        </div>

        <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-2 tracking-tighter uppercase italic">JS Master Challenge</h1>
        <p class="text-slate-500 mb-8 font-medium">Pilih satu jawaban yang paling tepat!</p>

        {{-- Box Pertanyaan --}}
        <div class="bg-slate-50 p-8 rounded-[2rem] mb-8 border-2 border-slate-100 shadow-inner">
            <h2 id="question" class="text-xl md:text-2xl font-bold text-slate-800 leading-tight">Memuat pertanyaan...</h2>
        </div>

        {{-- Opsi Jawaban --}}
        <div id="options-container" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <button class="option-btn bg-indigo-500 hover:bg-indigo-600 text-white p-6 rounded-2xl font-bold text-lg transition-all active:scale-95 shadow-lg" onclick="checkAnswer(0)" id="opt0"></button>
            <button class="option-btn bg-indigo-500 hover:bg-indigo-600 text-white p-6 rounded-2xl font-bold text-lg transition-all active:scale-95 shadow-lg" onclick="checkAnswer(1)" id="opt1"></button>
            <button class="option-btn bg-indigo-500 hover:bg-indigo-600 text-white p-6 rounded-2xl font-bold text-lg transition-all active:scale-95 shadow-lg" onclick="checkAnswer(2)" id="opt2"></button>
            <button class="option-btn bg-indigo-500 hover:bg-indigo-600 text-white p-6 rounded-2xl font-bold text-lg transition-all active:scale-95 shadow-lg" onclick="checkAnswer(3)" id="opt3"></button>
        </div>

        <div id="feedback" class="bg-slate-50 text-slate-400 py-3 px-6 rounded-xl font-bold mb-6 inline-block">
            Hati-hati, jawaban salah mengurangi poin! ⚠️
        </div>

        <div class="mt-4">
            <button onclick="location.reload()" class="text-slate-400 hover:text-slate-600 font-bold text-xs uppercase tracking-widest transition">Batal & Ulangi</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const questions = [
        {
            question: "Siapakah pencipta JavaScript dalam 10 hari pada tahun 1995?",
            options: ["Ryan Dahl", "Brendan Eich", "Marc Andreessen", "Bill Gates"],
            answer: 1
        },
        {
            question: "Perintah untuk menampilkan data ke konsol browser adalah...",
            options: ["alert()", "console.log()", "prompt()", "document.write()"],
            answer: 1
        },
        {
            question: "Extension VS Code untuk server lokal adalah...",
            options: ["Material Icon", "Live Server", "Noctis Theme", "JavaScript Nightly"],
            answer: 1
        },
        {
            question: "Keyword untuk variabel konstan adalah...",
            options: ["let", "const", "var", "undefined"],
            answer: 1
        },
        {
            question: "Tipe data true/false disebut...",
            options: ["String", "Number", "Boolean", "NaN"],
            answer: 2
        }
    ];

    let currentQuestion = 0;
    let score = 100; // Skor mulai dari 100
    const penalty = 20; // Pengurangan poin per kesalahan

    function initExam() {
        loadQuestion();
    }

    function loadQuestion() {
        const q = questions[currentQuestion];
        document.getElementById("question").textContent = q.question;

        q.options.forEach((option, index) => {
            document.getElementById(`opt${index}`).textContent = option;
        });

        document.getElementById("level").textContent = currentQuestion + 1;
    }

    function checkAnswer(selected) {
        const correct = questions[currentQuestion].answer;
        const feedback = document.getElementById("feedback");
        const optionsBtn = document.querySelectorAll('.option-btn');
        const scoreDisplay = document.getElementById("score-display");

        optionsBtn.forEach(btn => btn.disabled = true);

        if (selected === correct) {
            feedback.innerHTML = "Luar Biasa! Benar 🎉";
            feedback.className = "bg-green-50 text-green-600 py-3 px-6 rounded-xl font-bold mb-6 inline-block";
        } else {
            score -= penalty; // Kurangi skor jika salah
            if(score < 0) score = 0;
            
            feedback.innerHTML = "Waduh, Salah! ❌ (-" + penalty + ")";
            feedback.className = "bg-red-50 text-red-600 py-3 px-6 rounded-xl font-bold mb-6 inline-block";
            
            // Beri warna merah pada skor jika sudah di bawah KKM (80)
            if(score < 80) scoreDisplay.className = "text-red-600";
        }

        scoreDisplay.textContent = score;
        currentQuestion++;

        setTimeout(() => {
            if (currentQuestion < questions.length) {
                loadQuestion();
                feedback.innerHTML = "Menuju pertanyaan selanjutnya...";
                feedback.className = "bg-slate-50 text-slate-400 py-3 px-6 rounded-xl font-bold mb-6 inline-block";
                optionsBtn.forEach(btn => btn.disabled = false);
            } else {
                finishGame();
            }
        }, 1000);
    }

    async function finishGame() {
        if (score >= 80) {
            confetti({ particleCount: 200, spread: 70, origin: { y: 0.6 } });

            // --- TAMBAHKAN KODE INI ---
            // Di dalam file javascript.blade.php
            await fetch("{{ route('exams.saveScore') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                // Ganti 'Javascript' menjadi 'JS' agar sesuai database
                body: JSON.stringify({ category: 'JS', score: score }) 
            });
            // --------------------------

            Swal.fire({
                title: 'JS MASTER CERTIFIED! 🎓',
                icon: 'success',
                confirmButtonText: 'Klaim Sertifikat'
            }).then(() => { window.location.href = "{{ route('profile') }}"; });
        } else {
            Swal.fire({
                title: 'GAGAL SERTIFIKASI ❌',
                html: `Skor Kamu: <b class="text-2xl text-red-600">${score}</b><br>Minimal 80 untuk lulus. Jangan menyerah!`,
                icon: 'error',
                confirmButtonText: 'Ulangi Ujian'
            }).then(() => {
                location.reload();
            });
        }
    }
</script>