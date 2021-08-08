@extends('site.layouts.index')

@section('content')
<div class="flex">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb mb-0">
			<li class="breadcrumb-item"><a href="{{route('.home')}}">Home</a></li>
			<li class="breadcrumb-item"><a href="{{route('requisicao.index')}}">Requisicões</a></li>
			<li class="breadcrumb-item"><a href="{{route('requisicao.show',  $requisicao->uuid)}}">Requisicao nº {{$requisicao->ordem ?? '' }}</a></li>
			<li class="breadcrumb-item active" aria-current="page">Novo item</li>
		</ol>
	</nav>
	<h1 Class="page-header page-title">Cadastrar item</h1>
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

{{Form::open(['route' => ['item.store',  $requisicao->uuid], 'method' => 'post', 'class' => 'form-padrao'])}}
	<div class="row">
		@include('form.number', [
		'input' => 'quantidade',
		'label' => 'Quantidade',			
		'largura' => 4, 
		'value' => old($input ?? ''),
		'attributes' => ['id' => 'quantidade', 'required' => '' ]])

		@include('form.number', [
		'input' => 'codigo',
		'label' => 'Código', 
		'largura' => 4, 
		'value' => old($input ?? ''),
		'attributes' => ['id' => 'codigo' ]])
		
		@include('form.select', [
		'input' => 'unidade', 
		'label' => 'Unidade',
		'largura' => 4,  
		'selected' => old($input ?? ''), 
		'options' => $unidades, 
		'attributes' => ['id' => 'unidade', 'required' => '']])
	</div>

	<div class="row">
		@include('form.text', [
		'input' => 'objeto',
		'label' => 'Objeto',
		'value' => old($input ?? ''),
		'attributes' => ['id' => 'objeto', 'required' => '']])
	</div>

	<div class="row">
		@include('form.textarea', [
		'input' => 'descricao', 
		'label' => 'Descricao Detalhada', 
		'value' => old($input ?? ''),
		'attributes' => ['id' => 'descricao', 'required' => '' ]])
	</div>
   
	<div class="row centered mt-3">
		@include('form.button', [
		'value' => 'Voltar',
		'largura' 	=> 3,
		'class'		=> 'btn btn-primary btn-block font-weight-bold',
		'url' 		=> 	route('requisicao.show', $requisicao->uuid) ])

		@include('form.submit', [
		'input' => 'Salvar',
		'largura' => 3 ])

		<div class="col-md-3">
			<button type="submit" formaction="{{route('item.store',[$requisicao->uuid, true])}}" class="btn btn-block btn-info font-weight-bold">Salvar e Cadastrar Novo</button>
		</div>

	</div>	
{{Form::close()}}
@endsection

 