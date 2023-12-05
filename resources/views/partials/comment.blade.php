{{-- resources/views/partials/comment.blade.php --}}

<div class="comment">
    <div class="comment-metadata">
        <span class="comment-user">{{ $comment->user->name }}</span>
        <span class="comment-date">{{ \Carbon\Carbon::parse($comment->date)->diffForHumans() }}</span>
    </div>
    <div class="comment-content">{{ $comment->content }}</div>

    @if($comment->replies && count($comment->replies) > 0)
        <div class="nested-comments">
            @foreach($comment->replies as $reply)
                @include('partials.comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
    @if(auth()->check()) {{-- Check if the user is authenticated --}}
        <form method="POST" action="{{ route('comments.store') }}">
            @csrf
            <input type="hidden" name="questionid" value="{{ $comment->question->id }}" />
            <input type="hidden" name="parent_id" value="{{ $comment->id }}" /> 
            <textarea class="escrever-texto" name="content" placeholder="Reply to this comment..." required></textarea>
            <button class="submit-answer"type="submit">Reply</button>
        </form>
    @endif
</div>