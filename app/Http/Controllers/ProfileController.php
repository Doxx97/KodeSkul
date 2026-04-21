<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile');
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    // Menangani hasil dari Cropper.js
    if ($request->filled('cropped_image')) {
        $imgData = $request->cropped_image;
        
        // Decode Base64 string
        list($type, $imgData) = explode(';', $imgData);
        list(, $imgData)      = explode(',', $imgData);
        $imgData = base64_decode($imgData);

        // Hapus foto lama
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Simpan file baru
        $fileName = 'profile_photos/' . $user->id . '_' . time() . '.jpg';
        Storage::disk('public')->put($fileName, $imgData);
        
        $user->profile_photo_path = $fileName;
    }

    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    return back()->with('success', 'Profil kamu makin ganteng/cantik! ✨');
}
}