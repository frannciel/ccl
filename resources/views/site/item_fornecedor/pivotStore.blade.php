@extends('site.layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Atribuir Fornecedor</h1>
		</div>
	</div>
	<div class="panel panel-warning">
		<div class="panel-heading"><h3 class="panel-title">CPF / CNPJ n° <a href="{{route('fornecedor.edit', [$fornecedor->id])}}">{{$fornecedor->cpf_cnpj ?? ''}}</a></h3></div>
			
		<div class="panel-body">
			<label> Razão Social:</label> {{$fornecedor->razao_social ?? ''}}
		</div>
	</div>

	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Requisição n° <a href="{{route('requisicao.show', [$requisicao->id])}}">{{$requisicao->numero ?? '' }} / {{$requisicao->ano ?? ''}}</a></h3>
		</div>
		<div class="panel-body">
			<label> Objeto:</label> {{$requisicao->descricao}}
		</div>
	</div>

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Item  n° <a href="{{route('item.edit', [$item->id])}}">{{$item->numero ?? ''}}</a></h3>
		</div>
		<div class="panel-body">			
			<div class="row">
				<div class='col-md-12'>
					<label> Descrição Detalhada:</label>@php print($item->descricao) ?? '' @endphp 
				</div>
			</div>	
		</div>
	</div>

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"> Preencha os campus abaixo de acordo com a proposta do fornecedor </h3>
		</div>
			
		<div class="panel-body">
			{{Form::open(['url' => 'item/fornecedor/update', 'method' => 'post', 'class' => 'form-padrao'])}}
				{{ Form::hidden('item', $item->id)}}				
				{{ Form::hidden('fornecedor', $fornecedor->id)}}
				<div class="row">
					@include('form.text', [
					'input' => 'marca',
					'label' => 'Marca', 
					'largura' => 6, 
					'value' => old($input ?? '') ?? $item->fornecedores()->where('fornecedor_id', $fornecedor->id)->first()->pivot->marca,
					'attributes' => ['id' => 'marca', 'placeholder' => 'Opcional ...']])
				
					@include('form.text', [
					'input' => 'modelo',
					'label' => 'Modelo', 
					'largura' => 6, 
					'value' => old($input ?? '') ?? $item->fornecedores()->where('fornecedor_id', $fornecedor->id)->first()->pivot->modelo,
					'attributes' => ['id' => 'modelo', 'placeholder' => 'Opcional ...']])
				</div>
				
				<div class="row">
					@include('form.text', [
					'input' => 'quantidade',
					'label' => 'Quantidade', 
					'largura' => 6, 
					'value' => old($input ?? '')  ?? $item->fornecedores()->where('fornecedor_id', $fornecedor->id)->first()->pivot->quantidade ?? $item->quantidade,
					'attributes' => ['id' => 'quantidade', 'required' => '']])

					@include('form.text', [
					'input' => 'valor',
					'label' => 'Valor Unitário', 
					'largura' => 6, 
					'value' => old($input ?? '') ?? number_format($item->fornecedores()->where('fornecedor_id', $fornecedor->id)->first()->pivot->valor, 2, ',', '.'),
					'attributes' => ['id' => 'valor', 'required' => '']])
				</div>

				<div class="row">
					@include('form.submit', [
					'input' => 'Cadastrar',
					'largura' => 4,
					'recuo' => 4 ])
				</div>
			{{Form::close()}} 
		</div>
	</div>

	<nav aria-label="...">
		 <ul class="pager">
			<li class="previous {{$anterior == 0 ? 'disabled' : '' }}"><a href="{{ $anterior == 0 ? '#': route('item.FornecShow', ['fornecedor' => $fornecedor->uuid,'item' => $anterior])}}"><span aria-hidden="true">&larr;</span> Próximo</a></li>
			<li class="active"><a href="{{ route('requisicao.show', $requisicao->uuid)}}"><span aria-hidden="false"></span>Requisição</a></li>
			<li class="next {{$proximo == 0 ? 'disabled' : '' }}"><a href="{{ $proximo == 0 ? '#': route('item.FornecShow', ['fornecedor' => $fornecedor->id,'item' => $proximo])}}">Anterior <span aria-hidden="true">&rarr;</span></a></li>
		 </ul>
	</nav>
</div>
@endsection
	
	
	
	