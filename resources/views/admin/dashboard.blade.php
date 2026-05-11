@extends('layouts.admin')

@section('content')
<div class="container mx-auto pb-12">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Daftar Materi</h1>
            <p class="text-slate-500 mt-1 flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-indigo-500"></span>
                Kelola kurikulum dan tantangan coding KodeSkul
            </p>
        </div>
        <a href="/admin/materi/create" class="group relative inline-flex items-center gap-2 px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-200 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Materi Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Total Materi</p>
            <h3 class="text-3xl font-black text-slate-800">{{ $materials->count() }}</h3>
        </div>
        <div class="bg-indigo-50 p-6 rounded-3xl border border-indigo-100 shadow-sm">
            <p class="text-indigo-600 text-sm font-bold uppercase tracking-wider">Update Terakhir</p>
            <h3 class="text-3xl font-black text-indigo-800">{{ $materials->first() ? $materials->first()->created_at->diffForHumans() : '-' }}</h3>
        </div>
    </div>

    @if(session('success'))
        <div class="animate__animated animate__fadeInDown mb-8 p-4 bg-emerald-50 text-emerald-700 font-bold rounded-2xl border border-emerald-100 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Materi</th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($materials as $materi)
                    <tr class="group hover:bg-slate-50/80 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-lg font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $materi->title }}</span>
                                <span class="text-xs text-slate-400 font-medium">Dibuat pada {{ $materi->created_at->format('d M, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-tighter
                                {{ $materi->category == 'HTML' ? 'bg-orange-100 text-orange-600' : 
                                   ($materi->category == 'CSS' ? 'bg-sky-100 text-sky-600' : 'bg-amber-100 text-amber-600') }}">
                                {{ $materi->category }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('admin.materi.edit', $materi->id) }}" 
                                   class="p-3 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-2xl transition-all tooltip" title="Edit Materi">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.materi.destroy', $materi->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete p-3 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-2xl transition-all" title="Hapus Materi">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-4xl">🌵</div>
                                <h3 class="text-xl font-bold text-slate-800">Masih Kosong Melompong</h3>
                                <p class="text-slate-400 max-w-xs mx-auto">Mulai isi KodeSkul dengan materi-materi gokil hari ini!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Mencari semua tombol dengan class 'btn-delete'
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah form langsung terkirim
            
            const form = this.closest('form'); // Mengambil form terdekat dari tombol yang diklik

            // Memunculkan SweetAlert yang cantik
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Materi ini akan dihapus secara permanen dan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Warna merah khas Tailwind (red-500)
                cancelButtonColor: '#94a3b8',  // Warna abu-abu Tailwind (slate-400)
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                backdrop: `rgba(0,0,123,0.1)`, // Efek blur/gelap di belakang
                customClass: {
                    popup: 'rounded-3xl shadow-2xl border border-slate-100', // Membuat ujungnya membulat
                    confirmButton: 'rounded-xl font-bold px-6 py-3',
                    cancelButton: 'rounded-xl font-bold px-6 py-3'
                }
            }).then((result) => {
                // Jika tombol "Ya, Hapus!" diklik
                if (result.isConfirmed) {
                    form.submit(); // Baru form-nya dikirim (materi dihapus)
                }
            });
        });
    });
</script>
@endsection