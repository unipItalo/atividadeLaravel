<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::all();
        
        // Criar uma resposta com a view
        $response = response()->view('categorias.index', compact('categorias'));
        
        // Definir cookie com última visualização se não existir
        if (!$request->cookie('ultima_visita_categorias')) {
            $response->cookie('ultima_visita_categorias', now()->toDateTimeString(), 60*24*7); // 7 dias
        }
        
        return $response;
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:categorias',
            'descricao' => 'nullable|string|max:500',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('categorias', 'public');
            $data['imagem'] = $imagePath;
        }

        Categoria::create($data);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria cadastrada com sucesso!');
    }

    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.show', compact('categoria'));
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:categorias,nome,' . $id,
            'descricao' => 'nullable|string|max:500',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $categoria = Categoria::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('imagem')) {
            // Remove imagem antiga se existir
            if ($categoria->imagem) {
                Storage::disk('public')->delete($categoria->imagem);
            }
            $imagePath = $request->file('imagem')->store('categorias', 'public');
            $data['imagem'] = $imagePath;
        }

        $categoria->update($data);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        
        // Remove imagem se existir
        if ($categoria->imagem) {
            Storage::disk('public')->delete($categoria->imagem);
        }
        
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}