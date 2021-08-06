@extends('site.layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')
	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item"><a href="{{route('licitacao.index')}}">Licitações</a></li>
				<li class="breadcrumb-item"><a href="{{route('licitacao.show',  $licitacao->uuid)}}">Pregão nº {{$licitacao->ordem ?? '' }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">Ordenar item</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Reordenar itens</h1>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-12">
					<h3>
						<i class="fa fa-legal "></i>
						Licitação n° {{$licitacao->ordem ?? '' }}
					</h3>
					<p><label> Objeto:</label> {{$licitacao->objeto ?? ''}}</p>
				</div><!-- / col -->
			</div><!-- / row -->
		</div><!-- / panel-heading -->
	</div><!-- / panel -->

	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-2 center font-weight-bold">Nº item</div>
				<div class="col-md-6 center font-weight-bold">Descrição </div>
				<div class="col-md-2 center font-weight-bold">Unidade</div>
				<div class="col-md-2 center font-weight-bold">Quantidade</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 sortable" data-route="{{route('licitacao.ordenar.store', $licitacao->uuid)}}">
			@foreach ($licitacao->itens->sortBy('ordem') as $item)
				<div class="well item mb-1" id="{{$item->uuid}}">
					<div class="row">
						<div class="col-md-2 center">{{$item->ordem}}</div>
						<div class="col-md-6" >{{$item->objeto}}</div>
						<div class="col-md-2 center">{{$item->unidade->nome}}</div>
						<div class="col-md-2 center">{{$item->quantidade}}</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<div class="row centered mt-2">
		<div class="col-md-6">
			<a href="{{route('licitacao.show', $licitacao->uuid)}}" class="btn btn-primary btn-block" type="button">Voltar</a>
		</div><!-- / col-md-3  -->
	</div>
@endsection
