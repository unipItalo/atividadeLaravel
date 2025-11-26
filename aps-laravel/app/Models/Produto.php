<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'quantidade',
        'imagem'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getPrecoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

    public function getStatusEstoqueAttribute()
    {
        if ($this->quantidade == 0) {
            return 'Esgotado';
        } elseif ($this->quantidade < 10) {
            return 'Estoque Baixo';
        } else {
            return 'Em Estoque';
        }
    }

    // Relacionamento com categoria (opcional)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}