<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function dashboard()
    {
        return response()->json([
            'stats' => [
                'progreso_proyectos' => 75,
                'tareas_pendientes' => 3,
                'mensajes_no_leidos' => 5,
            ],
        ]);
    }
}
