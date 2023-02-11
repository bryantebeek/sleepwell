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
            'theme'     => $this->getTheme(),
            'family'    => $this->getFamily(),
            'companion' => $this->getCompanion()
        ];
        $prompt         = $options['prompt'] ?? view('prompts.' . $promptTemplate, $variables)->render();
        $story          = $options['story'] ?? $this->getStory($prompt);

        if (config('openai.generate_summary')) {
            $paragraphs     = $options['paragraphs'] ?? $this->extractParagraphs($story);
            $formattedStory = implode("\n", $paragraphs);
            $storyBeats     = $this->makeBeats($paragraphs);
            $summaryPrompt  = $this->getStorySummaryPrompt($formattedStory);
            $summary        = $options['summary'] ?? $this->getStorySummary($summaryPrompt);
            if (config('openai.generate_beat_summary')) {
                foreach ($storyBeats as $key => $storyBeat) {
                    $storyBeat->summary_prompt = $this->getParagraphDescriptionsPrompt($storyBeat->paragraph);
                    $storyBeat->summary        = $this->getParagraphDescriptions($storyBeat->summary_prompt);

                    if (config('openai.generate_images')) {
                        $storyBeat->image = $this->getImage($summary . ' ' . $storyBeat->summary . ' picture book style with soft colours');
                    }
                }
            }
        }
        $this->story                 = new Story();
        $this->story->summary        = $summary ?? '';
        $this->story->summary_prompt = $summaryPrompt ?? '';
        $this->story->variables      = $variables;
        $this->story->prompt         = $prompt;
        $this->story->beats          = $storyBeats;
        $this->story->user()->associate($this->user);
        $this->story->save();
    }

    private function getCompanion()
    {
        if (random_int(0, 3) !== 3) {
            return '';
        }

        return 'To make it complete, ' . Arr::random([
                $this->user->profile['companion1'],
                $this->user->profile['companion2']
            ]) . ' is with them. ';
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
            'max_tokens'  => 2048,
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
                'summary'   => '',
                'image'     => '',
            ];
        });
    }

    private function getParagraphDescriptionsPrompt($story)
    {
        return "“””\n" . $story . "\n“””\nGive main action in 5 words. No names.";
    }

    private function getParagraphDescriptions($story)
    {
        $prompt = "“””\n" . $story . "\n“””\nGive main action in 5 words. No names.";
        //dd($prompt);
        $result = OpenAI::completions()->create([
            'model'       => 'text-davinci-003',
            'prompt'      => $prompt,
            'max_tokens'  => 256,
            'temperature' => 0.7,
            'user'        => '' . $this->user->id
        ]);

        return $result['choices'][0]['text'];
    }

    private function getStorySummaryPrompt($story)
    {
        return "“””\n" . $story . "\n“””\nGive the setting in 7 words or less as a prompt to draw.\n\n";
    }

    private function getStorySummary($prompt)
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

    private function getImage($prompt)
    {
        $response = OpenAI::images()->create([
            'prompt'          => $prompt,
            'n'               => 1,
            'size'            => config('openai.image_size'),
            'response_format' => 'url',
            'user'            => '' . $this->user->id
        ]);

        return $response['data'][0]['url'];
    }

}