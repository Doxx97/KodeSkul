@extends('layouts.admin')

@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="text-indigo-600">✏️</span> Edit Materi
            </h1>
            <p class="text-slate-500 mt-2 text-sm font-medium">Perbarui modul, kuis video, dan post-test untuk siswa.</p>
        </div>
        
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-slate-600 font-semibold rounded-xl border border-slate-200 hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl shadow-sm">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">Ada kesalahan saat menyimpan:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
        
        <div class="h-2 w-full bg-gradient-to-r from-amber-400 via-orange-500 to-red-500"></div>

        <div class="p-8 sm:p-10">
            <form action="{{ route('admin.materi.update', $material->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    
                    {{-- 1. INFORMASI DASAR --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Judul Materi <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $material->title) }}" required
                                class="w-full bg-slate-50 text-slate-900 px-4 py-3.5 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Kategori <span class="text-red-500">*</span></label>
                            <select name="category" required
                                class="w-full bg-slate-50 text-slate-900 px-4 py-3.5 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none transition-colors shadow-sm">
                                <option value="HTML" {{ $material->category == 'HTML' ? 'selected' : '' }}>🔥 HTML</option>
                                <option value="CSS" {{ $material->category == 'CSS' ? 'selected' : '' }}>🎨 CSS</option>
                                <option value="JS" {{ $material->category == 'JS' ? 'selected' : '' }}>⚡ JavaScript</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                            Link Video YouTube (Opsional)
                        </label>
                        <input type="text" name="video_url" value="{{ old('video_url', $material->video_url) }}"
                            class="w-full bg-slate-50 text-slate-900 px-4 py-3.5 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm font-mono text-sm">
                    </div>

                    {{-- 2. DESKRIPSI --}}
                    <div class="space-y-2 pt-6">
                        <label class="block text-sm font-bold text-slate-700">Deskripsi Singkat <span class="text-red-500">*</span></label>
                        <textarea name="description" required rows="3"
                            class="w-full bg-slate-50 text-slate-900 px-4 py-3.5 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm">{{ old('description', $material->description) }}</textarea>
                    </div>

                    {{-- 3. KUIS TENGAH VIDEO --}}
                    <div class="space-y-4 pt-6 border-t border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-lg font-bold text-slate-700">▶️ Kuis Tengah Video (Opsional)</label>
                                <p class="text-xs text-slate-500 mt-1">Muncul pop-up pertanyaan otomatis saat video menyentuh detik tertentu.</p>
                            </div>
                            <button type="button" onclick="tambahVideoQuiz()" class="text-sm px-4 py-2 bg-amber-50 text-amber-600 rounded-lg font-bold hover:bg-amber-100 transition-colors border border-amber-200">
                                + Tambah Kuis Video
                            </button>
                        </div>
                        <div id="video-quiz-container" class="space-y-6">
                            {{-- Data akan dirender via JS di bawah --}}
                        </div>
                    </div>

                    {{-- 4. ISI MATERI --}}
                    <div class="space-y-3 pt-6 border-t border-slate-100">
                        <label class="block text-sm font-bold text-slate-700">Isi Materi <span class="text-red-500">*</span></label>
                        <div class="prose max-w-none rounded-xl shadow-sm">
                            <textarea name="content" id="editor">{!! old('content', $material->content) !!}</textarea>
                        </div>
                    </div>

                    {{-- 5. POST TEST --}}
                    <div class="space-y-4 pt-6 border-t border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-lg font-bold text-slate-700">📝 Buat Soal Post-Test (Opsional)</label>
                                <p class="text-xs text-slate-500 mt-1">Syarat lulus materi. Siswa harus mendapat nilai 80 untuk lanjut bab.</p>
                            </div>
                            <button type="button" onclick="tambahPostTest()" class="text-sm px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg font-bold hover:bg-indigo-100 transition-colors">
                                + Tambah Soal
                            </button>
                        </div>
                        <div id="post-test-container" class="space-y-6">
                            {{-- Data akan dirender via JS di bawah --}}
                        </div>
                    </div>

                    {{-- TOMBOL SIMPAN --}}
                    <div class="pt-6 border-t border-slate-100">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold py-4 px-10 rounded-2xl shadow-lg shadow-orange-200 transition-all duration-300 transform hover:-translate-y-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Simpan Perubahan Materi
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Inisialisasi CKEditor
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [ 
                'heading', '|', 
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                'blockQuote', 'codeBlock', 'insertTable', '|',
                'undo', 'redo' 
            ]
        }).catch(error => { console.error(error); });


    /* ====== LOGIKA RENDER DATA LAMA (JSON to Form) ====== */
    
    // Ambil data dari database (sudah di-encode JSON)
    const existingVideoQuizzes = {!! $material->interactive_quiz ?: '[]' !!};
    const existingPostTests = {!! $material->post_test ?: '[]' !!};

    let videoQuizCount = 0;
    let postTestCount = 0;

    // Fungsi Render Kuis Video Lama
    function renderExistingVideoQuizzes() {
        if(Array.isArray(existingVideoQuizzes) || typeof existingVideoQuizzes === 'object') {
            // Karena jika object dari PHP (JSON object keys bisa jadi berantakan indeksnya), kita pakai for...in atau Object.values
            Object.values(existingVideoQuizzes).forEach((quiz) => {
                tambahVideoQuiz(quiz);
            });
        }
    }

    // Fungsi Render Post Test Lama
    function renderExistingPostTests() {
        if(Array.isArray(existingPostTests) || typeof existingPostTests === 'object') {
            Object.values(existingPostTests).forEach((test) => {
                tambahPostTest(test);
            });
        }
    }

    /* ====== SCRIPT KUIS TENGAH VIDEO ====== */
    function tambahVideoQuiz(data = null) {
        const container = document.getElementById('video-quiz-container');
        
        // Cek apakah ada data lama, jika tidak kosongkan
        const timeVal = data ? data.time : '';
        const questionVal = data ? data.question : '';
        const opt0 = (data && data.options && data.options[0]) ? data.options[0] : '';
        const opt1 = (data && data.options && data.options[1]) ? data.options[1] : '';
        const opt2 = (data && data.options && data.options[2]) ? data.options[2] : '';
        const opt3 = (data && data.options && data.options[3]) ? data.options[3] : '';
        const correctVal = data ? data.correct : '0';

        const html = `
        <div class="bg-amber-50/40 p-6 rounded-xl border border-amber-200 relative" id="video-quiz-${videoQuizCount}">
            <button type="button" onclick="hapusVideoQuiz(${videoQuizCount})" class="absolute top-4 right-4 text-red-500 hover:text-red-700 font-bold">X Hapus</button>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-bold text-slate-700">Waktu Muncul (Detik ke-)</label>
                    <input type="number" name="interactive_quiz[${videoQuizCount}][time]" value="${timeVal}" required class="w-full mt-1 p-3 rounded-lg border border-slate-300" placeholder="Contoh: 120">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Pertanyaan</label>
                    <input type="text" name="interactive_quiz[${videoQuizCount}][question]" value="${questionVal}" required class="w-full mt-1 p-3 rounded-lg border border-slate-300">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs font-bold">Opsi 1</label><input type="text" name="interactive_quiz[${videoQuizCount}][options][]" value="${opt0}" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi 2</label><input type="text" name="interactive_quiz[${videoQuizCount}][options][]" value="${opt1}" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi 3</label><input type="text" name="interactive_quiz[${videoQuizCount}][options][]" value="${opt2}" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi 4</label><input type="text" name="interactive_quiz[${videoQuizCount}][options][]" value="${opt3}" required class="w-full p-2 border rounded"></div>
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Jawaban Benar</label>
                    <select name="interactive_quiz[${videoQuizCount}][correct]" required class="w-full p-3 border rounded-lg">
                        <option value="0" ${correctVal == '0' ? 'selected' : ''}>Opsi 1</option>
                        <option value="1" ${correctVal == '1' ? 'selected' : ''}>Opsi 2</option>
                        <option value="2" ${correctVal == '2' ? 'selected' : ''}>Opsi 3</option>
                        <option value="3" ${correctVal == '3' ? 'selected' : ''}>Opsi 4</option>
                    </select>
                </div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
        videoQuizCount++;
    }
    function hapusVideoQuiz(id) { document.getElementById('video-quiz-' + id).remove(); }


    /* ====== SCRIPT SOAL POST TEST ====== */
    function tambahPostTest(data = null) {
        const container = document.getElementById('post-test-container');
        
        const questionVal = data ? data.pertanyaan : '';
        const optA = data ? data.opsi_a : '';
        const optB = data ? data.opsi_b : '';
        const optC = data ? data.opsi_c : '';
        const optD = data ? data.opsi_d : '';
        const correctVal = data ? data.jawaban_benar : 'a';

        const html = `
        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 relative" id="post-test-${postTestCount}">
            <button type="button" onclick="hapusPostTest(${postTestCount})" class="absolute top-4 right-4 text-red-500 hover:text-red-700 font-bold">X Hapus</button>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-bold text-slate-700">Pertanyaan</label>
                    <input type="text" name="post_test[${postTestCount}][pertanyaan]" value="${questionVal}" required class="w-full mt-1 p-3 rounded-lg border border-slate-300">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs font-bold">Opsi A</label><input type="text" name="post_test[${postTestCount}][opsi_a]" value="${optA}" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi B</label><input type="text" name="post_test[${postTestCount}][opsi_b]" value="${optB}" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi C</label><input type="text" name="post_test[${postTestCount}][opsi_c]" value="${optC}" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi D</label><input type="text" name="post_test[${postTestCount}][opsi_d]" value="${optD}" required class="w-full p-2 border rounded"></div>
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Jawaban Benar</label>
                    <select name="post_test[${postTestCount}][jawaban_benar]" required class="w-full p-3 border rounded-lg">
                        <option value="a" ${correctVal === 'a' ? 'selected' : ''}>Opsi A</option>
                        <option value="b" ${correctVal === 'b' ? 'selected' : ''}>Opsi B</option>
                        <option value="c" ${correctVal === 'c' ? 'selected' : ''}>Opsi C</option>
                        <option value="d" ${correctVal === 'd' ? 'selected' : ''}>Opsi D</option>
                    </select>
                </div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
        postTestCount++;
    }
    function hapusPostTest(id) { document.getElementById('post-test-' + id).remove(); }

    // Jalankan fungsi render saat halaman selesai dimuat
    document.addEventListener("DOMContentLoaded", function() {
        renderExistingVideoQuizzes();
        renderExistingPostTests();
    });

</script>

<style>
    .ck-editor__editable_inline { min-height: 400px; border-bottom-left-radius: 0.75rem !important; border-bottom-right-radius: 0.75rem !important; border-color: #e2e8f0 !important; padding: 1.5rem !important; }
    .ck-toolbar { border-top-left-radius: 0.75rem !important; border-top-right-radius: 0.75rem !important; background-color: #f8fafc !important; border-color: #e2e8f0 !important; padding: 0.5rem !important; }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) { border-color: #e2e8f0 !important; }
    .ck.ck-editor__editable:not(.ck-editor__nested-editable).ck-focused { border-color: #6366f1 !important; box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2) !important; }
</style>
@endsection