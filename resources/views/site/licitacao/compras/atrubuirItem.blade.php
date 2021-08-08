@extends('site.layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')
	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item"><a href="{{route('licitacao.index')}}">Licitações</a></li>
				<li class="breadcrumb-item"><a href="{{route('licitacao.show',  $licitacao->uuid)}}">Pregão nº {{$licitacao->ordem ?? '' }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">Atribuir item</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Atribuir ou remover itens</h1>
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

	<table class="table table-hover tablesorter">
		<thead>
			<tr> 
				<th class="center">Requisição</th>
				<th class="center">Descrição</th>
				<th class="center">Solicitante</th>
				<th class="center"></th>
			</tr>
		</thead>
		<tbody>
			@forelse ($licitacao->requisicoes as $requisicoes)
			<tr>
				<td class="center">{{$requisicoes->ordem}}</td>
				<td>{{$requisicoes->descricao}}</td>
				<td class="center">{{$requisicoes->requisitante->sigla}}</td>
				<td class="center">
					<a href="{{route('licitacao.atribuir.create', [$licitacao->uuid, $requisicoes->uuid])}}" class="btn btn-success btn-sm"><i class="fa fa-search"></i></a>
					<button data-route="{{route('licitacao.requisicao.remove', [$licitacao->uuid, $requisicoes->uuid])}}" class="btn btn-warning btn-sm" data-modal="licitacao-requisicao"> <i class="glyphicon glyphicon-trash"></i></button>
				</td>
			</tr>
			@empty
				<tr><td colspan=4><center><i> Esta licitcação ainda não possui requisições relacionadas </i></center></td></tr>
			@endforelse
		</tbody>
	</table>

	<div class="row mt-2">								
		<div class="col-md-3">
			<div class="input-group custom-search-form">
				<meta name="csrf-token" content="{{ csrf_token() }}">
				<input type="text" name="seachKey"  id="seachKey" class="form-control form-control-sm" placeholder="Ex. 012019">
				<span class="input-group-btn">
					<button type="button" id="buscar" class="btn btn-success" type="button" title="Buscar requisição">
						<i class="fa fa-search"></i>
					</button>
				</span>
			</div> <!-- / input-group -->
		</div><!-- / col-md-3 -->

		<div class="col-md-3">
			<a type="button" id="buscarItem" data-route="{{route('licitacao.atribuir.create', $licitacao->uuid)}}" class="btn btn-success btn-block" title="Buscar itens da requisição pesquisada"><i class="fa fa-search"></i><b>&emsp;Buscar Itens</b></a>
		</div><!-- / col-md-3  -->

		<div class="col-md-12">
			<label class="label-control">Objeto da Requisição:</label>
			<textarea name="descricao" id="descricao" rows="3" class="form-control" readonly=""></textarea>
		</div><!-- / col-md-12  -->
	</div><!-- / row -->


@if(isset($requisicao))
<div class="row row-fluid">
	<div class="col-md-3 col-md-offset-1 mt-2">
		<a  type="button" class="btn btn-primary btn-block" title="Voltar para licitação" href="{{route('licitacao.show', $licitacao->uuid)}}">Voltar</a>
	</div><!-- / col-md-3  -->

	<div class="col-md-3 mt-2">
		<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#atribuirItemModal" title="Atribuir itens selecionados">Atribuir</button>
	</div><!-- / col-md-3  -->

	<div class="col-md-3 mt-2">
		<button type="submit" class="btn btn-warning btn-block" data-toggle="modal" data-target="#removerItemModal" title="Remover itens selecionados">Remover</button>
	</div><!-- / col-md-3  -->
</div><!-- / row -->

<div class="panel panel-default mt-4">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h3>
					<i class="fa fa-shopping-cart"></i>
					<a href="{{route('requisicao.show', $requisicao->uuid)}}">Requisição n° {{$requisicao->ordem ?? '' }}</a>
				</h3>
				<p><label> Objeto:</label> {{$requisicao->descricao ?? ''}}</p>
			</div><!-- / col-md-12 -->
		</div><!-- / row -->
	</div><!-- / panel-heading -->

	<div class="panel-body">
		{{ Form::open(['url' => 'licitacao', 'method' => 'POST', 'class' => 'form-padrao']) }}
			{{ Form::hidden('requisicao', $requisicao->uuid)}}
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="dataTables-example">
					<thead>
						<tr>
							<th class="center"><input type="checkbox" id="ckAll"></th>
							<th class="center">Número</th>
							<th class="center">Descrição Detalhada</th>
							<th class="center">Unidade</th>
							<th class="center">Quantidade</th>
							<th class="center">Status</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($requisicao->itens->sortBy('numero') as $item)
						<tr>
							<td>
								<div class="input-group">
									<input type="checkbox" class="chk" name="itens[]" value="{{$item->uuid}}" >
								</div>
							</td>
							<td class=" center">{{$item->numero}}</td>
							<td class=" justicado">@php print($item->descricaoCompleta) @endphp</td>
							<td class=" center">{{$item->unidade->nome}}</td>
							<td class=" center">{{$item->quantidadeTotal}}</td>
							<td class=" center">
								@if($item->itens()->exists())
									<button type="button" class="btn btn-primary btn-circle btn-sm" title="Mesclado">
										<i class="fa fa-compress" aria-hidden="true"></i>
									</button>
								@elseif($item->licitacao()->exists())
									<button type="button" class="btn btn-warning btn-circle btn-sm" title="Atribuido">
										<i class="fa fa-minus" aria-hidden="true"></i>
									</button>
								@else
									<button type="button" class="btn btn-success btn-circle btn-sm" title="Disponível">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</button>
								@endif
							</td>
						</tr>
						@empty
						<tr><td colspan=7><center><i> Nenhum item encontrado </i></center></td></tr>
						@endforelse
					</tbody>
				</table>
			</div><!-- table-responsive -->

			<div class="modal fade" id="removerItemModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div class="col-md-6">
									<h4 class="modal-title" id="removerItemModal">Remover Itens</h4>
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
											Tem certeza que deseja remover os itens selecionados da licitação ?
										</p>
										<p> - Você poderá atribuir estes itens novamente à esta licitação.</p>
										<p> - Ao remover itens mesclado ocorrerá a desmescla desses itens.</p>
									</h5>
								</div><!-- / col-md-10 -->	
							</div><!-- / row -->
						</div><!-- /.modal-body -->
						<div class="modal-footer">
							<div class="row">
								<div class="col-md-3 col-md-offset-6">
									<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
								</div><!-- / col-md-3 -->	
								<div class="col-md-3">
									<button  type="submit" class="btn btn-warning btn-block" formaction="{{route('licitacao.atribuir.remove', $licitacao->uuid)}}" >Remover</button>
								</div><!-- / col-md-3 -->	
							</div><!-- / row -->
						</div><!-- /.modal-footer -->
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="modal fade" id="atribuirItemModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div class="col-md-6">
									<h4 class="modal-title" id="atribuirItemModal">Atribuir Itens</h4>
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
									<i class="fa fa-exclamation-triangle fa-4x color-green" aria-hidden="true"></i>
								</div><!-- / col-md-2 -->										
								<div class="col-md-10">
									<h5>
										<p class="font-weight-bold">
											Tem certeza que deseja incluir na licitação os itens selecionados?
										</p>
									</h5>
								</div><!-- / col-md-10 -->
							</div><!-- / row -->
						</div><!-- /.modal-body -->
						<div class="modal-footer">
							<div class="row">
								<div class="col-md-3 col-md-offset-6">
									<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
								</div><!-- / col-md-3 -->
								<div class="col-md-3">
									<button type="submit" class="btn btn-success btn-block" formaction="{{route('licitacao.atribuir.store', $licitacao->uuid)}}">Atribuir</button>
								</div><!-- / col-md-3 -->
							</div><!-- / row -->
						</div><!-- /.modal-footer -->
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		{{ Form::close() }} 	
	</div><!-- / panel-body -->
</div><!-- / panel -->

@else
<div class="row row-fluid">
	<div class="col-md-6 col-md-offset-3 mt-2">
		<a href="{{route('licitacao.show', $licitacao->uuid)}}" class="btn btn-primary btn-block" type="button">Voltar</a>
	</div><!-- / col-md-3  -->
@endif

@endsection
