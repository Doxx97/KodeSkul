@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<div class="container mx-auto px-6 py-12 max-w-6xl">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <span class="inline-block px-4 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-4">
                User Dashboard ⚡
            </span>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter italic uppercase">
                Setting <span class="text-indigo-600">Profil</span>
            </h2>
        </div>
        @if(session('success'))
            <div class="flex items-center gap-3 px-6 py-3 bg-green-500 text-white rounded-2xl font-bold shadow-lg shadow-green-100 animate-bounce">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        <input type="hidden" name="cropped_image" id="cropped_image">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- KIRI: Foto Profil Card --}}
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-100 overflow-hidden relative group">
                    {{-- Banner Kecil --}}
                    <div class="h-24 bg-gradient-to-r from-indigo-600 to-purple-600"></div>
                    
                    <div class="px-8 pb-10 text-center -mt-12">
                        <div class="relative inline-block">
                            <img id="previewImg" 
                                 src="{{ auth()->user()->profile_photo_path ? asset('storage/'.auth()->user()->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=6366f1&color=fff' }}" 
                                 class="w-32 h-32 mx-auto rounded-[2.5rem] border-4 border-white shadow-2xl object-cover transition-transform group-hover:scale-105 duration-500">
                            
                            <label for="photoInput" class="absolute -bottom-2 -right-2 bg-slate-900 text-white p-3 rounded-2xl cursor-pointer hover:bg-indigo-600 transition-all shadow-xl active:scale-90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                </svg>
                            </label>
                            <input type="file" id="photoInput" class="hidden" accept="image/*">
                        </div>
                        
                        <h3 class="mt-6 text-xl font-black text-slate-800 uppercase italic tracking-tight">{{ auth()->user()->name }}</h3>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1">Student Member</p>
                    </div>
                </div>

                {{-- Status Card (Optional Tip) --}}
                <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12 blur-2xl"></div>
                    <h4 class="font-black italic uppercase tracking-tighter text-lg mb-2">Tips Pro 💡</h4>
                    <p class="text-indigo-100 text-sm leading-relaxed font-medium">Gunakan foto asli agar sertifikatmu terlihat lebih profesional saat dibagikan!</p>
                </div>
            </div>

            {{-- KANAN: Form Pengaturan --}}
            <div class="lg:col-span-8 space-y-8">
                {{-- Data Akun --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-100">
                    <h4 class="text-xs font-black text-indigo-600 uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center">01</span>
                        Account Information
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 outline-none transition font-bold text-slate-700">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 outline-none transition font-bold text-slate-700">
                        </div>
                    </div>
                </div>

                {{-- Keamanan --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-100">
                    <h4 class="text-xs font-black text-purple-600 uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center">02</span>
                        Security Settings
                    </h4>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Current Password</label>
                            <input type="password" name="current_password" placeholder="Isi hanya jika ingin ganti password" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-purple-500 outline-none transition font-bold">
                            @error('current_password') <p class="text-rose-500 text-[10px] font-black mt-2 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">New Password</label>
                                <input type="password" name="new_password" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-purple-500 outline-none transition font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-purple-500 outline-none transition font-bold">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="group flex items-center gap-3 px-10 py-5 bg-slate-900 text-white font-black rounded-2xl hover:bg-indigo-600 shadow-2xl shadow-indigo-100 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs italic">
                        Save Changes
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- SECTION 03: SERTIFIKAT --}}
        <div class="mt-20">
            <div class="flex items-center gap-4 mb-10">
                <div class="w-12 h-12 bg-amber-500 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-amber-100">🎓</div>
                <h4 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">My Certificates</h4>
                <div class="flex-grow h-px bg-slate-100"></div>
            </div>

            @php
                $myExams = \DB::table('user_exams')->where('user_id', auth()->id())->get();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($myExams as $exam)
                    <div class="group relative bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-xl shadow-slate-100 transition-all hover:-translate-y-2 overflow-hidden">
                        {{-- Icon Background --}}
                        <div class="absolute -top-6 -right-6 text-8xl opacity-5 grayscale group-hover:rotate-12 transition-transform">
                            @if($exam->category == 'HTML') 📄 @elseif($exam->category == 'CSS') 🎨 @else ⚡ @endif
                        </div>

                        <div class="relative z-10">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-full uppercase tracking-widest mb-4 inline-block">
                                Verified Skills
                            </span>
                            <h4 class="text-2xl font-black text-slate-800 uppercase italic tracking-tighter mb-1">
                                {{ $exam->category }} Master
                            </h4>
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-8">
                                Score: {{ $exam->score }}/100 • {{ \Carbon\Carbon::parse($exam->updated_at)->format('M Y') }}
                            </p>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('certificate.download', ['category' => $exam->category]) }}&preview=1" 
                                   target="_blank"
                                   class="flex-1 text-center py-3 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-colors">
                                    Preview
                                </a>
                                <a href="{{ route('certificate.download', ['category' => $exam->category]) }}" 
                                   class="flex-1 text-center py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-colors shadow-lg">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200 text-center">
                        <div class="text-5xl mb-4">🔓</div>
                        <h5 class="text-xl font-black text-slate-800 uppercase italic">Locked Achievements</h5>
                        <p class="text-slate-400 font-medium max-w-xs mx-auto text-sm mt-2">Selesaikan ujian akhir untuk membuka sertifikat eksklusifmu!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </form>
</div>

{{-- MODAL CROP TETAP SAMA NAMUN DENGAN STYLE BARU --}}
<div id="cropModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/80 backdrop-blur-md p-6">
    <div class="bg-white rounded-[3rem] p-8 max-w-lg w-full shadow-2xl overflow-hidden animate-in zoom-in duration-300">
        <div class="text-center mb-6">
            <h3 class="text-2xl font-black text-slate-900 uppercase italic">Crop Photo ✂️</h3>
            <p class="text-slate-500 text-sm">Sesuaikan posisi fotomu agar terlihat mantap!</p>
        </div>
        <div class="aspect-square overflow-hidden rounded-[2rem] bg-slate-100 shadow-inner">
            <img id="imageToCrop" class="max-w-full block">
        </div>
        <div class="mt-8 flex gap-4">
            <button type="button" onclick="closeCropModal()" class="flex-1 py-4 text-slate-400 font-black uppercase tracking-widest text-xs hover:text-slate-600 transition">Cancel</button>
            <button type="button" id="cropButton" class="flex-[2] py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition active:scale-95 uppercase tracking-widest text-xs">Apply Photo</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    // Logika JS tetap sama karena sudah berjalan dengan baik, 
    // saya hanya merapikan struktur modal di atas.
    let cropper;
    const photoInput = document.getElementById('photoInput');
    const imageToCrop = document.getElementById('imageToCrop');
    const cropModal = document.getElementById('cropModal');
    const previewImg = document.getElementById('previewImg');
    const croppedInput = document.getElementById('cropped_image');

    photoInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];
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
        const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
        const base64Image = canvas.toDataURL('image/jpeg', 0.9);
        previewImg.src = base64Image;
        croppedInput.value = base64Image;
        closeCropModal();
    });

    function closeCropModal() {
        cropModal.classList.add('hidden');
        photoInput.value = '';
    }
</script>

<style>
    /* Custom Cropper Styling agar lebih clean */
    .cropper-view-box, .cropper-face { border-radius: 2rem; }
    .cropper-line, .cropper-point { background-color: #4f46e5; }
</style>
@endsection