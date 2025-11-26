<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $produtos = Produto::all();
        
        // Criar uma resposta com a view
        $response = response()->view('produtos.index', compact('produtos'));
        
        // Definir cookie com última visualização se não existir
        if (!$request->cookie('ultima_visita_produtos')) {
            $response->cookie('ultima_visita_produtos', now()->toDateTimeString(), 60*24*7); // 7 dias
        }
        
        // Se receber um parâmetro 'tema' via request, atualizar o cookie do tema
        if ($request->has('tema')) {
            $response->cookie('tema', $request->tema, 60*24*30); // 30 dias
        }
        
        return $response;
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'preco' => 'required|numeric|min:0.01',
            'quantidade' => 'required|integer|min:0',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('produtos', 'public');
            $data['imagem'] = $imagePath;
        }

        Produto::create($data);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    public function show($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.show', compact('produto'));
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'preco' => 'required|numeric|min:0.01',
            'quantidade' => 'required|integer|min:0',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $produto = Produto::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('imagem')) {
            // Remove imagem antiga se existir
            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }
            $imagePath = $request->file('imagem')->store('produtos', 'public');
            $data['imagem'] = $imagePath;
        }

        $produto->update($data);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        
        // Remove imagem se existir
        if ($produto->imagem) {
            Storage::disk('public')->delete($produto->imagem);
        }
        
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}