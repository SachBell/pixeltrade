<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servers;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    public function index()
    {
        $stores = Servers::with('user')->get();
        return view('admin.stores.index', compact('stores'));
    }

    public function show(Servers $stores)
    {
        return view('admin.stores.partials.show', compact('stores'));
    }

    public function suspend(Request $request, Servers $stores)
    {

        $this->authorize('update', $stores);

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $stores->update([
            'status' => 'suspend',
            'suspension_reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Tienda suspendida exitosamente.');
    }

    public function reactivate(Servers $stores)
    {

        $this->authorize('update', $stores);

        $stores->update([
            'status' => 'active',
            'suspension_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Tienda reactivada exitosamente.');
    }

    public function destroy(Servers $stores)
    {
        $this->authorize('delete', $stores);
        $stores->delete();

        return redirect()->route('admin.stores.index')->with('success', 'Tienda eliminada exitosamente.');
    }
}
