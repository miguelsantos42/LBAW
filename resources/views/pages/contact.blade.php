@extends('layouts.app')

@section('content')
    <section class="d-flex justify-content-center">
        <div class="container">
            <h1 class="text-center">Contact Us</h1>
            <p>If you are interested in becoming the newest admin.</p>
            <p>If you want to join our dev team.</p>
            <p>If you have ideas to share with us.</p>
            <p>Here are a few contacts:</p>
            <ul>
                <li>Administration Desk: Elon Musk | Email: tesla@hotmail.com</li>
                <li>Senior Dev leader: Mark Zucchini | Email: metamark@yahoo.com</li>
                <li>Human relations: Klaus Schwab | Email: alex@gmail.com</li>
            </ul>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var footer = document.querySelector('.footer');
            footer.classList.add('fixed-bottom');
        });
    </script>
@endsection
