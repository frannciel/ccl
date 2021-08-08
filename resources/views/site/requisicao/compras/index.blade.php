@extends('site.layouts.index')

@section('content')
	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Requisicão</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Requisições</h1>
	</div>


    <div class="row">
		<div class="col-md-4">
			<a href="{{route('requisicao.create')}}" class="btn btn-primary">Cadastrar Requisicão</a>
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
					<label for="sit">Numero</label>
					<input type="text" class="form-control" id="sit">
				</div>
				<div class="form-group col-sm-2">
					<label for="cad">Ano</label>
					<input type="text" class="form-control" id="cad">
				</div>			
				<div class="form-group col-sm-2">
					<label for="sit">Requisitante</label>
					<input type="text" class="form-control" id="sit">
				</div>

				<button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
			</div>
		</div>
	{{ Form::close() }} 
 

	<table id="tabela" class="table table-hover mt-2">
		<thead style="background-color: #f5f5f5;">
			<tr>
				<th class="text-left">Numero</th>
				<th class="text-left w-6">Objeto</th>
				<th class="text-left">Solicitante</th>
				<th class="text-left">Data</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($requisicoes as $requisicao)
				<tr onclick="location.href ='{{route('requisicao.show', $requisicao->uuid)}}'; target='_blank';" class="pointer">
					<td>{{$requisicao->ordem ?? 'error'}}</td>
					<td>{{$requisicao->descricao ?? 'error'}}</td>
					<td>{{$requisicao->requisitante->sigla ?? 'error'}}</td>
					<td>{{$requisicao->data ?? 'error'}}</td>
				</tr>
			@empty
				<tr><td><center><i> Nenhuma Requisição encontrada </i></center></td></tr>
			@endforelse
		</tbody>
	</table> 


	<div class="row">
		<div class="col-md-6 align-center-col">
			{{ $requisicoes->links() }}
		</div>
	</div>


@endsection
