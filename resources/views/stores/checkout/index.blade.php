<h1>Comprar {{ $product->name_product }}</h1>
<p>Precio: ${{ $product->price }}</p>

<form action="{{ route('store.checkout.store', [$server->slug, $product->id]) }}" method="POST">
    @csrf
    <label for="username">Nombre de usuario de Minecraft:</label>
    <input type="text" name="username" required>

    <button type="submit">Confirmar Compra</button>
</form>
