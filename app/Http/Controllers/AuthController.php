<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Fungsi menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Fungsi untuk menangani login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    // Fungsi menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Fungsi untuk menangani pendaftaran pengguna
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:tbl_user,username',
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:tbl_user,nip',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'admin' => 0, // Set admin default to 0
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    // Fungsi untuk logout pengguna
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // Fungsi untuk menampilkan halaman Edit Profil
    public function edit()
    {
        return view('auth.edit_profil', [
            'user' => Auth::user()
        ]);
    }

    // Fungsi untuk memperbarui data profil pengguna
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:tbl_user,nip,' . $user->id_user . ',id_user',
            'current_password' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        // Verifikasi password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak cocok.'
            ])->withInput();
        }

        // Memperbarui data pengguna secara manual tanpa timestamps
        $updateData = [
            'nama' => $request->nama,
            'nip' => $request->nip
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Update manual tanpa updated_at
        User::where('id_user', $user->id_user)->update($updateData);

        return redirect('/dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}