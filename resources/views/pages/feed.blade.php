{{-- resources/views/pages/feed.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="feed">
    <div class="container">
        <h1 class="title">Questions Feed</h1>
        <div id="questionModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <p id="modalQuestionContent"></p>
            </div>
        </div>
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
    var content = document.getElementById('content' + questionId);
    var modal = document.getElementById('questionModal');
    var modalContent = document.getElementById('modalQuestionContent');

    modalContent.innerHTML = content.innerHTML; // Transfer content to modal
    modal.style.display = "block"; // Display the modal

    event.stopPropagation(); // Prevents the accordion from toggling when the content is clicked
}


function closeModal() {
    var modal = document.getElementById('questionModal');
    modal.style.display = "none";
}

// Close modal when clicking on the close button
document.querySelector('.close').onclick = closeModal;

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    var modal = document.getElementById('questionModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>
@endsection