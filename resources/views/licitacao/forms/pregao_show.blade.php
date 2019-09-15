<div class="row">
	@include('form.radioButton', [
	'input' => 'srp',
	'label' => 'Registro de Preços*',
	'value' => old($input ?? '') ?? $licitacao->licitacaoable->srp ?? '',
	'largura' => 3, 
	'options' => ['1' => 'SIM', '2' => 'NÃO',], 
	'attributes' => ['id' => 'srp']])

	@include('form.radioButton', [
	'input' => 'forma', 
	'label' => 'Forma*', 
	'value' => old($input ?? '') ?? $licitacao->licitacaoable->forma ?? '', 
	'largura' => 3,
	'options' => $formas ?? '', 
	'attributes' => ['id' => 'forma']])

	@include('form.select', [
	'input' => 'tipo', 
	'label' => 'Tipo*', 
	'selected' => old($input ?? '') ?? '3', 
	'largura' => 3,
	'options' => $tipos ?? '', 
	'attributes' => ['id' => 'tipo', 'readonly' => '']])
</div>

