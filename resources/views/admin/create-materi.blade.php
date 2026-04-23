@extends('layouts.admin')

@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="text-indigo-600">✨</span> Tambah Materi Baru
            </h1>
            <p class="text-slate-500 mt-2 text-sm font-medium">Buat modul pembelajaran yang interaktif dan menarik untuk siswa.</p>
        </div>
        
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-slate-600 font-semibold rounded-xl border border-slate-200 hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
        
        <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

        <div class="p-8 sm:p-10">
            <form action="{{ route('admin.materi.store') }}" method="POST">
                @csrf

                <div class="space-y-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Judul Materi <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required
                                class="w-full bg-slate-50 text-slate-900 px-4 py-3.5 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm" 
                                placeholder="Contoh: Pengenalan Dasar HTML">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Kategori <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="category" required
                                    class="w-full bg-slate-50 text-slate-900 px-4 py-3.5 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none transition-colors shadow-sm">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    <option value="HTML">🔥 HTML</option>
                                    <option value="CSS">🎨 CSS</option>
                                    <option value="JS">⚡ JavaScript</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                            Link Video YouTube (Opsional)
                        </label>
                        <input type="text" name="video_url" 
                            class="w-full bg-slate-50 text-slate-900 px-4 py-3.5 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm font-mono text-sm" 
                            placeholder="Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                    </div>
                    
                    {{-- BAGIAN DESKRIPSI --}}
                    <div class="space-y-2 pt-6">
                        <label class="block text-sm font-bold text-slate-700">Deskripsi Singkat <span class="text-red-500">*</span></label>
                        <textarea name="description" required rows="3"
                            class="w-full bg-slate-50 text-slate-900 px-4 py-3.5 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm" 
                            placeholder="Tuliskan deskripsi singkat atau tujuan pembelajaran materi ini..."></textarea>
                        <p class="text-xs text-slate-500 font-medium">Deskripsi ini akan tampil di halaman daftar materi siswa.</p>
                    </div>

                    {{-- BAGIAN KUIS TENGAH VIDEO BARU --}}
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
                        <div id="video-quiz-container" class="space-y-6"></div>
                    </div>

                    <div class="space-y-3 pt-6 border-t border-slate-100">
                        <label class="block text-sm font-bold text-slate-700">Isi Materi <span class="text-red-500">*</span></label>
                        
                        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 flex gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-indigo-800 leading-relaxed">
                                <strong>Tips Koding:</strong> Gunakan ikon <b>&lt; &gt; (Code Block)</b> pada toolbar agar kodingan rapi.
                            </p>
                        </div>

                        <div class="prose max-w-none rounded-xl shadow-sm">
                            <textarea name="content" id="editor" placeholder="Ketik materi kamu di sini..."></textarea>
                        </div>
                    </div>

                    {{-- BAGIAN POST-TEST --}}
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
                        <div id="post-test-container" class="space-y-6"></div>
                    </div>

                    <div class="pt-6 border-t border-slate-100">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white font-bold py-4 px-10 rounded-2xl shadow-lg shadow-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Simpan Materi Baru
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [ 
                'heading', '|', 
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                'blockQuote', 'codeBlock', 'insertTable', '|',
                'undo', 'redo' 
            ]
        }).catch(error => { console.error(error); });

    /* ====== SCRIPT KUIS TENGAH VIDEO ====== */
    let videoQuizCount = 0;
    function tambahVideoQuiz() {
        const container = document.getElementById('video-quiz-container');
        const html = `
        <div class="bg-amber-50/40 p-6 rounded-xl border border-amber-200 relative" id="video-quiz-${videoQuizCount}">
            <button type="button" onclick="hapusVideoQuiz(${videoQuizCount})" class="absolute top-4 right-4 text-red-500 hover:text-red-700 font-bold">X Hapus</button>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-bold text-slate-700">Waktu Muncul (Detik ke-)</label>
                    <input type="number" name="interactive_quiz[${videoQuizCount}][time]" required class="w-full mt-1 p-3 rounded-lg border border-slate-300" placeholder="Contoh: 120 (muncul pada menit 2:00)">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Pertanyaan</label>
                    <input type="text" name="interactive_quiz[${videoQuizCount}][question]" required class="w-full mt-1 p-3 rounded-lg border border-slate-300">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs font-bold">Opsi 1</label><input type="text" name="interactive_quiz[${videoQuizCount}][options][]" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi 2</label><input type="text" name="interactive_quiz[${videoQuizCount}][options][]" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi 3</label><input type="text" name="interactive_quiz[${videoQuizCount}][options][]" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi 4</label><input type="text" name="interactive_quiz[${videoQuizCount}][options][]" required class="w-full p-2 border rounded"></div>
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Jawaban Benar</label>
                    <select name="interactive_quiz[${videoQuizCount}][correct]" required class="w-full p-3 border rounded-lg">
                        <option value="0">Opsi 1</option>
                        <option value="1">Opsi 2</option>
                        <option value="2">Opsi 3</option>
                        <option value="3">Opsi 4</option>
                    </select>
                </div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
        videoQuizCount++;
    }
    function hapusVideoQuiz(id) { document.getElementById('video-quiz-' + id).remove(); }

    /* ====== SCRIPT SOAL POST TEST ====== */
    let postTestCount = 0;
    function tambahPostTest() {
        const container = document.getElementById('post-test-container');
        const html = `
        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 relative" id="post-test-${postTestCount}">
            <button type="button" onclick="hapusPostTest(${postTestCount})" class="absolute top-4 right-4 text-red-500 hover:text-red-700 font-bold">X Hapus</button>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-bold text-slate-700">Pertanyaan</label>
                    <input type="text" name="post_test[${postTestCount}][pertanyaan]" required class="w-full mt-1 p-3 rounded-lg border border-slate-300">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs font-bold">Opsi A</label><input type="text" name="post_test[${postTestCount}][opsi_a]" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi B</label><input type="text" name="post_test[${postTestCount}][opsi_b]" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi C</label><input type="text" name="post_test[${postTestCount}][opsi_c]" required class="w-full p-2 border rounded"></div>
                    <div><label class="text-xs font-bold">Opsi D</label><input type="text" name="post_test[${postTestCount}][opsi_d]" required class="w-full p-2 border rounded"></div>
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Jawaban Benar</label>
                    <select name="post_test[${postTestCount}][jawaban_benar]" required class="w-full p-3 border rounded-lg">
                        <option value="a">Opsi A</option>
                        <option value="b">Opsi B</option>
                        <option value="c">Opsi C</option>
                        <option value="d">Opsi D</option>
                    </select>
                </div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
        postTestCount++;
    }
    function hapusPostTest(id) { document.getElementById('post-test-' + id).remove(); }
</script>

<style>
    .ck-editor__editable_inline { min-height: 400px; border-bottom-left-radius: 0.75rem !important; border-bottom-right-radius: 0.75rem !important; border-color: #e2e8f0 !important; padding: 1.5rem !important; }
    .ck-toolbar { border-top-left-radius: 0.75rem !important; border-top-right-radius: 0.75rem !important; background-color: #f8fafc !important; border-color: #e2e8f0 !important; padding: 0.5rem !important; }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) { border-color: #e2e8f0 !important; }
    .ck.ck-editor__editable:not(.ck-editor__nested-editable).ck-focused { border-color: #6366f1 !important; box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2) !important; }
</style>
@endsection