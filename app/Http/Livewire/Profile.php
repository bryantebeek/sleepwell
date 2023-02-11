<?php

namespace App\Http\Livewire;

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


    private function isBoyOrGirl($pronoun)
    {
        return trim(Str::lower($pronoun ?? 'he')) === 'he' ? 'boy' : 'girl';
    }

    public function submit()
    {
        $user                     = auth()->user();
        $validatedData            = $this->validate();
        $pronoun                  = trim(Str::lower($validatedData['pronoun'] ?? 'he'));
        $validatedData['boyGirl'] = $pronoun === 'he' ? 'boy' : 'girl';
        $validatedData['hisHer']  = $pronoun === 'he' ? 'his' : 'her';
        $user->profile            = $validatedData;
        $user->save();
    }

    protected function getFormSchema(): array
    {
        return [

            Forms\Components\Wizard::make([
                Forms\Components\Wizard\Step::make('name')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                    ]),
                Forms\Components\Wizard\Step::make('age')
                    ->schema([
                        Forms\Components\TextInput::make('age')
                            ->numeric()
                            ->required(),
                    ]),
                Forms\Components\Wizard\Step::make('pronoun')
                    ->schema([
                        Forms\Components\Select::make('pronoun')
                            ->options(['he', 'she'])
                            ->required(),
                    ]),
                Forms\Components\Wizard\Step::make('family')
                    ->description('Describe two of your family members, do not forget about grandma!')
                    ->schema([
                        Forms\Components\TextInput::make('family1')
                            ->label('Family member')
                            ->helperText('For example: Mom Elie')
                            ->required(),
                        Forms\Components\TextInput::make('family2')
                            ->label('Family member')
                            ->label('Stuffed-animal or pet')
                            ->helperText('For example: Brother Luke')
                            ->required(),
                    ]),
                Forms\Components\Wizard\Step::make('animal')
                    ->label('Stuffed-animal/Pet')
                    ->schema([
                        Forms\Components\TextInput::make('animal1')
                            ->label('Stuffed-animal or pet')
                            ->helperText('For example: Rabbit Bobby')
                            ->required(),
                        Forms\Components\TextInput::make('animal2')
                            ->label('Stuffed-animal or pet')
                            ->helperText('For example: Dog Brunno')
                            ->required(),
                    ]),
            ])
                ->skippable()
                ->submitAction(new HtmlString('<button type="submit" class="filament-button filament-button-size-sm">Get me a story</button>')),
            //Forms\Components\Repeater::make('family')
            //    ->schema([
            //        Forms\Components\Select::make('role')
            //            ->options([
            //                'mom'    => 'Mom',
            //                'dad'    => 'Dad',
            //                'sister' => 'Sister',
            //            ])
            //            ,
            //        Forms\Components\TextInput::make('name'),
            //    ])
            //    ->columns(2),
            //Forms\Components\Repeater::make('pets')
            //    ->schema([
            //        Forms\Components\TextInput::make('animal'),
            //        Forms\Components\TextInput::make('name'),
            //
            //    ])
            //    ->columns(2),
            //Forms\Components\Repeater::make('stuffed-animals')
            //    ->schema([
            //        Forms\Components\TextInput::make('animal'),
            //        Forms\Components\TextInput::make('name'),
            //
            //    ])
            //    ->columns(2),
            //Forms\Components\TagsInput::make('character-traits'),
            //Forms\Components\TextInput::make('fandom'),
        ];
    }

}
