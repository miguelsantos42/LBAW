@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class= "title">Create new tag</h1>

    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="tagname" value="{{ old('tagname') }}"
                placeholder="Enter tag name">
        </div>
        <button type="submit" class="search-button">Create</button>
    </form>
</div>
@endsection