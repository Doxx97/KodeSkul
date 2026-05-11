@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 pt-6 pb-12">
    {{-- Bagian Header: Jarak atas diperkecil (pt-6) agar lebih naik --}}
    <div class="max-w-5xl mx-auto text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-black text-slate-800 mb-2 tracking-tighter">
            Panduan Belajar <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">KodeSkul</span> 🚀
        </h1>
        <p class="text-slate-500 font-medium">Klik setiap ikon pada jalur untuk memahami cara kerja platform kami.</p>
    </div>

    {{-- Box Utama Roadmap --}}
    <div class="relative bg-white rounded-[3rem] shadow-2xl shadow-indigo-100/50 p-6 md:p-10 overflow-hidden border border-slate-100 max-w-6xl mx-auto">
        
        <div class="relative min-h-[500px] md:min-h-[600px] flex items-center justify-center">
            <svg class="absolute w-full h-full" viewBox="0 0 800 500" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <path d="M50 350C150 350 200 450 300 450C400 450 450 250 550 250C650 250 700 350 750 150" 
                      stroke="#F1F5F9" stroke-width="50" stroke-linecap="round" />
                <path d="M50 350C150 350 200 450 300 450C400 450 450 250 550 250C650 250 700 350 750 150" 
                      stroke="#CBD5E1" stroke-width="2" stroke-dasharray="12 15" stroke-linecap="round" />
            </svg>

            <div class="absolute flex flex-col items-center group" style="left: 10%; bottom: 30%;">
                <button onclick="showInfo(1)" class="btn-node bg-amber-400 animate-bounce-slow">🏠</button>
                <div class="label-node">01. Beranda</div>
            </div>

            <div class="absolute flex flex-col items-center group" style="left: 32%; bottom: 12%;">
                <button onclick="showInfo(2)" class="btn-node bg-amber-400">📊</button>
                <div class="label-node">02. Progres</div>
            </div>

            <div class="absolute flex flex-col items-center group" style="left: 62%; top: 35%;">
                <button onclick="showInfo(3)" class="btn-node bg-amber-400">💡</button>
                <div class="label-node">03. Tantangan</div>
            </div>

            <div class="absolute flex flex-col items-center group" style="right: 10%; top: 15%;">
                <button onclick="showInfo(4)" class="btn-node bg-indigo-600 !text-white border-indigo-200">🏆</button>
                <div class="label-node !text-indigo-600 border-indigo-100">04. Reward</div>
            </div>
        </div>
    </div>
</div>

{{-- Script SweetAlert & Logic --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const roadmapData = {
        1: {
            title: "Eksplorasi Beranda",
            text: "Langkah pertama: Kunjungi menu **Beranda** untuk melihat daftar materi. Pilih topik pemrograman yang ingin kamu kuasai hari ini.",
            icon: "info"
        },
        2: {
            title: "Pantau Progresmu",
            text: "Gunakan menu **Progres** untuk melihat statistik belajarmu. Pantau materi yang selesai dan skor rata-rata kuis secara berkala.",
            icon: "success"
        },
        3: {
            title: "Uji Skill di Tantangan",
            text: "Buktikan kemampuanmu di fitur kuis coding. Tulis kode langsung di editor dan dapatkan umpan balik instan!",
            icon: "warning"
        },
        4: {
            title: "Dapatkan Sertifikat",
            text: "Selesaikan semua tantangan! Unduh sertifikat kelulusan di halaman profil sebagai bukti kompetensi profesionalmu.",
            icon: "question"
        }
    };

    function showInfo(id) {
        const data = roadmapData[id];
        Swal.fire({
            title: `<span class="font-black text-indigo-600 text-2xl">${data.title}</span>`,
            html: `<div class="text-slate-600 text-lg leading-relaxed mt-2">${data.text}</div>`,
            confirmButtonText: 'Lanjutkan Petualangan!',
            confirmButtonColor: '#4f46e5',
            showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' },
            hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' },
            customClass: {
                confirmButton: 'px-10 py-4 rounded-2xl font-bold uppercase tracking-wider text-sm shadow-lg shadow-indigo-200'
            }
        });
    }
</script>

<style>
    body {
        background-color: #f8fafc;
        background-image: radial-gradient(#e2e8f0 1.5px, transparent 1.5px);
        background-size: 40px 40px;
    }
    
    .btn-node {
        width: 70px;
        height: 70px;
        border-radius: 9999px;
        border: 6px solid white;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 20;
    }

    .btn-node:hover {
        transform: scale(1.15) rotate(5deg);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
    }

    .label-node {
        margin-top: 1rem;
        background-color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #f1f5f9;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        white-space: nowrap;
        pointer-events: none;
    }

    .animate-bounce-slow {
        animation: bounce-slow 3s infinite;
    }

    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    /* Optimalisasi Mobile */
    @media (max-width: 768px) {
        .btn-node { width: 55px; height: 55px; font-size: 1.5rem; border-width: 4px; }
        .label-node { padding: 0.4rem 0.8rem; font-size: 0.65rem; }
        svg { transform: scale(1.2); }
    }
</style>
@endsection