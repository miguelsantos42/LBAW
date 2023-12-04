{{-- resources/views/pages/question.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="question-details">
    <h1>{{ $question->title }}</h1>
    <p>{{ $question->content }}</p>

    {{-- Check if the authenticated user is the author of the question --}}
    @if (auth()->id() === $question->usersid)
        <form method="POST" action="{{ route('questions.update', $question->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ $question->title }}" required class="form-control"/>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" rows="5" required class="form-control">{{ $question->content }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    @endif

    {{-- Display existing comments --}}
    @forelse ($question->comments as $comment)
        <div class="comment">
            <p>{{ $comment->content }}</p>
        </div>
    @empty
        <p>No answers yet.</p>
    @endforelse

    {{-- Form for adding a new comment --}}
    <form method="POST" action="{{ route('comments.store') }}">
        @csrf
        <input type="hidden" name="questionid" value="{{ $question->id }}" />
        <div class="form-group">
            <textarea name="content" placeholder="Your answer..." required class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Answer</button>
    </form>
</div>
@endsection
