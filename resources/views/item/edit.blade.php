	@include('form.hidden', [
	'input' => 'item',
	'value' =>  old($input ?? '') ??  $item->uuid ,
	'attributes' => ['id' => 'item' ]])

<div class="row">
	@include('form.number', [
	'input' => 'numero',
	'label' => 'Número',			
	'largura' => 2, 
	'value' =>  old($input ?? '') ??  $item->numero ,
	'attributes' => ['id' => 'numero', 'disabled' => '' ]])

	@include('form.number', [
	'input' => 'quantidade',
	'label' => 'Quantidade', 
	'largura' => 2, 
	'value' => old($input ?? '') ?? $item->quantidade,
	'attributes' => ['id' => 'quantidade', 'required' => '' ]])
	
	@include('form.number', [
	'input' => 'codigo',
	'label' => 'Código', 
	'largura' => 2, 
	'value' => old($input ?? '') ?? $item->codigo,
	'attributes' => ['id' => 'codigo', 'required' => '' ]])
	
	@include('form.select', [
	'input' => 'unidade', 
	'label' => 'Unidade', 
	'largura' => 3, 
	'selected' => old($input ?? '') ?? $item->unidade->id, 
	'options' => $unidades, 
	'attributes' => ['id' => 'unidade', 'required' => '']])

	@include('form.select', [
	'input' => 'grupo', 
	'label' => 'Grupo', 
	'largura' => 3, 
	'selected' => old($input ?? '') ?? $item->grupo, 
	'options' => $grupos ?? '', 
	'attributes' => ['id' => 'grupo', 'disabled' => '']])
</div>

<div class="row">
	@include('form.text', [
	'input' => 'objeto',
	'label' => 'Objeto',
	'value' => old($input ?? '') ?? $item->objeto,
	'attributes' => ['id' => 'objeto', 'autocomplete' => 'off' ]])
</div>

<div class="row">
	@include('form.textarea', [
	'input' => 'descricao', 
	'label' => 'Descrição Detalhada', 
	'value' => old($input ?? '') ??  $item->descricao,
	'attributes' => ['id' => 'descricao', 'required' => '' ]])
</div>