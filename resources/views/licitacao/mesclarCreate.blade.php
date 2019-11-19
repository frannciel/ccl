@extends('layouts.index')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>Mesclar Itens</h1>
		</div>
	</div>

	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Pregão n° <a href="#">01/2019</a></h3>
		</div>
		<div class="panel-body">
			<label> Objeto:</label> Primeiro Pregão de teste
		</div>
	</div>

	<div class="panel panel-default mb-4">
		<div class="panel-heading">

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
							@forelse ($itens_array as $item)
							<tr>
								<td>@php echo substr_replace($objetos[0], (strlen($objetos[0]) > 100 ? '...' : ''), 100); @endphp</td>
								<td>
									<div class="row">
										<div class="col-lg-8">
											<div class="input-group">
												<span class="input-group-addon" title ="Selecione as características a serem mantidas">
													{!! Form::radio('principal', $rows,  '', array('id' => 'principal')) !!} 
													@php $rows += 1; @endphp <!-- Incrementa o numero da linha -->
												</span>
												{!! Form::select('itens[]',  [null => ''] + $item, '', array('class' => 'form-control form-control-sm', 'id' => 'itens'))!!}
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
			
			<div class="row mb-2">
				<div class="col-md-3 col-6 col-md-offset-3 mt-2">
					<a href="{{route('licitacaoExibir', [$mesclados->first()->licitacao()->first()->uuid])}}" class="btn btn-primary btn-block" type="button">Voltar</a>
				</div>

				@include('form.submit', [
				'input' => 'Salvar', 
				'largura' => 3])
			</div>
			{{ Form::close() }} 
		</div><!-- / panel-heading -->

		<div class="panel-body">
			<table class="table table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr>
						<th class="w-1 center">Lista de Itens Mesclados </th>
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
													Item: {{$mesclado->licitacao()->first()->pivot->ordem}}
												</div>
												<div class="col-lg-9">
													Descrição: {{$mesclado->objeto }}
												</div>	
											</div>
											<div class="col-lg-1">
												<button type="button" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-minus-sign" title="Desfazer Mescla"></i></button>
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
												@foreach ($mesclado->itens()->get() as $item)
												<tr>
													<td>{{$item->requisicao()->first()->numero}}/{{$item->requisicao()->first()->ano}}</td>
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
		</div><!-- / panel-body -->
	</div> <!-- / panel  -->
@endsection
