<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    // Fungsi untuk menandai materi selesai (Bagi materi yang TIDAK ADA kuisnya)
    public function complete($id)
    {
        $user = Auth::user();
        $material = Material::findOrFail($id);

        // Simpan ke database dengan nilai default 100 karena tidak ada kuis
        $user->completedMaterials()->syncWithoutDetaching([
            $id => ['is_completed' => true, 'score' => 100]
        ]);

        return $this->redirectKeMateriSelanjutnya($material, 'Selamat! Materi selesai. Yuk lanjut ke bab berikutnya!');
    }

    // Fungsi untuk menampilkan/membaca materi
    public function baca($id) 
    {
        $user = Auth::user();
        $material = Material::findOrFail($id);
        
        // 1. Cari materi sebelumnya dalam kategori yang sama
        $previousMaterial = Material::where('category', $material->category)
                                    ->where('id', '<', $material->id)
                                    ->orderBy('id', 'desc')
                                    ->first();

        // 2. Jika ada materi sebelumnya, cek apakah sudah selesai
        if ($previousMaterial) {
            $isCompleted = $user->completedMaterials()
                                ->where('material_id', $previousMaterial->id)
                                ->where('is_completed', true)
                                ->exists();

            if (!$isCompleted) {
                return redirect()->back()->with('error', 'Ups! Selesaikan materi "' . $previousMaterial->title . '" dulu ya sebelum lanjut ke sini. ✨');
            }
        }

        // Ambil SEMUA materi untuk sidebar daftar materi
        $allMaterials = Material::where('category', $material->category)
                                ->orderBy('id', 'asc')
                                ->get();

        return view('materi.show', compact('material', 'allMaterials'));
    }
    
    // Fungsi utama untuk mengoreksi Quiz
    public function submitQuiz(Request $request, $id)
    {
        $user = Auth::user();
        $material = Material::findOrFail($id);
        $quizzes = json_decode($material->post_test, true); // Ubah ke post_test
        
        // Jika ternyata admin tidak membuat kuis, anggap langsung lulus
        if (empty($quizzes)) {
            $user->completedMaterials()->syncWithoutDetaching([
                $material->id => ['is_completed' => true, 'score' => 100]
            ]);
            return $this->redirectKeMateriSelanjutnya($material, 'Materi diselesaikan!');
        }

        $totalSoal = count($quizzes);
        $jawabanBenar = 0;

        // Koreksi jawaban
        foreach ($quizzes as $index => $quiz) {
            $jawabanSiswa = $request->input('jawaban_'.$index);
            if ($jawabanSiswa === $quiz['jawaban_benar']) {
                $jawabanBenar++;
            }
        }

        // Hitung Skor
        $skor = ($jawabanBenar / $totalSoal) * 100;

        if ($skor >= 80) {
            // LULUS: Simpan ke database
            $user->completedMaterials()->syncWithoutDetaching([
                $material->id => ['is_completed' => true, 'score' => $skor]
            ]);
            
            // Lanjut ke materi berikutnya
            return $this->redirectKeMateriSelanjutnya($material, "Luar biasa! Kamu Lulus dengan skor $skor 🎉 Materi selanjutnya telah terbuka.");
        } else {
            // GAGAL: Kembali ke halaman yang sama dengan pesan error
            return back()->withErrors([
                'quiz' => "Skor kamu $skor. Minimal kelulusan adalah 80. Yuk, baca ulang materinya dan coba lagi!"
            ]);
        }
    }

    // --- FUNGSI BANTUAN (HELPER) ---
    // Agar kita tidak mengulang-ulang kode pencarian materi selanjutnya
    private function redirectKeMateriSelanjutnya($material, $pesanSukses)
    {
        $nextMaterial = Material::where('category', $material->category)
                                ->where('id', '>', $material->id)
                                ->orderBy('id', 'asc')
                                ->first();

        if ($nextMaterial) {
            // Catatan: Jika nama route di web.php adalah 'materi.baca', ganti 'materi.show' di bawah ini
            return redirect()->route('materi.show', $nextMaterial->id)
                             ->with('success', $pesanSukses);
        }

        // Jika sudah materi terakhir
        return redirect()->route('materi.list_per_kategori', strtolower($material->category))
                         ->with('success', 'Luar biasa! Kamu telah menyelesaikan semua materi dan kuis di kategori ini.');
    }
}