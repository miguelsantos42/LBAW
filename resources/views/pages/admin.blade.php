@extends('layouts.app')

@section('content')
<style>
.content-background {
    background-color: rgba(255, 255, 255, 0.95);
    padding: 20px;
    margin: 20px auto;
    width: 90%;
    border-radius: 10px;
}

.user-actions {
    display: flex;
    justify-content: start;
    gap: 10px;
}

.user-actions form {
    margin: 0;
}

.btn {
    background-color: rgba(255, 0, 0, 0.75);
}
</style>

<div class="content-background">

    <form action="{{ route('admin.search') }}" method="GET">
        <input type="text" name="search" placeholder="Search user..." value="{{ request()->query('search') }}">
        <button type="submit">Search</button>
    </form>

    <h2>Admin Page - User List</h2>
    <ul>
        @forelse ($users as $user)
        <li>
            <strong>{{ $user->name }}</strong> (Role: {{ $user->role }}) Email: {{ $user->email }}
            <div class="user-actions">
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

                    <button type="submit" class="btn">Update</button>

                </form>

                <form method="post" action="{{ route('admin.destroy', ['id' => $user->id]) }}"
                    onsubmit="return confirm('Are you sure do you want to delete this user?');">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

            </div>
        </li>
        @empty
        <li>No users found.</li>
        @endforelse
    </ul>
</div>
@endsection