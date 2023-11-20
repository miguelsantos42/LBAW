@extends('layouts.app')

@section('content')
<style>
    .content-background {
        background-color: rgba(255, 255, 255, 0.95); /* Branco com 80% de opacidade */
        padding: 20px; /* Espaçamento interno */
        margin: 20px auto; /* Margem superior e centralização horizontal */
        width: 90%; /* Largura definida */
        border-radius: 10px; /* Bordas arredondadas */
    }
</style>

<div class="content-background">


        <h2>Admin Page - User List</h2>
        <ul>
            @foreach ($users as $user)
                <li>
                    <strong>{{ $user->name }}</strong> (Role: {{ $user->role }})
                    <form method="post" action="{{ route('admin.update', ['id' => $user->id]) }}">
                        @csrf
                        @method('put')

                        <label for="newName">Change Name:</label>
                        <input type="text" id="newName" name="newName" value="{{ old('newName', $user->name) }}">

                        <label for="newRole">Change Role:</label>
                        <select id="newRole" name="newRole">
                            <option value="0" {{ old('newRole', $user->role) == 0 ? 'selected' : '' }}>User</option>
                            <option value="1" {{ old('newRole', $user->role) == 1 ? 'selected' : '' }}>Moderator</option>
                            <option value="2" {{ old('newRole', $user->role) == 2 ? 'selected' : '' }}>Admin</option>
                        </select>

                        <button type="submit">Update</button>
                    </form>
                </li>
            @endforeach
        </ul>

</div>
@endsection