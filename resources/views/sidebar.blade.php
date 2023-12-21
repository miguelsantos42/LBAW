<div id="sidebar" class="sidebar" style="top: -600px;">
    <a href="/feed">Feed</a>
    <a href="/tags">Tags</a>
    <a href="/feed?order=top">Top Questions</a>
    <a href="/feed?order=recent">Recent Questions</a>
    <a href="/feed?order=myquestions">My Questions</a>
    <a href="/feed?order=followedquestions">Followed Questions</a>
    <a href="/feed?order=myanswers">My Answers</a>
    <?php
    $user = auth()->user();

    if ($user) {
    $userRole = $user->role;

    if ($userRole == 2) {
        echo '<a href="/admin">Admin</a>';
    }
    if ($userRole == 1) {
        echo '<a href="/admin">Moderator</a>';

    }
    }
    ?>

    <!-- Add more links or content as needed -->
</div>
