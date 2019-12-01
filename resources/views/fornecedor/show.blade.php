@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
   
    <div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Relação de Fornecedores</h1>
		</div>
    </div>

	{{ Form::open(['url' => '/requisicao', 'method' => 'post', 'class' => 'form-padrao']) }}
		<div class="row">
			@include('form.text', [
			'input' => 'buscado',
			'label' => 'Dados do Fornecedor', 
			'largura' => 6,
			'attributes' => ['id' => 'buscado', 'required' => '' ]
			])

			@include('form.submit', [
			'input' => 'Buscar', 
			'largura' => 3 ])
			
			<div class="col-md-3" style="margin-top:20px;">
				<a href="{{route('fornecedorNovo')}}" class="btn btn-primary btn-block" type="button">Cadastar Novo</a>
			</div>
		</div>
	{{ Form::close() }} 
  

	<table class="table table-hover tablesorter">
		<thead>
			<tr>
				<th>CPF/CNPJ</th>
				<th>Razão Social</th>
				<th>Cidade</th>
				<th>Estado</th>
			</tr>
		</thead>
		
		<tbody>
			@forelse ($fornecedores as $fornecedor)
				<tr onclick="location.href ='{{route('fornecedorEditar', $fornecedor->uuid)}}'; target='_blank';" style="cursor: hand;">
					<td>{{$fornecedor->cpf_cnpj}}</td>
					<td>{{$fornecedor->razao_social}}</td>
					<td>{{$fornecedor->cidade->nome ?? ''}}</td>
					<td>{{$fornecedor->cidade->estado->nome ?? ''}}</td>
				</tr> 
			@empty
				<tr><td><center><i> Nenhum Fornecedor encontrado </i></center></td></tr>
			@endforelse
		</tbody>
	</table>
</div>
@endsection