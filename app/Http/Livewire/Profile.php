<?php

namespace App\Http\Livewire;

use App\Models\Story;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
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

        $pronoun = trim(Str::lower($validatedData['pronoun'] ?? 'he'));
        $validatedData['boyGirl'] = $pronoun === 'he' ? 'boy' : 'girl';
        $validatedData['hisHer'] = $pronoun === 'he' ? 'his' : 'her';

        $user->profile = $validatedData;
        $user->save();

        $this->story                 = new Story();

        //new \App\Services\GenerateStory($user, []);

        $this->redirect(route('stories.index'));
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
                            ->required(),
                        Forms\Components\Radio::make('age')
                            ->label('How old are you?')
                            ->options(array_combine(range(1, 6), range(1, 6)))
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
                            ->label('Describe your favorite stuffed animal')
                            ->helperText('For example: stuffed rabbit Bobby / stuffed giraf Charlie'),
                        Forms\Components\TextInput::make('companion2')
                            ->label('Do you have a pet?')
                            ->helperText('For example: dog Brunno / cat Simba'),
                    ]),
            ])
                ->submitAction(view('profile.submit_button')),
        ];
    }

}
