@extends('layouts.app')

@section('content')
<div class="container">
	<div class="content">
		<div class="card mb-2">
		   <div class="p-2 card-body">
				{{ Form::open(['url' => '/requisicao', 'method' => 'POST', 'class' => 'form-padrao']) }}

				<div class="row mb-3">
			   		@include('form.select', ['input' => 'requisitante', 'label' => 'Requisitante', 'largura' => '6', 'selected' => '{{ old($input) }}', 'options' => [
			   			'1' => 'DEPAD',
			   		 	'2' => 'GGTI', 
			   		 	'3' => 'Diretoria Acadêmica',
			   		 	'4' => 'Gestão de Pessoas', 
			   		 	'5' => 'Diretoria Administrativa',
			   		 	'6' => 'Comunicacão Social', 
			   		 	'7' => 'Segurança do Trabalho',
			   		 	'8' => 'Almoxarifado', 
			   		 	'9' => 'DEPAE',
			   		 	'10' => 'Coordenação de Segurança do Trabalho', 
			   		 	'11' => 'Laboratório de segurança do Trabalho'
			   		], 
			   		'attributes' => ['id' => 'requisitante', 'class' => 'form-control form-control-sm']])
		    	</div>
		    	<div class="row mb-3">
			   		@include('form.select', ['input' => 'tipo', 'label' => 'Tipo de Despesa', 'largura' => '6', 'selected' => '{{ old($input) }}', 'options' =>  $tipos,	'attributes' => ['id' => 'requisitante', 'class' => 'form-control form-control-sm']])
		    	</div>
				<div class="row mb-3">
					@include('form.text', ['input' => 'descricao', 'label' => 'Objeto', 'largura' => '6', 'attributes' => ['id' => 'objeto', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}' ]])
			   </div>
			    <div class="row mb-3">
		    		@include('form.submit', ['input' => 'Cadastrar', 'largura' => '6', 'attributes' => ['class' => 'btn btn-primary btn-block']])
		    	</div>	
				{{ Form::close() }} 
			</div>
		</div>
	</div>
</div>
<!-- @include('form.password', ['input' => 'senha', 'label' => 'Senha', 'attributes' => ['id' => 'senha', 'required' => '', 'class' => 'form-control', ]]) -->
<!--$list = $locations->pluck('title', 'id')->toArray(); -->
@endsection

 