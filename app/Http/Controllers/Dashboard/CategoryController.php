<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::id();
        $categories = Categories::where('server_id', $user)->get();

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create() {}

    public function store(Request $request)
    {

        $request->validate([
            'name_categorie' => 'required|string|max:255',
            'description' => 'sometimes|string'
        ]);

        $user = auth()->user();

        Categories::created([
            'name_categorie' => $request->name_categorie,
            'description' => $request->description,
            'user_id' => $user->id,
        ]);

        return redirect()->route('dashboard.categories.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Categories $category)
    {

        $this->authorize('update', $category);

        return view('dashboard.categories.partials.edit', compact('category'));
    }

    public function update(Request $request, Categories $category)
    {

        $this->authorize('update', $category);
        $request->validate([
            'name_categorie' => 'required|string|max:255',
            'description' => 'sometimes|string'
        ]);

        $category->update($request->only('name_categorie', 'description'));

        return redirect()->route('dashboard.categories.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(Categories $category)
    {

        $this->authorize('delete', $category);

        $category->delete();

        return redirect()->route('dashboard.categories.index')->with('success', 'Categorí Eliminada.');
    }
}
