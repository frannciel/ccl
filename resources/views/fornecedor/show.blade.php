@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
   
    <div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Fornecedores</h1>
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
				<a href="{{route('fornecedorNovo')}}" class="btn btn-primary btn-block" type="button"> Novo</a>
			</div>
		</div>
	{{ Form::close() }} 
  

	<table class="table table-hover tablesorter">
		<thead>
			<tr>
				<th >CPF/CNPJ</th>
				<th >Razão Social</th>
				<th >Cidade</th>
				<th >Estado</th>
			</tr>
		</thead>
		
		<tbody>
			@forelse ($fornecedores as $fornecedor)
				<tr onclick="location.href ='{{route('fornecedorEditar', $fornecedor->uuid)}}'; target='_blank';" style="cursor: hand;">
					@if($fornecedor->fornecedorable_type == 'App\PessoaJuridica')
						<td>
							<button type="button" class="btn btn-info btn-circle btn-sm">PJ</i></button>
							{{$fornecedor->fornecedorable->cnpj}}
						</td>
						<td>{{$fornecedor->fornecedorable->razao_social}}</td>
					@else
						<td>
							<button type="button" class="btn btn-warning btn-circle btn-sm">PF</i></button>
							{{$fornecedor->fornecedorable->cpf}}
						</td>
						<td>{{$fornecedor->fornecedorable->nome}}</td>
					@endif
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