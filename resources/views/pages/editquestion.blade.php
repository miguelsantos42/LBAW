@extends('layouts.app')

@section('content')
<div class="editquestion-container">
    <h1>Edit Question</h1>
    
    <form action="{{ route('questions.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $question->title }}" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" required>{{ $question->content }}</textarea>
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <select multiple class="form-control" id="tags" name="tags[]">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @if($question->tags->contains($tag->id)) selected @endif>
                        {{ $tag->tagname }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
