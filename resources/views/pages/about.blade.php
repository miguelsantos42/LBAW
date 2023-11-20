@extends('layouts.app')

@section('content')
<style>
    .content-background {
        background-color: rgba(255, 255, 255, 0.95); /* Branco com 80% de opacidade */
        padding: 20px; /* Espaçamento interno */
        margin: 20px auto; /* Margem superior e centralização horizontal */
        width: 90%; /* Largura definida */
        border-radius: 10px; /* Bordas arredondadas */
    }
</style>

<div class="content-background">
    <h2>Welcome to Q&AHub</h2>
    <p>Q&AHub is an online community platform dedicated to promoting the exchange of knowledge and collaborative
            learning among users. In times where the problem is the acess of very and divergent information, the necessity for accurate
            information and cooperative education is paramount. Q&AHub aims to fulfill this requirement by offering an
            environment where individuals are encouraged to both disseminate knowledge and resolve queries in their
            respective fields.</p>
            <h3>Features of Q&AHub:</h3>
            <ul>
                <!-- list of features -->
            </ul>
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
@endsection