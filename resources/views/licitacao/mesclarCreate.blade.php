@extends('layouts.index')

@section('content')
<div class="panel panel-default mb-4 mt-4">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2 class="center">MESCLAR ITENS</h2>
			</div><!-- / col-md-12  -->
		</div><!-- / row -->

		<div class="row">
			<div class="col-md-12">
				<h3>
					<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
					<a href="{{route('licitacaoShow', $licitacao->uuid)}}">Licitação n° {{$licitacao->ordem ?? '' }}</a>
				</h3>
				<p><label> Objeto:</label> {{$licitacao->objeto ?? ''}}</p>
			</div><!-- / col-md-12  -->
		</div><!-- / row -->
	</div><!-- / panel-heading -->

	<div class="panel-body">
		{{ Form::open(['url' => 'licitacao/item/mesclar/store/', 'method' => 'post', 'class' => 'form-padrao']) }}
			<div class="row">
				<div class="col-md-12">
					<table id="tabela" class="table table-hover tablesorter">
						<thead>
							<tr>
								<th>Requisicao</th>
								<th>Selecione os itens a mesclar </th>
							</tr>
						</thead>
						<tbody>
							@php $rows = 0; @endphp <!-- variável que indica qua linha/requisição foi definida como principal -->
							@forelse ($requisicoes as $key => $requisicao)
							<tr>
								<td>{{$requisicao}}</td>
								<td>
									<div class="row">
										<div class="col-lg-8">
											<div class="input-group">
												<span class="input-group-addon" title ="Selecione as características a serem mantidas">
													{{ Form::radio('principal', $rows,  '', array('id' => 'principal')) }} 
													@php $rows += 1; @endphp <!-- Incrementa o numero da linha -->
												</span>
												{{ Form::select('itens[]',  [null => ''] + $selectItens[$key], '', array('class' => 'form-control form-control-sm', 'id' => 'itens'))}}
											</div><!-- /input-group -->
										</div><!-- /.col-lg-6 -->
									</div>
								</td>
							</tr>
							@empty
							<tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>

			<div class="{{$errors->has('principal') ? ' has-error' : '' }} col-lg-12">
				@if ($errors->has('principal'))
				<span class="help-block">
					<strong>Falha Encontrada: {{ $errors->first('principal') }}</strong>
				</span>
				@endif 
			</div>

			<div class="{{$errors->has('itens') ? ' has-error' : '' }} col-lg-12">
				@if ($errors->has('itens'))
				<span class="help-block">
					<strong>Falha Encontrada: {{ $errors->first('itens') }}</strong>
				</span>
				@endif 
			</div>
			
			<div class="row mt-2 mb-2">
				<div class="col-md-3 col-6 col-md-offset-3">
					<a href="{{route('licitacaoShow', [$licitacao->uuid])}}" class="btn btn-primary btn-block" type="button">Voltar</a>
				</div>

				@include('form.submit', [
				'input' => 'Salvar', 
				'largura' => 3])
			</div>
		{{ Form::close() }} 
	</div><!-- / panel-body -->

	<div class="panel-footer">
		<table class="table table-bordered table-hover" id="dataTables-example">
			<thead>
				<tr>
					<td class="w-1 center">Lista de Itens Mesclados </td>
				</tr>
			</thead>

			<tbody>
				@forelse ($mesclados as $mesclado)
				<tr>
					<td>
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-bottom: 0px;">
							<div class="panel panel-default" >
								<div class="panel-heading" role="tab" id="headingOne">
									<div class="row">
										<div data-toggle="collapse" data-parent="#accordion" href="#collapse{{$mesclado->id}}" aria-expanded="true" aria-controls="collapseOne" style="cursor: hand;">
											<div class="col-lg-2">
												Item: {{$mesclado->ordem}}
											</div>
											<div class="col-lg-9">
												Descrição: {{$mesclado->objeto }}
											</div>	
										</div>
										<div class="col-lg-1">
											<button type="button" data-route="{{route('licitacaoDesmesclar', $mesclado->uuid)}}" class="btn btn-warning btn-sm desmesclar" data-toggle="modal" data-target="#desmesclarModal" title="Desmesclar itens"><i class="glyphicon glyphicon-minus-sign"></i></button>
										</div>										
									</div>
								</div>
								<div id="collapse{{$mesclado->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
									<div class="panel-body">
									<table id="tabela" class="table table-hover">
										<thead>
											<tr>
												<th>Requisicao</th>
												<th>Item </th>
												<th>Descrição </th>
											</tr>
										</thead>
										<tbody>
											@foreach ($mesclado->mesclados as $item)
											<tr>
												<td>{{$item->requisicao->ordem}}</td>
												<td>{{$item->numero}}</td>
												<td>@php echo substr_replace($item->objeto, (strlen($item->objeto) > 150 ? '...' : ''), 150); @endphp</td>
											@endforeach
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				@empty
				<tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div> <!-- / panel  -->

<div class="modal fade" id="desmesclarModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-md-6">
						<h4 class="modal-title" id="desmesclarModal">Remover Itens</h4>
					</div><!-- / col-md-6 -->	
					<div class="col-md-6">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div><!-- / col-md-6 -->	
				</div><!-- / row -->		
			</div><!-- /.modal-header -->
			<div class="modal-body">
				<div class="row">
					<div class="col-md-2 text-center">
						<i class="fa fa-exclamation-triangle fa-5x color-orange" aria-hidden="true"></i>
					</div><!-- / col-md-2 -->											
					<div class="col-md-10">
						<h5>
							<p class="font-weight-bold">
								Tem certeza que deseja desfazer a mesclado deste item?
							</p>
							<p>Está ação remove:</p>
							<p> - Definitivamente edições no item mesclado.</p>
							<p> - Órgão e entidades participantes do item mesclado.</p>
							<p> - Fornecedor atribuido ao item mesclado.</p>
							<p>Os itens separados serão inseridos ao final da relação de itens.</p>
							<br>
							<p>Observação: Não é possível desfazer mescla de item que tenha Ata SRP e contraçãoes realizadas.</p>
						</h5>
					</div><!-- / col-md-10 -->	
				</div><!-- / row -->
			</div><!-- /.modal-body -->
			<div class="modal-footer">
				<div class="row">
				{{ Form::open(['url' => 'licitacao', 'method' => 'POST', 'class' => 'form-padrao', 'id' => 'formDesmesclar']) }}
					<div class="col-md-3 col-md-offset-6">
						<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
					</div><!-- / col-md-3 -->	
					<div class="col-md-3">
						<button  type="submit" class="btn btn-warning btn-block">Remover</button>
					</div><!-- / col-md-3 -->
				{{ Form::close() }} 
				</div><!-- / row -->
			</div><!-- /.modal-footer -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
