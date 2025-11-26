@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Cadastrar Novo Produto</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- NOTE: enctype="multipart/form-data" é ESSENCIAL para upload de arquivos -->
            <form method="POST" action="{{ route('produtos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Produto:</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ old('descricao') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço (R$):</label>
                            <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="{{ old('preco') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade:</label>
                            <input type="number" class="form-control" id="quantidade" name="quantidade" value="{{ old('quantidade', 0) }}" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="imagem" class="form-label">Imagem do Produto (PNG/JPG):</label>
                    <input type="file" class="form-control" id="imagem" name="imagem" accept=".png,.jpg,.jpeg">
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection