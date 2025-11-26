@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Editar Categoria</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('categorias.update', $categoria->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome da Categoria:</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $categoria->nome) }}" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ old('descricao', $categoria->descricao) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="imagem" class="form-label">Imagem da Categoria (PNG/JPG):</label>
                    <input type="file" class="form-control" id="imagem" name="imagem" accept=".png,.jpg,.jpeg">
                    @if($categoria->imagem)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $categoria->imagem) }}" alt="{{ $categoria->nome }}" width="100">
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection