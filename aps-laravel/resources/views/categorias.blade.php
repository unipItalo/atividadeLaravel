<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .success-message {
            animation: fadeOut 3s ease-in-out forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            70% { opacity: 1; }
            100% { opacity: 0; display: none; }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">📁 Gerenciamento de Categorias</h1>
                
                <!-- Mensagens de Sucesso/Erro -->
                @if(session('success'))
                    <div class="alert alert-success success-message" role="alert">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>❌ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Formulário de Cadastro -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">➕ Cadastrar Nova Categoria</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/categorias">
                            @csrf
                            <div class="mb-3">
                                <label for="nome" class="form-label">
                                    <strong>Nome da Categoria:</strong>
                                </label>
                                <input type="text" class="form-control" id="nome" name="nome" 
                                       value="{{ old('nome') }}" 
                                       placeholder="Ex: Eletrônicos, Roupas, Livros..." 
                                       required maxlength="255">
                                <div class="form-text">O nome deve ser único no sistema.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="descricao" class="form-label">
                                    <strong>Descrição:</strong>
                                </label>
                                <textarea class="form-control" id="descricao" name="descricao" 
                                          rows="3" placeholder="Descreva brevemente esta categoria..."
                                          maxlength="500">{{ old('descricao') }}</textarea>
                                <div class="form-text">Máximo 500 caracteres.</div>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100">
                                💾 Salvar Categoria
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de Categorias -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">📋 Lista de Categorias Cadastradas</h5>
                    </div>
                    <div class="card-body">
                        @if($categorias->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Descrição</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categorias as $categoria)
                                            <tr>
                                                <td><strong>#{{ $categoria->id }}</strong></td>
                                                <td>{{ $categoria->nome }}</td>
                                                <td>
                                                    @if($categoria->descricao)
                                                        {{ Str::limit($categoria->descricao, 50) }}
                                                    @else
                                                        <span class="text-muted">Sem descrição</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" 
                                                            onclick="editarCategoria({{ $categoria->id }})">
                                                        ✏️ Editar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-3">
                                <p class="text-muted">
                                    <strong>Total:</strong> {{ $categorias->count() }} categoria(s)
                                </p>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="text-muted mb-2">
                                    <i style="font-size: 48px;">📭</i>
                                </div>
                                <h5>Nenhuma categoria cadastrada</h5>
                                <p class="text-muted">Use o formulário ao lado para cadastrar a primeira categoria.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Links de Navegação -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <div class="btn-group" role="group">
                    <a href="/produtos" class="btn btn-outline-primary">
                        🛍️ Ir para Produtos
                    </a>
                    <a href="/" class="btn btn-outline-secondary">
                        🏠 Página Inicial
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript para funcionalidades extras -->
    <script>
        // Função placeholder para edição (pode ser expandida depois)
        function editarCategoria(id) {
            alert('Funcionalidade de edição para categoria ID: ' + id + '\n(Pode ser implementada como extensão)');
        }

        // Auto-hide das mensagens de sucesso
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const successMessages = document.querySelectorAll('.success-message');
                successMessages.forEach(function(msg) {
                    msg.style.display = 'none';
                });
            }, 3000);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>