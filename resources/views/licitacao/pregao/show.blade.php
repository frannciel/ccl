@extends('layouts.index')

@section('content')
<div class="panel panel-default mb-4">
	<div class="panel-heading text-center">
		<h2>ALTERAR OU EXCLUIR PREGÃO</h1>
	</div>
	
	<div class="panel-body">
		{{ Form::open(['url' => 'pregao/update', 'method' => 'post', 'class' => 'form-padrao']) }} <!-- Formulário de update de pregão -->
		<div class="row">
			@include('form.text', [
			'input' => 'ordem',
			'label' => 'Número', 
			'largura' => 2,
			'value' => old($input ?? '') ?? $licitacao->ordem ?? '',
			'attributes' => ['id' => 'ordem', 'disabled' => '', 'placeholder' => 'NNN/AAAA']])

			@include('form.text', [
			'input' => 'processo',
			'label' => 'Processo',
			'value' => old($input ?? '') ?? $licitacao->processo ?? '',
			'largura' => 3, 
			'attributes' => ['id' => 'processo']])

			@include('form.select', [
			'input' => 'tipo', 
			'label' => 'Tipo', 
			'selected' => old($input ?? '') ?? '3', 
			'largura' => 2,
			'options' => $tipos ?? '', 
			'attributes' => ['id' => 'tipo', 'readonly' => '']])

			@include('form.radioButton', [
			'input' => 'forma', 
			'label' => 'Forma', 
			'value' => old($input ?? '') ?? $licitacao->licitacaoable->forma ?? '', 
			'largura' => 3,
			'options' => $formas ?? '', 
			'attributes' => ['id' => 'forma']])

			@include('form.radioButton', [
			'input' => 'srp',
			'label' => 'SRP ?',
			'value' => old($input ?? '') ?? $licitacao->licitacaoable->srp ?? '',
			'largura' => 2,
			'options' => ['1' => 'SIM', '2' => 'NÃO',], 
			'attributes' => ['id' => 'srp', 'title' => 'Sistema de Registro de preços']])
		</div>

		<div class="row">
			@include('form.textarea', [
			'input' => 'objeto',
			'label' => 'Objeto',
			'value' => old($input ?? '') ?? $licitacao->objeto ?? '',
			'largura' => 12, 
			'attributes' => ['id' => 'objeto', 'required' => '',  'rows'=>'5']])
		</div>

		<div class="row row-fluid">
			<div class="col-md-3 col-md-offset-1 mt-2">
				<a href="{{route('licitacao')}}" class="btn btn-primary btn-block" type="button">Voltar</a>
			</div>

			@include('form.submit', [
			'input' => 'Salvar', 
			'largura' => 3])

			<div class="col-md-3 mt-2">
				<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#excluirLicitacaoModal">Excluir</button>
			</div>
		</div>
		{{ Form::close() }} <!-- /Formulário de update de pregão -->
	</div>
</div>

<div class="modal fade" id="excluirLicitacaoModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-md-6">
						<h4 class="modal-title" id="excluirLicitacaoModal">Excluir Licitação</h4>
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
							<p class="font-weight-bold">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								&nbsp;Tem certeza que deseja excluir definitivamente esta licitação?
							</p>
							<p>Esta ação também excluirá:</p>
							<ul>
								<li>Itens mesclados e duplicados;</li>
								<li>Item criado a partir desta licitação e não relacionado a requisição;</li>
								<li>Fornecedores dos itens desta licitação;</li>
								<li>Atas de Registros de Preços desta licitação;</li>
								<li>Todas as contratações relacionadas a esta licitação; e</li>
								<li>Participantes desta licitação.</li>
							</ul>
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
						<form action="{{url('licitacao/apagar', $licitacao->uuid)}}" method="post">
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

