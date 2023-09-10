<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;

        return view('notifications.index', compact('notifications'));
    }

    public function update(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        $notification->markAsRead();

        return redirect()->route('notifications.index');
    }

    public function destroy(): RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->route('notifications.index');
    }
}
