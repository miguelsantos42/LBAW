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

                <!-- tags -->
                <div class="m-2 p-2">
                    <label for="tags"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Select Tags
                    </label>
                        <select id="tags" name="tags[]"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" multiple>
                            @if(isset($tags))
                                @foreach( $tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->tagName }}</option>
                                @endforeach
                            @endif    
                        </select>
                </div>


                <button class="submit-post" type="submit">Submit Post</button>
            </form>
        </div>
    </div>
@endsection
