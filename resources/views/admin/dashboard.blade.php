@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900">Daftar Materi</h1>
        <p class="text-slate-500">Kelola semua modul pembelajaran di sini.</p>
    </div>
    <a href="/admin/materi/create" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition transform hover:-translate-y-0.5">
        + Tambah Materi
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 text-green-600 font-bold rounded-xl border border-green-100">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left text-sm text-slate-500">
        <thead class="bg-slate-50 text-slate-700 uppercase font-bold">
            <tr>
                <th class="px-6 py-4">Kategori</th>
                <th class="px-6 py-4">Judul Materi</th>
                <th class="px-6 py-4">Tanggal Dibuat</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($materials as $materi)
            <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                <td class="px-6 py-4">
                    <span class="px-3 py-1 text-xs font-bold rounded-full 
                        {{ $materi->category == 'HTML' ? 'bg-orange-100 text-orange-600' : ($materi->category == 'CSS' ? 'bg-blue-100 text-blue-600' : 'bg-yellow-100 text-yellow-600') }}">
                        {{ $materi->category }}
                    </span>
                </td>
                <td class="px-6 py-4 font-bold text-slate-800">{{ $materi->title }}</td>
                <td class="px-6 py-4">{{ $materi->created_at->format('d M Y') }}</td>
                
                {{-- BAGIAN AKSI YANG SUDAH DIUBAH --}}
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-4">
                        <a href="{{ route('admin.materi.edit', $materi->id) }}" class="text-indigo-600 hover:underline font-semibold">
                            Edit
                        </a>
                        
                        <form action="{{ route('admin.materi.destroy', $materi->id) }}" method="POST" class="inline-block form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 font-medium rounded-lg transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
                {{-- AKHIR BAGIAN AKSI --}}

            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-10 text-center text-slate-400 font-semibold">
                    Belum ada materi nih. Yuk buat yang pertama! 🚀
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
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