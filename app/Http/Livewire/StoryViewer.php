<?php

namespace App\Http\Livewire;

use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;

class StoryViewer extends Component
{
    public Story $story;
    public $step = 0;
    public $beats;

    public function next()
    {
        $this->step += 1;
    }

    public function previous()
    {
        $this->step -= 1;
    }

    public function finish()
    {
        $this->redirect(Auth::check() ? route('stories.index') : route('welcome'));
    }

    public function render()
    {
        return view('livewire.story-viewer')
            ->with('currentBeat', collect($this->story->beats)->get($this->step));
    }
}
