<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function markRead($id)
    {
        $notif = Notification::where('id', $id)->where('user_id', Auth::id())->first();
        if ($notif) {
            $notif->update(['is_read' => true]);
        }

        return redirect()->back();
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())->where('is_read', false)->update(['is_read' => true]);
        return redirect()->back();
    }
}
