{{-- resources/views/pages/about.blade.php --}}
@extends('layouts.app')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Q&AHub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header,
        footer {
            background: #333;
            color: #fff;
            padding: 20px;
        }
        header a,
        footer a {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>About Q&AHub</h1>
        </div>
    </header>

    <div class="container">
        <h2>Welcome to Q&AHub</h2>
        <p>Q&AHub is an online community platform dedicated to promoting the exchange of knowledge and collaborative learning among users. In the ever-changing landscape of today's world, the necessity for accurate information and cooperative education is paramount. Q&AHub aims to fulfill this requirement by offering an environment where individuals are encouraged to both disseminate knowledge and resolve queries in their respective fields.</p>

        <h3>Features of Q&AHub:</h3>
        <ul>
            <li><strong>User Authentication:</strong> Secure sign-in through email/password and social media integrations.</li>
            <li><strong>User Management:</strong> Comprehensive administrative tools including role assignments.</li>
            <li><strong>Advanced Search:</strong> Enhanced search functionalities for fast and effective data retrieval.</li>
            <li><strong>Tagging System:</strong> A robust categorization system for organizing questions effectively.</li>
            <li><strong>Analytics:</strong> Insightful statistics to monitor user engagement and activity.</li>
            <li><strong>Reputation System:</strong> A merit-based framework to recognize top contributors.</li>
            <li><strong>Reporting System:</strong> Mechanisms to report and maintain the quality of content.</li>
            <li><strong>Content Recommendation:</strong> Personalized suggestions aligned with user interests.</li>
        </ul>

        <p>At Q&AHub, we believe in the power of community-driven learning and the significant impact it can have on individual growth and collective advancement. Join us in our mission to make knowledge accessible and learning collaborative!</p>
    </div>

    <footer>
        <div class="container">
            <p>Q&AHub - Where Questions Meet Answers</p>
        </div>
    </footer>
</body>
</html>