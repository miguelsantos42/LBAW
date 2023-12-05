{{-- resources/views/pages/question.blade.php --}}

@extends('layouts.app')

@section('content')
<style>
/* Add your CSS styles here */
.question-details {
    background-color: #fff;
    padding: 20px;
    border-radius: 4px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.comment {
    background-color: #f9f9f9;
    margin-bottom: 15px;
    padding: 20px;
    color: #000;

}
.comment-content{
    margin-left: 5px;
}

.comment-metadata {
    font-size: 0.9em;
    color: #6c757d;
    margin-bottom: 5px;
}

.comment-user {
    font-weight: bold;
}

.comment-date {
    margin-left: 10px;
}

.form-group textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.nested-comments {
    margin-left: 5px;
    border-left: 4px solid #e3e3e3;
    padding-left: 5px;
    border-radius: 7px 0px 0px 0px;

}

.submit-answer{
    background-color: grey;
    border-radius: 15px;
    padding: 0 1.5em;
    margin-left: 15px;
}

.escrever-texto{
    height: 50px;
    border: none;
}

</style>

<div class="question-container">
    <div class="question-details">
        <h1>{{ $question->title }}</h1>
        <p>{{ $question->content }}</p>

        {{-- Form for adding a new top-level comment --}}
        <form method="POST" action="{{ route('comments.store') }}" class="form-group">
            @csrf
            <input type="hidden" name="questionid" value="{{ $question->id }}" />
            <textarea name="content" placeholder="Your answer..." required class="form-control"></textarea>
            <button type="submit" class="btn btn-primary">Submit Answer</button>
        </form>

        {{-- Inside question.blade.php --}}
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