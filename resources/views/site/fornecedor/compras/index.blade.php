@extends('site.layouts.index')

@section('content')  
	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Fornecedores</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Fornecedores</h1>
	</div>

    <div class="row">
		<div class="col-md-4">
			<a href="{{route('fornecedor.create')}}" class="btn btn-primary">Adicionar Fornecedor</a>
			<a href="{{route('fornecedor.create')}}" class="btn btn-default">Importar</a>
		</div>
		<div class="col-md-5">
			<div class="input-group custom-search-form">
		        <input type="text" class="form-control" placeholder="Pesquisar...">
		        <span class="input-group-btn">
		            <button class="btn btn-success" type="button">
		                <i class="fa fa-search"></i>
		            </button>
		        </span>
			</div>
		</div>
		<div class="col-md-3">
			 <button id="btnPesquisaAvancada" type="button" class="btn btn-outline btn-default" data-toggle="tooltip" data-original-title="Pesquisa Avançada" data-container="body">
			    <i class="icon wb-search" aria-hidden="true"></i>
			    <span class="hidden-xs">Pesquisa Avançada</span>
			</button>
		</div>
    </div>

	{{ Form::open(['url' => '/requisicao', 'method' => 'post', 'class' => 'form-padrao busca']) }}
        <div class="form-row mt-2">
			<div class=" col-12">
				<div class="form-group col-sm-2">
					<label for="sit">Tipo</label>
					<input type="text" class="form-control" id="sit">
				</div>
				<div class="form-group col-sm-2">
					<label for="cad">CNPJ</label>
					<input type="text" class="form-control" id="cad">
				</div>			
				<div class="form-group col-sm-2">
					<label for="sit">Cidade</label>
					<input type="text" class="form-control" id="sit">
				</div>
				<div class="form-group col-sm-2">
					<label for="cad">Estado</label>
					<input type="text" class="form-control" id="cad">
				</div>

				<button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
			</div>
		</div>
	{{ Form::close() }} 
 
	<table class="table table-hover mt-2">
		<thead style="background-color: #f5f5f5;">
			<tr>
				<th>#</th>
				<th>CPF/CNPJ</th>
				<th>Identificação</th>
				<th>Cidade</th>
				<th>Estado</th>
			</tr>
		</thead>
		
		<tbody>
			@forelse ($fornecedores as $fornecedor)
				<tr onclick="location.href ='{{route('fornecedor.edit', $fornecedor->uuid)}}'; target='_blank';" class="pointer">
					@if($fornecedor->fornecedorable_type == 'Pessoa Jurídica')
						<td>
							<button type="button" class="btn btn-info btn-circle btn-sm" title="Pessoa jurídica">PJ</i></button>
						</td>
						<td>
							{{$fornecedor->fornecedorable->cnpj}}
						</td>
						<td>{{$fornecedor->fornecedorable->razao_social}}</td>
					@else
						<td>
							<button type="button" class="btn btn-warning btn-circle btn-sm">PF</i></button>
						</td>
						<td>
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

	<div class="row">
		<div class="col-md-6 text-center" style="float: none; margin: 0 auto;">
			{{ $fornecedores->links() }}
		</div>
	</div>
@endsection