@extends('site.layouts.index')

@section('content')
	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="{{route('.home')}}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{route('requisicao.index')}}">Requisicões</a></li>
				<li class="breadcrumb-item"><a href="{{route('requisicao.show',  $requisicao->uuid)}}">Requisicao nº {{$requisicao->ordem ?? '' }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">Alterar item</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Alterar ou excluir item</h1>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-12">
					<h3>
						<i class="fa fa-shopping-cart "></i>
						Requisição n° {{$requisicao->ordem ?? '' }}
					</h3>
					<p><label> Objeto:</label> {{$requisicao->descricao ?? ''}}</p>
				</div>
			</div><!-- / row -->
		</div><!-- / panel-heading -->
	</div>

	{{Form::open(['route' => ['item.update', $item->uuid], 'method' => 'post', 'class' => 'form-padrao'])}}

		<div class="row">
			@include('form.number', [
			'input' => 'numero',
			'label' => 'Número',			
			'largura' => 3, 
			'value' =>  old($input ?? '') ??  $item->numero ,
			'attributes' => ['id' => 'numero', 'disabled' => '' ]])

			@include('form.number', [
			'input' => 'quantidade',
			'label' => 'Quantidade', 
			'largura' => 3, 
			'value' => old($input ?? '') ?? $item->quantidade,
			'attributes' => ['id' => 'quantidade', 'required' => '' ]])
			
			@include('form.number', [
			'input' => 'codigo',
			'label' => 'Código', 
			'largura' => 3, 
			'value' => old($input ?? '') ?? $item->codigo,
			'attributes' => ['id' => 'codigo']])
			
			@include('form.select', [
			'input' => 'unidade', 
			'label' => 'Unidade', 
			'largura' => 3, 
			'selected' => old($input ?? '') ?? $item->unidade->uuid, 
			'options' => $unidades, 
			'attributes' => ['id' => 'unidade', 'required' => '']])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'objeto',
			'label' => 'Objeto',
			'value' => old($input ?? '') ?? $item->objeto,
			'attributes' => ['id' => 'objeto', 'required' => '', 'autocomplete' => 'off' ]])
		</div>
		
		<div class="row">
			@include('form.textarea', [
			'input' => 'descricao', 
			'label' => 'Descrição Detalhada', 
			'value' => old($input ?? '') ?? strip_tags($item->descricao),
			'attributes' => ['id' => 'descricao', 'required' => '' ]])
		</div>

		<div class="row mt-2">
			@include('form.button', [
			'value' => 'Voltar',
			'largura' 	=> 3,
			'class'		=> 'btn btn-primary btn-block',
			'url' 		=> 	route('requisicao.show',[$item->requisicao->uuid]),
			'recuo' 	=> 1 ])

			@include('form.submit', [
			'input' => 'Salvar',
			'largura' => 3 ])

			<div class="col-md-3">
				<button type="button" class="btn btn-danger btn-block font-weight-bold" data-modal="item-delete" data-route="{{route('item.destroy', $item->uuid)}}">Excluir</button>
			</div>
		</div>
	{{Form::close()}} 
@endsection