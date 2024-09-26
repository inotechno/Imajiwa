<?php

namespace App\Livewire\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationIndex extends Component
{
    public $user;
    public $name;
    public $notifications;
    public $unreadCount;


    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->notifications = $this->user->notifications()->orderBy('created_at', 'desc')->get();
        $this->unreadCount = $this->user->notifications()->where('is_read', false)->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = $this->user->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $this->notifications = $this->user->notifications()->get();
            $this->unreadCount = $this->user->notifications()->where('is_read', false)->count();
            $url = $notification->url;
            if ($url) {
                return redirect($url);
            }
        }
    }


    public function render()
    {
        return view('livewire.notification.notification-index', [
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
        ])->layout('layouts.app', ['title' => 'Notifications']);
    }
}
