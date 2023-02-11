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
                'paragraph' => 'The train ride was long and tiring, but the excitement of James and his brother Luke was palpable. James couldn’t wait to explore the new world outside the window. Click-clack, click-clack, went the wheels of the train. He stuck his head out and felt the wind on his face. “Weeeee!” he shouted. His brother Luke just smiled and shook his head.',
                'image' => 'https://uce9405c67243a4b45031faf8719.previews.dropboxusercontent.com/p/thumb/ABxT1T9Dyhv2E_THMYKHboKgACG_GpDGA92nOQH3H5dpY5nkog8w2Om9Z_Fi87Cg6kr6eegBSZMQCgzbs_MbzV1of-vw_DKYI0ooB4RWp2I2jJt1Qu9KIQRQTIYMPYxIPZlrBiVXKTGlWaNegbGVtjyse-iWrvU1LjTakdBFMmVXW0I23M9l8afhmM7V-FE_trZyCwttuE2OmoScIN5JHAYZ3AOgEaIFAOCx4kwbnXJ2u2gnWAZ309vL2YwZzVxsww-Kh6ohzIYoFkxkcYAPdG32sI_YlNXB5iuT5nE54LpCoeB7UxLgfWPtGkIBsk6IzNPn0f8vAEPjzDN9feOwbkNfzgRhgeZKxjUjAhQQIdxMWBpXoD3GunuPrBQ_HFi_eu8/p.png'
            ],
            [
                'paragraph' => 'James couldn’t help but want to join the birds who were flying by. He jumped up and down and waved his arms wildly, hoping to take off. Luke smiled and just watched.',
                'image' => 'https://ucaa3fdba19f9957e53ed1cc083b.previews.dropboxusercontent.com/p/thumb/ABzDwb62T_UU0GSdH3oviQoqd7gTow5ENAQEUUtajKXu_IRg5d3rRQASCVqsuSELW1UydnqzHf_PG8ke7tLA5TjCJT_g32tFVMeNAchaJ9gu5eUJcV3g9DgzW55gi2PgPMvOZauW6E4h9Y6Ro-LQ6fDU57q6hzk-90j39_3JdisqrrRfGBLa3__jN0sOGqltAQFEDawUDIyNZsq5WxGrd_DZ5OtyuiYg1Bh5JUoqsSK6SOIJimLRJVDXE_tPC7x709PiiaL042debZbHvWGb3c87pZgrWlE6PBEZrSXJiFXtXayB_RQytlVQez1YplkVP5dMjYm8vouNd8eZ5QFlS4L_1NseQ-Rui02V8jD9q9mn9nGA-HP335ddlime4KG0HPM/p.png'
            ],
            [
                'paragraph' => 'James noticed a few passengers looking out at him, but he didn’t care. He was lost in his own world. He made funny faces, blew raspberries, and pretended to be a superhero. Luke laughed and started to join in on the fun.',
                'image' => 'https://uc047d47c105b16b7061d1faee36.previews.dropboxusercontent.com/p/thumb/ABz8qQHd5SN3UytiIi5uF3yIRrWmjT8_StYYRewMzmJVY_1GWAmPisIzEx9D7EmIKdqqvNS25935jugdd54dnvFXauVFtVNq1pxFNEW1_yb3QQfTzfxbkIc-yOwzNCbTrYN4b8_Tph_CLD6ts73DBx4yBnRW0qhwOuET_LFhfcJBemFjBC9z0flzLTQrshauYXDAuMUmu25KMZbHF70Hd4jAQ3zsv69V_ZeA-j6vK-ll-ppv59UjDjfO2YtpDcxk-jtJHKDMa1JYK0pgiuqph9wU8XY5tgoo3HwdSpme3xOWojMdfIe2nxtc16uRnN7jh5beYX7B_9VNIbiATBcsXMfO1-Qd_SAopbZSwnW5wQKUHok8Lni8ypMo6rnA0Es1w10/p.png'
            ],
            [
                'paragraph' => 'The train ride was full of laughter and silliness. James and Luke created a whole new world on the train, and the miles flew by in no time. Click-clack, click-clack, went the wheels of the train.',
                'image' => 'https://uc7be506e48d23fda931e973faa5.previews.dropboxusercontent.com/p/thumb/ABzPZKpzFYRo4W6pcyi-xSZjbDZxKnTNhl0xfOjJ93KQAcaQcLQ72Lva-thGYmecBopriQbG33s5xNyLoXpy32AxB_PBZ2LLvBayd7rxwegD-nEhfVkrVX2UdbxO0DfN4Fw8aF3hzZqXNblPXx1GqFJmm6qgUeFpmbs8MgMldiGvGFuge42D7Ftt582aFHJ8QLk8Rv3MIPytH1UKCmOPv5BTEv3RTjhRNzI2euYNdV3dS6RlzMuJmgv8Wk1YWbWHvT27t9IZIjxpWZ5FGOcLNdhL57sR3H6mBnT76xzBNTK40QXQJCMxLYkDBOUAlAbh3-aIX4bUb6kWd0l62yZ3GFU2gCVRnYHmz5vdpF-1tiWgPwC6taoOJEFdo66GA45hr78/p.png'
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

    public function finish()
    {
        $this->redirect(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.story-viewer')
            ->with('currentBeat', $this->beats->get($this->step));
    }
}
