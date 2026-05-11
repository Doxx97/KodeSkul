@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-5xl">
    {{-- Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">✏️ Edit Materi</h1>
            <p class="text-slate-500 mt-1">Perbarui informasi atau isi materi agar tetap relevan.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-indigo-600 transition">
            ← Batal & Kembali
        </a>
    </div>

    {{-- Alert Sukses & Error dipindah ke atas agar terlihat duluan --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-2xl flex items-center gap-3 shadow-md animate-bounce-short">
            <span class="text-2xl">✅</span>
            <p class="font-bold text-emerald-800">{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl flex items-start gap-3 shadow-md">
            <span class="text-2xl">⚠️</span>
            <div>
                <h4 class="font-bold text-red-800">Gagal Memperbarui Materi</h4>
                <ul class="text-sm text-red-700 list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-12">
            <div class="grid grid-cols-1 gap-8">
                
                {{-- 1. Judul Materi --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1 uppercase tracking-wider">Judul Materi</label>
                    <input type="text" name="title" value="{{ old('title', $article->title) }}" required
                        class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-lg font-medium focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all shadow-inner">
                </div>

                {{-- 2. Lampiran Materi --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1 uppercase tracking-wider">Lampiran Materi (Optional)</label>
                    
                    @if($article->file_materi)
                        <div class="flex items-center gap-3 p-3 bg-indigo-50 rounded-xl border border-indigo-100 mb-2">
                            <span class="text-xl">📄</span>
                            <div class="overflow-hidden">
                                <p class="text-xs font-bold text-indigo-900 truncate">{{ basename($article->file_materi) }}</p>
                                <p class="text-[10px] text-indigo-600">File saat ini sudah terpasang</p>
                            </div>
                        </div>
                    @endif

                    <div class="relative group">
                        <input type="file" name="file_materi" 
                            class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl px-6 py-4 text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all shadow-inner">
                    </div>
                    <p class="text-[10px] text-slate-400 ml-2 italic">*Format: PDF, DOCX, ZIP (Maks 20MB)</p>
                </div>

                {{-- 3. Kategori --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1 uppercase tracking-wider">Kategori</label>
                    <div class="relative">
                        <select name="category" required
                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-slate-700 font-medium focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all appearance-none shadow-inner">
                            <option value="HTML" {{ $article->category == 'HTML' ? 'selected' : '' }}>HTML Dasar</option>
                            <option value="CSS" {{ $article->category == 'CSS' ? 'selected' : '' }}>CSS Styling</option>
                            <option value="JavaScript" {{ $article->category == 'JavaScript' ? 'selected' : '' }}>JavaScript Interaktif</option>
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">▼</div>
                    </div>
                </div>

                {{-- 4. Konten Materi --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1 uppercase tracking-wider">Isi Materi</label>
                    <div class="rounded-2xl overflow-hidden shadow-inner bg-slate-50">
                        <textarea name="content" id="editor">{{ old('content', $article->content) }}</textarea>
                    </div>
                </div>

                {{-- 5. Tombol Simpan --}}
                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-5 px-8 rounded-2xl shadow-lg shadow-emerald-100 transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 text-lg">
                        <span>💾</span> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- 1. CSS diletakkan di dalam tag <style> --}}
<style>
    @keyframes bounce-short {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    .animate-bounce-short {
        animation: bounce-short 0.5s ease-in-out 1;
    }
    /* Tambahan agar editor terlihat lebih tinggi */
    .ck-editor__editable {
        min-height: 300px !important;
    }
</style>

{{-- 2. Script JS diletakkan di bawah --}}
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => { console.error(error); });
</script>
@endsection