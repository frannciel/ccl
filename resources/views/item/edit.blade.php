@extends('layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Alterar Item</h1>
		</div>
	</div>

	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Requisição n° <a href="{{route('requisicaoExibir', [$item->requisicao->id])}}">{{$item->requisicao->numero ?? '' }} / {{$item->requisicao->ano ?? ''}}</a></h3>
		</div>
		<div class="panel-body">
			<label> Objeto:</label> {{$item->requisicao->descricao ?? ''}}
		</div>
	</div>

	{{Form::open(['url' => '/item/update', 'method' => 'post', 'class' => 'form-padrao'])}}
		{{ Form::hidden('item', $item->id)}}	
		<div class="row">
			@include('form.number', [
			'input' => 'numero',
			'label' => 'Número',			
			'largura' => 2, 
			'value' =>  old($input ?? '') ??  $item->numero ,
			'attributes' => ['id' => 'numero', 'disabled' => '' ]])

			@include('form.number', [
			'input' => 'quantidade',
			'label' => 'Quantidade', 
			'largura' => 2, 
			'value' => old($input ?? '') ?? $item->quantidade,
			'attributes' => ['id' => 'quantidade', 'required' => '' ]])
			
			@include('form.number', [
			'input' => 'codigo',
			'label' => 'Código', 
			'largura' => 2, 
			'value' => old($input ?? '') ?? $item->codigo,
			'attributes' => ['id' => 'codigo', 'required' => '' ]])
			
			@include('form.select', [
			'input' => 'unidade', 
			'label' => 'Unidade', 
			'largura' => 3, 
			'selected' => old($input ?? '') ?? $item->unidade->id, 
			'options' => $unidades, 
			'attributes' => ['id' => 'unidade', 'required' => '']])

			@include('form.select', [
			'input' => 'grupo', 
			'label' => 'Grupo', 
			'largura' => 3, 
			'selected' => old($input ?? '') ?? $item->grupo, 
			'options' => $grupos ?? '', 
			'attributes' => ['id' => 'grupo', 'disabled' => '']])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'objeto',
			'label' => 'Objeto',
			'value' => old($input ?? '') ?? $item->objeto,
			'attributes' => ['id' => 'objeto', 'autocomplete' => 'off' ]])
		</div>

		<div class="row">
			@include('form.textarea', [
			'input' => 'descricao', 
			'label' => 'Descrição Detalhada', 
			'value' => old($input ?? '') ??  $item->descricao,
			'attributes' => ['id' => 'descricao', 'required' => '' ]])
		</div>
	   
		<div class="row">
			@include('form.submit', [
			'input' => 'Cadastrar',
			'largura' => 6,
			'recuo' => 3 ])
		</div>
	{{Form::close()}} 

	<div class="row">
		<div class="col-md-12">
			<h3 Class="page-header">Fornecedores:</h3>
		</div>
	</div>

	<table class="table table-hover tablesorter">
	    <thead>
	        <tr>
	            <th>CPF/CNPJ</th>
	            <th>Razão Social</th>
	            <th>Quantidade</th>
	           	<th>Valor Unitário</th>
	         </tr>
	    </thead>
    	<tbody>
    		@forelse ($item->fornecedores()->get() as $value)
		        <tr onclick="location.href ='{{route('itemFornecShow', [$value->id, $item->id])}}'; target='_blank';" style="cursor: hand;">
		            <td>{{$value->cpf_cnpj}}</td>
		            <td>{{$value->razao_social}}</td>
		            <td>{{$value->pivot->quantidade}}</td>
		           	<td>{{number_format($value->pivot->valor, 4, ',', '.')}}</td>
		        </tr>
	        @empty
	        	<tr><td colspan=4><center><i> Nenhuma fornecedor encontrado </i></center></td></tr>
	        @endforelse
      	</tbody>
   </table>


	<div class="row">
		<div class="col-md-12">
			<h3 Class="page-header">Participantes:</h3>
		</div>
	</div>

	<table class="table table-hover tablesorter">
	    <thead>
	        <tr>
	            <th>Código Uasg</th>
	            <th>Nome da Uasg</th>
	            <th>Local de Entrega </th>
	           	<th>Quantidade </th>
	         </tr>
	    </thead>
    	<tbody>
    		@forelse ($dados as $value)
		        <tr onclick="location.href ='{{route('itemEditar', [$item->id])}}'; target='_blank';" style="cursor: hand;">
		            <td>{{$value->uasg}}</td>
		            <td>{{$value->participante}}</td>
		            <td>{{$value->cidade}} - {{$value->estado}}</td>
		           	<td>{{$value->quantidade}}</td>
		        </tr>
	        @empty
	        	<tr><td colspan=4><center><i> Nenhuma unidade participante encontrada </i></center></td></tr>
	        @endforelse
      	</tbody>
   </table>
</div>
@endsection
