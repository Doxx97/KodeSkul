<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    /**
     * Menampilkan isi materi
     */
    public function baca($id) 
    {
        $user = Auth::user();
        
        // 1. Ambil data materi utama, jika tidak ada langsung 404
        $material = Material::findOrFail($id);
        
        // 2. Definisikan kategori agar tidak "Undefined variable" di VS Code
        $category = $material->category;

        // 3. Cari materi sebelumnya dalam kategori yang sama untuk sistem penguncian
        $previousMaterial = Material::where('category', $category)
                                    ->where('id', '<', $material->id)
                                    ->orderBy('id', 'desc')
                                    ->first();

        // 4. Jika ada materi sebelumnya, cek apakah user sudah menyelesaikannya
        if ($previousMaterial) {
            $isCompleted = $user->completedMaterials()
                                ->where('material_id', $previousMaterial->id)
                                ->where('is_completed', true)
                                ->exists();

            // Jika belum lulus materi sebelumnya, tendang balik ke daftar
            if (!$isCompleted) {
                return redirect()->route('materi.list_per_kategori', $category)
                                 ->with('error', 'Ups! Selesaikan materi "' . $previousMaterial->title . '" dulu ya! ✨');
            }
        }

        // 5. Ambil SEMUA materi di kategori ini untuk ditampilkan di Sidebar
        $allMaterials = Material::where('category', $material->category)
                            ->orderBy('id', 'asc')
                            ->get();

        return view('materi.show', compact('material', 'allMaterials'));
    }

    public function list_per_kategori($category)
    {
        // Pastikan kategori dalam huruf besar agar cocok dengan database jika perlu
        // Kita ambil materi, lalu URUTKAN berdasarkan ID dari terkecil ke terbesar
        $materials = Material::where('category', $category)
                             ->orderBy('id', 'asc') 
                             ->get();

        // Jika data kosong, pastikan kategori tetap terkirim ke view
        return view('materi.list', compact('materials', 'category'));
    }

    /**
     * Menangani pengiriman kuis (Post Test)
     */
    public function submitQuiz(Request $request, $id)
    {
        $user = Auth::user();
        $material = Material::findOrFail($id);
        
        // Decode data kuis dari kolom post_test
        $quizzes = json_decode($material->post_test, true);
        
        // Jika tidak ada kuis, otomatis lulus
        if (empty($quizzes)) {
            $user->completedMaterials()->syncWithoutDetaching([
                $material->id => ['is_completed' => true, 'score' => 100]
            ]);
            return $this->redirectKeMateriSelanjutnya($material, 'Materi berhasil diselesaikan!');
        }

        $totalSoal = count($quizzes);
        $jawabanBenar = 0;

        // Koreksi jawaban siswa
        foreach ($quizzes as $index => $quiz) {
            $jawabanSiswa = $request->input('jawaban_'.$index);
            if ($jawabanSiswa === $quiz['jawaban_benar']) {
                $jawabanBenar++;
            }
        }

        // Hitung Skor (Skala 100)
        $skor = ($jawabanBenar / $totalSoal) * 100;

        if ($skor >= 80) {
            // Jika Lulus (Skor >= 80)
            $user->completedMaterials()->syncWithoutDetaching([
                $material->id => ['is_completed' => true, 'score' => $skor]
            ]);
            
            return $this->redirectKeMateriSelanjutnya($material, "Selamat! Kamu lulus dengan skor $skor 🎉");
        } else {
            // Jika Gagal
            return back()->withErrors([
                'quiz' => "Skor kamu $skor. Minimal kelulusan adalah 80. Ayo coba lagi!"
            ]);
        }
    }

    /**
     * Menandai materi selesai jika tidak ada kuis sama sekali
     */
    public function complete(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            // Simpan ke tabel pivot
            $user->completedMaterials()->syncWithoutDetaching([
                $id => ['is_completed' => true]
            ]);

            return response()->json(['message' => 'Progres berhasil disimpan'], 200);
        } catch (\Exception $e) {
            // Ini akan membantu kita melihat error asli di log
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Fungsi Helper untuk mencari materi selanjutnya
     */
    private function redirectKeMateriSelanjutnya($material, $pesanSukses)
    {
        $nextMaterial = Material::where('category', $material->category)
                                ->where('id', '>', $material->id)
                                ->orderBy('id', 'asc')
                                ->first();

        // Jika ada materi selanjutnya, arahkan ke sana
        if ($nextMaterial) {
            return redirect()->route('materi.show', $nextMaterial->id)
                             ->with('success', $pesanSukses);
        }

        // Jika ini materi terakhir, balikkan ke halaman list kategori
        return redirect()->route('materi.list_per_kategori', $material->category)
                         ->with('success', 'Hebat! Semua materi di kategori ini telah selesai kamu pelajari.');
    }

    public function terbaru()
    {
        // Mengambil materi terbaru berdasarkan created_at
        $materials = \App\Models\Material::latest()->get(); 
        return view('materi.terbaru', compact('materials'));
    }
}