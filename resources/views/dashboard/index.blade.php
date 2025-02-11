<form class="flex items-center w-full" id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
    <a class="flex items-center w-full py-3" href="#"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-left mr-4 text-lg"></i>
        <span class="text-lg font-semibold">{{ __('Cerrar Sesión') }}</span>
    </a>
</form>
