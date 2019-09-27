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
			<h3 class="panel-title">Pregão n° <a href="{{route('licitacaoExibir', [$licitacao->uuid])}}">{{$licitacao->numero ?? '' }} / {{$licitacao->ano ?? ''}}</a></h3>
		</div>
		<div class="panel-body">
			<label> Objeto:</label> {{$licitacao->objeto ?? ''}}
		</div>
	</div>

	{{Form::open(['url' => '/item/update', 'method' => 'post', 'class' => 'form-padrao'])}}

		@include('item.edit') <!-- Inclui os demais campus do formulário -->
		<div class="row">
			<div class="col-md-3 col-6 col-md-offset-3 mt-2">
				<a href="{{route('licitacaoExibir', [$licitacao->uuid])}}" class="btn btn-primary btn-block" type="button">Voltar</a>
			</div>

			@include('form.submit', [
			'input' => 'Salvar',
			'largura' => 3 ])
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
    		@forelse ($participantes as $value)
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
