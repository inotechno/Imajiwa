<?php

namespace App\Livewire\Component\Page;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationBell extends Component
{
    public $notifications;
    public $unreadCount;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->getNotifications();
    }

    public function getNotifications()
    {
        if (!$this->user) return;
        
        $this->notifications = $this->user->notifications()->latest()->limit(5)->get();
        $this->unreadCount = $this->user->notifications()->where('is_read', false)->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = $this->user->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $this->getNotifications();
            
            $url = $notification->url;
            if ($url) {
                return redirect($url);
            }
        }
    }

    public function render()
    {
        // Refresh data on render (polling triggers this)
        $this->getNotifications();
        
        return view('livewire.component.page.notification-bell');
    }
}
