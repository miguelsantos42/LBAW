<div id="sidebar" class="sidebar" style="top: -1000px">

    @if(Auth::check())
        <a href="/feed">Feed</a>
        <a href="/feed?order=top">Top Questions</a>
        <a href="/feed?order=recent">Recent Questions</a>
        <a href="/feed?order=myquestions">My Questions</a>
        <a href="/feed?order=followedquestions">Followed Questions</a>
        <a href="/feed?order=myanswers">My Answers</a>
        <a href="/feed?order=closedq">Closed Questions</a>
        <a href="/feed?order=followedtags">Followed Tags</a>
        <a href="/tags">Tags</a>

    @else
        <a href="/login">Login</a>

    @endif


    <?php
    $user = auth()->user();

    if ($user) {
    $userRole = $user->role;

    if ($userRole == 2) {
        echo '<a href="/admin">Admin</a>';
    }
    if ($userRole == 1) {
        echo '<a href="/moderator">Moderator</a>';

    }
    }
    ?>
</div>
