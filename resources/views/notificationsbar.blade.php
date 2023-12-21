{{-- resources/views/notificationsbar.blade.php --}}
@if(Auth::check())
    <div id="notifications" class="notifications" style="top: -500px;">
        <div class="notifications-header">
            <h3>Notifications</h3>
        </div>
        <div class="notifications-body">
            @foreach ($allnotifications as $notification)
            <div class="notification-item">
                <div class="notification-content">
                    <p>{{ $notification['content'] }} | {{ \Carbon\Carbon::parse($notification['date'])->diffForHumans()}}
                    </p>
                    
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endif

