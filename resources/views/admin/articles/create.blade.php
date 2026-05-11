@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-5xl">
    {{-- Breadcrumb & Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">📝 Buat Materi Baru</h1>
            <p class="text-slate-500 mt-1">Tulis materi berbasis teks untuk membantu siswa belajar lebih dalam.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-indigo-600 transition">
            ← Kembali ke Daftar
        </a>
    </div>

    {{-- Alert Error jika file terlalu besar atau format salah --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl flex items-start gap-3 shadow-md">
            <span class="text-2xl">⚠️</span>
            <div>
                <h4 class="font-bold text-red-800">Gagal Menerbitkan Materi</h4>
                <ul class="text-sm text-red-700 list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- PENTING: Tambahkan enctype="multipart/form-data" --}}
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-12">
            <div class="grid grid-cols-1 gap-8">
                
                {{-- Judul Materi --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1 uppercase tracking-wider">Judul Materi</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-lg font-medium focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all placeholder:text-slate-400 shadow-inner"
                        placeholder="Contoh: Dasar-dasar Flexbox CSS">
                </div>

                {{-- Kategori --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1 uppercase tracking-wider">Pilih Kategori</label>
                    <div class="relative">
                        <select name="category" required
                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-slate-700 font-medium focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all appearance-none shadow-inner">
                            <option value="HTML">HTML Dasar</option>
                            <option value="CSS">CSS Styling</option>
                            <option value="JavaScript">JavaScript Interaktif</option>
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">▼</div>
                    </div>
                </div>

                {{-- Lampiran Materi --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1 uppercase tracking-wider">Lampiran Materi (Optional)</label>
                    <div class="relative group">
                        <input type="file" name="file_materi" 
                            class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl px-6 py-4 text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all shadow-inner">
                    </div>
                    <p class="text-[10px] text-slate-400 ml-2 italic text-center md:text-left">*Format: PDF, DOCX, ZIP (Maks 20MB)</p>
                </div>

                {{-- Konten Materi --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1 uppercase tracking-wider">Konten Materi</label>
                    <div class="rounded-2xl overflow-hidden border-none shadow-inner bg-slate-50">
                        <textarea name="content" id="editor">{{ old('content') }}</textarea>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white font-bold py-5 px-8 rounded-2xl shadow-lg shadow-indigo-200 transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 text-lg">
                        <span>🚀</span> Terbitkan Materi Sekarang
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Styling & Script tetap sama --}}
<style>
    .ck-editor__human-interface-container { border: none !important; background: #f8fafc !important; padding: 10px !important; }
    .ck-content { min-height: 400px !important; border: none !important; background: white !important; padding: 2rem !important; font-size: 1.1rem !important; color: #334155 !important; }
    .ck-toolbar { background: #f1f5f9 !important; border: none !important; border-bottom: 1px solid #e2e8f0 !important; padding: 0.5rem !important; }
    
    @keyframes bounce-short {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    .animate-bounce-short { animation: bounce-short 0.5s ease-in-out 1; }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            placeholder: 'Tuliskan ilmu bermanfaatmu di sini...',
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ]
        })
        .catch(error => { console.error(error); });
</script>
@endsection