<?php

namespace App\Livewire;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\note;
use Livewire\Component;




class ResultatEleve extends Component
{

    public  $matricule;
    public $notesWithPivot;


    public function valider()
    {

        $this->validate(['matricule' => 'required']);

        try {

            $eleve = Eleve::where('id', $this->matricule)->exists();

            if ($eleve) {


                $eleveChhose = Eleve::where('id', $this->matricule)->first();

                $classe = Classe::find($eleveChhose->classe->id); // Remplacez 1 par l'ID de la classe que vous utilisez

                $notesWithPivot = [];



                foreach ($classe->matieres as $matiere) {
                    $pivotNote = $matiere->pivot->note;

                    $notes = note::where('eleve_id', $eleveChhose->id)
                        ->where('matiere_id', $matiere->id)
                        ->first();

                    $notesWithPivot[] = [
                        'matiere' => $matiere->nom_matiere,
                        'pivotNote' => $pivotNote,
                        'notes' => $notes ? ($notes->note ? $notes->note : 'Vide') : 'Vide',
                    ];
                }

                $this->notesWithPivot = $notesWithPivot;
            } else {

                $this->dispatch('error');
            }
        } catch (\Exception $e) {


            dd($e->getMessage());
            $this->dispatch('error');
        }
    }


    public function getResultat()
    {

        try {

            $eleve = Eleve::where('id', $this->matricule)->exists();

            if ($eleve) {


                $eleveChhose = Eleve::where('id', $this->matricule)->first();

                $classe = Classe::find($eleveChhose->classe->id); // Remplacez 1 par l'ID de la classe que vous utilisez

                $notesWithPivot = [];



                foreach ($classe->matieres as $matiere) {
                    $pivotNote = $matiere->pivot->note;

                    $notes = note::where('eleve_id', $this->eleve)
                        ->where('matiere_id', $matiere->id)
                        ->first();

                    $notesWithPivot[] = [
                        'matiere' => $matiere->nom_matiere,
                        'pivotNote' => $pivotNote,
                        'notes' => $notes ? ($notes->note ? $notes->note : 'Vide') : 'Vide',
                    ];
                }

                $this->notesWithPivot = $notesWithPivot;
            } else {

                $this->dispatch('error');
            }
        } catch (\Exception $e) {

            $this->dispatch('error');
        }
    }
    public function render()
    {
        return view('livewire.resultat-eleve')->layout('layouts.app-layout');
    }
}