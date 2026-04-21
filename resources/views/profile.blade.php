@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-5xl">
    <div class="mb-10 text-center md:text-left">
        <h2 class="text-3xl font-extrabold text-slate-900">Setting Profil ⚙️</h2>
    </div>

    <form action="/profile" method="POST" enctype="multipart/form-data">
        @csrf
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
                            <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <h3 class="mt-4 font-bold text-slate-800">{{ auth()->user()->name }}</h3>
                        <p class="text-xs text-slate-400">Klik ikon kamera untuk ganti foto</p>
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
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <span class="p-2 bg-purple-50 text-purple-600 rounded-lg text-sm">02</span> Keamanan
                    </h4>
                    <div class="space-y-4">
                        @if($errors->has('current_password'))
                            <p class="text-red-500 text-xs font-bold">{{ $errors->first('current_password') }}</p>
                        @endif
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Password Lama</label>
                            <input type="password" name="current_password" placeholder="Isi jika ingin ganti password" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-purple-100 outline-none transition">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                                <input type="password" name="new_password" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-purple-100 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password Baru</label>
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

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection