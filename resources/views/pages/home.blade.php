@extends('layouts.app')

@section('content')
    <!-- Existing form -->
    <form action="{{ route('ask.question') }}" method="POST" class="question-form">
        @csrf <!-- CSRF token for security -->
        <div class="search-container" id="search-container">
            <input type="text" id="question-title" name="title" placeholder="Search anything" required class="question-input">
            <button type="submit" class="search-button">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <div>
            <!-- Add an ID to your button for the JavaScript click event listener -->
        </div>
    </form>
    <button type="button" id="create-post-btn" class="create-post">Create Post</button>

    <!-- Modal structure -->
    <div id="postModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <!-- Modal form, updated to submit to the correct route -->
            <form action="{{ route('ask.question') }}" method="POST" id="postForm">
                @csrf <!-- CSRF token for security -->
                <!-- Form fields for creating a post -->
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="content" rows="50" cols="40" placeholder="Description" required></textarea>
                <button class="submit-post" type="submit">Submit Post</button>
            </form>
        </div>
    </div>
@endsection
