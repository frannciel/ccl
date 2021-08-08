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

		<div class="row row-fluid">
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
							<a type="button" href="{{route('licitacao.ordenar.create', $licitacao->uuid)}}" class="btn btn-success btn-outline" title="Ordenar Itens"><i class="fa fa-sort"></i></a>
						</div>
						<div class="btn-group" role="group">
							<a type="button" class="btn btn-success btn-outline" title="Mesclar Itens" href="{{route('licitacaoMesclar', ['uuid' => $licitacao->uuid])}}"><i class="glyphicon glyphicon-resize-small"></i></a>
						</div>
						<div class="btn-group" role="group">
							<button type="submit" class="btn btn-success btn-outline" title="Duplicar Itens"><i class="glyphicon glyphicon-duplicate"></i></button>
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
											<td class=" center">""</td>


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
										<th>Requisição</th>
										<th>Descrição</th>
										<th>Solicitante</th>
										<th>Remover</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($licitacao->requisicoes as $requisicao)
									<tr onclick="location.href ='{{route('itemEditar', [$licitacao->uuid])}}'; target='_blank';" style="cursor: hand;">
										<td>{{$requisicao->numero}}/{{$requisicao->ano}}</td>
										<td>{{$requisicao->descricao}}</td>
										<td>{{$requisicao->requisitante->first()['sigla']}}</td>
										<td>
											<a type="button"  href="{{url('licitacao/remover/requisicao', ['requisicao' => $requisicao->uuid, 'licitacao' => $licitacao->uuid])}}" class="btn btn-danger btn-circle btn-sm"><i class="glyphicon glyphicon-trash"></i></a>
										</td>
									</tr>
									@empty
									<tr><td colspan=4><center><i> Nenhuma Requisição Encontrada </i></center></td></tr>
									@endforelse
								</tbody>
							</table>

							<div class="row mt-2">								
								<div class="col-md-3">
									<div class="input-group custom-search-form">
										<input type="text" name="requisicao"  id="requisicao" class="form-control form-control-sm" placeholder="Ex. 012019">
										<span class="input-group-btn">
											<button class="btn btn-success" type="button" onclick="getDescricao('#requisicao', '#local')" title="Buscar Requisição">
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
									'input' => 'descricao',
									'label' => 'Descricão',
									'value' => old($input ?? ''),
									'largura' => 12, 
									'attributes' => ['id' => 'descricao', 'required' => '',  'rows'=>'3', 'id' => 'descricao', 'disabled' => '']])

									<div id='local'></div>

									{{ Form::hidden('licitacao', $licitacao->uuid,  array('id' => 'licitacao')) }}
								{{ Form::close() }} 
							</div>
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
											<button type="button" class="btn btn-danger btn-circle btn-sm"><i class="glyphicon glyphicon-trash"></i></button>
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
										<th>Código Uasg</th>
										<th>Órgão ou Entidade Participante</th>
										<th>Remover</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($uasgs as $uasg)
									<tr onclick="location.href ='{{route('itemEditar', $uasg['codigo'])}}'; target='_blank';" style="cursor: hand;">
										<td>{{$uasg['codigo']}}</td>
										<td>{{$uasg['nome']}}</td>
										<td>
											<button type="button" class="btn btn-danger btn-circle btn-sm"><i class="glyphicon glyphicon-trash"></i></button>
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