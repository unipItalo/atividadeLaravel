<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'descricao'
    ];

    // Campos que devem ser escondidos na serialização
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}