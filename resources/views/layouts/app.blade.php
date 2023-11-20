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
        <link href="{{ url('css/home.css') }}" rel="stylesheet">        <link href="{{ url('css/home.css') }}" rel="stylesheet">
        <link href="{{ url('css/feed.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">

        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
        <script type="text/javascript" src={{ url('js/home_question_bar.js') }} defer>        </script>

    </head>
    <body>
        @include('sidebar')
        <main>
            <header>
                <div class="logo-container">
                    <h2 class="logo"><a href="{{ url('/home') }}">Q&AHub</a></h2>
                    <button onclick=toggleSidebar()  id="sidebar" class="house-main" type="">
                        <i class="bi bi-house-fill"></i>
                    </button>        
                </div>
                <nav class="navigation">
                    <a href="{{ url('/about') }}">About</a>
                    <a href="{{ url('/faq') }}">FAQ</a>
                    <a href="{{ url('/services') }}">Services</a>
                    <a href="{{ url('/contact') }}">Contact</a>

                    @if (Auth::check())
                        <button class="btnLogout" onclick="location.href='{{ url('/logout') }}'"> Logout </button> 
                        <button class="btnLogin"  onclick="location.href='{{ url('/profile') }}'">{{ Auth::user()->name }}</button>
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
                if (sidebar.style.top === '-500px') {
                    sidebar.style.top = '180px'; // Slide in
                } else {
                    sidebar.style.top = '-500px'; // Slide out
                }
            }
        </script>
    </body>
</html>