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
                            Link Video YouTube (Hanya ID-nya saja)
                        </label>
                        <input type="text" name="video_url" value="{{ old('video_url', $material->video_url) }}"
                            class="w-full bg-slate-50 text-slate-900 px-4 py-3.5 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm font-mono text-sm" placeholder="Contoh: dQw4w9WgXcQ">
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
                            {{-- Area render kuis lama --}}
                        </div>
                    </div>

                    {{-- 4. ISI MATERI --}}
                    <div class="space-y-3 pt-6 border-t border-slate-100">
                        <label class="block text-sm font-bold text-slate-700">Isi Materi <span class="text-red-500">*</span></label>
                        <div class="prose max-w-none rounded-xl shadow-sm">
                            <textarea name="content" id="editor">{!! old('content', $material->content) !!}</textarea>
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
    // 1. Inisialisasi CKEditor
    ClassicEditor.create(document.querySelector('#editor')).catch(error => { console.error(error); });

    // 2. Ambil data kuis lama dengan cara yang lebih "aman" dari ParseError
    // Kita simpan ke variabel perantara dulu
    const dataKuisRaw = {!! json_encode($material->interactive_quiz) !!};
    
    let kuisIndex = 0;

    // 3. Fungsi Tambah/Render Kotak Kuis
    function tambahVideoQuiz(data = null) {
        const container = document.getElementById('video-quiz-container');
        
        const waktu = data ? data.time : '';
        const tanya = data ? data.question : '';
        const opsi  = (data && data.options) ? data.options : ['', '', '', ''];
        const benar = (data && data.correct !== undefined) ? data.correct : '0';

        const html = `
            <div class="bg-amber-50/40 p-6 rounded-xl border border-amber-200 relative mb-4" id="item-kuis-${kuisIndex}">
                <div class="flex justify-between items-center mb-4">
                    <label class="font-bold text-slate-700">Kuis #${kuisIndex + 1}</label>
                    <button type="button" onclick="hapusVideoQuiz(${kuisIndex})" class="text-red-500 hover:text-red-700 font-bold text-xs flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg> Hapus
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div class="md:col-span-1">
                        <label class="text-xs font-bold text-slate-500">Detik Ke-</label>
                        <input type="number" name="interactive_quiz[${kuisIndex}][time]" value="${waktu}" required class="w-full mt-1 p-3 rounded-lg border border-slate-300">
                    </div>
                    <div class="md:col-span-3">
                        <label class="text-xs font-bold text-slate-500">Pertanyaan</label>
                        <input type="text" name="interactive_quiz[${kuisIndex}][question]" value="${tanya}" required class="w-full mt-1 p-3 rounded-lg border border-slate-300">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div><label class="text-xs font-bold text-slate-400">Opsi A</label><input type="text" name="interactive_quiz[${kuisIndex}][options][]" value="${opsi[0] || ''}" required class="w-full p-2 border border-slate-200 rounded-lg"></div>
                    <div><label class="text-xs font-bold text-slate-400">Opsi B</label><input type="text" name="interactive_quiz[${kuisIndex}][options][]" value="${opsi[1] || ''}" required class="w-full p-2 border border-slate-200 rounded-lg"></div>
                    <div><label class="text-xs font-bold text-slate-400">Opsi C</label><input type="text" name="interactive_quiz[${kuisIndex}][options][]" value="${opsi[2] || ''}" required class="w-full p-2 border border-slate-200 rounded-lg"></div>
                    <div><label class="text-xs font-bold text-slate-400">Opsi D</label><input type="text" name="interactive_quiz[${kuisIndex}][options][]" value="${opsi[3] || ''}" required class="w-full p-2 border border-slate-200 rounded-lg"></div>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500">Jawaban Benar</label>
                    <select name="interactive_quiz[${kuisIndex}][correct]" required class="w-full mt-1 p-3 border border-slate-300 rounded-lg bg-white">
                        <option value="0" ${String(benar) === '0' ? 'selected' : ''}>Opsi A</option>
                        <option value="1" ${String(benar) === '1' ? 'selected' : ''}>Opsi B</option>
                        <option value="2" ${String(benar) === '2' ? 'selected' : ''}>Opsi C</option>
                        <option value="3" ${String(benar) === '3' ? 'selected' : ''}>Opsi D</option>
                    </select>
                </div>
            </div>`;
        
        container.insertAdjacentHTML('beforeend', html);
        kuisIndex++;
    }

    function hapusVideoQuiz(id) {
        const el = document.getElementById('item-kuis-' + id);
        if(el) el.remove();
    }

    // 4. Inisialisasi data saat halaman siap
    document.addEventListener('DOMContentLoaded', function() {
        let quizData = dataKuisRaw;

        // Jika data dikirim sebagai string (JSON), parse dulu
        if (typeof quizData === 'string' && quizData.trim() !== "") {
            try {
                quizData = JSON.parse(quizData);
            } catch (e) {
                console.error("Gagal parse kuis:", e);
                quizData = [];
            }
        }

        // Render kuis lama
        if (quizData && typeof quizData === 'object') {
            Object.values(quizData).forEach(item => {
                tambahVideoQuiz(item);
            });
        }
    });
</script>

{{-- Jika ingin styling khusus untuk CKEditor, bisa ditambahkan di sini --}}

<style>
    .ck-editor__editable_inline { min-height: 400px; border-bottom-left-radius: 0.75rem !important; border-bottom-right-radius: 0.75rem !important; border-color: #e2e8f0 !important; padding: 1.5rem !important; }
    .ck-toolbar { border-top-left-radius: 0.75rem !important; border-top-right-radius: 0.75rem !important; background-color: #f8fafc !important; border-color: #e2e8f0 !important; padding: 0.5rem !important; }
</style>
@endsection