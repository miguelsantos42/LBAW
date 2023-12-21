{{-- resources/views/partials/comment.blade.php --}}

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="comment" data-comment-id="{{ $comment->id }}">
    <div class="comment-metadata">
        <span class="comment-user">{{ $comment->user->name }}</span>
        <span class="comment-date">{{ \Carbon\Carbon::parse($comment->date)->diffForHumans() }}</span>
        @if($comment->edited === true)
            <span class="edited">
                Edited
            </span>
        @endif
    </div>
    <div class="comment-content">{{ $comment->content }}</div>

    <div class="comment-actions">
        <!-- Voting controls -->
        <div class="vote-controls">
            <button class="upvote @if(optional($comment->userVote)->updown === true) upvote-active @endif"
                onclick="voteComment({{ $comment->id }}, true)">
                <i class="bi bi-arrow-up-square"></i>
            </button>
            <span class="vote-count">{{ $comment->votecount }}</span>
            <button class="downvote @if(optional($comment->userVote)->updown === false) downvote-active @endif"
                onclick="voteComment({{ $comment->id }}, false)">
                <i class="bi bi-arrow-down-square"></i>
            </button>
        </div>

        @if(auth()->check() && auth()->id() === $question->usersid)
        <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" class="delete-form">
            @csrf
            @method('DELETE')
            <button class="delete-comment" type="submit">
                <i class="bi bi-trash"></i>
            </button>
        </form>
        <button class="mark-as-correct" onclick="markAsCorrect({{ $comment->id }})">
            @if($comment->correct === true)
                <i id="estrela" class="bi bi-star-fill "></i>
            @elseif($comment->correct === false)
                <i id="estrela-fill" class="bi bi-star"></i>
            @endif
        </button>
        <button class="edit-comment" onclick="editComment({{ $comment->id }})">
            <i class="bi bi-pencil"></i> Edit
        </button>
        @else
            @if($comment->correct === true)
                <i id="estrela" class="bi bi-star-fill "></i>
            @elseif($comment->correct === false)
                <i id="estrela-fill" class="bi bi-star"></i>
            @endif
        @endif
    

        <!-- Reply button -->
        @if(auth()->check())
        <button class="reply-button" onclick="toggleReplyForm({{ $comment->id }})">
            <i class="bi bi-chat"></i> Reply
        </button>
        @endif
    </div>

    @if($comment->replies && count($comment->replies) > 0)
    <div class="nested-comments">
        @foreach($comment->replies as $reply)
        @include('partials.comment', ['comment' => $reply])
        @endforeach
    </div>
    @endif

    <!-- Hidden reply form -->
    @if(auth()->check())
    <div class="reply-form-container" id="reply-form-{{ $comment->id }}" style="display: none;">
        <form method="POST" action="{{ route('comments.store') }}">
            @csrf
            <input type="hidden" name="questionid" value="{{ $comment->question->id }}" />
            <input type="hidden" name="parent_id" value="{{ $comment->id }}" /> <!-- Corrected name attribute -->
            <textarea class="escrever-texto" name="content" placeholder="Reply to this comment..." required></textarea>
            <button class="submit-answer" type="submit">Post Reply</button> <!-- Changed button text -->
        </form>
    </div>
    @endif
    <!-- hidden edit form -->
    @if(auth()->check() && auth()->id() === $comment->user->id)
    <div class="edit-form-container" id="edit-form-{{ $comment->id }}" style="display: none;">
        <form method="POST" action="{{ route('comments.edit', $comment->id) }}">
            @csrf
            @method('POST')
            <textarea class="edit-textarea" name="editedContent" placeholder="Edit your comment..."
                required>{{ $comment->content }}</textarea>
            <button class="submit-edit" type="submit">Save Edit</button>
        </form>
    </div>
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
            let upvoteButton = document.querySelector(`.comment[data-comment-id="${commentid}"] .upvote`);
            let downvoteButton = document.querySelector(`.comment[data-comment-id="${commentid}"] .downvote`);

            if (voteCountElement) {
                voteCountElement.textContent = data.votecount;
            }

            // Toggle button active state
            if (isupvote) {
                upvoteButton.classList.toggle('upvote-active');
                downvoteButton.classList.remove('downvote-active');
            } else {
                downvoteButton.classList.toggle('downvote-active');
                upvoteButton.classList.remove('upvote-active');
            }
        })
        .catch(error => console.error('Error:', error));
}

function toggleReplyForm(commentId) {
    var replyForm = document.getElementById('reply-form-' + commentId);
    if (replyForm.style.display === 'none' || replyForm.style.display === '') {
        replyForm.style.display = 'block';
    } else {
        replyForm.style.display = 'none';
    }
}
function editComment(commentId) {
    var editForm = document.getElementById('edit-form-' + commentId);
    var replyForm = document.getElementById('reply-form-' + commentId);

    if (editForm.style.display === 'none' || editForm.style.display === '') {
        editForm.style.display = 'block';
        if (replyForm) replyForm.style.display = 'none'; // Hide reply form if visible
    } else {
        editForm.style.display = 'none';
    }
}

function hideEditForm(commentId) {
    var editForm = document.getElementById('edit-form-' + commentId);
    if (editForm) editForm.style.display = 'none';
}

function markAsCorrect(commentId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/comments/${commentId}/mark-as-correct`;
    form.style.display = 'none';

    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = token;
    form.appendChild(csrfInput);

    const commentIdInput = document.createElement('input');
    commentIdInput.type = 'hidden';
    commentIdInput.name = 'commentId';
    commentIdInput.value = commentId;
    form.appendChild(commentIdInput);

    document.body.appendChild(form);

    form.submit(); 

    document.body.removeChild(form);
}




</script>