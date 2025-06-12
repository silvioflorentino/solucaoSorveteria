@extends('layouts.estrutura')

@section('content')
    <h1>Editar Sabor</h1>
    <form method="POST" action="{{ route('sorveteria.update', $sorvetes['id']) }}">
        @csrf
        <div class="mb-3">
            <label>Sabor</label>
            <input type="text" name="sabor" class="form-control" value="{{ $sorvetes['sabor'] }}" required>
        </div>
        <div class="mb-3">
            <label>Descrição</label>
            <input type="text" name="descricao" class="form-control" value="{{ $sorvetes['descricao'] }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Alterar</button>
        <a href="{{ route('sorveteria.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection