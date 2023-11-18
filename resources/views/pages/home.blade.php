@extends('layouts.app')

@section('content')
    <form action="{{ route('ask.question') }}" method="POST" class="question-form">
        @csrf <!-- CSRF token for security -->
        <div class="search-container">
            <input type="text" id="question-title" name="title" placeholder="Title of your question" required class="question-input">
            <div id="additional-fields" class="additional-fields">
                <textarea name="content" placeholder="Ask any question" required></textarea>
            </div>
            <button type="submit" class="search-button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>
@endsection
