@extends('site.layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Editar ou Excluir Cotação</h1>
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

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Item  n° <a href="{{route('itemEditar', [$item->id])}}">{{$item->numero ?? ''}}</a></h3>
		</div>
		<div class="panel-body">			
			<label> Descrição Detalhada:</label>@php print($item->descricao) ?? '' @endphp 	
		</div>
	</div>

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"> Dados da Cotação</h3>
		</div>
		<div class="panel-body">
			{{Form::open(['url' => 'cotacao/update', 'method' => 'post', 'class' => 'form-padrao'])}}
				{{Form::hidden('cotacao', $cotacao->id)}}
				<div class="row">
					@include('form.text', [
					'input' => 'fonte',
					'label' => 'Fonte dos Dados',			
					'largura' => 12, 
					'value' => old($input ?? '') ?? $cotacao->fonte ?? '',
					'attributes' => ['id' => 'fonte', 'required' => '' ]])
				</div>

				<div class="row">
					@include('form.text', [
					'input' => 'valor',
					'label' => 'Valor Cotado', 
					'largura' => 4, 
					'value' => old($input ?? '') ?? $cotacao->contabil ?? '', 
					'attributes' => ['id' => 'valor', 'required' => '', 'autocomplete' => 'off' ]])

					@include('form.text', [
					'input' => 'data',
					'label' => 'Data da Cotação',
					'largura' => 4, 
					'value' => old($input ?? '') ?? $cotacao->data ?? '',
					'attributes' => ['id' => 'data', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off']])

					@include('form.text', [
					'input' => 'hora',
					'label' => 'Hora',
					'largura' => 4, 
					'value' => old($input ?? '') ?? $cotacao->hora ?? '',
					'attributes' => ['id' => 'hora', 'placeholder' => 'HH:MM', 'autocomplete' => 'off']])
				</div>

				<div class="row">
					@include('form.submit', [
					'input' => 'Cadastrar',
					'largura' => 3,
					'recuo' => 3 ])

					<div class="col-md-3 col-6 mt-2">
						<a href="{{route('cotacaoApagar', ['id' => $cotacao->id])}}" class="btn btn-danger btn-block" type="button">
						   	Apagar
						</a>
					</div>
				</div>	
			{{Form::close()}}
		</div>
	</div>
@endsection