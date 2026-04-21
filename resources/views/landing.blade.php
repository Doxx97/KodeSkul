@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[80vh] text-center px-4">
    <div class="inline-block px-4 py-1.5 mb-6 text-xs font-bold tracking-wider text-purple-600 bg-purple-100 rounded-full uppercase">
        🚀 Belajar Web Dev Kelas 11
    </div>
    <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
        Ngoding Itu Gampang,<br>
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-pink-500">Kalo Tau Caranya.</span>
    </h1>
    <p class="text-slate-500 text-lg md:text-xl max-w-2xl mb-10">
        Kuasai HTML, CSS, dan JavaScript dari nol. Didesain khusus buat anak SMK biar langsung siap bikin website keren.
    </p>
    <div class="flex gap-4">
        <a href="/materi" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">
            Mulai Belajar
        </a>
        <a href="/quiz" class="px-8 py-4 bg-white text-slate-900 font-bold border-2 border-slate-200 rounded-full hover:border-slate-900 transition">
            Coba Quiz
        </a>
    </div>
</div>

<section class="bg-slate-50 py-20" x-data="{ activeTab: 'html' }">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-slate-900 mb-8">Pilih Jalur Belajarmu 🗺️</h2>
            
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/3 lg:w-1/4 space-y-3">
                    @php 
                        $tabs = [
                            ['id' => 'html', 'label' => 'HTML Dasar', 'icon' => '🌐'],
                            ['id' => 'css', 'label' => 'Styling CSS', 'icon' => '🎨'],
                            ['id' => 'javascript', 'label' => 'Logic JavaScript', 'icon' => '⚡']
                        ];
                    @endphp

                    @foreach($tabs as $tab)
                    <button 
                        @click="activeTab = '{{ $tab['id'] }}'"
                        :class="activeTab === '{{ $tab['id'] }}' ? 'bg-white border-indigo-600 shadow-md ring-1 ring-indigo-600' : 'bg-transparent border-transparent text-slate-500 hover:bg-slate-200'"
                        class="w-full flex items-center p-4 rounded-2xl border-2 transition-all duration-200"
                    >
                        <span class="text-2xl mr-4">{{ $tab['icon'] }}</span>
                        <span class="font-bold">{{ $tab['label'] }}</span>
                    </button>
                    @endforeach
                </div>

                <div class="w-full md:w-2/3 lg:w-3/4">
                    @foreach(['html', 'css', 'javascript'] as $cat)
                    <div x-show="activeTab === '{{ $cat }}'" x-transition class="space-y-4">
                       @php 
                            $filteredMaterials = $materials->filter(function($item) use ($cat) {
                                return strtolower(trim($item->category)) == strtolower($cat);
                            });
                        @endphp
                        @forelse($filteredMaterials as $item)
                        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center justify-between hover:shadow-md transition group">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $item->title }}</h3>
                                <div class="flex flex-wrap gap-4 text-sm text-slate-400 font-medium">
                                    <span class="flex items-center gap-1">⏱️ 15 Menit</span>
                                    <span class="flex items-center gap-1">⭐ 4.9</span>
                                    <span class="flex items-center gap-1 text-indigo-500">📈 Pemula</span>
                                </div>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <a href="{{ route('materi.show', $item->id) }}" class="inline-block px-6 py-3 bg-slate-50 text-slate-700 font-bold rounded-2xl border border-slate-200 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all text-sm shadow-sm">
                                    Belajar sekarang
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="p-20 text-center bg-white rounded-3xl border-2 border-dashed border-slate-200">
                            <p class="text-slate-400 italic">Materi {{ strtoupper($cat) }} belum tersedia. Admin sedang mengetik... ✍️</p>
                        </div>
                        @endforelse
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-white py-12 border-t border-slate-100">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-start gap-8">
            
            <div class="md:w-5/12">
                <h3 class="text-slate-400 font-semibold mb-3 uppercase tracking-wider text-[11px]">Alamat</h3>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-6 max-w-sm">
                    Universitas Negeri Malang Jl. Semarang No.5, Sumbersari, Kec. Lowokwaru, Kota Malang, Jawa Timur 65145
                </p>
                
                <div class="flex gap-4 items-center">
                    <a href="#" class="opacity-80 hover:opacity-100 transition shadow-sm">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg" class="w-5 h-5" alt="Instagram">
                    </a>
                    <a href="#" class="opacity-80 hover:opacity-100 transition">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_(2019).png" class="w-5 h-5" alt="Facebook">
                    </a>
                    <a href="#" class="opacity-80 hover:opacity-100 transition">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/ca/LinkedIn_logo_initials.png" class="w-5 h-5" alt="LinkedIn">
                    </a>
                    <a href="#" class="text-lg text-black opacity-80 hover:opacity-100 transition">
                         <i class="fa-brands fa-tiktok text-sm"></i>
                    </a>
                    <a href="#" class="opacity-80 hover:opacity-100 transition">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/09/YouTube_full-color_icon_(2017).svg" class="w-6 h-6" alt="YouTube">
                    </a>
                    <a href="#" class="text-sm text-black font-bold opacity-80 hover:opacity-100 transition">
                        𝕏
                    </a>
                </div>
            </div>

            <div class="flex gap-16 md:gap-24">
                <div>
                    <h4 class="text-slate-400 font-semibold mb-4 uppercase tracking-wider text-[11px]">Company</h4>
                    <ul class="space-y-2 text-[13px] text-slate-700 font-medium">
                        <li><a href="#" class="hover:text-indigo-600 transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Blog</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-slate-400 font-semibold mb-4 uppercase tracking-wider text-[11px]">Product</h4>
                    <ul class="space-y-2 text-[13px] text-slate-700 font-medium">
                        <li><a href="#" class="hover:text-indigo-600 transition">Elite</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Event</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Challenge</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Mentoring</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Jobs</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection