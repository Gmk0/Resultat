<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'addrese'];


    public function classe()
    {

        return $this->hasOne(Classe::class);
    }
}
