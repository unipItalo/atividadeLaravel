<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias', compact('categorias'));
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255|unique:categorias',
            'descricao' => 'nullable|string|max:500',
        ]);

        // Criar a categoria no banco de dados
        Categoria::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        // Redirecionar de volta com mensagem de sucesso
        return redirect('/categorias')->with('success', 'Categoria cadastrada com sucesso!');
    }
}