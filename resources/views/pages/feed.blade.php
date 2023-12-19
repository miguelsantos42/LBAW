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
                <strong>{{ $question->title }}</strong> Posted by {{ $question->user->name }} <span
                    class="date">{{ \Carbon\Carbon::parse($question->date)->diffForHumans() }}</span>
            </div>
            <div class="accordion-content" id="content{{ $question->id }}">
                <p>{{ Str::limit($question->content, 500) }}</p>
                <div class="vote-controls">
                    <button class="upvote" onclick="voteQuestion({{ $question->id }}, true)">
                        <i class="bi-arrow-up-square"></i>
                    </button>
                    <span id="votecount-{{ $question->id }}">
                        {{ $question->votecount }}
                    </span>
                    <button class="downvote" onclick="voteQuestion({{ $question->id }}, false)">
                        <i class="bi-arrow-down-square"></i>
                    </button>

                </div>
                <a href="{{ route('questions.show', $question->id) }}">Read more...</a>

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

    // Check if the accordion is already open
    if (content.style.maxHeight && content.style.maxHeight !== "0px") {
        // Collapse the content
        content.style.maxHeight = "0px";
        container.classList.remove('active');
    } else {
        // Close all open accordions
        document.querySelectorAll('.accordion-content').forEach(function(element) {
            element.style.maxHeight = "0px";
        });
        document.querySelectorAll('.accordion-container').forEach(function(element) {
            element.classList.remove('active');
        });

        // Expand the clicked content
        content.style.maxHeight = content.scrollHeight + "px";
        container.classList.add('active');
    }
}

function voteQuestion(questionid, isupvote) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const url = isupvote ? `/questions/${questionid}/upvote` : `/questions/${questionid}/downvote`;

    fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                questionid: questionid,
                _token: token // CSRF token
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            let voteCountElement = document.querySelector(`#votecount-${questionid}`);
            if (voteCountElement) {
                voteCountElement.textContent = data.votecount;
            }

            // Optionally, toggle the button's active state
            let upvoteButton = document.querySelector(`#container${questionid} .upvote`);
            let downvoteButton = document.querySelector(`#container${questionid} .downvote`);
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
</script>
@endsection