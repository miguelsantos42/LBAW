@extends('layouts.app')

@section('content')
<style>
    .container {
        background-color: rgba(255, 255, 255, 0.95); 
        padding: 20px; 
        margin: 20px auto;
        width: 90%;
        border-radius: 10px;
    }
</style>

<div class="container">
    <section>   
        <h2>Contact us</h2>
        <p><strong>Interested in becoming the newest admin?</strong></p>
        <p><strong>Want to join our dev team?</strong></p>
        <p><strong>You have ideas to share with us?</strong></p>
    </section>
</div>
<div class="container">
        <section>
            <h2>Get in touch with our team:</h2>
            <ol>
                <li><strong>Administration Desk:</strong> Elon Muska | Email: tesla@hotmail.com</li>
                <li><strong>Senior Dev leader:</strong> Mark Zucchini | Email: metamark@yahoo.com</li>
                <li><strong>Human relations:</strong> Claus Schwab | Email: whf@gmail.com</li>
            </ol>
        </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var footer = document.querySelector('.footer');
        footer.classList.add('fixed-bottom');
    });
</script>
@endsection
