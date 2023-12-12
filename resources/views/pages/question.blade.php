{{-- resources/views/pages/question.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="question-container">
    <div class="question-details">
        
        <h1>{{ $question->title }}</h1>
    
        <p>{{ $question->content }}</p>
        @foreach($question->tags as $tag)
            <span class="tag">{{ $tag->tagname }}</span>
        @endforeach
        {{-- Form for adding a new top-level comment --}}
        <form method="POST" action="{{ route('comments.store') }}" class="form-group">
            @csrf
            <input type="hidden" name="questionid" value="{{ $question->id }}" />
            <textarea name="content" placeholder="Your answer..." required class="form-control"></textarea>
            <button type="submit" class="btn btn-primary">Submit Answer</button>
        </form>
        <div class="comments-section">
            @if($nestedComments)
            @foreach ($question->comments as $comment)
            @include('partials.comment', ['comment' => $comment])
            @endforeach
            @else
            @endif
        </div>
    </div>
</div>

@endsection