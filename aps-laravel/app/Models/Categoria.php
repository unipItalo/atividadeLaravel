<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'imagem'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Relacionamento com produtos (opcional)
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}