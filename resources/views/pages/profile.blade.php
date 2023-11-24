@extends('layouts.app')

@section('content')
<div class="container-wrapper">
    <div class="profile-container">
        <div class="profile-header">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                <!-- CSRF token for security -->

                <div class="profile-header-content">
                    <h1 class="profile-title">Welcome to your profile</h1>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required />
                    <h3 class="profile-email">Email:</h3>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required />
                    <h4 class="profile-rating">Your rating is: {{ Auth::user()->rating }}</h4>
                </div>

                <div class="profile-actions">@extends('layouts.app')

                    @section('content')
                    <div class="container-wrapper">
                        <div class="profile-container">
                            <div class="profile-header">
                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    <!-- CSRF token for security -->

                                    <div class="profile-header-content">
                                        <h1 class="profile-title">Welcome to your profile</h1>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}" required />
                                        <h3 class="profile-email">Email:</h3>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}" required />
                                        <h4 class="profile-rating">Your rating is: {{ Auth::user()->rating }}</h4>
                                    </div>

                                    <div class="profile-actions">
                                        <button type="submit" class="profile-edit">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    @endsection

                    <button type="submit" class="profile-edit">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection