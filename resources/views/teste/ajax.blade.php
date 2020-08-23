
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



<div class="panel-body">
@foreach ($requisicao->itens->sortBy('numero') as $item)
<div class="row panel-collapse collapse " id="collapse{{$item->id}}" role="tabpanel" aria-labelledby="headingOne">
	<div class="col-md-12">
		<table class="table table-bordered table-striped">
			<tr>
				<th colspan="4">
					<div class="row">
						<div class="col-md-12 center"><label class="control-label">Item: {{$item->numero}} - {{$item->objeto ?? ''}} </label></div>
					</div>
				</th>
			</tr>
			<tr>
				<th colspan="4">
					<div class="row">
						<div class="col-md-4 center"><label class="control-label">Quantidade: {{$item->quantidade}}</label></div>
						<div class="col-md-4 center"><label class="control-label">Valor Unitário: {{$item->valorMedio}}</label></div>
						<div class="col-md-4 center"><label class="control-label">Valor Total: {{$item->valorTotal}}</label></div>
					</div>
				</th>
			</tr>
			<tr>
				<th class="center">#</th>
				<th class="center">Fonte:</th>
				<th class="center">Valor:</th>
				<th class="center">Data/Hora:</th>
			</tr>
			@foreach ($item->cotacoes as $key => $cotacao)
			<tr onclick="location.href ='{{route('cotacaoEditar', [$cotacao->id])}}'; target='_blank';" style="cursor: pointer">
				<td class="col-md-1 center">{{$key + 1}}</td>
				<td class="col-md-7">{{$cotacao->fonte ?? '' }}</td>
				<td class="col-md-2 center">{{$cotacao->contabil ?? '' }}</td>
				<td class="col-md-2 center">{{$cotacao->data  ?? ''}}</td>
			</tr>
			@endforeach
		</table> 

		{{Form::open(['url' => 'cotacao/store', 'method' => 'post', 'class' => 'form-padrao'])}}
		{{ Form::hidden('requisicao', $requisicao->id)}}
		<div class="row">
			@include('form.text', [
			'input' => 'fonte',
			'label' => 'Fonte dos Dados',			
			'largura' => 6, 
			'value' => old($input ?? '') ?? $cotacao->fonte ?? '',
			'attributes' => ['id' => 'fonte', 'required' => '' ]])

			@include('form.text', [
			'input' => 'valor',
			'label' => 'Valor Pesquisado', 
			'largura' => 2, 
			'value' => old($input ?? '') ?? $cotacao->valor ?? '', 
			'attributes' => ['id' => 'valor', 'required' => '', 'autocomplete' => 'off' ]])

			@include('form.text', [
			'input' => 'data',
			'label' => 'Data',
			'largura' => 2, 
			'value' => old($input ?? '') ?? $cotacao->data ?? '',
			'attributes' => ['id' => 'data', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off']])

			@include('form.text', [
			'input' => 'hora',
			'label' => 'Hora',
			'largura' => 2, 
			'value' => old($input ?? '') ?? $cotacao->hora ?? '',
			'attributes' => ['id' => 'hora', 'placeholder' => 'HH:MM', 'autocomplete' => 'off']])

			@include('form.button', [
			'value' => 'Voltar',
			'largura' 	=> 3,
			'class'		=> 'btn btn-primary btn-block',
			'url' 		=> 	route('requisicaoExibir', [$requisicao->uuid]),
			'recuo' 	=> 3 ])

			@include('form.submit', [
			'input' => 'Salvar',
			'largura' => 3])
		</div>	
		{{Form::close()}}
	</div>
</div><!-- collapse -->
@endforeach
</div>
<div class="panel-footer">
	<div class="table-responsive">
		<table class="table table-striped table-bordered" id="dataTables-example">
			<thead>
				<tr>
					<th class=" left">Item</th>
					<th class=" left">Descrição</th>
					<th class=" center">Quantidade</th>
					<th class=" center">Valor Unitário</th>
					<th class=" center">Valor Total</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($requisicao->itens->sortBy('numero') as $item)
				<tr data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $item->id }}" aria-expanded="false" aria-controls="collapseOne">
					<td cursor="pointer" class="left">{{$item->numero}}</td>
					<td class="left">{{$item->objeto ?? ''}}</td>
					<td class="center">{{$item->quantidade}}</td>
					<td class="center">{{$item->valorMedio}}</td>
					<td class="center">{{$item->valorTotal}}</td>
				</tr>
				@empty
				<tr><td colspan=7><center><i> Nenhum item encontrado </i></center></td></tr>
				@endforelse
			</tbody>
		</table>
	</div><!-- table-responsive -->
</div>