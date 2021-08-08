@extends('site.layouts.index')

@section('content')

	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="{{route('.home')}}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{route('licitacao.index')}}">Licitações</a></li>
				<li class="breadcrumb-item"><a href="{{route('licitacao.show',  $licitacao->uuid)}}">Licitação nº {{$licitacao->ordem ?? '' }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">Mesclar itens</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Mesclar itens da licitação</h1>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-12">
					<h3>
						<i class="fa fa-shopping-cart "></i>
						Licitação n° {{$licitacao->ordem ?? '' }}
					</h3>
					<p><label> Objeto:</label> {{$licitacao->objeto ?? ''}}</p>
				</div><!-- / col -->
			</div><!-- / row -->
		</div><!-- / panel-heading -->
	</div><!-- / panel -->

	{{ Form::open(['route' => 'licitacao.mesclar.store', 'method' => 'post', 'class' => 'form-padrao']) }}
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
						@php $row = 0; @endphp <!-- variável que indica qua linha/requisição foi definida como principal -->
						@forelse ($requisicoes as $key => $requisicao)
						<tr>
							<td>{{$requisicao}}</td>
							<td>
								<div class="row">
									<div class="col-lg-8">
										<div class="input-group">
											<span class="input-group-addon" title ="Selecione as características a serem mantidas">
												{{ Form::radio('principal', $row) }} 
												@php $row += 1; @endphp <!-- Incrementa o numero da linha -->
											</span>
											{{ Form::select('itens[]',  [null => ''] + $selectItens[$key], '', array('class' => 'form-control form-control-sm'))}}
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

		<div class="{{$errors->has('itens') ? ' has-error' : '' }} col-lg-12">
			@if ($errors->has('itens'))
			<span class="help-block">
				<strong>Falha Encontrada: {{ $errors->first('itens') }}</strong>
			</span>
			@endif 
		</div>

		@if ($errors->has('principal'))
		<div class="alert alert-danger fixed-bottom w-5" id="success-alert">
			<strong>Erro Encontrado!</strong>
		   <button type="button" class="close" data-dismiss="alert">x</button>
		   {{ $errors->first('principal') }}
	   	</div>
		@endif
		
		<div class="row mt-2 mb-2">
			<div class="col-md-3 col-6 col-md-offset-3">
				<a href="{{route('licitacao.show', [$licitacao->uuid])}}" class="btn btn-primary btn-block" type="button">Voltar</a>
			</div>

			@include('form.submit', [
			'input' => 'Salvar', 
			'largura' => 3])
		</div>
	{{ Form::close() }} 


	<div class="well">
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
											<button type="button" data-route="{{route('licitacao.mesclar.separar', $mesclado->uuid)}}" class="btn btn-warning btn-sm desmesclar" data-modal="separar"  title="Desmesclar itens"><i class="glyphicon glyphicon-minus-sign"></i></button>
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
@endsection
