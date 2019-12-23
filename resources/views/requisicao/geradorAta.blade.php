@extends('layouts.index')

@section('content')
<div class="panel panel-default mt-2">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h1 Class="center">Nova Ata de Registro de Preços</h1>
			</div>
		</div>


		<div class="alert alert-default" role="alert">
			<h3>
				<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
				<a href="{{route('licitacaoExibir', [$licitacao->licitacaoable->uuid])}}">Pregão Eletrônico SRP N° {{$licitacao->numero ?? '' }} / {{$licitacao->ano ?? ''}}</a>
			</h3>
			<p><label>Objeto da Licitação:</label> {{$licitacao->objeto ?? ''}}</p>
		</div> 
	</div>

	<div class="panel-body">
		{{Form::open(['url' => 'registro/precos/store', 'method' => 'post', 'class' => 'form-padrao'])}}
			{{ Form::hidden('licitacao', $licitacao->uuid)}}
			
			<div class="row">
				@include('form.select', [
				'input' => 'fornecedor', 
				'label' => 'Fornecedor:', 
				'largura' => 12,  
				'selected' => old($input ?? ''), 
				'options' => $empresas ?? '', 
				'attributes' => ['id' => 'fornecedor', 'required' => '']])
			</div>

			<div class="row">
				@include('form.text', [
				'input' => 'numero',
				'label' => 'Ata numero:',			
				'largura' => 2, 
				'value' => old($input ?? '') ?? $ata_numero ?? '',
				'attributes' => ['id' => 'numero', 'placeholder' => '000', 'required' => '']])

				@include('form.text', [
				'input' => 'ano',
				'label' => 'Ata ano:',			
				'largura' => 2, 
				'value' => old($input ?? '') ?? $ata_ano ?? '',
				'attributes' => ['id' => 'ano', 'placeholder' => 'AAAA', 'required' => '']])


				@include('form.text', [
				'input' => 'publicacao', 
				'label' => 'Publicação do Edital no DOU:', 
				'largura' => 4,  
				'value' => old($input ?? '') ?? $licitacao->publicacao ?? '', 
				'attributes' => ['id' => 'publicacao', 'required' => '']])
			</div>
			
			<div class="row">
				@include('form.text', [
				'input' => 'assinatura', 
				'label' => 'Data de Assinatura:', 
				'largura' => 4, 
				'value' => old($input ?? ''), 
				'attributes' => ['id' => 'assinatura']])

				@include('form.text', [
				'input' => 'inicio', 
				'label' => 'Início da Vigência:', 
				'largura' =>4, 
				'value' => old($input ?? ''), 
				'attributes' => ['id' => 'inicio']])

				@include('form.text', [
				'input' => 'fim', 
				'label' => 'Fim da Vigência:', 
				'largura' => 4, 
				'value' => old($input ?? ''), 
				'attributes' => ['id' => 'fim']])
			</div>
	 
			<div class="row">
				@include('form.submit', [
				'input' => 'Visualizar Ata de Registro de Preços',
				'largura' => 6,
				'recuo' => 3 ])
			</div>	
		{{Form::close()}} 
	</div>
</div>
@endsection

 