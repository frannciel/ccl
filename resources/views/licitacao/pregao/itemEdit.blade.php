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


	<div class="panel panel-default mb-4">
		<div class="panel-heading">
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

			<div class="btn-group btn-group-justified mt-4" role="group" aria-label="...">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-success btn-outline btn-lg" title="Importar Dados"><i class="fa fa-upload"></i></button>
				</div>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-success btn-outline btn-lg" title="Adicionar Novo Item"><i class="glyphicon glyphicon-plus"></i></button>
				</div>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-success btn-outline btn-lg" title="Relação de Itens"><i class="glyphicon glyphicon-list"></i></button>
				</div>
				<div class="btn-group" role="group">
					<a type="button" class="btn btn-success btn-outline btn-lg" title="Mesclar Itens" href="{{route('licitacaoMesclar', ['uuid' => $licitacao->uuid])}}"><i class="glyphicon glyphicon-resize-small"></i></a>
				</div>
				<div class="btn-group" role="group">
					<button type="submit" formaction="/action_page2.php" class="btn btn-success btn-outline btn-lg" title="Remover Itens"><i class="glyphicon glyphicon-trash"></i></button>
				</div>
				<div class="btn-group" role="group">
					<button type="submit" class="btn btn-success btn-outline  btn-lg" title="Duplicar Itens"><i class="glyphicon glyphicon-duplicate"></i></button>
				</div>
			</div>
		</div><!-- / panel-heading -->

		<div class="panel-body">
			<table class="table table-hover table-striped mb-4">
			    <thead>
			    	<tr class="table-primary"><th colspan=4 class="center">FORNECEDORES</th></tr>
			        <tr>
			            <th class="center">CPF/CNPJ</th>
			            <th class="center">Nome / Razão Social</th>
			            <th class="center">Quantidade</th>
			           	<th class="center">Valor Unitário</th>
			         </tr>
			    </thead>
		    	<tbody>
		    		@forelse ($item->fornecedores()->get() as $value)
				        <tr onclick="location.href ='{{route('itemFornecShow', [$value->id, $item->id])}}'; target='_blank';" style="cursor: hand;">
				            <td class="center">{{$value->cpfCnpj}}</td>
				            <td class="center">{{$value->nome}}</td>
				            <td class="center">{{$value->pivot->quantidade}}</td>
				           	<td class="center">{{number_format($value->pivot->valor, 4, ',', '.')}}</td>
				        </tr>
			        @empty
			        	<tr><td colspan=4><center><i> Nenhuma fornecedor encontrado </i></center></td></tr>
			        @endforelse
		      	</tbody>
		    </table>
	
			<table class="table table-hover table-striped">
			    <thead>
			    	<tr><th colspan=4 class="center">PARTICIPANTES</th></tr>
			        <tr class="table-dark">
			            <th class="center">Código Uasg</th>
			            <th class="center">Nome da Uasg</th>
			            <th class="center">Local de Entrega </th>
			           	<th class="center">Quantidade </th>
			         </tr>
			    </thead>
		    	<tbody>
		    		@forelse ($uasgs as $uasg)
				        <tr onclick="location.href ='{{route('itemEditar', [$item->id])}}'; target='_blank';" style="cursor: hand;">
				            <td class="center">{{$uasg->codigo}}</td>
				            <td class="center">{{$uasg->nome}}</td>
				            <td class="center">{{$uasg->pivot->cidade->nome}} - {{$uasg->pivot->cidade->estado->nome}}</td>
				           	<td class="center">{{$uasg->pivot->quantidade}}</td>
				        </tr>
			        @empty
			        	<tr><td colspan=4 class="center"><i> Nenhuma unidade participante encontrada </i></td></tr>
			        @endforelse
		      	</tbody>
		    </table>
		</div><!-- / panel-body -->

		<div class="panel-footer">

		</div>
	</div> <!-- / panel  -->
</div>
@endsection
