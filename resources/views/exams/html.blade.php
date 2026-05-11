<div class="p-1 bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-600 rounded-[2.5rem] shadow-2xl">
    <div class="bg-slate-950 rounded-[2.4rem] p-8 md:p-12 text-white relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-2 bg-slate-900">
            <div id="exam-progress" class="h-full bg-gradient-to-r from-blue-500 to-purple-500 transition-all duration-500" style="width: 20%"></div>
        </div>

        <div class="flex justify-between items-start mb-10 mt-4">
            <div>
                <h2 class="text-4xl font-black italic tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 uppercase">HTML Certification</h2>
                <p id="challenge-desc" class="text-slate-400 mt-2 tracking-wide font-medium italic">Tantangan 1: Struktur Dasar Document</p>
            </div>
            <div class="bg-slate-900 px-6 py-3 rounded-2xl border border-slate-800 text-center min-w-[120px]">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Live Score</div>
                <div id="live-score" class="text-3xl font-black text-emerald-400 transition-all duration-300">100</div>
            </div>
        </div>

        <div id="exam-content" class="min-h-[400px]">
            
            <div id="step-1" class="exam-step transition-all duration-500">
                <p class="mb-6 text-indigo-300 font-mono text-sm">// Susun urutan tag agar membentuk struktur HTML yang valid</p>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div class="bg-slate-900/50 p-6 rounded-2xl border border-slate-800">
                        <div id="source-1" class="grid grid-cols-2 gap-3">
                            <div class="drag-item bg-indigo-600 p-4 rounded-xl cursor-grab font-mono text-xs border-b-4 border-indigo-900 text-center" draggable="true" data-code="A">&lt;/body&gt;</div>
                            <div class="drag-item bg-indigo-600 p-4 rounded-xl cursor-grab font-mono text-xs border-b-4 border-indigo-900 text-center" draggable="true" data-code="B">&lt;head&gt;</div>
                            <div class="drag-item bg-indigo-600 p-4 rounded-xl cursor-grab font-mono text-xs border-b-4 border-indigo-900 text-center" draggable="true" data-code="C">&lt;/html&gt;</div>
                            <div class="drag-item bg-indigo-600 p-4 rounded-xl cursor-grab font-mono text-xs border-b-4 border-indigo-900 text-center" draggable="true" data-code="D">&lt;body&gt;</div>
                            <div class="drag-item bg-indigo-600 p-4 rounded-xl cursor-grab font-mono text-xs border-b-4 border-indigo-900 text-center" draggable="true" data-code="E">&lt;html&gt;</div>
                            <div class="drag-item bg-indigo-600 p-4 rounded-xl cursor-grab font-mono text-xs border-b-4 border-indigo-900 text-center" draggable="true" data-code="F">&lt;/head&gt;</div>
                        </div>
                    </div>
                    <div class="bg-black/80 p-6 rounded-2xl border-2 border-dashed border-indigo-500/20">
                        <div id="drop-1" class="space-y-2 min-h-[250px] flex flex-col justify-center">
                            <p id="placeholder-text" class="text-slate-600 text-center italic text-sm">Tarik potongan kode ke sini...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="step-2" class="exam-step hidden transition-all duration-500">
                <p class="mb-6 text-indigo-300 font-mono text-sm">// Pilih tipe input yang tepat untuk data berikut</p>
                <div class="max-w-2xl mx-auto space-y-4">
                    <div class="flex items-center justify-between bg-slate-900 p-5 rounded-2xl border border-slate-800">
                        <span>Pilih Tanggal Lahir:</span>
                        <select id="q2-1" class="bg-slate-800 rounded-lg px-4 py-2 text-sm"><option value="">--</option><option value="date">type="date"</option><option value="text">type="text"</option></select>
                    </div>
                    <div class="flex items-center justify-between bg-slate-900 p-5 rounded-2xl border border-slate-800">
                        <span>Input Kata Sandi:</span>
                        <select id="q2-2" class="bg-slate-800 rounded-lg px-4 py-2 text-sm"><option value="">--</option><option value="password">type="password"</option><option value="hidden">type="hidden"</option></select>
                    </div>
                </div>
            </div>

            <div id="step-3" class="exam-step hidden transition-all duration-500">
                <p class="mb-6 text-indigo-300 font-mono text-sm">// Apa fungsi dari atribut colspan="2" pada tag &lt;td&gt;?</p>
                <div class="grid gap-4 max-w-xl mx-auto">
                    <button onclick="checkStep3(false)" class="p-4 bg-slate-900 hover:bg-slate-800 rounded-xl border border-slate-700 text-left">A. Membuat 2 kolom baru secara otomatis</button>
                    <button onclick="checkStep3(true)" class="p-4 bg-slate-900 hover:bg-slate-800 rounded-xl border border-slate-700 text-left">B. Menggabungkan 2 kolom menjadi satu</button>
                </div>
            </div>

            <div id="step-4" class="exam-step hidden transition-all duration-500">
                <p class="mb-6 text-indigo-300 font-mono text-sm">// Atribut mana yang digunakan untuk membuka link di tab baru?</p>
                <div class="grid grid-cols-2 gap-4 max-w-md mx-auto">
                    <button onclick="checkStep4(true)" class="p-4 bg-slate-900 hover:bg-indigo-600 rounded-xl border border-slate-700 font-mono">target="_blank"</button>
                    <button onclick="checkStep4(false)" class="p-4 bg-slate-900 hover:bg-red-600 rounded-xl border border-slate-700 font-mono">href="new"</button>
                </div>
            </div>

            <div id="step-5" class="exam-step hidden transition-all duration-500">
                <p class="mb-6 text-indigo-300 font-mono text-sm">// Manakah di bawah ini yang termasuk 'Void Element' (tidak butuh penutup)?</p>
                <div class="grid grid-cols-1 gap-4 max-w-md mx-auto">
                    <button onclick="finishExam('img')" class="p-4 bg-slate-800 hover:border-emerald-500 border-2 border-transparent rounded-xl font-mono text-emerald-400">&lt;img&gt;</button>
                    <button onclick="reduceScore('Salah! div butuh penutup </div>')" class="p-4 bg-slate-800 hover:border-red-500 border-2 border-transparent rounded-xl font-mono">&lt;div&gt;</button>
                </div>
            </div>

        </div>

        <div class="mt-12 flex justify-between items-center">
            <button onclick="location.reload()" class="text-slate-500 hover:text-white transition font-bold uppercase text-xs tracking-widest">Reset Ujian</button>
            <button id="btn-next" onclick="validateStep()" class="px-12 py-5 bg-white text-black font-black rounded-2xl hover:scale-105 transition-all uppercase tracking-widest">
                Lanjut &rarr;
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
    let score = 100;
    let currentStep = 1;
    const totalSteps = 5;
    const penalty = 5; // Pengurangan skor per kesalahan

    function refreshUI() {
        document.getElementById('live-score').innerText = score;
        const progress = (currentStep / totalSteps) * 100;
        document.getElementById('exam-progress').style.width = `${progress}%`;
        if(score < 80) document.getElementById('live-score').style.color = '#ef4444';
    }

    function reduceScore(msg) {
        score -= penalty;
        if(score < 0) score = 0;
        refreshUI();
        Swal.fire({ title: 'Opps!', text: msg, icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
    }

    function moveNext(desc) {
        document.getElementById(`step-${currentStep}`).classList.add('hidden');
        currentStep++;
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');
        document.getElementById('challenge-desc').innerText = desc;
        refreshUI();
        if(currentStep >= 3) document.getElementById('btn-next').classList.add('hidden');
    }

    function validateStep() {
        if(currentStep === 1) {
            const res = [...document.querySelectorAll('#drop-1 .drag-item')].map(el => el.dataset.code).join('');
            if(res === "EBFDAC") moveNext("Tantangan 2: Atribut Form");
            else reduceScore("Urutan tag HTML masih salah!");
        } else if(currentStep === 2) {
            if(document.getElementById('q2-1').value === 'date' && document.getElementById('q2-2').value === 'password') 
                moveNext("Tantangan 3: Tabel & Layout");
            else reduceScore("Tipe input tidak sesuai!");
        }
    }

    function checkStep3(isCorrect) {
        if(isCorrect) moveNext("Tantangan 4: Navigasi Link");
        else reduceScore("Salah! Colspan menggabungkan kolom horizontal.");
    }

    function checkStep4(isCorrect) {
        if(isCorrect) moveNext("Tantangan 5: Void Elements");
        else reduceScore("Gunakan target='_blank'!");
    }

    async function finishExam(ans) {
        if(ans === 'img') {
            refreshUI();
            if(score >= 80) {
                confetti({ particleCount: 200, spread: 70 });

                // KIRIM DATA KE DATABASE LARAVEL
                try {
                    const response = await fetch("{{ route('exams.saveScore') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            category: 'HTML', // Ganti sesuai file (HTML/CSS/JS)
                            score: score
                        })
                    });

                    if (response.ok) {
                        Swal.fire({ 
                            title: 'LULUS HTML! 🎓', 
                            text: `Skor Akhir: ${score}. Nilai berhasil disimpan!`, 
                            icon: 'success' 
                        }).then(() => window.location.href = "{{ route('profile') }}");
                    }
                } catch (error) {
                    console.error("Gagal menyimpan nilai:", error);
                }

            } else {
                Swal.fire({ title: 'GAGAL ❌', text: `Skor ${score} tidak cukup. Minimal 80.`, icon: 'error' })
                .then(() => location.reload());
            }
        }
    }

    // Drag & Drop Logic
    const draggables = document.querySelectorAll('.drag-item');
    const dropzone = document.getElementById('drop-1');
    const sourcezone = document.getElementById('source-1');
    draggables.forEach(i => {
        i.addEventListener('dragstart', () => i.classList.add('dragging'));
        i.addEventListener('dragend', () => {
            i.classList.remove('dragging');
            document.getElementById('placeholder-text').style.display = dropzone.children.length > 1 ? 'none' : 'block';
        });
    });
    [dropzone, sourcezone].forEach(zone => {
        zone.addEventListener('dragover', e => { e.preventDefault(); zone.appendChild(document.querySelector('.dragging')); });
    });

    refreshUI();
</script>

<style>
    .drag-item.dragging { opacity: 0.5; }
    .exam-step { animation: fadeIn 0.4s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>