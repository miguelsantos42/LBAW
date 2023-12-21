@extends('layouts.app')
@section('content')
<form method="POST" action="/send" class="send-mail-form">
    @csrf
    <div>
        <h3 class="send-email-title" >Send Email</h3>
    </div>
    <label for="name">Name</label>
    <input id="name" type="text" name="name" required>
    <label class="emailfield" for="email">Email</label>
    <input id="email-mailtrap" type="email" name="email" required>
    <button class="send-email-button" type="submit">Send</button>
</form>
@endsection
