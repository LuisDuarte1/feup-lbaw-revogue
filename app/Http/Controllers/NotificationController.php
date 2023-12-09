<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public static function renderNotifications($notifications): array{
        $renderedNotifications = [];
        foreach($notifications as $notification){
            array_push($renderedNotifications, $notification->class_name::renderNotification($notification));
        }
        return $renderedNotifications;
    }

    function getPage(Request $request){
        return view('pages.notifications');
    }

    function getNotificationsAPI(Request $request){
        $user = $request->user();

        $notifications = $user->notifications()->where('dismissed', 'false')->paginate(10)->withQueryString();
        if($notifications->isEmpty()){
            return response('',204);
        }
        $renderedNotifications = NotificationController::renderNotifications($notifications);

        return view('api.notificationList', ['notifications' => $renderedNotifications]);
    }
}
