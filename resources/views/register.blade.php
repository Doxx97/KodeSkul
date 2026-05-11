@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-6 py-12">
    <div class="relative w-full max-w-md">
        {{-- Dekorasi Latar Belakang --}}
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl"></div>

        <div class="relative bg-white p-10 rounded-[3rem] shadow-2xl shadow-slate-100 border border-slate-100">
            {{-- Header --}}
            <div class="text-center mb-10">
                <div class="inline-block p-4 bg-orange-50 rounded-[1.5rem] mb-4">
                    <span class="text-3xl">🚀</span>
                </div>
                <h2 class="text-4xl font-black text-slate-900 mb-2 tracking-tighter italic uppercase">Create Account</h2>
                <p class="text-slate-500 font-medium text-sm">Join KodeSkul dan mulai petualanganmu.</p>
            </div>

            {{-- Form --}}
            <form action="/register" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Full Name</label>
                    <input type="text" name="name" required placeholder="John Doe" 
                        class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-orange-500 focus:ring-0 transition-all outline-none font-medium text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="nama@email.com" 
                        class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-orange-500 focus:ring-0 transition-all outline-none font-medium text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Password</label>
                    <input type="password" name="password" required minlength="8" placeholder="Minimal 8 karakter" 
                        class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-orange-500 focus:ring-0 transition-all outline-none font-medium text-slate-700">
                </div>
                
                <button type="submit" class="w-full py-4 mt-4 bg-slate-900 text-white font-black rounded-[1.5rem] hover:bg-orange-500 shadow-xl shadow-orange-100 transition-all transform active:scale-95 uppercase tracking-widest text-sm italic">
                    Start Learning Now &rarr;
                </button>
            </form>

            {{-- Divider --}}
            <div class="relative my-10">
                <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-slate-100"></span></div>
                <div class="relative flex justify-center text-[10px] uppercase tracking-widest font-black"><span class="bg-white px-4 text-slate-400">Atau</span></div>
            </div>

            {{-- Google Login --}}
            <a href="/auth/google" class="flex items-center justify-center gap-3 w-full py-4 px-6 bg-white border-2 border-slate-100 rounded-[1.5rem] font-black text-xs uppercase tracking-widest text-slate-700 hover:border-slate-900 transition-all duration-300 active:scale-95">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                Sign Up with Google
            </a>

            {{-- Footer --}}
            <p class="text-center mt-10 text-xs font-bold text-slate-400 uppercase tracking-widest">
                Sudah punya akun? <a href="/login" class="text-orange-600 hover:text-orange-800 transition">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection