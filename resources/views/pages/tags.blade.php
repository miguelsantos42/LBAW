@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tags</h1>
        
        <form action="{{ route('tags.search') }}" method="GET"> 
            <input type="text" name="search" class="form-control" placeholder="Filter by tag name" value="{{ request()->query('search') }}">
            <button type="submit">Search</button>
        </form>


        <form action="{{ route('tags.create') }}">
            <button class="btn btn-primary">New Tag</button>
        </form>
        <div class="row mt-3">
            @foreach($tags as $tag)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title" style="display: none;">{{ $tag->id }}</h5>
                            <h5 class="card-title">{{ $tag->tagname }}</h5>

                            <a href="{{ route('tags.show', ['tag' => $tag->id]) }}" class="btn btn-primary">View Posts</a>
                            <a href="{{ route('tags.edit',  $tag->id) }}" class="btn btn-secondary">Edit</a>    <!-- Se for Admin -->
                            <form action="{{ route('tags.destroy',  $tag->id) }}" method="POST" 
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
