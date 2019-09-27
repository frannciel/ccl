
@if($etapa == 0) <!-- Lei 8666/93 -->
	@include('form.select', [
	'input' => 'modalidade', 
	'label' => 'Modalidade:', 
	'largura' => '4', 
	'selected' => '{{ old($input) }}', 
    'options' => $modalidades,
	'attributes' => ['id' => 'modalidade', 'required' => '', 'class' => 'form-control form-control-sm temp', 'onchange' => 'enviar(name)']
	])
@endif

@if($etapa == 7  ) <!-- Pregão -->
	<div class="row">
		@include('form.radioButton', [
		'input' => 'srp',
		'label' => 'Registro de Preços*',
		'value' => old($input ?? ''),
		'largura' => 3, 
		'options' => ['1' => 'SIM', '2' => 'NÃO',], 
		'attributes' => ['id' => 'srp', 'required' => '']])

		@include('form.radioButton', [
		'input' => 'forma', 
		'label' => 'Forma*', 
		'selected' => old($input ?? '') ?? '', 
		'largura' => 3,
		'options' => $formas ?? '', 
		'attributes' => ['id' => 'forma', 'required' => '']])

		@include('form.select', [
		'input' => 'tipo', 
		'label' => 'Tipo*', 
		'selected' => old($input ?? '') ?? '3', 
		'largura' => 3,
		'options' => $tipos ?? '', 
		'attributes' => ['id' => 'tipo', 'readonly' => '']])
	</div>
@endif


@if($etapa == 2) <!-- Contratação Direta -->
	@include('form.select', [
	'input' => 'inciso', 
	'label' => 'Inciso:', 
	'largura' => '4', 
	'selected' => '{{ old($input) }}', 
    'options' => $incisos,
	'attributes' => ['id' => 'inciso', 'required' => '', 'class' => 'form-control form-control-sm temp']
	])

	@include('form.text', [
	'input' => 'justificativa', 
	'label' => 'Justificativa para Contração Direta:', 
	'largura' => '12', 
	'attributes' => ['id' => 'justificativa', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}' ]
	])
@endif

@if($etapa == 3) <!-- Licitação Tradicional  -->
	@include('form.select', [
	'input' => 'tipo', 
	'label' => 'Tipo:', 
	'largura' => '4', 
	'selected' => '{{ old($input) }}', 
    'options' => $tipos,
	'attributes' => ['id' => 'tipo', 'required' => '', 'class' => 'form-control form-control-sm']
	])
@endif
