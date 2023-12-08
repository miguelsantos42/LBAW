{{-- resources/views/partials/comment.blade.php --}}
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="comment" data-comment-id="{{ $comment->id }}">
    <div class="comment-metadata">
        <span class="comment-user">{{ $comment->user->name }}</span>
        <span class="comment-date">{{ \Carbon\Carbon::parse($comment->date)->diffForHumans() }}</span>
    </div>
    <div class="comment-content">{{ $comment->content }}</div>
    <div class="vote-controls">
        <button class="upvote" onclick="voteComment({{ $comment->id }}, true)">
            <i class="bi bi-arrow-up-square"></i>
        </button>
        <span class="vote-count">{{ $comment->votecount }}</span>
        <button class="downvote" onclick="voteComment({{ $comment->id }}, false)">
            <i class="bi bi-arrow-down-square"></i>
        </button>
    </div>
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
        <button class="submit-answer" type="submit">Reply</button>
    </form>
    @endif
</div>

<script>
function voteComment(commentid, isupvote) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const url = isupvote ? `/comments/${commentid}/upvote` : `/comments/${commentid}/downvote`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            commentId: commentid,
            upvote: isupvote
        })
    })
    .then(response => response.json())
    .then(data => {
    let voteCountElement = document.querySelector(`.comment[data-comment-id="${commentid}"] .vote-count`);
        if(voteCountElement){
            voteCountElement.textContent = data.votecount;
        }
    })

    .catch(error => console.error('Error:', error));
}
</script>