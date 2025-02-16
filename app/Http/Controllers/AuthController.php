<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * 🔹 REGISTRO DE USUARIO
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:255',
                'apellido_paterno' => 'required|string|max:255',
                'apellido_materno' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
            ]);

            $user = User::create([
                'first_name' => $request->nombres,
                'last_name' => "{$request->apellido_paterno} {$request->apellido_materno}",
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 🔹 Iniciar sesión con Sanctum y sesiones en base de datos
            Auth::guard('web')->login($user);
            $request->session()->regenerate(); // 🔹 Evita ataques de fijación de sesión

            return response()->json([
                'message' => 'Registro exitoso',
                'user' => $user,
            ])->withCookie(cookie(
                'laravel_session',
                session()->getId(),
                120, // 🔹 Duración en minutos
                '/', // 🔹 Path
                'localhost', // 🔹 Dominio del frontend
                false, // 🔹 Secure (HTTPS)
                true, // 🔹 HttpOnly (solo accesible por el servidor)
                false, // 🔹 Raw
                'None' // 🔹 SameSite (permite compartir entre dominios)
            ));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en el registro',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 🔹 INICIAR SESIÓN
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::guard('web')->attempt($credentials)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user = Auth::guard('web')->user();
        
        // 🔹 Regenerar la sesión para evitar ataques de fijación de sesión
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => $user,
        ])->withCookie(cookie(
            'laravel_session',
            session()->getId(),
            120,
            '/',
            'localhost',
            false,
            true,
            false,
            'None'
        ));
    }

    /**
     * 🔹 CERRAR SESIÓN
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }
}
