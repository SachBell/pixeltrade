<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Servers;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($serverSlug)
    {
        // Buscar el servidor por slug
        $server = Servers::where('slug', $serverSlug)->firstOrFail();
        $category = Categories::where('server_id', $server->id)->firstOrFail();

        $products = $category->categorieProduct;

        return view('stores.categories.index', compact('server', 'category', 'products'));
    }

    public function show($serverSlug, $categoryId)
    {
        $server = Servers::where('slug', $serverSlug)->firstOrFail();
        $category = Categories::where('id', $categoryId)
            ->where('server_id', $server->id)
            ->firstOrFail();

        $products = $category->categorieProduct;

        return view('stores.partials.show', compact('server', 'category', 'products'));
    }
}
