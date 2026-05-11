@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-10">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">📚 Kelola Materi Teks</h1>
            <p class="text-slate-500 mt-1">Total terdapat {{ $articles->count() }} materi yang telah diterbitkan.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" 
           class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-1 active:scale-95">
            <span class="text-xl">+</span> Tambah Materi Baru
        </a>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="p-6 text-xs font-bold text-slate-400 uppercase tracking-widest">Judul Materi</th>
                        <th class="p-6 text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori</th>
                        <th class="p-6 text-xs font-bold text-slate-400 uppercase tracking-widest">Terakhir Diupdate</th>
                        <th class="p-6 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($articles as $article)
                    <tr class="group hover:bg-indigo-50/30 transition-colors">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold shadow-sm group-hover:scale-110 transition-transform">
                                    {{ substr($article->title, 0, 1) }}
                                </div>
                                <span class="font-semibold text-slate-700 group-hover:text-indigo-600 transition-colors">{{ $article->title }}</span>
                            </div>
                        </td>
                        <td class="p-6">
                            @php
                                $badgeColor = match($article->category) {
                                    'HTML' => 'bg-orange-100 text-orange-600 border-orange-200',
                                    'CSS' => 'bg-blue-100 text-blue-600 border-blue-200',
                                    'JavaScript' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    default => 'bg-slate-100 text-slate-600 border-slate-200',
                                };
                            @endphp
                            <span class="px-4 py-1.5 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                {{ $article->category }}
                            </span>
                        </td>
                        <td class="p-6">
                            <span class="text-sm text-slate-500 font-medium">
                                {{ $article->updated_at->diffForHumans() }}
                            </span>
                        </td>
                        <td class="p-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.articles.edit', $article->id) }}" 
                                   class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm"
                                   title="Edit Materi">
                                   ✏️
                                </a>
                                {{-- Tombol hapus jika diperlukan --}}
                                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <span class="text-5xl">📭</span>
                                <p class="text-slate-400 font-medium">Belum ada materi teks yang dibuat.</p>
                                <a href="{{ route('admin.articles.create') }}" class="text-indigo-600 font-bold hover:underline">Mulai buat sekarang →</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection