@extends('site.layouts.index')

@section('content')
	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="{{route('.home')}}">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Licitações</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Licitações</h1>
	</div>


    <div class="row">
		<div class="col-md-4">
			<a href="{{route('pregao.create')}}" class="btn btn-primary">Cadastrar Licitação</a>
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

    {{ Form::open(['url' => '/requisicao', 'method' => 'post', 'class' => 'form-padrao busca mt-2']) }}
		  <div class="form-row ">
			@include('form.number', [
			'input' => 'numero',
			'label' => 'Número', 
			'largura' => 2,
			'value' =>' $requisicao->numero' ?? '',
			'attributes' => ['id' => 'numero', 'required' => '']])

			@include('form.number', [
			'input' => 'ano',
			'label' => 'Ano', 
			'largura' => 2,
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'ano']])

			@include('form.text', [
			'input' => 'processo',
			'label' => 'Processo', 
			'largura' => 3,
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'processo']])

			@include('form.select', [
			'input' => 'tipo', 
			'label' => 'Tipo', 
			'selected' => old($input ?? ''), 
			'largura' => 3,
			'options' => $modalidades ?? '',
			'attributes' => ['id' => 'tipo']])

			<button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
		</div>
	{{ Form::close() }} 


	<div class="row mt-2">
		<div class="col-md-12">
			<table id="tabela" class="table table-hover tablesorter">
				<thead style="background-color: #f5f5f5;">
					<tr>
						<th>Numero</th>
						<th>Ano</th>
						<th>Modalidade</th>
						<th>Situação</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($licitacoes as $licitacao)
						<tr onclick="location.href ='{{route('pregao.show', $licitacao->uuid)}}'; target='_blank';" class="pointer">
							<td>{{$licitacao->numero}}</td>
							<td>{{$licitacao->ano}}</td>
							<td>{{$licitacao->licitacaoable_type}}</td>
							<td>"Em analise"</td>
						</tr>
					@empty
						<tr><td><center><i> Nenhuma Contratação  Encontrada </i></center></td></tr>
					@endforelse
				</tbody>
			</table> 
		</div>
	</div>
@endsection
