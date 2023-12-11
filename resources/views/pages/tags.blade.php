@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tags</h1>

        <a href="{{ route('tags.create') }}" class="btn btn-primary">New Tag</a>

        <ul>
            @foreach($tags as $tag)
                <li>
                    <a href="{{ route('tags.show', ['tag' => $tag->id]) }}">{{ $tag->tagName }}</a>
                    <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}">Edit</a>
                    <form action="{{ route('tags.destroy', ['tag' => $tag->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
