<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Http\Requests;

class NotificationController extends Controller
{
    public function proccessNotification(Request $request)
    {
      $notification = Notification::find($request['notification_id']);
      $notification->seen = 1;
      $notification->update();
      return redirect($request['route']);
    }

    public function getNotifications()
    {
      return view('account.notifications');
    }
}
