@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Ata de Registro de Preços</h1>
		</div>
	</div>
	
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Requisição n° <a href="{{route('requisicaoExibir', [$requisicao->id])}}">{{$requisicao->numero ?? '' }} / {{$requisicao->ano ?? ''}}</a></h3>
		</div>
		<div class="panel-body">
			<label> Objeto:</label> {{$requisicao->descricao ?? ''}}
		</div>
	</div>

	{{Form::open(['url' => 'requisicao/ata/create', 'method' => 'post', 'class' => 'form-padrao'])}}
		{{ Form::hidden('requisicao', $requisicao->id)}}
		
		<div class="row">
			@include('form.select', [
			'input' => 'fornecedor', 
			'label' => 'Fornecedor', 
			'largura' => 12,  
			'selected' => old($input ?? ''), 
			'options' => $opcoes ?? '', 
			'attributes' => ['id' => 'fornecedor', 'required' => '']])
		</div>

		<div class="row">	
			@include('form.text', [
			'input' => 'processo', 
			'label' => 'Processo',
			'largura' => 4,  
			'value' => old($input ?? ''), 
			'attributes' => ['id' => 'processo', 'required' => '']])
			
			@include('form.text', [
			'input' => 'pregao',
			'label' => 'Nº do Pregão', 
			'largura' => 4, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'pregao', 'placeholder' => 'nnn/aaaa', 'required' => '']])

			@include('form.text', [
			'input' => 'publicacao', 
			'label' => 'Data Publicação do Edital', 
			'largura' => 4,  
			'value' => old($input ?? ''), 
			'attributes' => ['id' => 'publicacao', 'required' => '']])
		</div>
		
		<div class="row">
			@include('form.text', [
			'input' => 'numero',
			'label' => 'Numero da Ata',			
			'largura' => 6, 
			'value' => old($input ?? ''),
			'attributes' => ['id' => 'numero', 'placeholder' => 'nnn/aaaa', 'required' => '']])
			
			@include('form.text', [
			'input' => 'data', 
			'label' => 'Data de Assinatura', 
			'largura' => 6, 
			'value' => old($input ?? ''), 
			'attributes' => ['id' => 'data']])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'objeto', 
			'label' => 'Objeto', 
			'largura' => 12,  
			'value' => old($input ?? ''), 
			'attributes' => ['id' => 'objeto', 'required' => '']])
		</div>
 
		<div class="row">
			@include('form.submit', [
			'input' => 'Visualizar Ata de Registro de Preços',
			'largura' => 6,
			'recuo' => 3 ])
		</div>	
		
	{{Form::close()}} 
</div>
@endsection

 