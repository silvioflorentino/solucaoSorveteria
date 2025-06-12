@extends('layouts.estrutura')

@section('content')
    <h1>Novo Sabor</h1>
    <form method="POST" action="{{ route('sorveteria.store') }}">
        @csrf
        <div class="mb-3">
            <label>Sabor</label>
            <input type="text" name="sabor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descrição</label>
            <input type="text" name="descricao" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Cadastrar</button>
        <a href="{{ route('sorveteria.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection