<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos', compact('produtos'));
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'preco' => 'required|numeric|min:0.01',
            'quantidade' => 'required|integer|min:0',
        ]);

        // Criar o produto no banco de dados
        Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'quantidade' => $request->quantidade,
        ]);

        // Redirecionar de volta com mensagem de sucesso
        return redirect('/produtos')->with('success', 'Produto cadastrado com sucesso!');
    }
}