@extends('layouts.app')

@section('content')
<div class="container-wrapper">
    <div class="profile-container">
        <div class="profile-header">
            <!-- Profile Update Form -->
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf <!-- CSRF token for security -->

                <div class="profile-header-content">
                    <h1 class="profile-title">Welcome to your profile</h1>
                    
                    <!-- User Info Fields, initially visible -->
                    <div id="user-info-fields">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="{{ old('name') ?: Auth::user()->name }}" required />

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="{{ old('email') ?: Auth::user()->email }}" required />
                    </div>

                    <!-- Toggle Button for Showing Password Fields -->
                    <button type="button" id="change-password-toggle" class="btn btn-info" onclick="togglePasswordFields()">Change Password</button>

                    <!-- Password Change Fields, initially hidden -->
                    <div id="password-fields" style="display: none;">
                        <label for="current_password">Current Password:</label>
                        <input type="password" id="current_password" name="current_password" required />

                        <label for="password">New Password:</label>
                        <input type="password" id="password" name="password" required />

                        <label for="password_confirmation">Confirm New Password:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required />
                    </div>

                    <h4 class="profile-rating">Your rating is: {{ Auth::user()->rating }}</h4>
                </div>

                <div class="profile-actions">
                    <button type="submit" class="profile-edit">Save Changes</button>
                </div>
            </form>

            <!-- Account Deletion Form -->
            <form method="POST" action="{{ route('profile.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account?')">
                @csrf
                @method('DELETE')

                <div class="profile-actions">
                    <button type="submit" class="profile-delete">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePasswordFields() {
    var passwordFields = document.getElementById('password-fields');
    var userInfoFields = document.getElementById('user-info-fields');
    var profileTitle = document.querySelector('.profile-title'); // Use querySelector for single elements
    
    if (passwordFields.style.display === 'none') {
        passwordFields.style.display = 'block';
        userInfoFields.style.display = 'none';
        profileTitle.textContent = 'Change your password';
    } else {
        passwordFields.style.display = 'none';
        userInfoFields.style.display = 'block';
        profileTitle.textContent = 'Welcome to your profile';
    }
}
</script>

@endsection
