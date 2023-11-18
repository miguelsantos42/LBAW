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
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
    </head>
    <body>
        <main>
            <header>
                <h2 class="logo"><a href="{{ url('/home') }}">Q&AHub!</a></h2>
                <nav class="navigation">
                    <a href="about.php">About</a>
                    <a href="faqs.php">FAQ's</a>
                    @if (Auth::check())
                        <a class="btnLogout" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
                    @else
                        <a class="btnLogin" href="{{ route('login') }}">Login</a>
                    @endif
                    
                </nav>
            </header>
            <section id="content">
                @yield('content')
            </section>
        </main>
    </body>
</html>