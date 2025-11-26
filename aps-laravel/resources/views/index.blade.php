@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Produtos</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-3">
                <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                    ➕ Novo Produto
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produtos as $produto)
                        <tr>
                            <td>{{ $produto->id }}</td>
                            <td>
                                @if($produto->imagem)
                                    <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                         alt="{{ $produto->nome }}" 
                                         width="50" height="50" 
                                         style="object-fit: cover;">
                                @else
                                    <span class="text-muted">Sem imagem</span>
                                @endif
                            </td>
                            <td>{{ $produto->nome }}</td>
                            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                            <td>
                                <span class="badge 
                                    @if($produto->quantidade == 0) bg-danger
                                    @elseif($produto->quantidade < 10) bg-warning
                                    @else bg-success @endif">
                                    {{ $produto->quantidade }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('produtos.show', $produto->id) }}" 
                                   class="btn btn-sm btn-info">👁️ Ver</a>
                                <a href="{{ route('produtos.edit', $produto->id) }}" 
                                   class="btn btn-sm btn-warning">✏️ Editar</a>
                                <form action="{{ route('produtos.destroy', $produto->id) }}" 
                                      method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Tem certeza?')">
                                        🗑️ Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection