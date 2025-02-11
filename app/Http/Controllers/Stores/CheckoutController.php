<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Servers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function create(Servers $serverSlug, Products $productId)
    {

        $server = $serverSlug->where('slug', $serverSlug)->firstOrFail();
        $product = $productId->where('id', $productId)
            ->where('server_id', $server->id)
            ->firstOrFail();

        return view('stores.checkout.index', compact('server', 'product'));
    }

    public function store(Request $request, Servers $serverSlug, Products $productId)
    {

        $request->validate([]);

        $server = $serverSlug->where('slug', $serverSlug)->firstOrFail();
        $product = $productId->where('id', $productId)
            ->where('server_id', $server->id)
            ->firstOrFail();

        $paymentStatus = 'success';

        if ($paymentStatus === 'success') {
            Http::post($server->api_url . '/execute-command', [
                'token' => $server->token,
                'command' => str_replace('{player}', $request->username, $product->command),
            ]);

            return redirect()->route('store.products.show', [$serverSlug, $productId])
                ->with('success', 'Compra realizada con éxito.');
        }

        return redirect()->back()->with('error', 'Error al procesar el pago.');
    }
}
