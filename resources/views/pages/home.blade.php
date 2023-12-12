@extends('layouts.app')

@section('content')
    <form action="{{ route('ask.question') }}" method="POST" class="question-form">
        @csrf 
        <div class="search-container" id="search-container">
            <input type="text" id="question-title" name="title" placeholder="Search anything" required class="question-input">
            <button type="submit" class="search-button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>
    <button type="button" id="create-post-btn" class="create-post">Create Post</button>
    <div id="postModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
         
            <form action="{{ route('ask.question') }}" method="POST" id="postForm">
                @csrf
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="content" placeholder="Description" required></textarea>
                <div>
                    <label for="tags">Select Tags:</label>
                    <select id="tags" name="tags[]" multiple required>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->tagname }}</option>
                        @endforeach
                    </select>
                </div>


                <button class="submit-post" type="submit">Submit Post</button>
            </form>
        </div>
    </div>
@endsection
