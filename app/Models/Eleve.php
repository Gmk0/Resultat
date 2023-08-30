<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'postnom', 'prenom', 'date_naissance', 'lieu_naissance', 'sexe', 'addresse', 'classe_id'];



    public function notes()
    {
        return $this->hasMany(note::class);
    }
    public function classe(): BelongsTo
    {

        return $this->belongsTo(Classe::class);
    }
}