<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {

        $serverId = Auth::user()->userServer->first();
        $products = Products::where('server_id', $serverId)->get();

        return view('dashboard.products.index', compact('products'));
    }

    public function create()
    {
        $serverId = Auth::user()->userServer->first();
        $categories = Categories::where('server_id', $serverId)->get();

        return view('dashboard.products.partials.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name_product' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'command' => 'required|string',
        ]);

        Products::create([
            'server_id' => Auth::user()->userServer->first(),
            'category_id' => $request->category_id,
            'name_product' => $request->name_product,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $request->fill('image') ? $request->file('image')->store('products') : null,
            'command' => $request->command,
        ]);

        return redirect()->route('dashboard.products.index')->with('success', 'Producto creado con éxito.');
    }

    public function edit(Products $products)
    {

        $this->authorize('update', $products);
        $serverId = Auth::user()->userServer->id;
        $categories = Categories::where('server_id', $serverId)->get();

        return view('dashboard.products.partials.edit', compact('categories'));
    }

    public function update(Request $request, Products $products)
    {

        $this->authorize('update', $products);

        $request->validate([
            'name_product' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'command' => 'required|string',
        ]);

        $products->update([
            'category_id' => $request->category_id,
            'name_product' => $request->name_product,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $request->file('image') ? $request->file('image')->store('products') : $products->image,
            'command' => $request->command,
        ]);

        return redirect()->route('dashboard.products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Products $products)
    {

        $this->authorize('delete', $products);
        $products->delete();

        return redirect()->route('dashboard.products.index')->with('success', 'Producto eliminado.');
    }
}
