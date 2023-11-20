{{-- resources/views/pages/about.blade.php --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/home.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <title>About Q&AHub</title>
</head>
<body>
    <header>
        <div class="logo-container">
            <h2 class="logo"><a href="{{ url('/home') }}">Q&AHub</a></h2>
            <button onclick=toggleSidebar() id="sidebar" class="house-main" type="">
                <i class="bi bi-house-fill"></i>
            </button>
        </div>
        <nav class="navigation">
            <a href="{{ url('/about') }}">About</a>
            <a href="faqs.php">FAQ's</a>
            <a href="faqs.php">Services</a>
            <a href="faqs.php">Contact</a>

            @if (Auth::check())
            <a class="btnLogout" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
            @else
            <button class="btnLogin" onclick="location.href='{{ route('login') }}'">Login</button>
            @endif

        </nav>
    </header>

    <div class="container">
        <h2>Welcome to Q&AHub</h2>
        <p>Q&AHub is an online community platform dedicated to promoting the exchange of knowledge and collaborative
            learning among users. In the ever-changing landscape of today's world, the necessity for accurate
            information and cooperative education is paramount. Q&AHub aims to fulfill this requirement by offering an
            environment where individuals are encouraged to both disseminate knowledge and resolve queries in their
            respective fields.</p>

        <h3>Features of Q&AHub:</h3>
        <ul>
            <li><strong>User Authentication:</strong> Secure sign-in through email/password and social media
                integrations.</li>
            <li><strong>User Management:</strong> Comprehensive administrative tools including role assignments.</li>
            <li><strong>Advanced Search:</strong> Enhanced search functionalities for fast and effective data retrieval.
            </li>
            <li><strong>Tagging System:</strong> A robust categorization system for organizing questions effectively.
            </li>
            <li><strong>Analytics:</strong> Insightful statistics to monitor user engagement and activity.</li>
            <li><strong>Reputation System:</strong> A merit-based framework to recognize top contributors.</li>
            <li><strong>Reporting System:</strong> Mechanisms to report and maintain the quality of content.</li>
            <li><strong>Content Recommendation:</strong> Personalized suggestions aligned with user interests.</li>
        </ul>

        <p>At Q&AHub, we believe in the power of community-driven learning and the significant impact it can have on
            individual growth and collective advancement. Join us in our mission to make knowledge accessible and
            learning collaborative!</p>
    </div>
</body>

</html>