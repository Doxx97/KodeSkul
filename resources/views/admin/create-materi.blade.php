@extends('layouts.admin')

@section('content')
<div class="max-w-4xl">
    <div class="mb-8 flex items-center gap-4">
        <a href="/admin/dashboard" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 rounded-full text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition">
            &larr;
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Buat Materi Baru ✍️</h1>
        </div>
    </div>

    <form action="/admin/materi" method="POST" class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-slate-100 space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Judul Materi</label>
                <input type="text" name="title" required placeholder="Contoh: Pengenalan Tag <div>" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                <select name="category" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none transition appearance-none">
                    <option value="HTML">HTML</option>
                    <option value="CSS">CSS</option>
                    <option value="JavaScript">JavaScript</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Singkat</label>
            <textarea name="description" required rows="2" placeholder="Tulis ringkasan materinya di sini..." class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none transition resize-none"></textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Isi Materi Lengkap</label>
            <textarea name="content" required rows="10" placeholder="Ketik isi materinya. (Nantinya kita bisa pasang WYSIWYG Editor/CKEditor di sini)" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none transition"></textarea>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-8 py-4 bg-indigo-600 text-white font-extrabold rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all transform hover:-translate-y-1">
                🚀 Publish Materi
            </button>
        </div>
    </form>
</div>
@endsection