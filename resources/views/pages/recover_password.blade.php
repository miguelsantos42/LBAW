@extends('layouts.app')
@section('content')
<form method="POST" action="{{ route('password.update') }}" class="send-mail-form">
    @csrf
    <div>
        <h3 class="send-email-title" >Reset Password</h3>
    </div>
    <label for="email">Email</label>
    <input id="email-mailtrap" type="email" name="email" required>
    <label for="password">Password</label>
    <input class="password" id="password" type="password" name="password" required>
    <p class="min">Min 8 characters</p>
    <label for="password_confirmation">Confirm Password</label>
    <input class="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required>
    <button class="reset-password-button" type="submit">Reset Password</button>
</form>
@endsection