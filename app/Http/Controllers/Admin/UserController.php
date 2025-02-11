<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    public function index()
    {

        $users = User::role('server_owner')->with('userServer')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {

        return view('admin.users.partials.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:64|confirmed',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.dashboard.')->with('success', 'Usuario creado con éxito.');
    }

    public function show(User $users)
    {
        return view('admin.users.partials.show', compact('users'));
    }

    public function edit(User $users)
    {
        $this->authorize('update', $users);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $users)
    {
        $this->authorize('update', $users);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:64|confirmed',
            'role' => 'required|string'
        ]);

        $users->update([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => $request->password ? Hash::make($request->password) : $users->password,
        ]);

        $users->syncRoles([$request->role]);

        return redirect()->route('admin.dashboard.users.index')->with('success', 'Usuario actualizado.');
    }

    public function destroy(User $users)
    {
        $this->authorize('delete', $users);
        $users->delete();

        return redirect()->route('admin.dashboard.users.index')->with('Usuario eliminado con éxito.');
    }
}
