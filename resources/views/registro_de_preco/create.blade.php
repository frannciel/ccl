@extends('layouts.index')

@section('content')
<div class="panel panel-default mt-2">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h1 Class="center">Registro de Preços</h1>
			</div>
		</div>


		<div class="alert alert-default" role="alert">
			<h3>
				<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
				<a href="{{route('pregaoShow', [$licitacao->licitacaoable->uuid])}}">Pregão Eletrônico SRP N° {{$licitacao->numero ?? '' }} / {{$licitacao->ano ?? ''}}</a>
			</h3>
			<p><label>Objeto da Licitação:</label> {{$licitacao->objeto ?? ''}}</p>
		</div> 
	</div>

	<div class="panel-body">
		{{Form::open(['url' => 'registro/precos/store', 'method' => 'post', 'class' => 'form-padrao'])}}
			{{ Form::hidden('licitacao', $licitacao->uuid)}}
			
			<div class="row">
				@include('form.select', [
				'input' => 'fornecedor', 
				'label' => 'Fornecedor:', 
				'largura' => 12,  
				'selected' => old($input ?? ''), 
				'options' => $empresas ?? '', 
				'attributes' => ['id' => 'fornecedor', 'required' => '']])
			</div>

			<div class="row">
				@include('form.text', [
				'input' => 'numero',
				'label' => 'Ata numero:',			
				'largura' => 2, 
				'value' => old($input ?? '') ?? $ata_numero ?? '',
				'attributes' => ['id' => 'numero', 'placeholder' => '000', 'required' => '']])

				@include('form.text', [
				'input' => 'ano',
				'label' => 'Ata ano:',			
				'largura' => 2, 
				'value' => old($input ?? '') ?? $ata_ano ?? '',
				'attributes' => ['id' => 'ano', 'placeholder' => 'AAAA', 'required' => '']])


				@include('form.text', [
				'input' => 'publicacao', 
				'label' => 'Publicação do Edital no DOU:', 
				'largura' => 4,  
				'value' => old($input ?? '') ?? $licitacao->publicacao ?? '', 
				'attributes' => ['id' => 'publicacao', 'required' => '']])
			</div>
			
			<div class="row">
				@include('form.text', [
				'input' => 'assinatura', 
				'label' => 'Data de Assinatura:', 
				'largura' => 4, 
				'value' => old($input ?? ''), 
				'attributes' => ['id' => 'assinatura']])

				@include('form.text', [
				'input' => 'inicio', 
				'label' => 'Início da Vigência:', 
				'largura' =>4, 
				'value' => old($input ?? ''), 
				'attributes' => ['id' => 'inicio']])

				@include('form.text', [
				'input' => 'fim', 
				'label' => 'Fim da Vigência:', 
				'largura' => 4, 
				'value' => old($input ?? ''), 
				'attributes' => ['id' => 'fim']])
			</div>
	 
			<div class="row mt-2">
				@include('form.button', [
				'value' => 'Voltar',
				'largura' 	=> 3,
				'class'		=> 'btn btn-primary btn-block',
				'url' 		=> 	route('pregaoShow', [$licitacao->licitacaoable->uuid])])

				@include('form.button', [
				'value' => 'Voltar',
				'largura' 	=> 3,
				'class'		=> 'btn btn-primary btn-block',
				'url' 		=> 	route('requisicaoShow', [$licitacao->uuid]) ])


				@include('form.submit', [
				'input' => 'Gerar Ata SRP',
				'largura' => 3 ])
			</div>	
		{{Form::close()}} 
	</div>

	<div class="panel-footer">
		<div class="row">
			<div class="col-md-12">
				<table id="tabela" class="table table-striped">
					<thead>
						<tr>
							<th class="center">Numero</th>
							<th class="center">Fornecedor</th>
							<th class="center">vigência</th>
							<th class="center">Status</th>
							<th class="center"></th>
						</tr>
					</thead>
					<tbody>
						@forelse ($licitacao->registroDePrecos as $ata)
						<tr>
							<td class="center">{{$ata->numero}}/{{$ata->ano}}</td>
							<td class="justificado">{{$ata->fornecedor->nome}}</td>
							<td class="center">{{$ata->vigencia_fim}}</td>
							<td class="center">Vigente</td>
							<td class="center w-2">
								<div class="btn-group btn-group-justified" role="group" aria-label="...">
									<div class="btn-group" role="group">
										<a class="btn btn-default" type="button" href="{{url('registro/precos/documento', $ata->uuid)}}" role="button" target="_black">
											<i class="fa fa-eye"></i>
										</a>
									</div>
									<div class="btn-group" role="group">
										<a class="btn btn-default" type="button" href="{{url('registro/precos/pdf', $ata->uuid)}}" role="button" target="_black">
											<i class="fa fa-file-pdf-o"></i>
										</a>
									</div>
									<div class="btn-group" role="group">
										<form action="{{url('registro/precos/apagar',  $ata->uuid)}}" method="post">
											{{csrf_field() }}
											{{method_field('DELETE') }}
											<button type="submit" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></button>
										</form>
									</div>
								</div>
							</td>	
						</tr>
						@empty
						<tr><td><center><i>Nenhum registro de preços cadastrado </i></center></td></tr>
						@endforelse
					</tbody>
				</table> 
			</div>
		</div>
	</div>
</div>
@endsection

