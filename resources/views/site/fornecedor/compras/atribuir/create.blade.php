@extends('site.layouts.index')

<!-- View de atualização de Requsisção -->
@section('content')

<div class="flex">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb mb-0">
			<li class="breadcrumb-item"><a href="#">Home</a></li>
			<li class="breadcrumb-item"><a href="{{route('licitacao.index')}}">Licitações</a></li>
			<li class="breadcrumb-item"><a href="{{route('licitacao.show',  $licitacao->uuid)}}">Licitação nº {{$licitacao->ordem ?? '' }}</a></li>
			<li class="breadcrumb-item active" aria-current="page">Atribuir </li>
		</ol>
	</nav>
	<h1 Class="page-header page-title">Atribuir Fornecedor</h1>
</div>

		<input type='hidden' id='licitacao' name='licitacao' value="{{$licitacao->uuid ?? ''}}">

			<div class="row">
				<div class="col-md-6">
					<div class="input-group custom-search-form">
						<input type="text" name="cpf_cnpj"  id="cpf_cnpj" class="form-control form-control-sm" placeholder="CPF / CNPJ">
						<span class="input-group-btn">
							<button class="btn btn-success" type="button" id="buscarForncecedor">
								<i class="glyphicon glyphicon-search"> BUSCAR FORNECEDOR</i>
							</button>
						</span>
					</div>
				</div>

				<div class="col-md-12">
					<label for="razaoSocial" class="control-label">Razão Social</label>
					<textarea id="razaoSocial"  name="razaoSocial" readonly class="form-control"></textarea>
					<input type='hidden' id='fornecedor' name='fornecedor'>
				</div>
			</div><!-- / row -->

			<hr>

			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading" id="ordem">
							Selecione
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading" id="unidade">
							Selecione
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading" id="grupo">
							Selecione
						</div>
					</div>
				</div>
			</div><!-- / row -->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading" id="descricao">
							Selecione
						</div>
					</div>
				</div>

				<input type='hidden' id='item' name='item'>
			</div><!-- / row -->

			<div class="row">
				<nav aria-label="...">
					<ul class="pager">
						<div class="col-md-6">
							<li class="previous disabled" data-item="0"><a href="#" class="btn-block"><span aria-hidden="true">&larr;</span> Anterior</a></li>
						</div>
						<div class="col-md-6">
							<li class="next" data-item="1"><a href="#" class="btn-block">Próximo<span aria-hidden="true">&rarr;</span></a></li>
						</div>
					</ul>
				</nav>
			</div><!-- / row -->

			<div class="row">
				<div class="col-md-12">
					<h4 Class="center">Preencha os campus abaixo de acordo com a proposta do fornecedor </h4>
				</div>
			</div><!-- / row -->

			<div class="row mt-2">
				<div class="col-md-6">
					<label for="quantidade" class="control-label">Quantidade *</label>
					<div class="input-group custom-search-form">
						<input type="number" name="quantidade"  id="quantidade" class="form-control">
						<span class="input-group-btn">
							<button type="button" class="btn btn-success"  id="disponivel">
								<i class="glyphicon glyphicon-arrow-left"> DISPONÍVEL <span></span></i>
							</button>
						</span>
					</div>
				</div>

				<div class="col-md-6">
					<label for="valor" class="control-label">Valor Unitário</label>
					<input type="text" name="valor" id="valor" class="form-control">
				</div>
			</div><!-- / row -->

			<div class="row">
				<div class="col-md-6">
					<label for="marca" class="control-label">Marca</label>
					<input type="text" name="marca" id="marca" class="form-control">
				</div>

				<div class="col-md-6">
					<label for="modelo" class="control-label">Modelo </label>
					<input type="text" name="modelo" id="modelo" class="form-control" placeholder="Opcional ...">
				</div>
			</div><!-- / row -->

			<div class="row mt-4">
				<div class="col-md-3 col-6 col-md-offset-1">
					<a href="{{route('licitacao.show', [$licitacao->uuid])}}" class="btn btn-primary btn-block" type="button">Voltar</a>
				</div>

				<div class="col-md-3 ">
					<button class="btn btn-success btn-block" id="salvar" type="button">Salvar</button>
				</div>

				<div class="col-md-3 ">
					<button class="btn btn-warning btn-block" type="button">Limpar</button>
				</div>
			</div><!-- / row -->
		</div><!-- / panel-body -->


			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="dataTables-example" style="background: #fff">
					<thead>
						<tr>
							<th class="w-1 center">Número</th>
							<th class="w-4 center">Descrição Detalhada</th>
							<th class="w-2 center">Unidade</th>
							<th class="w-1 center">Quantidade</th>
							<th class="w-1 center">Grupo</th>
						</tr>
					</thead>

					<tbody>
						@php $index = 1; @endphp
						@forelse ($itens as $item)
						<tr class="linha pointer" id="{{$index}}" data-disponivel="{{$item->quantidadeTotalDisponivel}}" data-uuid="{{$item->uuid}}">
							<td class="w-1 center ordem">{{$item->ordem}}</td>
							<td class="w-4 justicado descricao" >@php print($item->descricaoCompleta) @endphp</td>
							<td class="w-2 center unidade">{{$item->unidade->nome}}</td>
							<td class="w-1 center quantidade">{{$item->quantidadeTotal}}</td>
							<td class="w-1 center grupo"></td>
							<!--<td>isset($item->grupo->numero) ? $item->grupo->numero : ''</td>-->
						</tr>
						@php $index += 1; @endphp
						@empty
						<tr><td colspan="7"><center><i> Nenhum item encontrado </i></center></td></tr>
						@endforelse
					</tbody>
				</table>
			</div><!-- table-responsive -->
			<input type="hidden" id="qtd" value="{{$index}}">
		</div><!-- / panel-footer -->
	</div> <!-- / panel  -->
</div>
@endsection
