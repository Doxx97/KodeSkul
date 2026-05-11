<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ArticleController extends Controller
{
    // 1. Menampilkan daftar artikel (Tabel)
    // 1. Fungsi untuk USER (Halaman yang harusnya muncul pas klik Jelajahi Materi)
    public function index()
    {
        $articles = Article::latest()->get();
        return view('materi.terbaru', compact('articles')); // Mengarah ke tampilan blog
    }

    // 2. Fungsi untuk ADMIN (Halaman yang ada di gambar kamu)
    public function adminIndex()
    {
        $articles = Article::latest()->get();
        return view('admin.articles.index', compact('articles')); // Mengarah ke tabel kelola
    }
    // 2. Menampilkan form tambah (Halaman Create)
    public function create()
    {
        return view('admin.articles.create');
    }

    // 3. Menyimpan data dari form ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'content' => 'required',
            'file_materi' => 'nullable|mimes:pdf,docx,zip|max:20480', // Max 20MB
        ]);

        $filePath = null;
        if ($request->hasFile('file_materi')) {
            $filePath = $request->file('file_materi')->store('materi_files', 'public');
        }

        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category' => $request->category,
            'excerpt' => Str::limit(strip_tags($request->content), 150),
            'content' => $request->content,
            'file_materi' => $filePath,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel & File berhasil diterbitkan!');
    }

    // 4. Menampilkan form edit
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }
    public function update(Request $request, $id)
    {
        // 1. Validasi data
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'content' => 'required',
            'file_materi' => 'nullable|mimes:pdf,docx,zip|max:20480', // Max 20MB
        ], [
            'file_materi.mimes' => 'File harus berupa PDF, DOCX, atau ZIP.',
            'file_materi.max' => 'Ukuran file maksimal 20MB.',
        ]);

        $article = Article::findOrFail($id);
        
        // 2. Data dasar untuk diupdate
        $updateData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category' => $request->category,
            'content' => $request->content,
            'excerpt' => Str::limit(strip_tags($request->content), 150),
        ];

        // 3. Logika Upload File Baru
        if ($request->hasFile('file_materi')) {
            // Hapus file lama dari storage jika ada
            if ($article->file_materi && Storage::disk('public')->exists($article->file_materi)) {
                Storage::disk('public')->delete($article->file_materi);
            }

            // Simpan file baru
            $path = $request->file('file_materi')->store('materi_files', 'public');
            $updateData['file_materi'] = $path;
        }

        // 4. Eksekusi Update
        $article->update($updateData);

        return redirect()->route('admin.articles.index')->with('success', 'Materi dan Lampiran berhasil diperbarui!');
    }
    // Fungsi untuk menampilkan detail satu artikel
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        // Sesuaikan dengan nama file baru kamu
        return view('materi.show_article', compact('article'));
    }
}