@extends('layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')
<div class="panel panel-default mt-4">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2 class="center">ALTERAR OU EXCLUIR ITEM</h2>
			</div>
		</div><!-- / row -->

		<div class="row">
			<div class="col-md-12">
				<h3>
					<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
					<a href="{{route('licitacaoShow', [$licitacao->uuid])}}">Pregão n° {{$licitacao->ordem ?? '' }}</a>
				</h3>
				<p><label> Objeto:</label> {{$licitacao->objeto ?? ''}}</p>
			</div>
		</div><!-- / row -->
	</div><!-- / panel-heading -->
	
	<div class="panel-body">
		{{Form::open(['route' => array('itemUpdateItemLicitacao', $item->uuid), 'method' => 'post', 'class' => 'form-padrao'])}}

			@include('form.hidden', ['input' => '_method', 'value' => 'PUT', 'attributes' => [] ])

			<div class="row">
				@include('form.number', [
				'input' => 'numero',
				'label' => 'Número',			
				'largura' => 2, 
				'value' =>  old($input ?? '') ??  $item->ordem ,
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
				'value' => old($input ?? '') ??  strip_tags($item->descricao),
				'attributes' => ['id' => 'descricao', 'required' => '' ]])
			</div>

			<div class="row mt-2">
				<div class="col-md-3 col-6 col-md-offset-1 ">
					<a href="{{route('licitacaoShow', [$licitacao->uuid])}}" class="btn btn-primary btn-block" type="button">Voltar</a>
				</div>

				@include('form.submit', [
				'input' => 'Salvar Alteração',
				'largura' => 3 ])

				<div class="col-md-3">
					<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#mediumModalLabel">Excluir</button>
				</div>
			</div>
		{{Form::close()}}
	</div><!-- / panel-heading -->

	<div class="panel-footer">
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
</div> <!-- / panel  -->


<div class="modal fade" id="mediumModalLabel" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-md-6">
						<h4 class="modal-title" id="mediumModalLabel">Apagar item</h4>
					</div>
					<div class="col-md-6">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>	
			</div><!-- /.modal-header -->
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<h5>
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							Tem certeza que deseja excluir definitivamente este item?
						</h5>
					</div>
				</div>
			</div><!-- /.modal-body -->
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-3 col-md-offset-6">
						<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
					</div>
					<div class="col-md-3">
						<form action="#" method="post">
							{{csrf_field() }}
							<input type="hidden" name="_method" value="DELETE">
							<button type="submit" class="btn btn-danger btn-block">Excluir</button>
						</form>
					</div>
				</div>
			</div><!-- /.modal-footer -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
