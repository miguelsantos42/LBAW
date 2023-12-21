<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/home.css') }}" rel="stylesheet">
    <link href="{{ url('css/home.css') }}" rel="stylesheet">
    <link href="{{ url('css/feed.css') }}" rel="stylesheet">
    <link href="{{ url('css/profile.css') }}" rel="stylesheet">
    <link href="{{ url('css/question.css') }}" rel="stylesheet">
    <link href="{{ url('css/editquestion.css') }}" rel="stylesheet">
    <link href="{{ url('css/emails.css') }}" rel="stylesheet">
    <link href="{{ url('css/tag.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <script type="text/javascript">
    </script>
    <script type="text/javascript" src={{ url('js/app.js') }} defer>
    </script>
    <script type="text/javascript" src={{ url('js/create_post.js') }} defer> </script>



</head>

<body>
    @include('sidebar')
    @include('notificationsbar')
    <main>
        <header>
            <div class="logo-container">
                <h2 class="logo"><a href="{{ url('/home') }}">Q&AHub</a></h2>
                <button onclick=toggleSidebar() id="sidebar" class="house-main" type="">
                    <i class="bi bi-house-fill"></i>
                </button>
            </div>
            <nav class="navigation">
                <a href="{{ url('/about') }}">About</a>
                <a href="{{ url('/faq') }}">FAQ</a>
                <a href="{{ url('/services') }}">Services</a>
                <a href="{{ url('/contact') }}">Contact</a>
                @if (Auth::check())
                <a class="dropdown">
                    <button onclick=toggleNotificationsbar() id="notifications" class="house-main" type="">
                        <i class="bi bi-bell" style="font-size: 25px"></i>
                    </button>
                </a>
                @endif


                @if (Auth::check())
                <button class="btnLogout" onclick="location.href='{{ url('/logout') }}'"> Logout </button>
                <button class="btnLogin"
                    onclick="location.href='{{ url('/profile') }}'">{{ Auth::user()->name }}</button>
                @else
                <button class="btnLogin" onclick="location.href='{{ route('login') }}'">Login</button>
                @endif

            </nav>
        </header>
        <section id="content">
            @yield('content')
        </section>

    </main>
    <script>
    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        if (sidebar.style.top === '-1000px') {
            sidebar.style.top = '180px';
        } else {
            sidebar.style.top = '-1000px';
        }
    }

    function toggleNotificationsbar() {
        var notifications = document.getElementById("notifications");
        var body = document.body; // Get the body element
        var content = document.getElementById("content");
        if (notifications.style.top === '-1000px') {
            notifications.style.top = '130px';
            body.classList.add('blur-backdrop'); // Add the blur effect to the body
            content.style.display = "none";
        } else {
            notifications.style.top = '-1000px';
            body.classList.remove('blur-backdrop'); // Remove the blur effect from the body
            content.style.display = "block";
        }
    }

    </script>
</body>

</html>