@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<div class="container mx-auto px-4 py-12 max-w-5xl">
    <div class="mb-10 text-center md:text-left">
        <h2 class="text-3xl font-extrabold text-slate-900">Setting Profil ⚙️</h2>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        {{-- Hidden input untuk menampung hasil crop --}}
        <input type="hidden" name="cropped_image" id="cropped_image">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="col-span-1 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-20 bg-indigo-600"></div>
                    <div class="relative z-10 mt-4">
                        <div class="relative inline-block group">
                            <img id="previewImg" 
                                 src="{{ auth()->user()->profile_photo_path ? asset('storage/'.auth()->user()->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=6366f1&color=fff' }}" 
                                 class="w-28 h-28 mx-auto rounded-full border-4 border-white shadow-md object-cover">
                            
                            <label for="photoInput" class="absolute bottom-0 right-0 bg-slate-900 text-white p-2 rounded-full cursor-pointer hover:bg-indigo-600 transition shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                            <input type="file" id="photoInput" class="hidden" accept="image/*">
                        </div>
                        <h3 class="mt-4 font-bold text-slate-800">{{ auth()->user()->name }}</h3>
                        <p class="text-xs text-slate-400">Maksimal file 2MB</p>
                    </div>
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <span class="p-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm">01</span> Data Akun
                    </h4>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <span class="p-2 bg-purple-50 text-purple-600 rounded-lg text-sm">02</span> Keamanan
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Password Lama</label>
                            <input type="password" name="current_password" placeholder="Isi jika ingin ganti password" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-purple-100 outline-none transition">
                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                                <input type="password" name="new_password" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-purple-100 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password</label>
                                <input type="password" name="new_password_confirmation" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-purple-100 outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-10 py-4 bg-indigo-600 text-white font-extrabold rounded-full hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all transform hover:-translate-y-1">
                        Simpan Semua Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="cropModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl p-6 max-w-lg w-full shadow-2xl">
        <h3 class="text-lg font-bold mb-4">Potong Foto Profil ✂️</h3>
        <div class="max-h-[400px] overflow-hidden rounded-xl bg-slate-100">
            <img id="imageToCrop" class="max-w-full block">
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeCropModal()" class="px-6 py-2 text-slate-500 font-bold hover:text-slate-700">Batal</button>
            <button type="button" id="cropButton" class="px-8 py-2 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">Potong & Gunakan</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    const photoInput = document.getElementById('photoInput');
    const imageToCrop = document.getElementById('imageToCrop');
    const cropModal = document.getElementById('cropModal');
    const previewImg = document.getElementById('previewImg');
    const croppedInput = document.getElementById('cropped_image');

    photoInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];

            // 1. VALIDASI UKURAN 2MB
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB ya.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                imageToCrop.src = event.target.result;
                cropModal.classList.remove('hidden');
                
                if (cropper) cropper.destroy();
                
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 1,
                    viewMode: 2,
                    guides: true,
                    background: false,
                    autoCropArea: 1
                });
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('cropButton').addEventListener('click', function() {
        const canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400
        });

        const base64Image = canvas.toDataURL('image/jpeg', 0.9);
        previewImg.src = base64Image;
        croppedInput.value = base64Image; // Masukkan ke input hidden
        
        closeCropModal();
    });

    function closeCropModal() {
        cropModal.classList.add('hidden');
        photoInput.value = ''; // Reset input agar bisa pilih file yang sama lagi
    }
</script>
@endsection