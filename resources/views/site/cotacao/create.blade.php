@extends('site.layouts.index')

@section('content')
<div class="flex">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb mb-0">
			<li class="breadcrumb-item"><a href="{{route('.home')}}">Home</a></li>
			<li class="breadcrumb-item"><a href="{{route('requisicao.index')}}">Requisicões</a></li>
			<li class="breadcrumb-item"><a href="{{route('requisicao.show',  $requisicao->uuid)}}">Requisicao nº {{$requisicao->ordem ?? '' }}</a></li>
			<li class="breadcrumb-item active" aria-current="page">Nova pesquisa de preços</li>
		</ol>
	</nav>
	<h1 Class="page-header page-title">Cadastrar pesquisa de preços</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h3>
					<i class="fa fa-shopping-cart "></i>
					Requisição n° {{$requisicao->ordem ?? '' }}
				</h3>
				<p><label> Objeto:</label> {{$requisicao->descricao ?? ''}}</p>
			</div>
		</div><!-- / row -->
	</div><!-- / panel-heading -->
</div>

{{Form::open(['route' =>'cotacao.store', 'method' => 'post', 'class' => 'form-padrao'])}}
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
		'url' 		=> 	route('requisicao.show', $requisicao->uuid),
		'recuo' 	=> 3 ])

		@include('form.submit', [
		'input' => 'Salvar',
		'largura' => 3])
	</div>	
{{Form::close()}}

<div class="panel panel-default mt-3">
	<div class="panel-body p-3">
		<h3 class="page-title center">Relação de itens</h3>
		<p class="panel-text center mb-2">Clique sobre o item para ver ou excluir cotação de preços</p>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-1 center font-weight-bold">Nº</div>
					<div class="col-md-5 center font-weight-bold">Descrição </div>
					<div class="col-md-2 center font-weight-bold">Quantidade</div>
					<div class="col-md-2 center font-weight-bold">Valor Unitário</div>
					<div class="col-md-2 center font-weight-bold">Valor Total</div>
				</div>
			</div>
		</div>

		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			@forelse ($itens as $item)
			<div class="panel panel-default">
				<div class="panel-heading item" role="tab" id="headingOne">
					<div class="row" role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$item->uuid}}" aria-expanded="false" aria-controls="collapseOne">
						<div class="col-xs-4 col-md-1 text-center">
							{{$item->numero}}
						</div><!-- / col-md-2 -->
						<div class="col-xs-4 col-md-5" >
							{{$item->objeto ?? ''}}
						</div><!-- / col-md-6 -->
						<div class="col-xs-4 col-md-2 text-center">
							{{$item->quantidade}}
						</div><!-- / col-md-2 -->
						<div class="col-xs-4 col-md-2 text-center">
							R$ {{$item->valorMedio}}
						</div><!-- / col-md-2 -->
						<div class="col-xs-4 col-md-2 text-center">
							R$ {{$item->valorTotal}}
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
										<i class="glyphicon glyphicon-trash text-red" title="Apagar cotação" data-modal="cotacao-delete" data-route="{{route('cotacao.destroy', $cotacao->uuid)}}"></i>
									</td>	
								</tr>
							@endforeach
						</table>  
					</div>
				</div>
			</div>
			@empty
				<tr><td><center><i> Esta requisição não possui itens cadastrados </i></center></td></tr>
			@endforelse
		</div><!-- / panel-group -->

		<div class="row">
			<div class="col-md-6 align-center-col">
				{{ $itens->links() }}
			</div>
		</div>
	</div>
</div>
@endsection