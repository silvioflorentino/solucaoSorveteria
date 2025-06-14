@extends('layouts.estrutura')

@section('content')
<h1>Bem-vindo à Sorveteria do Senac</h1>
<p>Estamos felizes em tê-lo aqui! Explore nossos deliciosos sorvetes.</p>  
    <p>Você está logado com Firebase. {{Session::get('firebase_user')['email']}} </p>
    <a href="{{ route('logout') }}">Sair</a>
<a href="{{ route('sorveteria.create') }}" class="btn btn-success mb-3">Novo Sabor</a>
@if(count($sorvetes))

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Código</th>
      <th scope="col">Sabor</th>
      <th scope="col">Descrição</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>
    @foreach($sorvetes as $sorvete)
    <tr>
      <td scope="row">{{$sorvete['id']}}</td>
      <td >{{$sorvete['sabor']}}</td>
      <td>{{$sorvete['descricao']}}</td>
      <td>
    
    <a href="{{ route('sorveteria.edit', $sorvete['id']) }}" class="btn btn-warning btn-sm">Editar</a>
    
    <a href="{{ route('sorveteria.destroy', $sorvete['id']) }}" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</a>
    
    </td>
    </tr>
    @endforeach
  </tbody>
</table>
@else
<p>Não há sorvetes cadastrados.</p>
@endif
   
@endsection
