<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Servers;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {

        $serverSlug = $request->route('serverSlug');

        dd($serverSlug);

        $server = Servers::where('slug', $serverSlug)->firstOrFail();
        $categories = Categories::where('server_id', $server->id)->get();
        $products = Products::where('server_id', $server->id)->get();

        return view('stores.index', compact('server', 'categories', 'products'));
    }

    public function category($serverSlug, $categoryId)
    {
        $server = Servers::where('slug', $serverSlug)->firstOrFail();
        $category = Categories::where('id', $categoryId)
            ->where('server_id', $server->id)
            ->firstOrFail();
        $products = Products::where('categorie_id', $category->id)->get();

        return view('stores.categories.index', compact('server', 'category', 'products'));
    }

    public function product($serverSlug, $productId)
    {
        $server = Servers::where('slug', $serverSlug)->firstOrFail();
        $product = Products::where('id', $productId)
            ->where('server_id', $server->id)
            ->firstOrFail();

        return view('stores.products.index', compact('server', 'product'));
    }
}
