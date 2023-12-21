{{-- resources/views/pages/feed.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="feed">
    <div class="container">
        <h1 class="title">{{$title}}</h1>
        <div class="accordion">
            @forelse ($questions as $question)
            <div class="accordion-container" id="container{{ $question->id }}"
                onclick="toggleAccordion('content{{ $question->id }}', 'container{{ $question->id }}')">
                <strong>{{ $question->title }}</strong><span></span> Posted by {{ $question->user->name }} <span
                    class="date">{{ \Carbon\Carbon::parse($question->date)->diffForHumans() }}</span>
                        <span>
                            @foreach ($question->tags as $tag)
                                <a href="{{ url('/tags') }}" class="tag">#{{ $tag->tagname }}</a>
                            @endforeach
                        </span>
                        <span>
                        @if ($question->edited)
                            <span title="Edited {{\Carbon\Carbon::parse($question->edited_date)->diffForHumans()}}" class="edited">Edited</span>
                        @endif
                        </span>
                        @if ($question->closed)
                        <span>
                            <span title="This question is closed" class="closed">Closed</span>
                        </span>
                        @endif
            </div>
            <div class="accordion-content" id="content{{ $question->id }}">
                <p>{{ Str::limit($question->content, 500) }}</p>
                <div class="vote-controls">
                    <button class="upvote" onclick="voteQuestion({{ $question->id }}, true)">
                        <i class="bi-arrow-up-square"></i>
                    </button>
                    <span class="votecount" id="votecount-{{ $question->id }}">
                        {{ $question->votecount }}
                    </span>
                    <button class="downvote" onclick="voteQuestion({{ $question->id }}, false)">
                        <i class="bi-arrow-down-square"></i>
                    </button>
                    @if (Auth::check() && Auth::user()->id == $question->usersid || Auth::user()->role == '2')
                        <button class="settings" onclick="window.location.href='{{ route('questions.edit', $question->id) }}'">
                            <i class="bi bi-gear"></i>
                        </button>
                        <button class="trash" onclick="deleteQuestion({{ $question->id }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    @endif

                </div>
                <div class="follow-unfollow">
                    @auth
                      @if(Auth::user()->followsQ($question))
                        <form method="POST" action="{{ route('questions.unfollow', $question->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Unfollow</button>
                        </form>
                      @else
                        <form method="POST" action="{{ route('questions.follow', $question->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                        </form>
                      @endif
                    @endauth 
                </div>
                <a class="ReadMore" href="{{ route('questions.show', $question->id) }}">Read more...</a>

            </div>
            @empty
            <p class="no_questions">There are no questions available.</p>
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

function deleteQuestion(questionId) {
    if(confirm('Are you sure you want to delete this question?')) {
        fetch(`/questions/${questionId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            // You can redirect or remove the element from the DOM
            window.location.reload(); // Simplest way to refresh the page
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}




</script>
@endsection