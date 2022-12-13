<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Requests\LoginRequest;
// use Illuminate\Support\Facades\Artisan;

class AuthController extends Controller
{
    public function loginPage()
    {
        // Artisan::call('migrate --seed');
        // Artisan::call('storage:link');
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $email = $request->email;
        if (User::where('email', $email)->count() == 0) {
            $user2 = User::where('email', $email)->first();
            if ($user2) $email = $user2->email;
        }

        if (Auth::attempt(['email' => $email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return response()->json([
                'message' => 'Ingreso al sistema exitoso'
            ]);
        }

        return response()->json([
            'message' => 'Las credenciales no coinciden con ningún registro nuestro'
        ], 422);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login.page');
    }
}
