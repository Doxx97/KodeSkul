<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        // Menggunakan model Gemini 3 Flash Preview yang terdeteksi aktif di sistem Anda
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => "Anda adalah SkulBot, asisten AI untuk KodeSkul. Jawab singkat: " . $message]
                    ]
                ]
            ]
        ]);

        $result = $response->json();

        // Jika sukses, ambil teksnya. Jika gagal, tampilkan pesan error yang jelas.
        if ($response->successful()) {
            return response()->json([
                'reply' => $result['candidates'][0]['content']['parts'][0]['text']
            ]);
        }

        return response()->json([
            'reply' => 'Aduh, SkulBot ada kendala: ' . ($result['error']['message'] ?? 'Koneksi terputus')
        ]);
    }
}