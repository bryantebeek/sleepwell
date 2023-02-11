<?php

namespace App\Http\Livewire;

use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;
class StoryViewer extends Component
{
    private $user;

    private $storyBeats;
    private $currentBeat;

    public function mount()
    {
        $this->user = auth()->user();

        $prompt = view('prompts.prompt1', $this->user->profile)->render();

        $result = OpenAI::completions()->create([
            'model'       => 'text-davinci-003',
            'prompt'      => $prompt,
            'max_tokens'  => 256,
            'temperature' => 0.7,
            'user'        => '' . $this->user->id
        ]);

        $story = $result['choices'][0]['text'];
        echo '<pre>' . $story . '</pre>';

        $paragraphs = explode("\n", $story);
        $paragraphs = array_values(array_filter($paragraphs));

        $this->storyBeats = collect($paragraphs)
            ->map(function ($item, $key) {
                return (object)[
                    'id'        => $key,
                    'paragraph' => $item,
                    'image'     => '',
                ];
            });

        //
        foreach ($this->storyBeats as $key => $storyBeat) {
            //$response           = OpenAI::images()->create([
            //    'prompt'          => 'In childrens book style. ' . $storyBeat->paragraph,
            //    'n'               => 1,
            //    'size'            => config('openai.image_size'),
            //    'response_format' => 'url',
            //    'user'            => '' . $this->user->id
            //]);
            //$storyBeat->image = $response['data'][0]['url'];
        }
        dd($this->storyBeats);
        //dd($paragraphs);

    }

    public function render()
    {
        return view('livewire.story-viewer');
    }
}
