<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        return response()->json([
            'user' => $user,
            'stats' => [
                'tareas_pendientes' => 5,
                'mensajes_no_leidos' => 3,
                'progreso_proyectos' => 75,
            ],
        ]);
    }
}
