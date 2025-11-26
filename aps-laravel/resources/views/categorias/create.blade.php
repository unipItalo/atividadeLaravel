@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Cadastrar Nova Categoria</h1>

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
            <form method="POST" action="{{ route('categorias.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome da Categoria:</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ old('descricao') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="imagem" class="form-label">Imagem da Categoria (PNG/JPG):</label>
                    <input type="file" class="form-control" id="imagem" name="imagem" accept=".png,.jpg,.jpeg">
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection