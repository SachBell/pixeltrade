<?php

namespace App\Http\Controllers;

use App\Models\Servers;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServerController extends Controller
{

    public function create(Request $request)
    {
        $user_id = $request->query('user_id');
        return view('auth.server-register', compact('user_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_server' => 'required|string|max:255|unique:servers',
            'description' => 'nullable|string|max:500',
        ]);

        $serverSlug = Str::slug($request->name_server, '-');

        $originalSlug = $serverSlug;
        $counter = 1;
        while (Servers::where('slug', $serverSlug)->exists()) {
            $serverSlug = $originalSlug . '-' . $counter++;
        }

        Servers::create([
            'name_server' => $request->name_server,
            'description' => $request->description,
            'slug' => $serverSlug,
            'user_id' => $request->user_id,
            'token' => Str::random(32), // Generar token para el servidor
        ]);

        // Ahora sí iniciamos sesión automáticamente
        $user = User::findOrFail($request->user_id);
        Auth::login($user);

        return redirect()->route('dashboard.')->with('success', '¡Servidor creado y cuenta registrada exitosamente!');
    }
}
