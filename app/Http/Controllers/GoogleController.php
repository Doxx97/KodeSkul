<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        $user = Socialite::driver('google')->user();
        $finduser = User::where('google_id', $user->id)->first();

        if($finduser){
            Auth::login($finduser);
            // Tambahkan notifikasi di sini
            return redirect()->intended('/')->with('success', 'Gokil! Berhasil masuk pakai Google. ✨');
        } else {
            $newUser = User::updateOrCreate(['email' => $user->email],[
                'name' => $user->name,
                'google_id'=> $user->id,
                'password' => encrypt('123456dummy')
            ]);

            Auth::login($newUser);
            // Tambahkan notifikasi di sini
            return redirect()->intended('/')->with('success', 'Akun berhasil dibuat via Google! Let\'s go belajar. 🚀');
        }
    } catch (Exception $e) {
        // Tambahkan notifikasi error jika gagal (opsional)
        return redirect('login')->with('error', 'Waduh, ada masalah pas login pakai Google.');
    }
}
}