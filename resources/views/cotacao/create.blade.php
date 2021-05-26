@extends('layouts.index')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h1 class="center">PESQUISA DE PREÇOS</h1>
			</div>
		</div><!-- / row -->

		<div class="alert alert-default" role="alert">
			<h3>
				<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
				<a href="{{route('requisicaoShow', [$requisicao->uuid])}}">Requisição n° {{$requisicao->ordem ?? '' }}</a>
			</h3>
			<p><label> Objeto:</label> {{$requisicao->descricao ?? ''}}</p>
		</div> 
		<input type='hidden' id='licitacao' name='licitacao' value="{{$licitacao->uuid ?? ''}}">
	</div><!-- / panel-heading -->

	<div class="panel-body">
		{{Form::open(['route' => ['cotacao.create', $requisicao->uuid], 'method' => 'post', 'class' => 'form-padrao'])}}
			<div class="row">
				@include('form.select', [
				'input' => 'item', 
				'label' => 'Item', 
				'largura' => 6,  
				'selected' => old($input ?? '') ?? $item->uuid ?? '', 
				'options' => $array ?? '', 
				'attributes' => ['id' => 'item', 'required' => '' ]])

				@include('form.text', [
				'input' => 'data',
				'label' => 'Data da Cotação',
				'largura' => 3, 
				'value' => old($input ?? '') ?? $cotacao->data ?? '',
				'attributes' => ['id' => 'data', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off']])

				@include('form.text', [
				'input' => 'hora',
				'label' => 'Hora',
				'largura' => 3, 
				'value' => old($input ?? '') ?? $cotacao->hora ?? '',
				'attributes' => ['id' => 'hora', 'placeholder' => 'HH:MM', 'autocomplete' => 'off']])
			</div>

			<div class="row">
				@include('form.text', [
				'input' => 'fonte',
				'label' => 'Fonte de Pesquisa',			
				'largura' => 8, 
				'value' => old($input ?? '') ?? $cotacao->fonte ?? '',
				'attributes' => ['id' => 'fonte', 'required' => '' ]])

				@include('form.text', [
				'input' => 'valor',
				'label' => 'Valor Cotado', 
				'largura' => 4, 
				'value' => old($input ?? '') ?? $cotacao->valor ?? '', 
				'attributes' => ['id' => 'valor', 'required' => '', 'autocomplete' => 'off' ]])
			</div>

			<div class="row mt-2">
				@include('form.button', [
				'value' => 'Voltar',
				'largura' 	=> 3,
				'class'		=> 'btn btn-primary btn-block',
				'url' 		=> 	route('requisicaoShow', [$requisicao->uuid]),
				'recuo' 	=> 3 ])

				@include('form.submit', [
				'input' => 'Salvar',
				'largura' => 3])
			</div>	
		{{Form::close()}}
	</div>

	<div class="panel-footer">
		<div class="row">
			<div class="col-xs-4 col-md-6 text-center"><label>Item</label></div>
			<div class="col-xs-4 col-md-2 text-center"><label>Quantidade Total</label></div>
			<div class="col-xs-4 col-md-2 text-center"><label>Valor Unitário</label></div>
			<div class="col-xs-4 col-md-2 text-center"><label>Valor Total</label></div>
		</div><!-- / row -->
		<div class="table-responsive div-tabela">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				@forelse ($itens as $item)
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<div class="row ">
							<div class="col-xs-12 col-md-6">
								<h5 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$item->uuid}}" aria-expanded="false" aria-controls="collapseOne">
										{{$item->numero}} - {{$item->objeto ?? ''}}
									</a>
								</h5>
							</div><!-- / col-md-6 -->
							<div class="col-xs-4 col-md-2 text-center">
								{{$item->quantidade}}
							</div><!-- / col-md-2 -->
							<div class="col-xs-4 col-md-2 text-center">
								{{$item->valorMedio}}
							</div><!-- / col-md-2 -->
							<div class="col-xs-4 col-md-2 text-center">
								{{$item->valorTotal}}
							</div><!-- / col-md-2 -->
						</div><!-- / row -->
					</div>
					<div id="{{$item->uuid}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							<table class="table table-striped table-bordered t-w10 mt-2">
								<tr>
									<th class="center">#</th>
									<th class="center">Fonte:</th>
									<th class="center">Valor:</th>
									<th class="center">Data/Hora:</th>
									<th></th>
								</tr>
								@foreach ($item->cotacoes as $key => $cotacao)
									<tr >
										<td class="col-md-1 center">{{$key + 1}}</td>
										<td class="col-md-7">{{$cotacao->fonte ?? '' }}</td>
										<td class="col-md-2 center">{{$cotacao->contabil ?? '' }}</td>
										<td class="col-md-2 center">{{$cotacao->data  ?? ''}}</td>
										<td>
											<i class="glyphicon glyphicon-trash text-red apagar-cotacao" title="Apagar cotação" data-route="{{route('cotacao.destroy', $cotacao->uuid)}}">
										</td>	
									</tr>
								@endforeach
							</table>  
						</div>
					</div>
				</div>
				@empty

				@endforelse
			</div><!-- / panel-group -->
		</div>
	</div>
</div>

<div class="modal fade" id="apagarCotacaoModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-md-6">
						<h4 class="modal-title" id="apagarCotacaoModal">Apagar Cotação</h4>
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
							Tem certeza que deseja excluir definitivamente Cotação
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
						<form id="formApagarCotacao" action="#" method="post">
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