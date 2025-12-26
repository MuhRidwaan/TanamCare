<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Update Profile User (Nama, Email, Password, Lokasi)
     */
    public function update(Request $request)
    {
        $user = Auth::user(); // Ambil user yang sedang login

        // Validasi
        $request->validate([
            'name'      => 'required|string|max:255',
            // Email harus unik, KECUALI untuk user ini sendiri (ignore($user->id))
            'email'     => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            // Password opsional (nullable), kalau diisi minimal 6 karakter
            'password'  => 'nullable|string|min:6',
            
            // Lokasi (Opsional)
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'city'      => 'nullable|string',
            'first_name'=> 'nullable|string',
            'last_name' => 'nullable|string',
            'phone_number'=> 'nullable|string',
        ]);

        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;

        // Cek jika user mengirim password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Cek jika user mengirim data lokasi (update parsial)
        if ($request->has('latitude')) $user->latitude = $request->latitude;
        if ($request->has('longitude')) $user->longitude = $request->longitude;
        if ($request->has('city')) $user->city = $request->city;

        $user->save(); // Simpan perubahan

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data'    => $user
        ]);
    }
}