@extends('layouts.app')

@section('content')
    <div class="tag-container">
        <h1 class= "title">Edit Tag</h1>

        <form action="{{ route('tags.update', $tag->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="text" class="form-control" name="tagname" value="{{ old('tagname', $tag->tagname) }}" placeholder="Edit tag name">
            </div>

            <button type="submit" class="search-button">Update</button>
        </form>
    </div>
@endsection
