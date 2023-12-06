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
                    <strong>{{ $question->title }}</strong> by {{ $question->user->name }}
                </div>
                <div class="accordion-content" id="content{{ $question->id }}">
                    <p>{{ Str::limit($question->content, 150) }}</p>
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
</script>
@endsection
