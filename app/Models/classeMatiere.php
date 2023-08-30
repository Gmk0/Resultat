<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classeMatiere extends Model
{
    use HasFactory;

    public function  classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function  matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}