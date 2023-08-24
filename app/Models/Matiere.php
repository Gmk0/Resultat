<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = ['nom_matiere', 'note', 'classe_id'];

    protected $cast = ['id_classe' => 'integer'];



    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
