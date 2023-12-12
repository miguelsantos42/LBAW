@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Tag</h1>

        <form action="{{ route('tags.update', $tag->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="tagName">Tag Name</label>
                <input type="text" class="form-control" name="tagName" value="{{ old('tagName', $tag->tagName) }}" placeholder="Edit tag name">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection