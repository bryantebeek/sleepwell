<?php

namespace App\Http\Livewire;

use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;

class StoryViewer extends Component
{
    public $step = 0;
    public $beats;

    public function mount()
    {
        $this->beats = collect([
            [
                'paragraph' => 'Staas and Julius were walking in the park. Staas was so excited to explore the wonders of nature around him. He ran around and pointed out all the beautiful flowers, trees and animals nearby. Tick-tock, tick-tock! went the leaves as the wind blew through them. Staas was so amazed and excited that he started hopping from one rock to another. Julius watched him, shaking his head and smiling.',
                'image' => 'https://openailabsprodscus.blob.core.windows.net/private/user-VsJxpqkmjH8yvqfxj7nwuPCk/generations/generation-7g3RUvH72mKDKq1zXrbC1HJC/image.webp?st=2023-02-11T07%3A27%3A01Z&se=2023-02-11T09%3A25%3A01Z&sp=r&sv=2021-08-06&sr=b&rscd=inline&rsct=image/webp&skoid=15f0b47b-a152-4599-9e98-9cb4a58269f8&sktid=a48cca56-e6da-484e-a814-9c849652bcb3&skt=2023-02-11T06%3A12%3A20Z&ske=2023-02-18T06%3A12%3A20Z&sks=b&skv=2021-08-06&sig=wlz5Z0ToFFyxz%2Bugn24ylp0LYZoxn0ygJiXWZnWu2P8%3D'
            ],
            [
                'paragraph' => 'Staas\'s hopping quickly turned into jumping and he started leaping from rock to rock. His little face was filled with joy and excitement as he jumped higher and higher, each jump making a thump, thump, thump that echoed throughout the park. Julius was still watching, now laughing as Staas jumped from rock to rock.',
                'image' => 'https://openailabsprodscus.blob.core.windows.net/private/user-VsJxpqkmjH8yvqfxj7nwuPCk/generations/generation-euHSwbRWkYMwPW4Qp0NbxsLD/image.webp?st=2023-02-11T07%3A27%3A55Z&se=2023-02-11T09%3A25%3A55Z&sp=r&sv=2021-08-06&sr=b&rscd=inline&rsct=image/webp&skoid=15f0b47b-a152-4599-9e98-9cb4a58269f8&sktid=a48cca56-e6da-484e-a814-9c849652bcb3&skt=2023-02-11T06%3A12%3A33Z&ske=2023-02-18T06%3A12%3A33Z&sks=b&skv=2021-08-06&sig=KyjGjwUgkxAlCQYiAR05rKkc5gaJJW03k1d52IhUJ18%3D'
            ],
            [
                'paragraph' => 'Staas finally stopped and looked around, taking a moment to appreciate how beautiful the park was. Julius came over and put his arm around Staas, telling him that it was time to go home. Staas smiled and looked around one last time before they started walking home. Thump, thump, thump went their feet on the path as they made their way back home.',
                'image' => 'https://openailabsprodscus.blob.core.windows.net/private/user-VsJxpqkmjH8yvqfxj7nwuPCk/generations/generation-XY9Sd6ln02h6nGpCVT7yxEAq/image.webp?st=2023-02-11T07%3A30%3A33Z&se=2023-02-11T09%3A28%3A33Z&sp=r&sv=2021-08-06&sr=b&rscd=inline&rsct=image/webp&skoid=15f0b47b-a152-4599-9e98-9cb4a58269f8&sktid=a48cca56-e6da-484e-a814-9c849652bcb3&skt=2023-02-11T06%3A40%3A52Z&ske=2023-02-18T06%3A40%3A52Z&sks=b&skv=2021-08-06&sig=14%2BccCN1pDSL5fK2hFVM%2BqHUD3zyLFtwGv1w5dUgE8c%3D'
            ],
        ]);

//        $prompt = view('prompts.prompt1', $this->user->profile)->render();
//
//        $result = OpenAI::completions()->create([
//            'model'       => 'text-davinci-003',
//            'prompt'      => $prompt,
//            'max_tokens'  => 256,
//            'temperature' => 0.7,
//            'user'        => '' . $this->user->id
//        ]);
//
//        $story = $result['choices'][0]['text'];
//        echo '<pre>' . $story . '</pre>';
//
//        $paragraphs = explode("\n", $story);
//        $paragraphs = array_values(array_filter($paragraphs));
//
//        $this->storyBeats = collect($paragraphs)
//            ->map(function ($item, $key) {
//                return (object)[
//                    'id'        => $key,
//                    'paragraph' => $item,
//                    'image'     => '',
//                ];
//            });
//
//        //
//        foreach ($this->storyBeats as $key => $storyBeat) {
//            //$response           = OpenAI::images()->create([
//            //    'prompt'          => 'In childrens book style. ' . $storyBeat->paragraph,
//            //    'n'               => 1,
//            //    'size'            => config('openai.image_size'),
//            //    'response_format' => 'url',
//            //    'user'            => '' . $this->user->id
//            //]);
//            //$storyBeat->image = $response['data'][0]['url'];
//        }
//        dd($this->storyBeats);
        //dd($paragraphs);
    }

    public function next()
    {
        $this->step += 1;
    }

    public function previous()
    {
        $this->step -= 1;
    }

    public function render()
    {
        return view('livewire.story-viewer')
            ->with('currentBeat', $this->beats->get($this->step));
    }
}
