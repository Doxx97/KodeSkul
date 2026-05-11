@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-12 py-12 max-w-4xl">
    
    {{-- Navigasi Kembali --}}
    <div class="mb-12">
        <a href="{{ route('blog.index') }}" class="group inline-flex items-center gap-3 text-slate-500 font-black text-xs uppercase tracking-widest hover:text-indigo-600 transition-all">
            <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all">&larr;</span>
            Back to Journal
        </a>
    </div>

    <article>
        {{-- Header Materi --}}
        <header class="mb-12">
            <div class="flex items-center gap-4 mb-6">
                <span class="px-4 py-1.5 bg-indigo-600 text-white text-[10px] font-black rounded-full uppercase tracking-[0.15em] shadow-lg shadow-indigo-100">
                    {{ $article->category }}
                </span>
                <div class="h-px w-12 bg-slate-200"></div>
                <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">
                    Published {{ $article->created_at->format('d M Y') }}
                </span>
            </div>

            <h1 class="text-4xl md:text-6xl font-black text-slate-900 mb-8 leading-[1.1] tracking-tighter italic uppercase">
                {{ $article->title }}
            </h1>

            {{-- Border Dekoratif --}}
            <div class="h-2 w-24 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full"></div>
        </header>

        {{-- Konten Utama --}}
        <div class="prose prose-indigo prose-lg max-w-none text-slate-700 leading-relaxed 
                    prose-headings:font-black prose-headings:uppercase prose-headings:italic prose-headings:tracking-tight
                    prose-p:font-medium prose-p:text-slate-600
                    prose-strong:text-slate-900 prose-strong:font-black
                    prose-img:rounded-[2.5rem] prose-img:shadow-2xl">
            {!! $article->content !!}
        </div>

        {{-- Section Download (Premium Look) --}}
        @if($article->file_materi)
        <div class="mt-16 group">
            <div class="relative overflow-hidden bg-slate-900 rounded-[2.5rem] p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-8 transition-all duration-500 hover:shadow-2xl hover:shadow-indigo-200">
                {{-- Decor --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                
                <div class="relative z-10 flex items-center gap-6 text-center md:text-left flex-col md:flex-row">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur-md border border-white/20 rounded-[1.5rem] flex items-center justify-center text-4xl group-hover:scale-110 transition-transform duration-500">
                        📄
                    </div>
                    <div>
                        <h4 class="font-black text-white text-xl uppercase italic tracking-tight">Offline Resource</h4>
                        <p class="text-indigo-200/60 text-sm font-medium">Simpan materi ini dalam format PDF berkualitas tinggi.</p>
                    </div>
                </div>
                
                <a href="{{ asset('storage/' . $article->file_materi) }}" 
                   download 
                   class="relative z-10 w-full md:w-auto bg-white text-slate-900 px-10 py-4 rounded-2xl font-black hover:bg-indigo-500 hover:text-white transition-all flex items-center justify-center gap-3 shadow-xl active:scale-95 uppercase tracking-widest text-xs">
                    Download PDF
                </a>
            </div>
        </div>
        @endif
    </article>

    {{-- Footer/Next Action --}}
    <div class="mt-20 p-12 bg-indigo-50 rounded-[3rem] border border-indigo-100 text-center relative overflow-hidden">
        <div class="absolute -bottom-10 -right-10 text-9xl opacity-5">📚</div>
        
        <h3 class="text-3xl font-black text-slate-900 mb-4 uppercase italic tracking-tighter">Level Up Completed!</h3>
        <p class="text-slate-600 mb-8 max-w-md mx-auto font-medium">Sudah paham materi ini? Yuk cari tantangan baru di jurnal lainnya.</p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('blog.index') }}" class="w-full sm:w-auto bg-slate-900 text-white px-10 py-4 rounded-2xl font-black hover:bg-indigo-600 transition-all shadow-lg uppercase tracking-widest text-xs">
                Explore More
            </a>
        </div>
    </div>
</div>

<style>
    /* Styling tambahan untuk elemen di dalam prose (konten blog) */
    .prose blockquote {
        border-left: 5px solid #4f46e5;
        background: #f8fafc;
        padding: 20px;
        border-radius: 0 20px 20px 0;
        font-style: italic;
    }
    .prose code {
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 6px;
        color: #4f46e5;
        font-weight: bold;
    }
    .prose pre {
        background: #1e293b !important;
        border-radius: 20px !important;
        padding: 20px !important;
    }
</style>
@endsection