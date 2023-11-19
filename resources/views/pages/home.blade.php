@extends('layouts.app')

@section('content')
    <form action="{{ route('ask.question') }}" method="POST" class="question-form">
        @csrf <!-- CSRF token for security -->
        <div class="search-container" id="search-container">
            <input type="text" id="question-title" name="title" placeholder="Title of your question" required class="question-input">
            <textarea id="question-content" name="content" placeholder="Ask any question" required class="question-content"></textarea>
            <button type="submit" class="search-button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>
@endsection
