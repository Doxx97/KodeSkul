<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    // Menampilkan halaman dashboard admin
    public function index()
    {
        $materials = Material::latest()->get(); // Pakai latest() agar materi terbaru ada di atas
        return view('admin.dashboard', compact('materials'));
    }

    // Menampilkan halaman tambah materi
    public function create()
    {
        return view('admin.create-materi'); 
    }

    // Menyimpan data materi baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required', // <--- Tambahkan validasi deskripsi
            'content' => 'required',
            'video_url' => 'nullable|string',
        ]);

        // Logika Ekstrak ID YouTube
        $videoUrl = $request->video_url;
        $videoId = null;

        if ($videoUrl) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $match)) {
                $videoId = $match[1];
            } else {
                $videoId = $videoUrl; 
            }
        }

        // Simpan data beserta kuisnya
        Material::create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description, // <--- Tangkap data deskripsi
            'content' => $request->content,
            'video_url' => $videoId,
            'interactive_quiz' => $request->has('interactive_quiz') ? json_encode($request->interactive_quiz) : null,
            'post_test' => $request->has('post_test') ? json_encode($request->post_test) : null,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Materi baru berhasil ditambahkan! 🚀');
    }

    // Menampilkan halaman edit
    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('admin.edit', compact('material')); // <-- Ini merujuk ke folder resources/views/admin/edit.blade.php
    }

    // Memproses update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required', // <--- Tambahkan validasi deskripsi
            'content' => 'required',
            'video_url' => 'nullable|string',
        ]);

        $material = Material::findOrFail($id);

        // Ekstrak YouTube ID saat diedit
        $videoUrl = $request->video_url;
        $videoId = $material->video_url; // Defaultnya pakai id yang lama

        if ($videoUrl && $videoUrl !== $material->video_url) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $match)) {
                $videoId = $match[1];
            } else {
                $videoId = $videoUrl;
            }
        }

        // Update data beserta kuisnya
        $material->update([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description, // <--- Tangkap data deskripsi
            'content' => $request->content,
            'video_url' => $videoId,
            'interactive_quiz' => $request->has('interactive_quiz') ? json_encode($request->interactive_quiz) : null,
            'post_test' => $request->has('post_test') ? json_encode($request->post_test) : null,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Materi berhasil diperbarui! ✅');
    }

    // Menghapus data
    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Materi berhasil dihapus! 🗑️');
    }
}