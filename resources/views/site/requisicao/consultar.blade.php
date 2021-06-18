@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
   
   <div class="row">
      <div class="col-md-12">
         <h1 Class="page-header">Buscar Requisição</h1>
      </div>
   </div>

	<div class="row">
		<div class="col-md-3">
			<label for="numeroAno" class="control-label">Numero e Ano</label>
			<div class="input-group custom-search-form">
				<input type="text" name="numeroAno"  id="numeroAno" class="form-control form-control-sm" placeholder="Ex: 012019 ...">
				<span class="input-group-btn">
					<button class="btn btn-success" type="button" onclick="getDescricao('numeroAno')">
						<i class="fa fa-search"></i>
					</button>
				</span>
			</div>
		</div>
		
		@include('form.text', [
		'input' => 'descricao',
		'label' => 'Objeto', 
		'largura' => 8, 
		'value' => old($input ?? ''),
		'attributes' => ['id' => 'descricao', 'disabled' => '']])
	</div>


	@switch($acao)
	    @case('preco')
	       	{{Form::open(['url' => '/cotacao/novo/', 'method' => 'GET', 'class' => 'form-padrao'])}}
	        @break
	    @case('importe')
	       	{{Form::open(['url' => '/importar/novo', 'method' => 'GET', 'class' => 'form-padrao'])}}
	        @break
	@endswitch
	<div class="row">
		@include('form.submit', [
		'input' => 'Enviar', 
		'largura' => 6,
		'recuo' => 3])
	</div>	
	{{Form::close()}}
</div>
@endsection