<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Crea tu Servidor</h2>

        <form method="POST" action="{{ route('server.create.store') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user_id }}">

            <div class="mb-4">
                <label for="name_server" class="block text-sm font-medium">Nombre del Servidor</label>
                <input type="text" name="name_server" id="name_server" class="w-full border-gray-300 rounded p-2"
                    required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Descripción (Opcional)</label>
                <textarea name="description" id="description" class="w-full border-gray-300 rounded p-2"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Finalizar
                Registro</button>
        </form>
    </div>
</x-guest-layout>
