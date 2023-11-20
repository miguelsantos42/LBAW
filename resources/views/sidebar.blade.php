<div id="sidebar" class="sidebar">
    <a href="/feed">Feed</a>
    <a href="/feed?order=top">Top Questions</a>
    <a href="/feed?order=recent">Recent Questions</a>
    <a href="/feed?order=myquestions">My Questions</a>
    <a href="/feed?order=myanswers">My Answers</a>


    <?php
    $user = auth()->user();

    if ($user) {
    $userRole = $user->role;

    // Check if the user's role is equal to 2 or above
    if ($userRole >= 2) {
        echo '<a href="/admin">Admin</a>';
    }
    }
    ?>

    <!-- Add more links or content as needed -->
</div>
