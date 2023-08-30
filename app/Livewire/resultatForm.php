<?php

namespace App\Livewire;

use App\Models\Classe;
use App\Models\classeMatiere;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\note as ModelsNote;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Storage;

use Filament\Forms\Components\{TextInput, RichEditor, MarkdownEditor, Select, Toggle, FileUpload, Section};

use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Laravel\Prompts\Note;

class resultatForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $classe;
    public $eleve;
    public $notesWithPivot;
    public $matiere;
    public $noteEleve;

    protected $listeners = ['refresh' => 'updatedEleve'];

    public function mount(): void
    {


        $this->classeForm->fill();
    }


    public function create(): void
    {
        // $data = $this->form->getState();

        // $record = Eleve::create($data);

        // $this->form->model($record)->saveRelationships();
    }

    protected function getForms(): array
    {
        return [
            'classeForm',
            'addResult',

        ];
    }

    public function addResult(Form $form): Form
    {
        return $form->schema([
            Grid::make([

                'sm' => 1,
                'md' => 2,

            ])->schema([
                Select::make('matiere')->label('Matiere')
                    ->options(fn (Get $get): Collection => Matiere::query()
                        ->whereHas('classes', function ($q) {
                            $q->where('classe_id', $this->classe);
                        })
                        ->pluck('nom_matiere', 'id'))
                    ->searchable()
                    ->live()
                    ->native(false),
                TextInput::make('noteEleve')->required(),
            ])
        ]);
    }

    public function classeForm(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([

                    'sm' => 1,
                    'md' => 2,

                ])->schema([
                    Select::make('classe')->label('Classe')
                        ->options(Classe::query()->pluck('niveau', 'id'))
                        ->live()
                        ->searchable()
                        ->native(false),

                    Select::make('eleve')->label('Eleve')
                        ->options(fn (Get $get): Collection => Eleve::query()
                            ->where('classe_id', $get('classe'))
                            ->pluck('nom', 'id'))
                        ->searchable()
                        ->live()
                        ->required()
                        ->native(false),





                ]),





                // ...
            ]);
    }

    public function updatedEleve()
    {
        $this->notesWithPivot = $this->getResultat();
    }

    public function render(): View
    {
        return view('livewire.resultat-form', ['notesWithPivot' => $this->notesWithPivot]);
    }

    public function getResultat()
    {



        $classe = Classe::find($this->classe); // Remplacez 1 par l'ID de la classe que vous utilisez

        $notesWithPivot = [];

        try {

            foreach ($classe->matieres as $matiere) {
                $pivotNote = $matiere->pivot->note;

                $notes = ModelsNote::where('eleve_id', $this->eleve)
                    ->where('matiere_id', $matiere->id)
                    ->first();

                $notesWithPivot[] = [
                    'matiere' => $matiere->nom_matiere,
                    'pivotNote' => $pivotNote,
                    'notes' => $notes ? ($notes->note ? $notes->note : 'Vide') : 'Vide',
                ];
            }

            return $notesWithPivot;
        } catch (\Exception $e) {
        }
    }

    public function newNote()
    {

        $this->addResult->validate();
        $this->classeForm->validate();

        $note = $this->addResult->getState();

        $data = ['eleve_id' => $this->eleve, 'matiere_id' => $this->matiere, 'note' => $note['noteEleve']];

        $notes = ModelsNote::where('eleve_id', $this->eleve)
            ->where('matiere_id', $this->matiere)
            ->exists();



        try {

            if ($notes) {

                dd($notes);
            } else {
                $data = ModelsNote::Create($data);



                $this->dispatch('refresh');
            }
        } catch (\Exception $e) {

            dd($e->getMessage());
        }
    }
}