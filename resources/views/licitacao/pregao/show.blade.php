@extends('layouts.index')

@section('content')
<div class="panel panel-default mb-4">
	<div class="panel-heading">
		<h2>Alterar ou Excluir Pregão</h1>
	</div>
	<div class="panel-body">
		{{ Form::open(['url' => 'pregao/update', 'method' => 'post', 'class' => 'form-padrao']) }} <!-- Formulário de update de pregão -->
		<div class="row">
			@include('form.number', [
			'input' => 'numero',
			'label' => 'Número', 
			'largura' => 2,
			'value' => old($input ?? '') ?? $licitacao->numero ?? '',
			'attributes' => ['id' => 'numero', 'disabled' => '']])

			@include('form.number', [
			'input' => 'ano',
			'label' => 'Ano', 
			'largura' => 2,
			'value' => old($input ?? '') ?? $licitacao->ano ?? '',
			'attributes' => ['id' => 'ano', 'disabled' => '']])

			@include('form.text', [
			'input' => 'processo',
			'label' => 'Processo',
			'value' => old($input ?? '') ?? $licitacao->processo ?? '',
			'largura' => 4, 
			'attributes' => ['id' => 'processo']])

			@include('form.text', [
			'input' => 'processoOrigem',
			'label' => 'Processo Original',
			'value' => old($input ?? '') ?? $licitacao->processoOrigem ?? '',
			'largura' => 4, 
			'attributes' => ['id' => 'processoOrigem', 'placeholder' => 'Processo Externo']])
		</div>

		<div class="row">
			@include('form.radioButton', [
			'input' => 'forma', 
			'label' => 'Forma*', 
			'value' => old($input ?? '') ?? $licitacao->licitacaoable->forma ?? '', 
			'largura' => 3,
			'options' => $formas ?? '', 
			'attributes' => ['id' => 'forma']])

			@include('form.radioButton', [
			'input' => 'srp',
			'label' => 'Registro de Preços*',
			'value' => old($input ?? '') ?? $licitacao->licitacaoable->srp ?? '',
			'largura' => 3, 
			'options' => ['1' => 'SIM', '2' => 'NÃO',], 
			'attributes' => ['id' => 'srp']])

			@include('form.radioButton', [
			'input' => 'srp_externo',
			'label' => 'Adesão/Participação',
			'value' => old($input ?? ''),
			'largura' => 3, 
			'options' => ['1' => 'Carona', '2' => 'Participante',], 
			'attributes' => ['id' => 'srp_externo']])

			@include('form.select', [
			'input' => 'tipo', 
			'label' => 'Tipo*', 
			'selected' => old($input ?? '') ?? '3', 
			'largura' => 3,
			'options' => $tipos ?? '', 
			'attributes' => ['id' => 'tipo', 'readonly' => '']])
		</div>

		<div class="row">
			@include('form.textarea', [
			'input' => 'objeto',
			'label' => 'Objeto*',
			'value' => old($input ?? '') ?? $licitacao->objeto ?? '',
			'largura' => 12, 
			'attributes' => ['id' => 'objeto', 'required' => '',  'rows'=>'5']])
		</div>

		<div class="row">
			<div class="col-md-3 col-md-offset-1 mt-2">
				<a href="{{route('licitacao')}}" class="btn btn-primary btn-block" type="button">Voltar</a>
			</div>

			@include('form.submit', [
			'input' => 'Salvar', 
			'largura' => 3])

			<div class="col-md-3 mt-2">
				<a href="{{route('licitacao')}}" class="btn btn-warning btn-block" type="button">Excluir</a>
			</div>
		</div>
		{{ Form::close() }} <!-- /Formulário de update de pregão -->
	</div>
</div>


{{ Form::open(['url' => 'licitacao/item/duplicar', 'method' => 'post', 'class' => 'form-padrao']) }}
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="btn-group btn-group-justified" role="group" aria-label="...">
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
					
					<ul class="nav nav-pills nav-justified mt-2">
						<li class="active"><a data-toggle="tab" href="#guiaItens">Item</a></li>
						<li><a data-toggle="tab" href="#guiaRequisicao">Requisição</a></li>
						<li><a data-toggle="tab" href="#guiaForncedor">Fornecedor</a></li>
						<li><a data-toggle="tab" href="#guiaParticipante">Participante</a></li>
					</ul>
				</div><!-- panel-heading -->
				
				<div class="panel-body">
					<div class="tab-content">
						<div id="guiaItens" class="tab-pane fade in active">
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
						</div><!-- / tab item-->
						
						<div id="guiaRequisicao" class="tab-pane fade">
						   <table class="table table-hover tablesorter">
					         <thead>
					            <tr>
					               <th>Requisição</th>
					               <th>Descrição</th>
					               <th>Solicitante</th>
					               <th></th>
					            </tr>
					         </thead>
					         <tbody>
					            @forelse ($licitacao->requisicoes as $value)
					            <tr onclick="location.href ='{{route('itemEditar', [$licitacao->uuid])}}'; target='_blank';" style="cursor: hand;">
					               <td>{{$value->numero}}/{{$value->ano}}</td>
					               <td>{{$value->descricao}}</td>
					               <td>{{$value->requisitante->first()['sigla']}}</td>
					               <td>
						               <button type="button" class="btn btn-danger btn-circle btn-sm"><i class="glyphicon glyphicon-trash"></i></button>
	                           </td>
					            </tr>
					            @empty
					            <tr><td colspan=4><center><i> Nenhuma unidade participante encontrada </i></center></td></tr>
					            @endforelse
					         </tbody>
				      	</table>



							<div class="row mt-2">								
								<div class="col-md-3">
									<div class="input-group custom-search-form">
										<input type="text" name="requisicao"  id="requisicao" class="form-control form-control-sm" placeholder="Exemplo 012019 ...">
										<span class="input-group-btn">
											<button class="btn btn-success" type="button" onclick="getDescricao('#requisicao', '#local')">
												<i class="fa fa-search"></i>
											</button>
										</span>
									</div>
								</div>

								{{ Form::open(['url' => 'licitacao/atribuir/requisicao', 'method' => 'post', 'class' => 'form-padrao']) }}

								<div class="col-md-3">
									<button type="submit" class="btn btn-success btn-block">Adicionar</button>
								</div>

								<div class="col-md-3">
									<button type="button" class="btn btn-warning btn-block">Limpar</button>
								</div>

								@include('form.textarea', [
								'input' => 'objeto',
								'label' => 'Descricão',
								'value' => old($input ?? ''),
								'largura' => 12, 
								'attributes' => ['id' => 'descricao', 'required' => '',  'rows'=>'3', 'id' => 'descricao', 'disabled' => '']])

								<div id='local'></div>

								{{ Form::hidden('licitacao', $licitacao->uuid,  array('id' => 'licitacao')) }}
								{{ Form::close() }} 
							</div>
						</div><!-- / tab requisição -->

						<div id="guiaForncedor" class="tab-pane fade">
							<h3>Menu 2</h3>
		  					<p>Some content in menu 2.</p>
						</div>

						<div id="guiaParticipante" class="tab-pane fade">
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