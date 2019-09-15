<div class="row">
	@include('form.number', [
	'input' => 'numero',
	'label' => 'Número', 
	'largura' => 2,
	'value' => old($input ?? '') ?? $licitacao->numero ?? '',
	'attributes' => ['id' => 'numero', 'disabled' => '']])

	@include('form.number', [
	'input' => 'ano',
	'label' => 'Ano', 
	'largura' => 2,
	'value' => old($input ?? '') ?? $licitacao->ano ?? '',
	'attributes' => ['id' => 'ano', 'disabled' => '']])

	@include('form.text', [
	'input' => 'processo',
	'label' => 'Processo',
	'value' => old($input ?? '') ?? $licitacao->processo ?? '',
	'largura' => 3, 
	'attributes' => ['id' => 'processo']])

	@include('form.text', [
	'input' => 'processoOrigem',
	'label' => 'Processo Original',
	'value' => old($input ?? '') ?? $licitacao->processoOrigem ?? '',
	'largura' => 3, 
	'attributes' => ['id' => 'processoOrigem', 'placeholder' => 'Processo Externo']])
</div>