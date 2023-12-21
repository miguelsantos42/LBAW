@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Tag</h1>

        <form action="{{ route('tags.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="tagname">Tag Name</label>
                <input type="text" class="form-control" name="tagname" value="{{ old('tagname') }}" placeholder="Enter tag name">
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
