<table class="table table-hover tablesorter">
	<thead>
		<tr>
			<th colspan="4">Selecione os itens a serem atribuidos a este fornecedor</th>
		</tr>
		<tr>
		 	<th>#</th>
			<th>ITEM</th>
			<th>DESCRIÇÃO DETALHADA</th>
			<th>UNIDADE </th>
		</tr>
	</thead>
	<tbody>
		@forelse ($requisicao->itens as $item)
			<tr>
				<td class='col-md-1'><input type="checkbox" id="itens" name="itens[]" value="{{$item->id}}"></td>
				<td class='col-md-2'>{{$item->numero}}</td>
				<td class='col-md-6'>@php print($item->descricao) @endphp</td>
				<td class='col-md-3'>{{$item->unidade->nome}}</td>
			</tr>
		@empty
			<tr><td><center><i> Nenhum item buscado </i></center></td></tr>
		@endforelse
	</tbody>
</table>

<div class="row">
	@include('form.submit', [
	'input' => 'Cadastrar',
	'largura' => 4,
	'recuo' => 4 ])
</div>
	
	
	
	
	
	