<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('story')->with('showNavigation', false);
})->middleware('auth')->name('story');

Route::get('about-php', function () {
    $result = OpenAI::completions()->create([
        'model'  => 'text-davinci-003',
        'prompt' => 'PHP is',
    ]);
    dd($result);
});
Route::get('random-prompts', function () {
    $prompts    = Cache::get('prompts');
    $promptName = rtrim(Arr::random($prompts), ".blade.php");
    $this->user = auth()->user();

    $prompt = view('prompts.' . $promptName, $this->user->profile)->render();
    dd($prompt);
});

Route::get('generate-story', function () {

    $storyGenerator = new \App\Services\GenerateStory(
        auth()->user(),
        [
//            'story'=>'The train ride was long and tiring, but the excitement of James and his brother Luke was palpable. James couldn’t wait to explore the new world outside the window. Click-clack, click-clack, went the wheels of the train. He stuck his head out and felt the wind on his face. “Weeeee!” he shouted. His brother Luke just smiled and shook his head.
//
//James couldn’t help but want to join the birds who were flying by. He jumped up and down and waved his arms wildly, hoping to take off. Luke smiled and just watched.
//
//James noticed a few passengers looking out at him, but he didn’t care. He was lost in his own world. He made funny faces, blew raspberries, and pretended to be a superhero. Luke laughed and started to join in on the fun.
//
//The train ride was full of laughter and silliness. James and Luke created a whole new world on the train, and the miles flew by in no time. Click-clack, click-clack, went the wheels of the train.'
        ]
    );
    dd($storyGenerator->story);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
