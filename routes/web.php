<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Material;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Http;

// Landing Page
Route::get('/', function () {
    $materials = App\Models\Material::all();
    return view('landing', compact('materials'));
});

// 1. Halaman Utama Materi (Tampilan 3 Kotak: HTML, CSS, JS)
Route::get('/progres', function () {
    // Ambil materi, diurutkan, lalu kelompokkan
    $materiPerKategori = App\Models\Material::orderBy('id', 'asc')->get()->groupBy('category');
    
    // Ganti nama view jika kamu mengubah nama foldernya, atau biarkan tetap mengarah ke view materi yang sudah kita buat
    return view('materi.progress', compact('materiPerKategori'));
})->name('progres.index');

// 2. Halaman List Materi Per Kategori (Setelah klik 'Mulai HTML', dll) 
Route::get('/materi-list/{category}', function ($category) {
    // Kita buat pemetaan (mapping) agar 'javascript' di URL mencari 'JS' di database
    $dbCategory = $category;
    if (strtolower($category) == 'javascript') {
        $dbCategory = 'JS';
    }

    // Gunakan strtoupper/strtolower agar lebih aman
    $materials = App\Models\Material::where('category', $dbCategory)->orderBy('id', 'asc')->get();
    
    return view('materi.list_per_kategori', [
        'materials' => $materials,
        'categoryName' => ($dbCategory == 'JS') ? 'JAVASCRIPT' : strtoupper($dbCategory)
    ]);
})->name('materi.list_per_kategori');

// Route untuk User (Tampilan Blog)// Route untuk user melihat daftar blog
Route::get('/materi-belajar', [ArticleController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [ArticleController::class, 'show'])->name('blog.show');

// Halaman Beranda (Dashboard Belajar Siswa)
Route::get('/beranda', function () {
    // Ambil semua materi dan kelompokkan berdasarkan kategori (html, css, js, dll)
    $materiPerKategori = App\Models\Material::all()->groupBy('category');
    
    return view('beranda', compact('materiPerKategori'));
})->name('beranda');

// Halaman Roadmap (Tampilan roadmap belajar)
Route::get('/roadmap', function () {
    return view('roadmap'); // Pastikan Anda sudah membuat file resources/views/roadmap.blade.php
})->name('roadmap');

// 3. Halaman Detail Isi Materi (Mengarah ke MateriController)
Route::get('/materi/baca/{id}', 
[MateriController::class, 'baca'])->name('materi.show');

Route::post('/materi/{id}/submit-quiz', [MateriController::class, 'submitQuiz'])->name('materi.submit_quiz')->middleware('auth');

Route::post('/materi/{id}/complete', [MateriController::class, 'complete'])->name('materi.complete')->middleware('auth');

// Quiz Page
Route::get('/quiz', function () {
    return view('quiz');
});

Route::post('/exams/save-score', [App\Http\Controllers\CertificateController::class, 'saveScore'])->name('exams.saveScore');

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
return redirect('/beranda')->with('success', 'Selamat datang di E-Learning SMK! 🎉');});

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
return redirect()->intended('/beranda')->with('success', 'Selamat datang kembali! 🎉');    }

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
    
   // Satu route GET untuk profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    // Route POST untuk update profil (Cropper)
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Route Klaim Sertifikat (Tambahkan {categoryName})
    Route::post('/claim-certificate/{categoryName}', [CertificateController::class, 'store'])->name('certificate.store');
    Route::get('/certificate/download', [CertificateController::class, 'download'])->name('certificate.download');

});

// HAPUS ATAU KOMENTARI KODE DI BAWAH INI (Yang Route::post('/profile', function...))
// Karena kode ini yang bikin fitur crop kamu jadi "tertimpa" dan tidak berfungsi.

use Illuminate\Support\Facades\Storage;

// --- ROUTE ADMIN AREA ---
// Sekarang kita pakai alias 'isAdmin'
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [MaterialController::class, 'index'])->name('admin.dashboard');

    // CRUD Materi (Semua diarahkan ke Controller)
    Route::get('/materi/create', [MaterialController::class, 'create'])->name('admin.materi.create');
    Route::post('/materi', [MaterialController::class, 'store'])->name('admin.materi.store');
    Route::get('/materi/{id}/edit', [MaterialController::class, 'edit'])->name('admin.materi.edit');
    Route::put('/materi/{id}', [MaterialController::class, 'update'])->name('admin.materi.update');
    Route::delete('/materi/{id}', [MaterialController::class, 'destroy'])->name('admin.materi.destroy');
// 1. Halaman Daftar (Index)
    Route::get('/articles', [ArticleController::class, 'adminIndex'])->name('admin.articles.index');
    
    // 2. Halaman Form Tambah (Create)
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
    
    // 3. Proses Simpan Data (Store)
    Route::post('/articles', [ArticleController::class, 'store'])->name('admin.articles.store');
    
    // 4. Halaman Form Edit (Edit)
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('admin.articles.edit');
    
    // 5. Proses Update Data (Update)
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('admin.articles.update');
    
    // 6. Proses Hapus Data (Destroy)
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('admin.articles.destroy');

});

Route::post('/chatbot/send', [ChatbotController::class, 'chat'])->name('chatbot.send');

Route::get('/cek-role', function() {
    if (Auth::check()) {
        return "Halo " . Auth::user()->name . "! Kamu SUDAH LOGIN. Role kamu di mata sistem adalah: [" . Auth::user()->role . "]";
    }
    return "Sistem mendeteksi kamu BELUM LOGIN alias tamu.";
});

Route::get('/cek-bot', function() {
    $apiKey = env('GEMINI_API_KEY');
    return Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}")->json();
});