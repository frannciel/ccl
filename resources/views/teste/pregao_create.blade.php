<div class="row">
	@include('form.radioButton', [
	'input' => 'forma', 
	'label' => 'Forma*', 
	'selected' => old($input ?? '') ?? '', 
	'largura' => 3,
	'options' => $formas ?? '', 
	'attributes' => ['id' => 'forma', 'required' => '']])

	@include('form.radioButton', [
	'input' => 'srp',
	'label' => 'Registro de Preços*',
	'value' => old($input ?? ''),
	'largura' => 3, 
	'options' => ['1' => 'SIM', '2' => 'NÃO',], 
	'attributes' => ['id' => 'srp', 'required' => '']])

	@include('form.radioButton', [
	'input' => 'srp_externo',
	'label' => 'Adesão/Participação',
	'value' => old($input ?? ''),
	'largura' => 3, 
	'options' => ['1' => 'Carona', '2' => 'Participante',], 
	'attributes' => ['id' => 'srp_externo']])

	@include('form.select', [
	'input' => 'tipo', 
	'label' => 'Tipo', 
	'selected' => old($input ?? '') ?? '3', 
	'largura' => 3,
	'options' => $tipos ?? '', 
	'attributes' => ['id' => 'tipo', 'readonly' => '']])
</div>
		
@include('licitacao.forms.pregao_create')