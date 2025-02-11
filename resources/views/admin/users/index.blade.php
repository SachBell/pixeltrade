@foreach ($users as $user)
    <p>{{ $user->name }}</p>
    @foreach ($user->roles as $role)
        <p>{{ $role->name }}</p>
    @endforeach
@endforeach
