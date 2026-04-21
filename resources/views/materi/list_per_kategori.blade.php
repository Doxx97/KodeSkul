@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('materi.pilih') }}" class="text-blue-500 hover:text-blue-700 font-medium flex items-center gap-2">
                <span>←</span> Kembali ke Pilihan Materi
            </a>
            <h1 class="text-3xl font-bold mt-4 text-gray-800">Materi {{ $categoryName }}</h1>
            <p class="text-gray-600 mt-2">Berikut adalah daftar materi {{ $categoryName }} yang bisa kamu pelajari.</p>
        </div>

        <div class="space-y-4">
            @forelse($materials as $index => $item)
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between hover:border-blue-400 hover:shadow-md transition group">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold group-hover:bg-blue-600 group-hover:text-white transition">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-500 line-clamp-1">{{ $item->description }}</p>
                        </div>
                    </div>
                    <a href="{{ route('materi.show', $item->id) }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                        Buka Materi
                    </a>
                </div>
            @empty
                {{-- Poin Nomor 3: Jika belum ada materi --}}
                <div class="text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                    <div class="text-5xl mb-4 text-gray-300">📁</div>
                    <h3 class="text-xl font-semibold text-gray-800">Belum ada materi</h3>
                    <p class="text-gray-500 mt-2">Admin belum mengunggah materi untuk kategori {{ $categoryName }}.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection