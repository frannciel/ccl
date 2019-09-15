<div class="row">
	@include('form.number', [
	'input' => 'numero',
	'label' => 'Número*', 
	'largura' => 2,
	'value' => old($input ?? ''),
	'attributes' => ['id' => 'numero', 'required' => '']])

	@include('form.number', [
	'input' => 'ano',
	'label' => 'Ano*', 
	'largura' => 2,
	'value' => old($input ?? ''),
	'attributes' => ['id' => 'ano', 'required' => '']])

	@include('form.text', [
	'input' => 'processo',
	'label' => 'Processo*',
	'value' => old($input ?? ''),
	'largura' => 3, 
	'attributes' => ['id' => 'processo', 'required' => '']])

	@include('form.text', [
	'input' => 'processoOrigem',
	'label' => 'Processo Original',
	'value' => old($input ?? ''),
	'largura' => 3, 
	'attributes' => ['id' => 'processoOrigem', 'placeholder' => 'Processo Externo']])
</div>