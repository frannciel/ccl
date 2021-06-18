@extends('site.layouts.index')

@section('content')
	<div class="flex">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item"><a href="{{route('requisicao.index')}}">Requisicao</a></li>
				<li class="breadcrumb-item active" aria-current="page">Novo</li>
			</ol>
		</nav>
		<h1 Class="page-header page-title">Cadastrar requisição</h1>
	</div>

	{{ Form::open(['url' => 'requisicao.store', 'method' => 'post', 'class' => 'form-padrao']) }}
		<div class="row">
			@include('form.select', [
			'input' => 'requisitante', 
			'label' => 'Requisitante *', 
			'selected' => old($input ?? ''), 
			'largura' => 6,
			'options' => $requisitantes, 
			'attributes' => ['id' => 'requisitante', 'required' => '']])

			<div class="col-md-6 {{$errors->has('tipo') ? ' has-error' : '' }}">
				<label for="tipo">Tipo de Contratação *</label>
				<select name="tipo" class="form-control" required="">
					<option noSelected></option>
					<optgroup label="Material">
						<option value="1">Permanente</option>
						<option value="2" >Consumo</option>
					</optgroup>
					<optgroup label="Serviço">
						<option value="3">Não Continuado</option>
						<option value="4">Continuado</option>
						<option value="5">Tempo Indeterminado</option>
					</optgroup>
					<option value="6" class="font-weight-bold">Obra</option>
					<option value="7" class="font-weight-bold">Serviço de Engenharia</option>
				</select>
				@if ($errors->has('tipo'))
				    <span class="help-block">
				    	<strong>{{ $errors->first('tipo') }}</strong>
				    </span>
				@endif	
			</div>
		</div>

		<div class="row">
	   		@include('form.radioButton', [
			'input' => 'prioridade',
			'label' => 'Grau de Prioridade*',
			'value' => old($input ?? ''),
			'largura' => 3, 
			'options' => ['1' => 'Alta', '2' => 'Média', '3' => 'Baixa' ], 
			'attributes' => ['id' => 'prioridade', 'required' => '']])

	   		@include('form.radioButton', [
			'input' => 'renovacao',
			'label' => 'Renovação de Contrato*',
			'value' => old($input ?? ''),
			'largura' => 3, 
			'options' => ['1' => 'Sim', '2' => 'Não' ], 
			'attributes' => ['id' => 'renovacao', 'required' => '']])

			@include('form.radioButton', [
			'input' => 'capacitacao',
			'label' => 'Necessita Capacitação*',
			'value' => old($input ?? ''),
			'largura' => 3, 
			'options' => ['1' => 'Sim', '2' => 'Não' ], 
			'attributes' => ['id' => 'capacitacao', 'required' => '']])

			@include('form.radioButton', [
			'input' => 'pac',
			'label' => 'Registrado no PAC*',
			'value' => old($input ?? ''),
			'largura' => 3, 
			'options' => ['1' => 'Sim', '2' => 'Não' ], 
			'attributes' => ['id' => 'pac', 'required' => '']])
	   	</div>
		
		<div class="row">
			@include('form.text', [
			'input' => 'descricao',
			'label' => 'Objeto *',
			'value' => old($input ?? ''),
			'largura' => 12, 
			'attributes' => ['id' => 'descricao', 'required' => '']])
	   </div>

	   	<div class="row">
			@include('form.textarea', [
			'input' => 'justificativa',
			'label' => 'Justificativa da Contratação *',
			'value' => old($input ?? ''),
			'largura' => 12, 
			'attributes' => ['id' => 'justificativa', 'required' => '',  'rows'=>'5']])
	    </div>

	    <div class="row">
	    	@include('form.text', [
			'input' => 'previsao',
			'label' => 'Data da Necessidade',
			'value' => old($input ?? ''),
			'largura' => 4, 
			'attributes' => ['id' => 'data']])

			@include('form.text', [
			'input' => 'metas',
			'label' => 'Código da(s) Meta(s) do PMI, separdas por vírgula',
			'value' => old($input ?? ''),
			'largura' => 8, 
			'attributes' => ['id' => 'metas']])
	    </div>

	    <div class="row mt-2">
	    	@include('form.button', [
	    	'value' => 'Voltar',
	    	'largura' 	=> 3,
	    	'class'		=> 'btn btn-primary btn-block',
	    	'url' 		=> 	route('requisicao.index'),
	    	'recuo' 	=> 3 ])

	    	@include('form.submit', [
	    	'input' => 'Salvar', 
	    	'largura' => 3])
	    </div>
	</div>
	{{ Form::close() }} 
@endsection

 