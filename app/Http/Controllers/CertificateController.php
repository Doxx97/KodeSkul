<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\UserQuiz; // Pastikan sesuaikan dengan nama Model hasil ujianmu
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function download(Request $request)
    {
        $user = Auth::user();
        $category = $request->query('category');
        $isPreview = $request->query('preview'); // Cek apakah ada parameter preview
        $searchCategory = ($category == 'Javascript' || $category == 'javascript') ? 'JS' : $category;

        $examData = DB::table('user_exams')
                    ->where('user_id', $user->id)
                    ->where('category', $searchCategory)
                    ->first();

        if (!$examData) {
            return back()->with('error', 'Data ujian tidak ditemukan!');
        }

        $data = [
            'user'      => $user,
            'category'  => $category,
            'score'     => $examData->score,
            'date'      => \Carbon\Carbon::parse($examData->updated_at)->format('d F Y'),
        ];

        $pdf = Pdf::loadView('certificate.pdf', $data)->setPaper('a4', 'landscape');

        // Jika tombol 'Lihat' diklik, gunakan stream()
        if ($isPreview) {
            return $pdf->stream('Preview_Sertifikat_' . $category . '.pdf');
        }

        // Jika tombol 'Unduh' diklik, gunakan download()
        return $pdf->download('Sertifikat_' . $category . '_' . $user->name . '.pdf');
    }
    public function saveScore(Request $request)
    {
        $user = Auth::user();
        $category = $request->category; // 'HTML', 'CSS', atau 'Javascript'
        $score = $request->score;

        // Simpan atau Update nilai di database
        // Kita asumsikan ada tabel 'user_exams'
        DB::table('user_exams')->updateOrInsert(
            ['user_id' => $user->id, 'category' => $category],
            ['score' => $score, 'updated_at' => now()]
        );

        return response()->json(['success' => true]);
    }
}