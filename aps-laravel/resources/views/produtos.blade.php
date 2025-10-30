<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos</title>
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
        .estoque-baixo { color: #ffc107; font-weight: bold; }
        .estoque-esgotado { color: #dc3545; font-weight: bold; }
        .estoque-normal { color: #198754; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">🛍️ Gerenciamento de Produtos</h1>
                
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
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">📦 Cadastrar Novo Produto</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/produtos">
                            @csrf
                            <div class="mb-3">
                                <label for="nome" class="form-label">
                                    <strong>Nome do Produto:</strong>
                                </label>
                                <input type="text" class="form-control" id="nome" name="nome" 
                                       value="{{ old('nome') }}" 
                                       placeholder="Ex: Smartphone, Camiseta, Livro..." 
                                       required maxlength="255">
                            </div>
                            
                            <div class="mb-3">
                                <label for="descricao" class="form-label">
                                    <strong>Descrição:</strong>
                                </label>
                                <textarea class="form-control" id="descricao" name="descricao" 
                                          rows="3" placeholder="Descreva o produto..."
                                          maxlength="500">{{ old('descricao') }}</textarea>
                                <div class="form-text">Máximo 500 caracteres.</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="preco" class="form-label">
                                            <strong>Preço (R$):</strong>
                                        </label>
                                        <input type="number" step="0.01" class="form-control" id="preco" name="preco" 
                                               value="{{ old('preco') }}" 
                                               placeholder="0.00" min="0.01" required>
                                        <div class="form-text">Preço unitário.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quantidade" class="form-label">
                                            <strong>Quantidade:</strong>
                                        </label>
                                        <input type="number" class="form-control" id="quantidade" name="quantidade" 
                                               value="{{ old('quantidade', 0) }}" 
                                               min="0" required>
                                        <div class="form-text">Quantidade em estoque.</div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100">
                                💾 Salvar Produto
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de Produtos -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">📋 Lista de Produtos Cadastrados</h5>
                    </div>
                    <div class="card-body">
                        @if($produtos->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Preço</th>
                                            <th>Estoque</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($produtos as $produto)
                                            <tr>
                                                <td><strong>#{{ $produto->id }}</strong></td>
                                                <td>
                                                    <strong>{{ $produto->nome }}</strong>
                                                    @if($produto->descricao)
                                                        <br><small class="text-muted">{{ Str::limit($produto->descricao, 30) }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ $produto->quantidade }} un
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        $statusClass = 'estoque-normal';
                                                        if ($produto->quantidade == 0) {
                                                            $statusClass = 'estoque-esgotado';
                                                        } elseif ($produto->quantidade < 10) {
                                                            $statusClass = 'estoque-baixo';
                                                        }
                                                    @endphp
                                                    <span class="{{ $statusClass }}">
                                                        @if($produto->quantidade == 0)
                                                            ❌ Esgotado
                                                        @elseif($produto->quantidade < 10)
                                                            ⚠️ Baixo
                                                        @else
                                                            ✅ Normal
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" 
                                                            onclick="editarProduto({{ $produto->id }})">
                                                        ✏️ Editar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-3">
                                @php
                                    $totalEstoque = $produtos->sum('quantidade');
                                    $totalValor = $produtos->sum(function($produto) {
                                        return $produto->preco * $produto->quantidade;
                                    });
                                @endphp
                                <p class="text-muted">
                                    <strong>Total de produtos:</strong> {{ $produtos->count() }}<br>
                                    <strong>Total em estoque:</strong> {{ $totalEstoque }} unidades<br>
                                    <strong>Valor total:</strong> R$ {{ number_format($totalValor, 2, ',', '.') }}
                                </p>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="text-muted mb-2">
                                    <i style="font-size: 48px;">📭</i>
                                </div>
                                <h5>Nenhum produto cadastrado</h5>
                                <p class="text-muted">Use o formulário ao lado para cadastrar o primeiro produto.</p>
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
                    <a href="/categorias" class="btn btn-outline-primary">
                        📁 Ir para Categorias
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
        // Função placeholder para edição
        function editarProduto(id) {
            alert('Funcionalidade de edição para produto ID: ' + id + '\n(Pode ser implementada como extensão)');
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

        // Formatação automática do preço
        document.getElementById('preco').addEventListener('blur', function(e) {
            let value = parseFloat(e.target.value);
            if (!isNaN(value)) {
                e.target.value = value.toFixed(2);
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>