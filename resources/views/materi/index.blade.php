@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-4xl mx-auto">
        {{-- Tombol Kembali --}}
        <a href="{{ route('materi.list_per_kategori', strtolower($material->category)) }}" class="text-blue-500 hover:underline">
            ← Kembali ke Daftar Materi {{ $material->category }}
        </a>

        {{-- Judul Materi --}}
        <h1 class="text-4xl font-bold mt-6 mb-4">{{ $material->title }}</h1>
        
        <div class="flex items-center text-sm text-gray-500 mb-8">
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full mr-3">{{ $material->category }}</span>
            <span>Dipublikasikan pada {{ $material->created_at->format('d M Y') }}</span>
        </div>

        {{-- Isi Materi --}}
        <div class="prose max-w-none bg-white p-8 shadow-sm rounded-xl border border-gray-100">
            {!! $material->content !!}
        </div>
    </div>
</div>
@endsection