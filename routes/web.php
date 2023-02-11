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
    return view('story');
});

Route::get('about-php', function () {
    $result = OpenAI::completions()->create([
        'model'  => 'text-davinci-003',
        'prompt' => 'PHP is',
    ]);
    dd($result);
});
Route::get('all-prompts', function () {
    $prompts    = Cache::get('prompts');
    $promptName = rtrim(Arr::random($prompts), ".blade.php");
    $this->user = auth()->user();

    $prompt = view('prompts.' . $promptName, $this->user->profile)->render();
    dd($prompt);
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
