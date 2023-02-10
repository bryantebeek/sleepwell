<?php

namespace App\Http\Livewire;

use Filament\Forms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Profile extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $name;
    public $age;
    public $gender;
    //public $family;
    //public $pets;
    //public $character;
    protected $rules = [
        'name'   => 'required|min:3',
        'age'    => 'required|numeric|min:2|max:20',
        'gender' => 'required',
    ];

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
        $user          = auth()->user();
        $validatedData = $this->validate();
        $user->profile = $validatedData;
        $user->save();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('age')->numeric(),
            Forms\Components\TextInput::make('gender'),
            //Forms\Components\Select::make('gender')
            //    ->options([
            //        'male' => 'Male',
            //        'female' => 'female'
            //    ]),
            Forms\Components\Repeater::make('family')
                ->schema([
                    Forms\Components\Select::make('role')
                        ->options([
                            'mom'    => 'Mom',
                            'dad'    => 'Dad',
                            'sister' => 'Sister',
                        ])
                        ,
                    Forms\Components\TextInput::make('name'),
                ])
                ->columns(2),
            Forms\Components\Repeater::make('pets')
                ->schema([
                    Forms\Components\TextInput::make('animal'),
                    Forms\Components\TextInput::make('name'),

                ])
                ->columns(2),
            Forms\Components\Repeater::make('stuffed-animals')
                ->schema([
                    Forms\Components\TextInput::make('animal'),
                    Forms\Components\TextInput::make('name'),

                ])
                ->columns(2),
            Forms\Components\TagsInput::make('character-traits'),
            Forms\Components\TextInput::make('fandom'),
        ];
    }

}
