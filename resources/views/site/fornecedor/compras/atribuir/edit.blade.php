@extends('site.layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')

<div class="flex">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb mb-0">
			<li class="breadcrumb-item"><a href="#">Home</a></li>
			<li class="breadcrumb-item"><a href="{{route('licitacao.index')}}">Licitações</a></li>
			<li class="breadcrumb-item"><a href="{{route('licitacao.show',  $licitacao->uuid)}}">Licitação nº {{$licitacao->ordem ?? '' }}</a></li>
			<li class="breadcrumb-item active" aria-current="page">Atribuir </li>
		</ol>
	</nav>
	<h1 Class="page-header page-title">Alterar ou excluir proposta</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h3>
					<i class="fa fa-legal"></i>
					Licitacão n° {{$licitacao->ordem ?? '' }}
				</h3>
				<p><label> Objeto:</label> {{$licitacao->objeto ?? ''}}</p>
			</div><!-- / col -->
		</div><!-- / row -->
	</div><!-- .panel-heading -->
	<div class="panel-body">
		<div class="row">
			@if($fornecedor->fornecedorable_type == 'Pessoa Jurídica')
				<div class="col-md-12">
					<i class="fa fa-building fa-2x" title="Pessoa jurídica"></i>
					<label>{{strtoupper($fornecedor->nome)}}</label>
				</div>
				<div class="col-md-6">
					<label>CNPJ:</label> {{$fornecedor->fornecedorable->cnpj}}
				</div>
			@else
				<div class="col-md-12">
					<i class="fa fa-user" title="Pessoa Física"></i>
					<label>{{strtoupper($fornecedor->nome)}}</label> 
				</div>
				<div class="col-md-6">
					CPF: {{$fornecedor->fornecedorable->cpf}}
				</div><!-- .col-md-6 -->
			@endif
			<div class="col-md-6">
				<label>Cidade:</label> {{$fornecedor->cidade->nome ?? ''}} - {{$fornecedor->cidade->estado->sigla ?? ''}}</td>
			</div><!-- .col-md -->
		</div><!-- / row -->
	</div><!-- .panel-body -->
</div><!-- .panel -->

<input type='hidden' id='licitacao' name='licitacao' value="{{$licitacao->uuid ?? ''}}">

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<label>Item n°:</label>{{$item->ordem ?? 'Selecione'}}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading" id="unidade">
				<label>Unidade:</label>{{$item->unidade->nome ?? 'Selecione'}}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<label>Grupo:</label>{{$item->grupo ?? ''}}
			</div>
		</div>
	</div>
</div><!-- / row -->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				{{print($item->descricaoCompleta) ?? 'Selecione'}}
			</div>
		</div>
	</div>

	<input type='hidden' id='item' name='item'>
</div><!-- / row -->

<div class="row">
	<div class="col-md-12">
		<h4 Class="center">Preencha os campus abaixo de acordo com a proposta do fornecedor </h4>
	</div>
</div><!-- / row -->

{{ Form::open(['route' => ['fornecedor.item.update', $fornecedor->uuid, $item->uuid], 'method' => 'post', 'class' => 'form-padrao']) }}
	<div class="row mt-2">
		<div class="col-md-6">
			<label for="quantidade" class="control-label">Quantidade</label>
			<div class="input-group custom-search-form">
				<input type="number" name="quantidade"  id="quantidade" class="form-control" value="{{$fornecedor->pivot->quantidade ?? ''}}">
				<span class="input-group-btn">
					<button type="button" class="btn btn-success" id="disponivel">
						<i class="glyphicon glyphicon-arrow-left"> DISPONÍVEL <span>{{$item->quantidadeTotalDisponivel ?? ''}}</span></i>
					</button>
				</span>
			</div>
		</div>

		@include('form.text', [
		'input' => 'valor',
		'label' => 'Valor Unitário', 
		'largura' => 6,
		'value' => old($input ?? '') ?? number_format($fornecedor->pivot->valor, 2, ',', '.') ?? '',
		'attributes' => ['id' => 'valor', 'required' => '']])
	</div><!-- / row -->

	<div class="row">
		@include('form.text', [
		'input' => 'marca',
		'label' => 'Marca',
		'value' => old($input ?? '') ?? $fornecedor->pivot->marca ?? '',
		'largura' => 6, 
		'attributes' => ['id' => 'marca']])

		@include('form.text', [
		'input' => 'modelo',
		'label' => 'Modelo',
		'value' => old($input ?? '') ?? $fornecedor->pivot->modelo ?? '',
		'largura' => 6, 
		'attributes' => ['id' => 'modelo']])
	</div><!-- / row -->

	<div class="row mt-2 centered">
		@include('form.button', [
		'value' => 'Voltar',
		'largura' 	=> 3,
		'class'		=> 'btn btn-primary btn-block',
		'url' 		=> 	route('licitacao.show', $licitacao->uuid)])

		@include('form.submit', [
		'input' => 'Salvar', 
		'largura' => 3])

		<div class="col-md-3">
			<button class="btn btn-warning font-weight-bold btn-block" type="button">Remover Propostas</button>
		</div>
	</div>
{{ Form::close() }} 

<div class="panel panel-info mb-1 mt-3">
	<div class="panel-heading">
		<div class="row center">
			<h3>Itens Atribuidos ao Fornecedor</h3>
			<small class="font-weight-bold">Clique no item para editar ou marque para remover</small>
			<br>
		</div>
		<div class="row">
			<div class="col-md-2 font-weight-bold"><input type="checkbox" id="ckAll">&ensp;&ensp; Item nº</div>
			<div class="col-md-6 center font-weight-bold">Descrição</div>
			<div class="col-md-2 center font-weight-bold">Unidade</div>
			<div class="col-md-2 center font-weight-bold">Quantidade</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		@foreach ($itens as $item)
			<div class="well item mb-1">
				<div class="row">
					<div class="col-md-2">
						<input type="checkbox" id="defaultCheck"  class="chk" name="itens[]" value="{{$item->uuid}}" >
						&ensp;&ensp;{{$item->ordem}}
					</div>
					<span onclick="location.href ='{{route('fornecedor.item.edit', [$fornecedor->uuid, $licitacao->uuid, $item->uuid])}}'; target='_blank';" class="pointer">
					<div class="col-md-6">{{$item->objeto}}</div>
					<div class="col-md-2 center">{{$item->unidade->nome}}</div>
					<div class="col-md-2 center">{{$item->quantidade}}</div>
					</span>
				</div>
			</div>
		@endforeach
	</div>
</div>
@endsection