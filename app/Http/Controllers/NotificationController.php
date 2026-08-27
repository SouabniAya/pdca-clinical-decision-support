<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Mark one notification as read, then follow it to its destination
     * (patient, recommendation, rule) if it has one.
     */
    public function markRead(Request $request, $id)
    {
        $notification = ActivityLog::findOrFail($id);

        if (! $notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        if ($request->boolean('redirect') && $notification->url) {
            return redirect($notification->url);
        }

        return back();
    }

    /**
     * Mark every notification as read (header "Mark all as read").
     */
    public function markAllRead()
    {
        ActivityLog::whereNull('read_at')->update(['read_at' => now()]);

        return back();
    }
}
