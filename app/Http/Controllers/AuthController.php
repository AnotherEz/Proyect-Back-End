<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\PasswordResetCode;
use App\Notifications\ResetPasswordCodeNotification;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * 🔹 REGISTRO DE USUARIO (Redirige automáticamente al dashboard)
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

            // 🔹 Autenticación automática después del registro
            Auth::login($user);

            // 🔹 Generar Token de Autenticación con Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Registro exitoso',
                'token' => $token,
                'user' => $user,
                'redirect' => '/dashboard', // ✅ Redirige al dashboard
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en el registro',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * 🔹 INICIO DE SESIÓN
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        // 🔹 Ahora usamos Auth::guard('sanctum') para asegurar que el usuario está autenticado
        $user = Auth::guard('sanctum')->user() ?? Auth::user();

        if (!$user) {
            return response()->json(['error' => 'No se encontró usuario autenticado'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token' => $token,
            'user' => $user,
            'redirect' => '/dashboard',
        ], 200);
    }

    /**
     * 🔹 CERRAR SESIÓN
     */
    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user() ?? Auth::user();

        if ($user) {
            $user->tokens()->delete();
        }

        Auth::logout();
        Session::flush();

        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }

    // 🔹 RECUPERACIÓN DE CONTRASEÑA

    /**
     * 🔹 Enviar código de recuperación de contraseña
     */
    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'No encontramos una cuenta con ese correo.'], 404);
        }

        // Generar código aleatorio
        $code = rand(100000, 999999);

        // Guardar en la base de datos
        PasswordResetCode::updateOrCreate(
            ['email' => $request->email],
            ['code' => $code, 'created_at' => Carbon::now()]
        );

        // Enviar el código por correo
        $user->notify(new ResetPasswordCodeNotification($code));

        return response()->json([
            'message' => 'Código de verificación enviado a tu correo'
        ], 200);
    }

    /**
     * 🔹 Verificar código de recuperación de contraseña
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        $record = PasswordResetCode::where('email', $request->email)
                    ->where('code', $request->code)
                    ->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(15)->isPast()) {
            return response()->json(['message' => 'El código es inválido o ha expirado.'], 400);
        }

        return response()->json(['message' => 'Código verificado'], 200);
    }

    /**
     * 🔹 Procesar restablecimiento de contraseña
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);
            PasswordResetCode::where('email', $request->email)->delete();
        }

        return response()->json(['message' => 'Tu contraseña ha sido restablecida con éxito.'], 200);
    }
}
