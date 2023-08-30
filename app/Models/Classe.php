<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['niveau', 'enseignant_id'];

    public function enseignant(): BelongsTo
    {

        return $this->belongsTo(Enseignant::class);
    }

    public function eleves()
    {

        return $this->hasMany(Eleve::class);
    }

    public  function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'classe_matieres')
            ->withPivot('note')
            ->withTimestamps();
    }
}
