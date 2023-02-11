<?php

namespace App\Http\Livewire;

use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Stories extends Component
{
    public array $stories;

    public function mount()
    {
        $this->stories = Auth::check() ? Auth::user()->stories()->orderByDesc('id')->get()->all() : Story::orderByDesc('id')->get()->all();
    }

    public function new()
    {
        $user = Auth::user();

        if (!$user->profile) {
            session()->flash('message', 'You have to complete your profile first to make your first story.');

            $this->redirect(route('dashboard'));

            return;
        }

        new \App\Services\GenerateStory($user, []);

        $this->redirect(route('stories.index'));
    }

    public function render()
    {
        return view('livewire.stories');
    }
}
