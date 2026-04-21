@extends('layouts.app')

@section('content')
<div class="mt-12 mb-20 flex items-center justify-center px-4">
    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-slate-100 w-full max-w-md">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Welcome Back! 👋</h2>
            <p class="text-slate-500">Masuk buat lanjutin belajar ngoding kamu.</p>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-600 text-sm rounded-xl font-semibold">
                Email atau password salah nih. Coba lagi ya!
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email Address</label>
                <input type="email" name="email" required placeholder="nama@email.com" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-indigo-100 transition-all outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-indigo-100 transition-all outline-none">
            </div>
            <button type="submit" class="w-full py-4 mt-2 bg-indigo-600 text-white font-extrabold rounded-2xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-0.5">
                Sign In
            </button>
        </form>

        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-slate-200"></span></div>
            <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-3 text-slate-400 font-bold">Atau</span></div>
        </div>

        <a href="/auth/google" class="flex items-center justify-center gap-3 w-full py-4 px-6 bg-white border-2 border-slate-200 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-900 transition-all duration-300">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-6 h-6" alt="Google Logo">
            Masuk dengan Google
        </a>

        <p class="text-center mt-8 text-sm text-slate-500">
            Belum punya akun? <a href="/register" class="text-indigo-600 font-bold hover:underline">Daftar dulu, gratis!</a>
        </p>
    </div>
</div>
@endsection