@extends('layouts.app')

@section('content')
<div class="tag-container">
    <h1 class= "title">Tags</h1>
    <form action="{{ route('tags.search') }}" method="GET">
        <input type="text" name="search" class="form-control" placeholder="🔎 Search tag by name"
            value="{{ request()->query('search') }}">
        <button class="search-button" type="submit"> Search</button>
    </form>

    <form action="{{ route('tags.create') }}">
        <button class="newtag">New Tag</button>
    </form>
    <div class="row mt-3">
        @foreach($tags as $index => $tag)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="display: none;">{{ $tag->id }}</h5>
                        <h5 class="card-title">{{ $tag->tagname }}</h5>
                        <div class="follow">
                        @auth
                            @if(Auth::user()->followsT($tag))
                                <form method="POST" action="{{ route('tags.unfollow', $tag->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Unfollow</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('tags.follow', $tag->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                                </form>
                            @endif
                        @endauth
                        </div>
                        @if (Auth::check() && (Auth::user()->role == 2) || (Auth::user()->role == 1))
                        <div class="buttons-both">
                            <a class="button" href="{{ route('tags.edit',  $tag->id) }}">Edit</a>
                            <form action="{{ route('tags.destroy',  $tag->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @if (Auth::check() && (Auth::user()->role == 2) || (Auth::user()->role == 1))
                @if (($index + 1) % 5 == 0)
                    </div><div class="row mt-3">
                @endif
            @else
                @if (($index + 1) % 7 == 0)
                    </div><div class="row mt-3">
                @endif
            @endif
        @endforeach
    </div>
</div>
@endsection
