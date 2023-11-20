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
    <h2>Frequently Asked Questions</h2>
    <p>Welcome to our Q&A platform! Below are some common questions to help you get started:</p>

    <h3>1. How do I create an account?</h3>
    <p>Creating an account is easy! Click on the "Login" button and then the "Register" button. Follow the prompts to set up your profile.</p>

    <h3>2. Can I ask a question anonymously?</h3>
    <p>No, that feature is not available. Maybe we will add it in the future.</p>

    <h3>3. How do I search for specific topics or questions?</h3>
    <p>Our advanced search feature allows you to find topics or questions quickly. Simply enter keywords in the search bar, and relevant results will be displayed.</p>

    <h3>4. What is the tagging system?</h3>
    <p>The tagging system helps organize questions. When posting a question, add relevant tags to categorize it. This makes it easier for others to find and answer questions in specific topics.</p>

    <h3>5. How can I track my contributions and achievements?</h3>
    <p>Check your user profile to see your contributions and achievements. We have a reputation system in place to recognize and reward active community members.</p>

    <h3>6. How do I report inappropriate content?</h3>
    <p>If you come across inappropriate content, use our reporting system. Click on the "Report" button, and our team will review and take appropriate action.</p>

    <h3>7. Can I receive personalized content recommendations?</h3>
    <p>Yes! Based on your interests and activity, our system provides personalized content recommendations on your home feed. Explore topics you love!</p>

    <h3>8. How can I contribute to improving the platform?</h3>
    <p>We welcome your feedback! Feel free to reach out to our support team with suggestions or report any issues. Together, we can make our Q&A community even better!</p>
</div>
@endsection