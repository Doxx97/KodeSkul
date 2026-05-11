@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-12 py-12 max-w-7xl">
    
    {{-- Header Section --}}
    <div class="relative overflow-hidden bg-slate-900 rounded-[2.5rem] p-12 md:p-20 mb-16 shadow-2xl">
        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-purple-600/20 rounded-full -ml-24 -mb-24 blur-3xl"></div>
        
        <div class="relative z-10 text-center">
            <span class="inline-block px-4 py-1 bg-indigo-500/20 border border-indigo-400/30 rounded-full text-indigo-300 text-xs font-black uppercase tracking-[0.2em] mb-6">
                Exclusive Content 💎
            </span>
            <h1 class="text-4xl md:text-7xl font-black text-white mb-6 tracking-tighter italic uppercase">
                KodeSkul <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Journal</span>
            </h1>
            <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto font-medium">
                Wawasan mendalam, tutorial eksklusif, dan tren tech terbaru untuk memperluas cakrawala kodingmu.
            </p>
        </div>
    </div>

    {{-- Artikel Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($articles as $article)
            <article class="group relative flex flex-col bg-white rounded-[2.5rem] p-4 shadow-xl shadow-slate-100 border border-slate-100 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-indigo-100">
                
                {{-- Decorative Meta --}}
                <div class="relative h-48 mb-6 bg-slate-50 rounded-[2rem] overflow-hidden flex items-center justify-center text-5xl group-hover:scale-[1.02] transition-transform duration-500">
                    {{-- Placeholder Icon berdasarkan Kategori --}}
                    @if(strtolower($article->category) == 'html') 📄 
                    @elseif(strtolower($article->category) == 'css') 🎨 
                    @elseif(strtolower($article->category) == 'js' || strtolower($article->category) == 'javascript') ⚡ 
                    @else 📝 @endif
                    
                    {{-- Floating Badge --}}
                    <div class="absolute top-4 left-4">
                        <span class="px-4 py-1.5 bg-white/90 backdrop-blur-sm text-slate-900 text-[10px] font-black rounded-full uppercase tracking-widest shadow-sm">
                            {{ $article->category }}
                        </span>
                    </div>
                </div>

                <div class="px-4 pb-4 flex flex-col flex-grow">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></div>
                        <span class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">
                            {{ $article->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    <h2 class="text-2xl font-black text-slate-900 group-hover:text-indigo-600 transition-colors mb-4 tracking-tighter leading-tight italic uppercase">
                        <a href="{{ route('blog.show', $article->slug) }}">{{ $article->title }}</a>
                    </h2>
                    
                    <p class="text-slate-500 text-sm leading-relaxed mb-8 line-clamp-3 font-medium">
                        {{ $article->excerpt }}
                    </p>

                    <div class="mt-auto">
                        <a href="{{ route('blog.show', $article->slug) }}" class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-widest text-slate-900 group-hover:text-indigo-600 transition-all">
                            Read Journal
                            <span class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center group-hover:bg-indigo-600 group-hover:translate-x-2 transition-all">
                                &rarr;
                            </span>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    {{-- Empty State --}}
    @if($articles->isEmpty())
        <div class="text-center py-20 bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
            <div class="text-6xl mb-4">📭</div>
            <h3 class="text-2xl font-black text-slate-800 uppercase italic">Belum Ada Tulisan</h3>
            <p class="text-slate-500 font-medium">Penulis kami sedang meracik konten berkelas untukmu.</p>
        </div>
    @endif
</div>
@endsection