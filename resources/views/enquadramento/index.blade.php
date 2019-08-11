@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Enquadramento de Material ou Serviço</h1>
		</div>
	</div>

    <div id="copiar">
	    <table class="table">
	    	<thead>
	    		<tr>
	    			<th>Processo</th>
	    			<th>Modalidade</th>
	    			<th>Número</th>
	    			<th>Valor</th>
	    			<th>Classificação</th>
	    			<th>Objeto</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		@foreach($enquadramentos as $value)
			        <tr>
			        	<td>{{ $value->processo }}</td>
			        	<td>{{ $value->modalidade }}</td>
				        <td>{{ $value->numero}} </td>
			        	<td>{{ $value->valor }}</td>
			        	<td>{{ $value->classificacao}} </td>
				        <td>{{ $value->objeto}} </td>
			        </tr>
		        @endforeach
	        </tbody>
	    </table>
	    <br/>
		
</div>
@endsection