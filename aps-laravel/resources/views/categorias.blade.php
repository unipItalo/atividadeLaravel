<!DOCTYPE html>
<html>
<head>
    <title>Categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Categoria</h1>
        
        <!-- Formulário de Cadastro -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Cadastrar Novo Produto</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/produtos">
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição:</label>
                        <textarea class="form-control" id="descricao" name="descricao"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço:</label>
                        <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>

        <!-- Lista de Produtos -->
        <div class="card">
            <div class="card-header">
                <h5>Lista de Produtos</h5>
            </div>
            <div class="card-body">
                @if($produtos->count() > 0)
                    <ul class="list-group">
                        @foreach($produtos as $produto)
                            <li class="list-group-item">
                                <strong>{{ $produto->nome }}</strong> - 
                                R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                <br>
                                <small>{{ $produto->descricao }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Nenhum produto cadastrado.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>