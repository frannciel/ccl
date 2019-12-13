@extends('layouts.index')

@section('content')

<div class="panel panel-default mb-4">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h1 Class="center">Dados da Requisição</h1>
			</div>
		</div>
	</div>

	<div class="panel-body">
		{{ Form::open(['url' => '/requisicao/update', 'method' => 'post', 'class' => 'form-padrao']) }}
			{{ Form::hidden('requisicao', $requisicao->uuid)}}
			<div class="row">
				@include('form.text', [
				'input' => 'numero',
				'label' => 'Número', 
				'largura' => 3,
				'value' => $requisicao->numero,
				'attributes' => ['id' => 'numero', 'disabled' => '' ]])

				@include('form.text', [
				'input' => 'ano',
				'label' => 'Ano', 
				'largura' => 3,
				'value' => $requisicao->ano,
				'attributes' => ['id' => 'ano', 'disabled' => '']])

				@include('form.select', [
				'input' => 'requisitante', 
				'label' => 'Requisitante', 
				'largura' => 6,
				'selected' => $requisicao->requisitante->uuid, 
				'options' => $requisitantes, 
				'attributes' => ['id' => 'requisitante']])
			</div>

			<div class="row">
				@include('form.text', [
				'input' => 'descricao',
				'label' => 'Objeto', 
				'value' =>  $requisicao->descricao,
				'attributes' => ['id' => 'descricao', 'required' => '', 'autocomplete' => 'off']])
			</div>

			<div class="row">
				@include('form.textarea', [
				'input' => 'justificativa',
				'label' => 'Justificativa da Contratação*',
				'value' => old($input ?? '') ?? $requisicao->descricao,
				'largura' => 12, 
				'attributes' => ['id' => 'justificativa', 'required' => '',  'rows'=>'5']])
		    </div>

			<div class="row">
				<div class="col-md-3  col-md-offset-1 mt-2">
					<a href="{{route('requisicao')}}" class="btn btn-primary btn-block" type="button">Voltar</a>
				</div>

				@include('form.submit', [
				'input' => 'Salvar', 
				'largura' => 3 ])

				<div class="col-md-3 mt-2">
					<a href="{{route('requisicao')}}" class="btn btn-warning btn-block" type="button">Excluir</a>
				</div>
			</div>
		{{ Form::close() }} 
	</div>
</div>
<!-- div class="row mt-4 p-2">
	<div class="col-md-3 col-6">
		<a href="{{route('itemNovo', ['id' => $requisicao->uuid])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-plus fa-3x"></i><br>Incluir Item
		</a>
	</div>
	<div class="col-md-3 col-6">
		<a href="{{route('importarNovo', ['id' => $requisicao->id])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-upload fa-3x"></i><br>Importar
		</a>
	</div>
	<div class="col-md-3 col-6">
		<a href="{{route('cotacaoNovo', ['id' => $requisicao->id])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-shopping-cart fa-3x"></i><br>Pesquisa de Preços
		</a>
	</div>
	<div class="col-md-3 col-6">
		<a href="{{route('cotacaoRelatorio', ['id' => $requisicao->id])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-list-alt fa-3x"></i><br>Relatório de Pesquisa
		</a>
	</div>
	<div class="col-md-3 col-6 mt-2">
		<a href="{{route('documento', ['id' => $requisicao->id])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-list-alt fa-3x"></i><br>Tabela de Itens
		</a>
	</div>
	<div class="col-md-3 col-6 mt-2">
		<a href="{{route('cotacaoRelatorio', ['id' => $requisicao->id])}}" class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-list-alt fa-3x"></i><br>Remover Itens
		</a>
	</div>
	<div class="col-md-3 col-6 mt-2">
		<a href="{{url('/requisicao/apagar', $requisicao->uuid)}}"  class="btn btn-primary btn-outline btn-block" type="button">
		   	<i class="fa fa-list-alt fa-3x"></i><br>Excluir 
		</a>
	</div>
</div> -->

<!-- <div class="row">
	<div class="col-md-12">
		<h2 Class="page-header">Relação de Itens</h2>
	</div>
</div>

<table class="w-10">
	<thead>
		<tr>
			<th class="w-1 center">Número</th>
			<th class="w-4 center">Descrição Detalhada</th>
			<th class="w-2 center">Unidade</th>
			<th class="w-1 center">Código</th>
			<th class="w-1 center">Quantidade</th>
			<th class="w-1 center">Grupo</th>
		</tr>
	</thead>
