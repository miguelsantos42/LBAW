@extends('layouts.app')

@section('content')
    <section class="d-flex justify-content-center">
        <div class="container">
            <h1 class="text-center">Our Services</h1>
            <p>Questions & Answers:
               Post questions on various topics and get insightful answers from our diverse community of members.
               Collaboration: 
               Engage in a collaborative environment where users can contribute with answers, vote on the best responses, and comment on posts.
               Diverse Topics: 
               Explore a wide array of topics, ensuring there's something for everyone's interests and expertise.
            </p>
        </div>
    </section>
    <section>
        <div class="container">
            <h2 class="text-center">How It Works?</h2>
            <ol>
                <li><strong>Registration/Login:</strong></li>
                <li>Create your account and log in to start participating in our community</li>
                <li><strong>Posting Questions:</strong></li> 
                <li>Easily post your questions and receive prompt responses from our dedicated users.</li>
                <li><strong>Comments & Voting:</strong></li>
                <li>Interact with content and contribute by commenting and voting on answers you find helpful.</li>
            </ol>
        </div>
    </section>
    <section>
        <div class="container">
            <h3 class="text-center">Testimonials</h3>
            <div class="testimonials">
                <blockquote>
                    <p>"I've found amazing solutions to my problems here! Great community." - Kader Sylla</p>
                </blockquote>
                <blockquote>
                    <p>"The diversity of topics is what keeps me coming back. Always something new to learn!" - Jim Morisson</p>
                </blockquote>
            </div>
        </div>
    </section>

   <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the footer element
            var footer = document.querySelector('.footer');
            // Add the fixed-bottom class to the footer element
            footer.classList.add('fixed-bottom');
        });
    </script>
@endsection
