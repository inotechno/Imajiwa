<?php

namespace App\Livewire\Component\Page;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public $user;
    public $name;
    public $notifications;
    public $unreadCount;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->notifications = $this->user->notifications()->latest()->limit(5)->get();
        $this->unreadCount = $this->user->notifications()->where('is_read', false)->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = $this->user->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $this->notifications = $this->user->notifications()->latest()->limit(5)->get();
            $this->unreadCount = $this->user->notifications()->where('is_read', false)->count();
            $url = $notification->url;
            if ($url) {
                return redirect($url);
            }
        }
    }

    public function render()
    {
        return view('livewire.component.page.header', [
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
        ]);
    }
}
