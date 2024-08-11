<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function markAllAsRead()
{
    Notification::where('is_read', false)->update(['is_read' => true]);
    return redirect()->back();
}
}
