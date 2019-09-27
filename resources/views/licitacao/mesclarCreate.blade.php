@extends('layouts.index')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Mesclar Itens da Licitcação</h1>
		</div>
	</div>

	{{ Form::open(['url' => 'budega/', 'method' => 'post', 'class' => 'form-padrao']) }}

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
												<span class="input-group-addon">
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

		<div class="row">
			@include('form.submit', [
			'input' => 'Salvar', 
			'largura' => 3,
			'recuo' => 3 ])
		</div>
	{{ Form::close() }} 

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
@endsection
