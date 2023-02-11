<?php

namespace App\Http\Livewire;

use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StoryViewer extends Component
{
    public Story $story;
    public       $step     = 0;
    public       $generate = false;
    public       $beats;

    protected $listeners = ['startGenerate' => 'generateStory'];

    public function generateStory()
    {
        if ($this->generate) {
            new \App\Services\GenerateStory($this->story, auth()->user(), []);
            $this->generate = false;
        }
    }
    public function mount()
    {
        if ($this->story->prompt === '') {
            $this->generate = true;
        }
    }

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
