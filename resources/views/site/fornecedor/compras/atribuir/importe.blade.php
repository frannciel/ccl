@extends('site.layouts.index')

@section('content')
<div class="panel panel-default mt-2">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h1 Class="center">Importar Dados de Registro de Preços</h1>
			</div>
		</div><!-- / row -->

		<div class="alert alert-default" role="alert">
			<h3>
				<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
				<a href="{{route('licitacao.show', $licitacao->uuid)}}">Pregão Eletrônico SRP n° {{$licitacao->numero ?? '' }} / {{$licitacao->ano ?? ''}}</a>
			</h3>
			<p><label> Objeto da Licitação:</label>{{$licitacao->objeto ?? ''}}</p>
		</div> 
	</div>
	{{Form::open(['route' => ['fornecedor.item.importarStore', $licitacao->uuid], 'method' => 'POST', 'class' => 'form-padrao'])}}
		<div class="panel-body">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				@foreach($resultado->unique('cnpj') as $key => $fornecedores)
					<div class="panel panel-success">
						<div class="panel-heading pointer" role="tab" id="heading{{$key}}" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
							<div class="row">
								<div class="col-md-4">
									<label>CNPJ:</label> {{$fornecedores['cnpj']}}
								</div>
								<div class="col-md-7">
									<label>Razão Social:</label> {{$fornecedores['razaoSocial']}}
								</div>
							</div>
						</div>
						<div id="collapse{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$key}}">
							<div class="panel-body">
								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th class=" center"><input type="checkbox" class="checkboxAll" name="{{$key}}"></th>
											<th class=" center">Item</th>
											<th class=" center">Descrição Detalhada</th>
											<th class=" center">Unidade</th>
											<th class=" center">Quantidade Homologada</th>
											<th class=" center">Valor Homologado</th>
										</tr>
									</thead>

									<tbody>
										@foreach($resultado->where('cnpj', $fornecedores['cnpj']) as $item)
										<tr>
											<td>
												<input type="checkbox" class="checkbox{{$key}}" name="itens[]" value="{{$item['ordem']}}" >
											</td>
											<td class="center">{{$item['ordem']}}</td>
											<td class="justificado">@php print($item['descricao']) @endphp</td>
											<td class="center">{{$item['unidade']}}</td>
											<td class="center">{{$item['quantidade']}}</td>
											<td class="center">{{$item['valor']}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				@endforeach
			</div>			
		</div><!-- panel-body -->

		<div class="panel-footer">
			<div class="row">
				<div class="col-md-3 col-6 col-md-offset-1">
					<a href="{{route('licitacao.importar', $licitacao->uuid)}}" class="btn btn-primary btn-block" type="button">Cancelar</a>
				</div>

				<div class="col-md-3 ">
					<button class="btn btn-success btn-block" type="submit">Importar</button>
				</div>

				<div class="col-md-3 ">
					<button class="btn btn-warning btn-block" type="button" id="marcarTodos" data-check="false" >Marcar Todos</button>
				</div>
			</div><!-- / row -->
		</div>
	{{Form::close()}} 
</div>
@endsection