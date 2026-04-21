<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Material;
use App\Http\Controllers\ProfileController;


// Landing Page
Route::get('/', function () {
    $materials = App\Models\Material::all();
    return view('landing', compact('materials'));
});

// 1. Halaman Utama Materi (Tampilan 3 Kotak: HTML, CSS, JS)
Route::get('/materi', function () {
    return view('materi.pilih');
})->name('materi.pilih');

// 2. Halaman List Materi Per Kategori (Setelah klik 'Mulai HTML', dll)
Route::get('/materi-list/{category}', function ($category) {
    // Pakai where('category', 'like', $category) agar lebih fleksibel
    $materials = App\Models\Material::where('category', $category)->latest()->get();
    
    return view('materi.list_per_kategori', [
        'materials' => $materials,
        'categoryName' => strtoupper($category)
    ]);
})->name('materi.list_per_kategori');

// 3. Halaman Detail Isi Materi (Saat klik 'Buka Materi')
Route::get('/materi/baca/{id}', function ($id) {
    // Mencari 1 data materi berdasarkan ID
    $material = App\Models\Material::findOrFail($id);
    
    // Mengirim variabel $material (tanpa 's') ke view
    return view('materi.index', compact('material'));
})->name('materi.show');

// Quiz Page
Route::get('/quiz', function () {
    return view('quiz');
});

// Login Page (Nanti bisa diganti pakai Laravel Breeze/Jetstream)
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// --- ROUTE UNTUK REGISTER ---
Route::get('/register', function () {
    return view('register');
})->name('register')->middleware('guest');

// --- ROUTE UNTUK REGISTER ---
Route::post('/register', function () {
    // Validasi input langsung pakai helper request()
    $validatedData = request()->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    // Buat User Baru
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    // Langsung otomatis login setelah daftar
    Auth::login($user);
    return redirect('/')->with('success', 'Selamat datang di E-Learning SMK! 🎉');
});

// --- ROUTE UNTUK LOGIN MANUAL (EMAIL & PASSWORD) ---
Route::post('/login', function () {
    // Validasi pakai helper request()
    $credentials = request()->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Coba login
    if (Auth::attempt($credentials)) {
        request()->session()->regenerate();
        return redirect()->intended('/')->with('success', 'Selamat datang kembali! 🎉');
    }

    // Jika gagal, kembalikan ke halaman login dengan pesan error
    return back()->withErrors([
        'email' => 'Email atau password salah nih. Coba lagi ya!',
    ]);
});

// --- ROUTE UNTUK LOGOUT ---
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    
    return redirect('/')->with('success', 'Berhasil logout. Sampai jumpa lagi!👋');
})->name('logout');

// --- ROUTE UNTUK PROFILE ---
// --- ROUTE UNTUK PROFILE ---
Route::middleware(['auth'])->group(function () {
    
    // 1. Menampilkan Halaman Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // 2. Memproses Update (Hanya gunakan yang ini agar Cropper.js jalan)
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

});

// HAPUS ATAU KOMENTARI KODE DI BAWAH INI (Yang Route::post('/profile', function...))
// Karena kode ini yang bikin fitur crop kamu jadi "tertimpa" dan tidak berfungsi.

use Illuminate\Support\Facades\Storage;

// --- ROUTE ADMIN AREA ---
// Sekarang kita pakai alias 'isAdmin'
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        $materials = Material::latest()->get();
        return view('admin.dashboard', compact('materials'));
    });

    Route::get('/materi/create', function () {
        return view('admin.create-materi');
    });

    Route::post('/materi', function () {
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:HTML,CSS,JavaScript',
            'description' => 'required|string',
            'content' => 'required|string',
        ]);

        Material::create($data);

        return redirect('/admin/dashboard')->with('success', 'Materi baru berhasil di-publish! 🚀');
    });
});

Route::get('/cek-role', function() {
    if (Auth::check()) {
        return "Halo " . Auth::user()->name . "! Kamu SUDAH LOGIN. Role kamu di mata sistem adalah: [" . Auth::user()->role . "]";
    }
    return "Sistem mendeteksi kamu BELUM LOGIN alias tamu.";
});