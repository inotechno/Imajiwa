<?php

namespace App\Livewire\Component;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ChangeTheme extends Component
{
    public $theme;

    public function mount()
    {
        $this->theme = session('theme', 'dark');
    }

    public function toggleTheme()
    {
        // Toggle the theme between 'light' and 'dark'
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';

        // Store the theme in the session
        session(['theme' => $this->theme]);

        // Emit the event to notify the frontend of the theme change
        $this->dispatch('themeChanged', $this->theme);
        // Refresh the page to apply the theme
        $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.component.change-theme');
    }
}
