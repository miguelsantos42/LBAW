<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\CommentNotification;
use App\Models\VoteNotification;
use App\Models\Question;

class NotificationController extends Controller
{
    public function index()
    {


        $userid = Auth::id();


        // Fetch all notifications with related models eager loaded
        $allnotifications = Notification::with(['commentNotification.comment.question', 'voteNotifications.question'])
                                        ->where('usersid', $userid)
                                        ->get()
                                        ->map(function ($notification) {
                                            $content = $notification->content;
                                            $date = $notification->date;
                                            if ($notification->commentNotification) {
                                                $content = $notification->commentNotification->comment->content;
                                                $date = $notification->commentNotification->comment->date;
                                            } else if ($notification->voteNotifications->count() > 0) {
                                                $content = $notification->voteNotifications[0]->voter->name . ' voted on your question';
                                                $date = $notification->voteNotifications[0]->date;
                                            }
                                            return [
                                                'id' => $notification->id,
                                                'content' => $content,
                                                'date' => $date,
                                                'status' => $notification->status,
                                                'questionid' => $notification->questionid,
                                                
                                            ];
                                        });

        return view('layouts.app', compact('allnotifications'));
    }
}
