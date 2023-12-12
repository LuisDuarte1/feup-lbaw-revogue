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
        $user = $request->user();
        $notifications = [];
        if($request->query('dismissed') === '1'){
            $notifications = $user->notifications()->where('dismissed', 'true')->orderBy('creation_date', 'DESC')->paginate(10)->withQueryString();
        } else {
            $notifications = $user->notifications()->where('dismissed', 'false')->orderBy('creation_date', 'DESC')->paginate(10)->withQueryString();
        }
        $renderedNotifications = NotificationController::renderNotifications($notifications);

        return view('pages.notifications', ['notifications' => $renderedNotifications]);
    }

    function getNotificationsAPI(Request $request){
        $user = $request->user();

        $notifications = $user->notifications()->where('dismissed', 'false')->orderBy('creation_date', 'DESC')->paginate(10)->withQueryString();
        if($notifications->isEmpty()){
            return response('',204);
        }
        $renderedNotifications = NotificationController::renderNotifications($notifications);

        return view('api.notificationList', ['notifications' => $renderedNotifications]);
    }
}
