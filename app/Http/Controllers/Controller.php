<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Notification;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $userId = Auth::id();
                $allnotifications = Notification::with(['commentNotification.comment.question', 'voteNotifications.question'])
                                                ->where('usersid', $userId)
                                                ->get()
                                                ->map(function ($notification) {
                                                    // Add a simple check to ensure the related objects are loaded
                                                    $content = $notification->content;
                                                    $date = $notification->date;
                                                    $questionid = optional($notification->commentNotification->comment->question)->id
                                                                ?? optional($notification->voteNotifications->question)->id;

                                                    return [
                                                        'id' => $notification->id,
                                                        'content' => $content,
                                                        'date' => $date,
                                                        'questionid' => $questionid,
                                                    ];
                                                });
                View::share('allnotifications', $allnotifications);
            }

            return $next($request);
        });
    }
}
