<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Servers;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($serverSlug)
    {

        $server = Servers::where('slug', $serverSlug)->firstOrFail();
        $products = $server->serverProduct()->with('productCategorie')->firstOrFail();

        return view('stores.products.index', compact('server', 'products'));
    }

    public function show($serverSlug, $productId)
    {

        $server = Servers::where('slug', $serverSlug)->firstOrFail();
        $products = Products::where('id', $productId)
            ->where('server_id', $server->id)
            ->with('productCategorie')
            ->firstOrFail();

        return view('stores.products.partials.show', compact('server', 'products'));
    }
}
