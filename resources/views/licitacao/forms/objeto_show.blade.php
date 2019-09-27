<div class="row">
	@include('form.textarea', [
	'input' => 'objeto',
	'label' => 'Objeto*',
	'value' => old($input ?? '') ?? $licitacao->objeto ?? '',
	'largura' => 12, 
	'attributes' => ['id' => 'objeto', 'required' => '',  'rows'=>'5']])
</div>

<div class="row">
	<div class="col-md-3 col-md-offset-3 mt-2">
		<a href="{{route('licitacao')}}" class="btn btn-primary btn-block" type="button">Voltar</a>
	</div>

	@include('form.submit', [
	'input' => 'Salvar', 
	'largura' => 3])
</div>
