@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-4 text-sm font-bold text-slate-500">
            <span>Soal 1 dari 10</span>
            <span class="text-indigo-600">10% Selesai</span>
        </div>
        
        <div class="w-full bg-slate-200 rounded-full h-2.5 mb-10">
            <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 10%"></div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 md:p-12 text-center mb-8">
            <span class="inline-block px-3 py-1 mb-4 text-xs font-bold text-orange-600 bg-orange-100 rounded-full uppercase">
                Kuis HTML Dasar
            </span>
            <h2 class="text-2xl md:text-4xl font-extrabold text-slate-800 leading-snug">
                Tag HTML apa yang digunakan untuk membuat judul utama atau yang paling besar pada sebuah halaman web?
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <button class="w-full p-6 text-left text-lg font-semibold bg-white border-2 border-slate-200 rounded-2xl hover:border-indigo-500 hover:bg-indigo-50 transition-all focus:outline-none focus:ring-4 focus:ring-indigo-100 group">
                <span class="inline-block w-8 h-8 mr-3 text-center leading-8 bg-slate-100 text-slate-500 rounded-lg group-hover:bg-indigo-500 group-hover:text-white transition-colors">A</span>
                &lt;head&gt;
            </button>

            <button class="w-full p-6 text-left text-lg font-semibold bg-white border-2 border-slate-200 rounded-2xl hover:border-indigo-500 hover:bg-indigo-50 transition-all focus:outline-none focus:ring-4 focus:ring-indigo-100 group">
                <span class="inline-block w-8 h-8 mr-3 text-center leading-8 bg-slate-100 text-slate-500 rounded-lg group-hover:bg-indigo-500 group-hover:text-white transition-colors">B</span>
                &lt;h6&gt;
            </button>

            <button class="w-full p-6 text-left text-lg font-semibold bg-white border-2 border-slate-200 rounded-2xl hover:border-indigo-500 hover:bg-indigo-50 transition-all focus:outline-none focus:ring-4 focus:ring-indigo-100 group">
                <span class="inline-block w-8 h-8 mr-3 text-center leading-8 bg-slate-100 text-slate-500 rounded-lg group-hover:bg-indigo-500 group-hover:text-white transition-colors">C</span>
                &lt;h1&gt;
            </button>

            <button class="w-full p-6 text-left text-lg font-semibold bg-white border-2 border-slate-200 rounded-2xl hover:border-indigo-500 hover:bg-indigo-50 transition-all focus:outline-none focus:ring-4 focus:ring-indigo-100 group">
                <span class="inline-block w-8 h-8 mr-3 text-center leading-8 bg-slate-100 text-slate-500 rounded-lg group-hover:bg-indigo-500 group-hover:text-white transition-colors">D</span>
                &lt;header&gt;
            </button>
        </div>

        <div class="flex justify-end mt-10">
            <button class="px-8 py-3 bg-slate-900 text-white font-bold rounded-full hover:bg-slate-800 transition">
                Selanjutnya &rarr;
            </button>
        </div>

    </div>
</div>
@endsection