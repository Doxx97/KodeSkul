@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.12/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.12/theme/dracula.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div id="danger-boundary" class="fixed inset-0 pointer-events-none z-[60] opacity-0 transition-opacity duration-500" style="box-shadow: inset 0 0 60px rgba(239, 68, 68, 0.8);"></div>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        
        <div class="flex justify-between items-center mb-4 text-sm font-bold text-slate-500">
            <div id="timer-container" class="flex items-center gap-2 text-red-600 bg-red-50 px-4 py-2 rounded-xl border border-red-100 transition-all duration-300">
                <span id="timer-icon" class="animate-pulse">⏳</span>
                <span id="timer-display">10:00</span>
            </div>
            <div class="text-right">
                <span id="quiz-counter">Tantangan 1 dari 10</span>
                <div id="quiz-percent" class="text-indigo-600 text-lg font-black">10% Selesai</div>
            </div>
        </div>
        
        <div class="w-full bg-slate-200 rounded-full h-2.5 mb-8 overflow-hidden shadow-inner">
            <div id="progress-bar" class="bg-indigo-600 h-full rounded-full transition-all duration-700" style="width: 10%"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
            <div class="flex flex-col gap-4">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <span id="task-badge" class="inline-block px-4 py-1.5 mb-4 text-[10px] font-black text-indigo-600 bg-indigo-50 rounded-full uppercase tracking-widest">Memuat...</span>
                    <h2 id="task-title" class="text-2xl font-black text-slate-800 mb-3 italic">Persiapan...</h2>
                    <p id="task-desc" class="text-slate-600 leading-relaxed text-sm"></p>
                </div>

                <div class="relative bg-[#282a36] rounded-3xl shadow-2xl border border-slate-800 overflow-hidden flex-grow flex flex-col min-h-[350px]">
                    <div id="start-overlay" class="absolute inset-0 z-50 flex flex-col items-center justify-center bg-slate-900/95 backdrop-blur-md transition-all duration-500">
                        <div class="text-center p-8">
                            <div class="text-5xl mb-6 animate-bounce">🚀</div>
                            <h3 class="text-white font-black text-2xl mb-2">Sudah Siap, Koder?</h3>
                            <p class="text-slate-400 text-sm mb-8 max-w-xs">Waktu 10 menit akan berjalan setelah hitungan mundur selesai.</p>
                            <button onclick="initQuiz()" class="px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-500 shadow-lg shadow-indigo-500/20 transition-all transform active:scale-95">
                                MULAI KUIS
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-6 py-3 bg-[#191a21] border-b border-slate-800">
                        <span class="text-[10px] font-bold text-slate-500 tracking-[0.3em] uppercase italic">index.html</span>
                        <div class="flex gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#ff5f56]"></div>
                            <div class="w-3 h-3 rounded-full bg-[#ffbd2e]"></div>
                            <div class="w-3 h-3 rounded-full bg-[#27c93f]"></div>
                        </div>
                    </div>
                    <textarea id="code-editor"></textarea>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col min-h-[450px]">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center gap-3">
                    <div class="bg-white border border-slate-200 rounded-full text-[10px] px-5 py-1 text-slate-400 flex-grow shadow-sm italic text-center">kodeskul-preview-v1.0</div>
                </div>
                <iframe id="preview-window" class="w-full h-full bg-white"></iframe>
            </div>
        </div>

        <div id="footer-actions" class="hidden flex justify-between items-center mt-10">
            <button onclick="resetCode()" class="text-slate-400 font-bold hover:text-red-500 transition-all uppercase tracking-tighter text-sm">Reset Kode</button>
            <button onclick="checkAnswer()" class="px-12 py-5 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 shadow-xl transition-all active:scale-95 flex items-center gap-3">
                CEK JAWABAN & LANJUT &rarr;
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.12/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.12/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.12/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.12/mode/javascript/javascript.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const questions = [
        { t: "Judul Utama", b: "HTML Easy", d: "Buat tag h1 dengan teks 'Halo KodeSkul'", i: "<h1></h1>", a: "<h1>halokodeskul</h1>" },
        { t: "Link & Target", b: "HTML Easy", d: "Buat link a ke 'google.com' dengan target='_blank'", i: "<a></a>", a: 'target="_blank"' },
        { t: "Input Type", b: "HTML Medium", d: "Buat input khusus 'email' dengan placeholder 'Email'", i: "<input>", a: 'type="email"' },
        { t: "Image Alt", b: "HTML Medium", d: "Masukkan gambar 'logo.png' dengan alt 'Logo'", i: "<img>", a: 'alt="logo"' },
        { t: "Warna & Ukuran", b: "CSS Styling", d: "Beri style color:red dan font-size:20px pada h2", i: '<h2 style="">Teks</h2>', a: 'color:red;font-size:20px' },
        { t: "Box Model", b: "CSS Styling", d: "Beri padding:10px dan border:1px solid black pada div", i: '<div style="">Box</div>', a: 'padding:10px;border:1pxsolidblack' },
        { t: "Flexbox Layout", b: "CSS Advanced", d: "Gunakan display:flex dan justify-content:center pada style div", i: '<div style="">Flex</div>', a: 'display:flex;justify-content:center' },
        { t: "Variable & Alert", b: "JS Logic", d: "Deklarasi let pesan = 'Hi'; panggil alert(pesan);", i: "<script>\n\n<\/script>", a: 'letpesan="hi";alert(pesan)' },
        { t: "Function Dasar", b: "JS Logic", d: "Buat fungsi 'cek' yang menjalankan alert('OK')", i: "<script>\n\n<\/script>", a: 'functioncek(){alert("ok")}' },
        { t: "DOM Master", b: "JS Master", d: "Ubah innerHTML ID 'status' menjadi 'Lulus'", i: "<div id='status'></div>\n<script>\n\n<\/script>", a: 'document.getelementbyid("status").innerhtml="lulus"' }
    ];

    let current = 0;
    let seconds = 600; // 10 Menit
    let timer;
    let isStarted = false;

    const editor = CodeMirror.fromTextArea(document.getElementById('code-editor'), {
        mode: "xml",
        theme: "dracula",
        lineNumbers: true,
        autoCloseTags: true,
        lineWrapping: true,
        readOnly: "nocursor"
    });

    async function initQuiz() {
        const overlay = document.getElementById('start-overlay');
        overlay.style.opacity = '0';
        setTimeout(() => overlay.style.display = 'none', 500);

        let timerInterval;
        await Swal.fire({
            title: 'Siap-siap!',
            html: '<b id="countdown-number" style="font-size: 3rem; color: #4f46e5;">3</b>',
            timer: 3500,
            timerProgressBar: true,
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                const content = Swal.getHtmlContainer().querySelector('#countdown-number');
                let timeLeft = 3;
                timerInterval = setInterval(() => {
                    timeLeft--;
                    if (timeLeft > 0) content.innerText = timeLeft;
                    else if (timeLeft === 0) { content.innerText = 'GOOO! 🚀'; content.style.color = '#22c55e'; }
                }, 1000);
            },
            willClose: () => { clearInterval(timerInterval); }
        });

        isStarted = true;
        document.getElementById('footer-actions').classList.remove('hidden');
        editor.setOption("readOnly", false);
        editor.getWrapperElement().style.opacity = "1"; 
        editor.focus();
        load();
        startTimer();
    }

    function load() {
        const q = questions[current];
        document.getElementById('task-badge').innerText = q.b;
        document.getElementById('task-title').innerText = q.t;
        document.getElementById('task-desc').innerText = q.d;
        document.getElementById('quiz-counter').innerText = `Tantangan ${current + 1} dari 10`;
        const progress = ((current + 1) / 10) * 100;
        document.getElementById('progress-bar').style.width = `${progress}%`;
        document.getElementById('quiz-percent').innerText = `${Math.round(progress)}% Selesai`;
        editor.setValue(q.i);
        updatePreview();
    }

    function updatePreview() {
        const code = editor.getValue();
        const frame = document.getElementById('preview-window').contentDocument;
        frame.open();
        frame.write(`<html><body style="font-family:sans-serif;padding:20px;">${code}</body></html>`);
        frame.close();
    }

    function startTimer() {
        timer = setInterval(() => {
            let m = Math.floor(seconds / 60);
            let s = seconds % 60;
            document.getElementById('timer-display').innerText = `${m}:${s < 10 ? '0'+s : s}`;
            
            // --- LOGIKA 10 DETIK TERAKHIR ---
            if (seconds <= 10 && seconds > 0) {
                const boundary = document.getElementById('danger-boundary');
                const timerCont = document.getElementById('timer-container');
                
                boundary.style.opacity = '1';
                boundary.classList.add('animate-emergency');
                
                timerCont.classList.remove('bg-red-50', 'text-red-600');
                timerCont.classList.add('bg-red-600', 'text-white', 'scale-110');
            }

            if (seconds <= 0) {
                clearInterval(timer);
                document.getElementById('danger-boundary').style.opacity = '0';
                Swal.fire({ title: 'Waktu Habis! ⏰', text: 'Coba lagi!', icon: 'error' }).then(() => location.reload());
            }
            seconds--;
        }, 1000);
    }

    function checkAnswer() {
        const code = editor.getValue().toLowerCase().replace(/\s/g, '').replace(/'/g, '"');
        const ans = questions[current].a.toLowerCase().replace(/\s/g, '').replace(/'/g, '"');
        if (code.includes(ans)) {
            if (current < 9) {
                Swal.fire({ title: 'Mantap! 🔥', icon: 'success', timer: 1000, showConfirmButton: false });
                current++;
                load();
            } else {
                clearInterval(timer);
                Swal.fire({ title: 'LULUS! 🏆', text: 'Cek profil kamu!', icon: 'success' })
                .then(() => window.location.href = "{{ route('profile') }}");
            }
        } else {
            Swal.fire({ title: 'Belum Tepat!', icon: 'error' });
        }
    }

    function resetCode() { editor.setValue(questions[current].i); }
    editor.on('change', updatePreview);
</script>

<style>
    .CodeMirror { height: 100% !important; font-family: 'Fira Code', monospace; font-size: 14px; opacity: 0.3; transition: all 0.5s; }
    #start-overlay[style*="display: none"] ~ .CodeMirror { opacity: 1; }

    /* Animasi Berkedip Merah */
    @keyframes emergency-pulse {
        0% { box-shadow: inset 0 0 40px rgba(239, 68, 68, 0.7); }
        50% { box-shadow: inset 0 0 100px rgba(239, 68, 68, 1); }
        100% { box-shadow: inset 0 0 40px rgba(239, 68, 68, 0.7); }
    }
    .animate-emergency {
        animation: emergency-pulse 0.8s infinite;
    }

    #timer-container { transition: all 0.3s ease; }
</style>
@endsection