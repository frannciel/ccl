@extends('layouts.index')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Pregão</h1>
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->

<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-default">
			A
			<br>
			A
			<br>
			A
			<br>
			A
			<br>
			A
			<br>
			A
			<br>
			A
			<br>
			A
			<br>
			A
			<br>
			A
			<br>
			A
			<br>
			A
			<br>
		</div>
	</div><!-- col-lg-8 -->

	<div class="col-lg-4">
		<div class="panel panel-default">
			<ul class="list-group">
				<li class="list-group-item">Cras justo odio</li>
				<li class="list-group-item">Dapibus ac facilisis in</li>
				<li class="list-group-item">Morbi leo risus</li>
				<li class="list-group-item">Porta ac consectetur ac</li>
				<li class="list-group-item">Vestibulum at eros</li>
			</ul>
		</div>
	</div>
</div>

<div class="row mb-4">
	<div class="col-md-3  col-md-offset-2 mt-2">
		<a href="{{route('requisicao')}}" class="btn btn-primary btn-block" type="button">Voltar</a>
	</div>

	@include('form.submit', [
	'input' => 'Salvar', 
	'largura' => 3 ])

		<div class="col-md-3 mt-2">
		<a href="{{route('requisicao')}}" class="btn btn-warning btn-block" type="button">Excluir</a>
	</div>
</div>

{{ Form::open(['url' => 'licitacao/item/duplicar', 'method' => 'post', 'class' => 'form-padrao']) }}
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
	
					
					<ul class="nav nav-pills nav-justified mt-2">
						<li class="active"><a data-toggle="tab" href="#home">Requisições</a></li>
						<li><a data-toggle="tab" href="#menu1">Itens</a></li>
						<li><a data-toggle="tab" href="#menu2">Forncedores</a></li>
						<li><a data-toggle="tab" href="#">Participantes</a></li>
					</ul>
				</div><!-- panel-heading -->
				
				<div class="panel-body">
					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">


							<div class="btn-group btn-group-justified mb-2" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-success btn-outline btn-lg"><i class="fa fa-upload"></i></button>
									<div style="display: none; hover: {dispaly: block;}">mostrar este texto</div>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-success btn-outline btn-lg"><i class="glyphicon glyphicon-plus"></i></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-success btn-outline btn-lg"><i class="glyphicon glyphicon-list"></i></button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-success btn-outline btn-lg"><i class="glyphicon glyphicon-resize-small"></i></button>
								</div>
								<div class="btn-group" role="group">
									<button type="submit" formaction="/action_page2.php" class="btn btn-success btn-outline btn-lg"><i class="glyphicon glyphicon-trash"></i></button>
								</div>
								<div class="btn-group" role="group">
									<button type="submit" class="btn btn-success btn-outline  btn-lg"><i class="glyphicon glyphicon-duplicate"></i></button>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr>
											<th> &nbsp &nbsp <input type="checkbox" id="ckAll" name="example1"> &nbsp Marcar</th>
										    <th class="w-1 center">Número</th>
										    <th class="w-4 center">Descrição Detalhada</th>
										    <th class="w-2 center">Unidade</th>
										    <th class="w-1 center">Código</th>
										    <th class="w-1 center">Quantidade</th>
										    <th class="w-1 center">Grupo</th>
										</tr>
									</thead>

									<tbody>
										@forelse ($licitacao->itens as $item)
										<tr>
											<td>
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" id="defaultCheck"  class="chk" name="itens[]" value="{{$item->uuid}}" >
													</span>
													<a class="btn btn-default" href="{{url('licitacao/item/editar', $item->uuid)}}" role="button">Detalhar</a>
												</div>
											</td>
											<td class="w-1 center">{{$item->licitacao()->first()->pivot->ordem}}</td>
											<td class="w-4 justicado">@php print($item->descricaoCompleta) @endphp</td>
											<td class="w-2 center">{{$item->unidade->nome}}</td>
											<td class="w-1 center">{{$item->codigo =='0'?'': $item->codigo}}</td>
											<td class="w-1 center">{{$item->quantidade}}</td>
											<td class="w-1 center"></td>


											<!--<td>isset($item->grupo->numero) ? $item->grupo->numero : ''</td>-->
										</tr>
										@empty
										<tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
										@endforelse

									</tbody>
								</table>
							</div><!-- table-responsive -->
						</div>
						<div id="menu1" class="tab-pane fade">
							 <h3>Menu 3</h3>
		  					<p>Some content in menu 3.</p>
						</div>
						<div id="menu2" class="tab-pane fade">
							<h3>Menu 2</h3>
		  					<p>Some content in menu 2.</p>
						</div>
					</div>
				</div><!-- panel-body -->
			</div><!-- /.panel -->
		</div><!-- /.col-lg-12 -->
	</div>
{{ Form::close() }} 
@endsection