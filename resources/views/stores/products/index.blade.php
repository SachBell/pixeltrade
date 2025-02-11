<h1>{{ $products->name_product }}</h1>
<p>{{ $products->description }}</p>
<p>Precio: ${{ $products->price }}</p>

<a href="{{ route('stores.checkout.create', [$server->slug, $products->id]) }}">Comprar Ahora</a>
