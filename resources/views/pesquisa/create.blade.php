@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Pesquisa de Preços</h1>
		</div>
	</div>

	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Requisição n° <a href="{{route('requisicaoExibir', [$requisicao->id])}}">{{$requisicao->numero ?? '' }} / {{$requisicao->ano ?? ''}}</a></h3>
		</div>
		<div class="panel-body">
			<label> Objeto:</label> {{$requisicao->descricao ?? ''}}
		</div>
	</div>

	{{Form::open(['url' => 'cotacao/store', 'method' => 'post', 'class' => 'form-padrao'])}}
		{{ Form::hidden('requisicao', $requisicao->id)}}
		<div class="row">
			@include('form.select', [
			'input' => 'item', 
			'label' => 'Item', 
			'largura' => 3,  
			'selected' => old($input ?? '') ?? $item->id ?? '', 
			'options' => $array ?? '', 
			'attributes' => ['id' => 'item' ]])

			@include('form.text', [
			'input' => 'fonte',
			'label' => 'Fonte dos Dados',			
			'largura' => 9, 
			'value' => old($input ?? '') ?? $cotacao->fonte ?? '',
			'attributes' => ['id' => 'fonte', 'required' => '' ]])
		</div>

		<div class="row">
			@include('form.text', [
			'input' => 'valor',
			'label' => 'Valor Cotado', 
			'largura' => 4, 
			'value' => old($input ?? '') ?? $cotacao->valor ?? '', 
			'attributes' => ['id' => 'valor', 'required' => '', 'autocomplete' => 'off' ]])

			@include('form.text', [
			'input' => 'data',
			'label' => 'Data da Cotação',
			'largura' => 4, 
			'value' => old($input ?? '') ?? $cotacao->data ?? '',
			'attributes' => ['id' => 'data', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off']])

			@include('form.text', [
			'input' => 'hora',
			'label' => 'Hora',
			'largura' => 4, 
			'value' => old($input ?? '') ?? $cotacao->hora ?? '',
			'attributes' => ['id' => 'hora', 'placeholder' => 'HH:MM', 'autocomplete' => 'off']])
		</div>

		<div class="row">
			@include('form.submit', [
			'input' => 'Cadastrar',
			'largura' => 6,
			'recuo' => 3 ])
		</div>	
	{{Form::close()}}

	<div class="row mt-2">
		<div class="col-md-7"><label class="control-label">Item</label></div>
		<div class="col-md-1 center"><label class="control-label">Quantidade</label></div>
		<div class="col-md-2 center"><label class="control-label">Valor Unitário</label></div>
		<div class="col-md-2 center"><label class="control-label">Valor Total</label></div>
	</div>

	<div class="row t-body table-responsive">
		<table class="table table-striped">
				@forelse ($itens as $item)
					<tr>
						<td>
							<div class="row" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $item->id }}" aria-expanded="false" aria-controls="collapseOne">
								<div class="col-md-7">
									{{$item->numero}} - {{$item->objeto ?? ''}}
								</div>
								<div class="col-md-1 center">
									{{$item->quantidade}}
								</div>
								<div class="col-md-2 center">
									{{$item->valorMedio}}
								</div>
								<div class="col-md-2 center">
									{{$item->valorTotal}}
								</div>
							</div>

							<div class="row">
								<div id="collapse{{$item->id}}" class="panel-collapse collapse col-md-10 col-md-offset-1" role="tabpanel" aria-labelledby="headingOne">
									<table class="table table-bordered t-w10 mt-2">
										<tr>
											<th class="center">#</th>
											<th class="center">Fonte:</th>
											<th class="center">Valor:</th>
											<th class="center">Data/Hora:</th>
										</tr>
										@foreach ($item->cotacoes as $key => $cotacao)
											<tr onclick="location.href ='{{route('cotacaoEditar', [$cotacao->id])}}'; target='_blank';" style="cursor: pointer">
												<td class="col-md-1 center">{{$key + 1}}</td>
												<td class="col-md-7">{{$cotacao->fonte ?? '' }}</td>
												<td class="col-md-2 center">{{$cotacao->contabil ?? '' }}</td>
												<td class="col-md-2 center">{{$cotacao->data  ?? ''}}</td>
											</tr>
										@endforeach
									</table>  
								</div>
							</div><!-- collapse -->
							<!-- collapse
								https://paulovitorweb.wordpress.com/2018/03/07/html-css-tabela-com-barra-de-rolagem-vertical-com-bootstrap/
							-->
						</td>
					</tr>
				@empty
				   <tr><td><center><i> Nenhum email encontrado </i></center></td></tr>
				@endforelse
		</table>
	</div>

	<div class="row mt-2  bg-success">
		<h4>
		<div class="col-md-4 col-md-offset-4">TOTAL: {{"R$ " .$requisicao->valorTotal ?? ''}}</div>
		</h4>
	</div>
</div>
@endsection