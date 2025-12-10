<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Definisikan Pesan Error Custom (Bahasa Indonesia)
        $messages = [
            'email.unique' => 'Email ini sudah terdaftar. Silakan login jika Anda sudah punya akun.',
            'email.required' => 'Email wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ];

        // 2. Lakukan Validasi
        // Parameter kedua adalah $messages yang kita buat di atas
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users', // <--- unique:users adalah kuncinya
            'password' => 'required|string|min:6'
        ], $messages);

        // 3. Jika lolos validasi (email belum ada), buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

      
        if (!Auth::attempt($request->only('email', 'password'))) {
        // print_r("masuke ke balok gagal");
            return response()->json(['message' => 'Login gagal, cek email atau password Anda'], 401);
        }
        // dd("masuke ke balok ini");

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
            return response()->json(['message' => 'Logout berhasil']);
        }

        return response()->json(['message' => 'User tidak ditemukan'], 404);
    }
}