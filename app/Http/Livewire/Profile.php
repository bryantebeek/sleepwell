<?php

namespace App\Http\Livewire;

use App\Models\Story;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class Profile extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public function mount(): void
    {
        $user = auth()->user();

        $this->form->fill($user->profile);
    }

    public function render(): View
    {
        return view('livewire.profile');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $user = auth()->user();

        $validatedData = $this->validate();

        $pronoun                  = trim(Str::lower($validatedData['pronoun'] ?? 'he'));
        $validatedData['boyGirl'] = $pronoun === 'he' ? 'boy' : 'girl';
        $validatedData['hisHer']  = $pronoun === 'he' ? 'his' : 'her';

        $user->profile = $validatedData;
        $user->save();

        $story = new Story();
        $story->user()->associate($user);
        $story->beats  = [];
        $story->prompt = '';
        $story->save();
        $this->redirect(route('stories.view', $story));
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Wizard::make([
                Forms\Components\Wizard\Step::make('name')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('What is your name?')
                            ->required(),
                        Forms\Components\Radio::make('pronoun')
                            ->label('How should we call you?')
                            ->options(['she' => 'she', 'he' => 'he'])
                            ->inline()
                            ->required(),
                        Forms\Components\Radio::make('age')
                            ->label('How old are you?')
                            ->options(array_combine(range(1, 6), range(1, 6)))
                            ->inline()
                            ->required(),
                    ]),
                Forms\Components\Wizard\Step::make('family')
                    ->description('Tell us about two of your family members, do not forget about grandma!')
                    ->schema([
                        Forms\Components\TextInput::make('family1')
                            ->label('Tell us about a family member')
                            ->helperText('For example: mom Elie')
                            ->required(),
                        Forms\Components\TextInput::make('family2')
                            ->label('Is there another person we should know about?')
                            ->helperText('For example: brother Luke / niece Sophia'),
                    ]),
                Forms\Components\Wizard\Step::make('animal')
                    ->label('Stuffed-animal/Pet')
                    ->schema([
                        Forms\Components\TextInput::make('companion1')
                            ->label('Describe your favorite toy or stuffed animal')
                            ->helperText('For example: stuffed rabbit Bobby / puppet doll Marie'),
                        Forms\Components\TextInput::make('companion2')
                            ->label('Do you have a pet?')
                            ->helperText('For example: dog Brunno / cat Simba'),
                    ]),
            ])
                ->submitAction(view('profile.submit_button')),
        ];
    }

}
