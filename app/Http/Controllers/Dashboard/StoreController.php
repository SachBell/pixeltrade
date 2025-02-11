<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Servers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $servers = Servers::where('user_id', $user)->get();

        return view('dashboard.store.index', compact('servers'));
    }

    public function store(Request $request) {}

    public function show(Servers $servers)
    {

        $userId = Auth::id();

        if ($servers->user_id !== $userId) {
            abort(403, 'No tienes acceso a este servidor.');
        }

        return view('dashboard.store.partials.config', compact('server'));
    }

    public function update(Request $request, Servers $servers)
    {

        $this->authorize('update', $servers);

        $request->validate([
            'name_server' => 'required|string|unique:servers,name_server' . $servers->id,
            'description' => 'sometimes|string',
        ]);

        $servers->update([
            'name_server' => $request->name_server,
            'description' => $request->description
        ]);

        return redirect()->route('dashboard.store.index')->with('success', 'Tienda actualizada correctamente.');
    }

    public function regenerateToken(Servers $servers)
    {

        $userId = Auth::id();

        if ($servers->user_id !== $userId) {
            abort(403, 'No tienes permiso para regenerar el token.');
        }

        $servers->token = Str::random(32);
        $servers->save();

        return redirect()->back()->with('success', 'Token generado exitosamente.');
    }
}
