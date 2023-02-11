<?php

namespace App\Services;


use App\Models\Story;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use OpenAI\Laravel\Facades\OpenAI;

class GenerateStory
{
    public $story;
    public $user;

    function __construct(User $user, array $options)
    {
        $this->user     = $user;
        $promptTemplate = $options['promptTemplate'] ?? $this->getRandomStoryPrompt();
        $variables      = [
            ...$this->user->profile,
                           'theme' => $this->getTheme(),
                           'family' => $this->getFamily()
        ];
        $prompt         = $options['prompt'] ?? view('prompts.' . $promptTemplate, $variables)->render();
        $story          = $options['story'] ?? $this->getStory($prompt);

        $paragraphs = $options['paragraphs'] ?? $this->extractParagraphs($story);

        $storyBeats = $this->makeBeats($paragraphs);
        //$this->getImages();
        dd($variables, $prompt, $story,$paragraphs,$storyBeats);
        $this->story         = new Story();
        $this->story->prompt = $prompt;
        $this->story->beats  = $storyBeats;
        $this->story->user()->associate($this->user);
        $this->story->save();
    }

    private function getFamily()
    {
        return Arr::random([
            $this->user->profile['family1'],
            $this->user->profile['family2']
        ]);
    }

    private function getTheme()
    {
        return Arr::random([
            'in the train',
            'on the beach',
            'in the playground',
            'in the kitchen',
            'at an amusement park',
            'on the bike',
            'in the car',
            'in the zoo',
            'in the forest',
            'at the park',
            'in the city',
            'on a farm',
            'on holiday',
            'in space',
            'in the supermarket'
        ]);
    }

    private function getRandomStoryPrompt()
    {
        $prompts = Cache::get('prompts');

        return rtrim(Arr::random($prompts), ".blade.php");
    }

    private function getStory($prompt)
    {
        $result = OpenAI::completions()->create([
            'model'       => 'text-davinci-003',
            'prompt'      => $prompt,
            'max_tokens'  => 256,
            'temperature' => 0.7,
            'user'        => '' . $this->user->id
        ]);

        return $result['choices'][0]['text'];
    }

    private function extractParagraphs($story)
    {
        $paragraphs = explode("\n", $story);
        $paragraphs = array_values(array_filter($paragraphs));

        return $paragraphs;
    }

    private function makeBeats($paragraphs)
    {
        return collect($paragraphs)->map(function ($item, $key) {
            return (object)[
                'id'        => $key,
                'paragraph' => $item,
                'image'     => '',
            ];
        });
    }

    private function getImages()
    {
        foreach ($this->story->storyBeats as $key => $storyBeat) {
            $response         = OpenAI::images()->create([
                'prompt'          => 'In childrens book style. ' . $storyBeat->paragraph,
                'n'               => 1,
                'size'            => config('openai.image_size'),
                'response_format' => 'url',
                'user'            => '' . $this->user->id
            ]);
            $storyBeat->image = $response['data'][0]['url'];
        }
    }

}