{{ Form::open(['url' => 'licitacao/item/duplicar', 'method' => 'POST', 'class' => 'form-padrao']) }}
	{{ Form::hidden('licitacao', $licitacao->uuid,  ['id' => 'licitacao']) }} <!-- o segundo parametro é o id do input hidden licitacao-->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="btn-group btn-group-justified" role="group" aria-label="...">
						<div class="btn-group" role="group">
							<button type="submit" formaction="{{url('item/primeiro')}}" class="btn btn-success btn-outline" title="Atribuir Fornecedor"><i class="glyphicon glyphicon-briefcase"></i></button>
						</div>
						<div class="btn-group" role="group">
							<a type="button" href="{{url('importar',['uuid' => $licitacao->uuid])}}" class="btn btn-success btn-outline" title="Importar Dados"><i class="fa fa-upload"></i></a>
						</div>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-success btn-outline " title="Adicionar Novo Item"><i class="glyphicon glyphicon-plus"></i></button>
						</div>
						<div class="btn-group" role="group">
							<a type="button" class="btn btn-success btn-outline" title="Mesclar Itens" href="{{route('licitacaoMesclarCreate', ['uuid' => $licitacao->uuid])}}"><i class="glyphicon glyphicon-resize-small"></i></a>
						</div>
						<div class="btn-group" role="group">
							<button type="submit" class="btn btn-success btn-outline" title="Duplicar Itens"><i class="glyphicon glyphicon-duplicate"></i></button>
						</div>
						<div class="btn-group" role="group">
							<a type="button" href="{{url('licitacao/atribuir',['licitacao' => $licitacao->uuid])}}" class="btn btn-success btn-outline" title="Atribuir ou Remover Itens"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
						</div>
						<div class="btn-group" role="group">
							<button type="submit" formaction="/action_page2.php" class="btn btn-danger btn-outline" title="Remover Itens"><i class="glyphicon glyphicon-trash"></i></button>
						</div>
					</div>

					<div class="row text-center">
						<div class="col-md-12 mt-2 mb-2">
							<button type="submit" formaction="{{url('item/primeiro')}}" class="btn  btn-outline btn-success rounded-pill">
							 Relação de Itens
							</button>
	
							<button type="submit" formaction="{{url('item/primeiro')}}" class="btn btn-outline btn-success rounded-pill">
								Itens por Fornecedor
							</button>

							<button type="submit" formaction="{{url('item/primeiro')}}" class="btn btn-outline btn-success rounded-pill">
								 Resultado
							</button>

							<a type="submit" href="{{url('registro/precos/novo',['licitacao' => $licitacao->uuid])}}"  class="btn btn-outline btn-success rounded-pill">
								 Atas SRP
							</a>

							<a type="button" href="{{url('contratacao/novo', ['licitacao' => $licitacao->uuid])}}" class="btn btn-outline btn-success rounded-pill">
								Contratações
							</a>
						</div>
					</div>

					<ul class="nav nav-pills nav-justified mt-2">
						<li class="active"><a data-toggle="tab" href="#guiaItens">Item</a></li>
						<li><a data-toggle="tab" href="#guiaRequisicao">Requisição</a></li>
						<li><a data-toggle="tab" href="#guiaFornecedor">Fornecedor</a></li>
						<li><a data-toggle="tab" href="#guiaParticipante">Participante</a></li>
					</ul>
				</div><!-- panel-heading -->
				
				<div class="panel-body">
					<div class="tab-content">
						<div id="guiaItens" class="tab-pane fade in active">
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
										@forelse ($licitacao->itens->sortBy('ordem') as $item)
										<tr>
											<td>
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" id="defaultCheck"  class="chk" name="itens[]" value="{{$item->uuid}}" >
													</span>
													<a class="btn btn-default" href="{{url('licitacao/item/editar', $item->uuid)}}" role="button">Detalhar</a>
												</div>
											</td>
											<td class=" center">{{$item->ordem}}</td>
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
						</div><!-- / tab item-->

{{ Form::close() }} 	

						<div id="guiaRequisicao" class="tab-pane fade">
							<table class="table table-hover tablesorter">
								<thead>
									<tr>
										<th class="center">Requisição</th>
										<th class="center">Descrição</th>
										<th class="center">Solicitante</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($licitacao->requisicoes as $requisicao)
									<tr onclick="location.href ='{{route('licitacaoAtribuirItemShow', [$licitacao->uuid, $requisicao->uuid])}}'; target='_blank';" style="cursor: hand;">
										<td class="center">{{$requisicao->numero}}/{{$requisicao->ano}}</td>
										<td>{{$requisicao->descricao}}</td>
										<td class="center">{{$requisicao->requisitante->first()['sigla']}}</td>
									</tr>
									@empty
									<tr><td colspan=4><center><i> Nenhuma Requisição Encontrada </i></center></td></tr>
									@endforelse
								</tbody>
							</table>
						</div><!-- / tab requisição -->

						<div id="guiaFornecedor" class="tab-pane fade">
							<table class="table table-hover tablesorter">
								<thead> 
									<tr>
										<th>CNPJ</th>
										<th>Razão Social</th>
										<th>Remover</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($lista as $value)
									<tr onclick="location.href ='{{route('itemEditar', [$value[0]])}}'; target='_blank';" style="cursor: hand;">
										<td>{{$value[1]}}</td>
										<td>{{$value[2]}}</td>
										<td>
											<button type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></button>
										</td>
									</tr>
									@empty
									<tr><td colspan=4><center><i> Nenhum fornecedor encontrado </i></center></td></tr>
									@endforelse
								</tbody>
							</table>
						</div>

						<div id="guiaParticipante" class="tab-pane fade">
							<table class="table table-hover tablesorter">
								<thead>
									<tr>
										<th class="center">Código Uasg</th>
										<th>Órgão ou Entidade Participante</th>
										<th class="center">Remover</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($uasgs as $uasg)
									<tr onclick="location.href ='{{route('itemEditar', $uasg['codigo'])}}'; target='_blank';" style="cursor: hand;">
										<td class="center">{{$uasg['codigo']}}</td>
										<td>{{$uasg['nome']}}</td>
										<td class="center">
											<button type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></button>
										</td>
									</tr>
									@empty
									<tr><td colspan=4><center><i> Nenhum fornecedor encontrado </i></center></td></tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</div><!-- panel-body -->
			</div><!-- /.panel -->
		</div><!-- /.col-lg-12 -->
	</div>
@endsection