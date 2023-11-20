{{-- resources/views/pages/feed.blade.php --}}


@extends('layouts.app')

@section('content')
<div class="feed">
    <div class="container">
        <h1 class="title">Questions Feed</h1>
        <div class="accordion">
            @forelse ($questions as $question)
            <div class="accordion-container" id="container{{ $question->id }}"
                onclick="toggleAccordion('content{{ $question->id }}', 'container{{ $question->id }}')">
                {{ $question->title }}
            </div>
            <div class="accordion-content" id="content{{ $question->id }}"
                onclick="openModal(event, {{ $question->id }})">
                <p>{{ $question->content }}</p>
                <div class="vote-controls">
                    <button class="upvote" data-question-id="{{ $question->id }}">
                        <i class="bi bi-hand-thumbs-up-fill"></i>
                    </button>
                    <span class="vote-count" id="voteCount{{ $question->id }}">
                        {{ $question-> votecount }}
                    </span>
                    <button class="downvote" data-question-id="{{ $question->id }}">
                        <i class="bi bi-hand-thumbs-down-fill"></i>
                    </button>
                </div>

            </div>

            {{-- Modal for editing the question --}}
            <div id="questionModal{{ $question->id }}" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal({{ $question->id }})">&times;</span>
                    {{-- Check if the authenticated user is the author of the question --}}
                    {{-- Form for updating the question --}}
                    @if (auth()->id() === $question->usersid)
                    <form method="POST" action="{{ route('questions.update', $question->id) }}">
                        @csrf
                        @method('PUT') {{-- Specify the method to be PUT for update --}}
                        <div class="modal-header">
                            <input type="text" name="title" value="{{ $question->title }}" required />
                        </div>
                        <div class="modal-body">
                            <textarea name="content" required>{{ $question->content }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn-save">Save Changes</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <p>No questions available.</p>
            @endforelse
        </div>
    </div>
</div>
<script>
function toggleAccordion(contentId, containerId) {
    var content = document.getElementById(contentId);
    var container = document.getElementById(containerId);

    if (content.style.maxHeight && content.style.maxHeight !== "0px") {
        // Collapse the content
        content.style.maxHeight = "0px";
        container.classList.remove('active');
    } else {
        // Expand the content
        content.style.maxHeight = content.scrollHeight + "px";
        container.classList.add('active');
    }
}

function openModal(event, questionId) {
    var modal = document.getElementById('questionModal' + questionId);
    modal.style.display = "block";
    event.stopPropagation(); // Prevents further propagation of the current event in the capturing and bubbling phases
}


function closeModal(questionId) {
    var modal = document.getElementById('questionModal' + questionId);
    if (modal) {
        modal.style.display = "none";
    }
}


// Close modal when clicking on the close button
document.querySelectorAll('.close').forEach(function(closeButton) {
    closeButton.onclick = function() {
        closeButton.closest('.modal').style.display = 'none';
    };
});
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
    }
}
</script>
@endsection