</table>
<div class="row t-body table-responsive">
   <table class="table table-striped table-bordered">
      <tbody>
         @forelse ($requisicao->itens as $item)
         <tr onclick="location.href ='{{route('itemEditar', $item->uuid)}}'; target='_blank';" style="cursor: hand;">
            <td class="w-1 center">{{$item->numero}}</td>
            <td class="w-4 justicado">@php print($item->descricaoCompleta) @endphp</td>
            <td class="w-2 center">{{$item->unidade->nome}}</td>
            <td class="w-1 center">{{$item->codigo =='0'?'': $item->codigo}}</td>
            <td class="w-1 center">{{$item->quantidade}}</td>
            <td class="w-1 center"></td>
            <!--<td>isset($item->grupo->numero) ? $item->grupo->numero : ''</td>
         </tr>
         @empty
         <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
         @endforelse
      </tbody>
   </table>
</div>
 -->
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="btn-group btn-group-justified" role="group" aria-label="...">
			<div class="btn-group" role="group">
				<a type="button" class="btn btn-success btn-outline btn-lg" title="Adicionar Novo Item" href="{{route('itemNovo', ['uuid' => $requisicao->uuid])}}"><i class="glyphicon glyphicon-plus"></i></a>
			</div>
			<div class="btn-group" role="group">
				<a type="button"  class="btn btn-success btn-outline btn-lg" title="Pesquisa de Preços" href="{{route('cotacaoNovo', ['uuid' => $requisicao->uuid])}}"><i class="glyphicon glyphicon-shopping-cart"></i></a>
			</div>
			<div class="btn-group" role="group">
				<a type="button" class="btn btn-success btn-outline btn-lg" title="Importar Dados" href="{{route('importarNovo', ['uuid' => $requisicao->uuid])}}"><i class="fa fa-upload"></i></a>
			</div>
			<div class="btn-group" role="group">
				<button type="submit" class="btn btn-success btn-outline  btn-lg" title="Duplicar Itens"><i class="glyphicon glyphicon-duplicate"></i></button>
			</div>
			<div class="btn-group" role="group">
				<a type="button" class="btn btn-info btn-outline btn-lg" title="Oficialização da Demanda" href="{{route('documento', ['uuid' => $requisicao->uuid])}}"><i class="glyphicon glyphicon-list"></i></a>
			</div>
			<div class="btn-group" role="group">
				<a type="button" class="btn btn-info btn-outline btn-lg" title="Relatório de Pesquisa de Preços" href="{{route('cotacaoRelatorio', ['uuid' => $requisicao->uuid])}}"><i class="fa fa-list-alt"></i></a>
			</div>
			<div class="btn-group" role="group">
				<button type="submit" formaction="/action_page2.php" class="btn btn-danger btn-outline btn-lg" title="Excluir Itens"><i class="glyphicon glyphicon-trash"></i></button>
			</div>
		</div>
	</div><!-- panel-heading -->

	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered" id="dataTables-example">
				<thead>
					<tr>
						<th class=" center"><input type="checkbox" id="ckAll" name="example1"></th>
					    <th class=" center">Número</th>
					    <th class=" center">Descrição Detalhada</th>
					    <th class=" center">Unidade</th>
					    <th class=" center">Código</th>
					    <th class=" center">Quantidade</th>
					    <th class=" center">Grupo</th>
					</tr>
				</thead>

				<tbody>
					@forelse ($requisicao->itens as $item)
					<tr>
						<td>
							<div class="input-group">
								<span class="input-group-addon">
									<input type="checkbox" id="defaultCheck"  class="chk" name="itens[]" value="{{$item->uuid}}" >
								</span>
								<a class="btn btn-default" href="{{route('itemEditar', $item->uuid)}}" role="button">Detalhar</a>
							</div>
						</td>
						<td class=" center">{{$item->numero}}</td>
						<td class=" justicado">@php print($item->descricaoCompleta) @endphp</td>
						<td class=" center">{{$item->unidade->nome}}</td>
						<td class=" center">{{$item->codigo =='0'?'': $item->codigo}}</td>
						<td class=" center">{{$item->quantidadeTotal}}</td>
						<td class=" center"></td>
						<!--<td>isset($item->grupo->numero) ? $item->grupo->numero : ''</td>-->
					</tr>
					@empty
					<tr><td colspan=7><center><i> Nenhum item encontrado </i></center></td></tr>
					@endforelse
				</tbody>
			</table>
		</div><!-- table-responsive -->
	</div><!-- panel-body -->
</div>
@endsection