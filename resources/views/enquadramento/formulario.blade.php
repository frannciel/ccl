@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Enquadramento de Material ou Serviço</h1>
		</div>
	</div>

    <div id="copiar">
	    <table frame=box width=100%>
	        <tr><td><b>Processo: </b> {{ $request->processo }}</td></tr>
	        <tr><td><br/><b>Valor Máximo: </b>R$ {{$request->valor}} ({{$extenso}})</td></tr>
	        <tr>
	            <td><br/><b>Tipo do Objeto: </b>
	            	{{$dados->where('tipo', 'classificacao')->whereIn('valor', $request->objeto)->first()->dado}}
				</td>
	        </tr>
	        <tr><td align='justify'><br/><b>Objeto: </b>{{ $request->descricao }}</td></tr>
	    </table>
	    <br/>
		@if($request->normativa == '0')

		    @if($request->modalidade == '5')
			    <!-- 
			    ////////////////////////////////////////////////////////////////////////////////////////////
			    ////////////////////////////////      DISPENSA      ////////////////////////////////////////
			    ////////////////////////////////////////////////////////////////////////////////////////////
				-->
		        <table width=100% frame=box>
		            <tr><td colspan=3><b>Dispensa de Licitação nº </b>{{$request->numero}}</td></tr>
		            <tr>
		                <td><br/><b>Lei nº:</b> 8.666 de 21 de Junho de 1993 </td>
						<td><br/><b>Artigo: </b> 24°</td>
						<td><br/><b>Inciso: </b>
							{{$dados->where('tipo', '866624')->whereIn('valor', $request->inciso)->first()->dado}}
						</td>
					</tr>
					<tr><td colspan=3 align='justify'><br/><b>Justificativa:</b> {{$request->justificativa}} </td></tr>
		        </table>
		    @endif

		    @if($request->modalidade == '6')
			    <!-- 
			    ////////////////////////////////////////////////////////////////////////////////////////////
			    ////////////////////////////////      INEXIGIBILIDADE      /////////////////////////////////
			    ////////////////////////////////////////////////////////////////////////////////////////////
				-->
		        <table width=100% frame=box>
		            <tr><td colspan=3><b>Inexigibilidade de Licitação nº </b>{{$request->numero}}</td></tr>
		            <tr>
		                <td><br/><b>Lei nº:</b> 8.666 de 21 de Junho de 1993</td>
						<td><br/><b>Artigo: </b> 25°</td>
						@php $value = $dados->where('tipo', '866625')->whereIn('valor', $request->inciso)->first() @endphp
						@if($value->valor == 0)
							<td><br/><b><i>Caput</i></b></td>
						@else
							<td><br/><b>Inciso: </b> {{$value->dado}}</td>
						@endif
					</tr>
					<tr><td colspan=3 align='justify'><br/><b>Justificativa:</b> {{$request->justificativa}} </td></tr>
		        </table>
		    @endif

			@if($request->modalidade != 6 && $request->modalidade != 5)
				<!-- 
			    ////////////////////////////////////////////////////////////////////////////////////////////
			    ////////////////////////////////      LICITAÇÃO TRADICIONAL      /////////////////////////
			    ////////////////////////////////////////////////////////////////////////////////////////////
				-->
				<table width=100% frame=box>
		            <tr><td colspan=2><b>Licitação nº</b> {{$request->numero}}</td></tr>
		            <tr>
		                <td><br/><b>Modalidade:</b>
		                	{{$dados->where('tipo', 'modalidade')->whereIn('valor', $request->modalidade)->first()->dado}}
						</td>
		                <td><br/>Lei 8.666 de 21 de Junho de 1993, Art. 22°</td>
		            </tr>
		            @if($request->modalidade != 3 && $request->modalidade != 4)
			            <tr>
			                <td><br/><b>Tipo:</b>
			                	{{$dados->where('tipo', 'tipo')->whereIn('valor', $request->tipo)->first()->dado}}
							</td>
			                <td><br/>Lei 8.666 de 21 de Junho de 1993, Art. 45 §1º</td>
			            </tr>
		           	@endif
		        </table>
			@endif
		 @endif

		@if($request->normativa == 2)
			<!-- 
			////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////      PREGÃO      //////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////
			-->
			<table width=100% frame=box>
		        <tr><td colspan=2><b>Licitação nº </b>{{$request->numero}}</td></tr>
		        <tr>
		            <td><br/><b>Modalidade:</b> Pregão  </td>
		            <td><br/>Lei 10.520 de 17 de Julho de 2002, Art. 1°.</td>
		        </tr>
		        <!-- 
		        //////////////////////////// FORMA PRESENCIAL OU ELETRÔNICO///////////////////////////
		     	-->
		        <tr>
		        	@if($request->forma == 0 || $request->forma == 3)
		            <td><br/><b>Forma:</b> Presencial </td>
		            <td><br/>Lei 10.520 de 17 de Julho de 2002.</td>
		        	@else
		            <td><br/><b>Forma:</b> Eletrônica</td>
		            <td><br/>Decreto 5.450 de 31 de Maio de 2005, Art. 1°.</td>
		            @endif
		        </tr>
		        <!-- 
		        //////////////////////////// TIPO MENOR PREÇO///////////////////////////
		     	-->
		        <tr>
		            <td><br/><b>Tipo:</b> Menor Preço</td>
		            <td><br/>Lei 10.520 de 17 de Julho de 2002, Art. 04, Inc. X.</td>
		        </tr>
		        <!-- 
		        //////////////////////////// REGISTRO DE PREÇOS ///////////////////////////
		     	-->
		        @if($request->forma == 2 || $request->forma == 3)
		        <tr>
		            <td><br/><b>Registro de Preços</b></td>
		            <td><br/>Decreto 7.892 de 23 de Janeiro de 2013, Art. 1°</td>
		        </tr>
		        @endif
		    </table>
		@endif

		@if($request->normativa == 1)
			<!-- 
		    ////////////////////////////////////////////////////////////////////////////////////////////
		    ////////////////////////////////      DISPENSA LEI 11.947      /////////////////////////////
		    ////////////////////////////////////////////////////////////////////////////////////////////
			-->
		    <table width=100% frame=box>
		        <tr><td colspan=2><b>Dispensa de Licitação nº: </b>{{$request->numero}}</td></tr>
		        <tr>
		            <td><br/><b>Lei nº:</b> 11.947 de  de  de 2009 </td>
					<td><br/><b>Artigo: </b> 4°</td>
				</tr>
				<tr>
					<td colspan=2 align='justify'><br/><b>Justificativa:</b> 
						Aquisição de gêneros alimentícios destinados a alimentação escolar nos termos da resoluução 23 do FNDE.
					</td>
				</tr>
		    </table>
		@endif
		<br />
	</div>

	<div class="row">
		@include('form.submit', [
		'input' => 'Copiar', 
		'largura' => '6', 
		'recuo' => 3,
		'attributes' => ['class' => 'btn btn-info btn-block', 'data-clipboard-action' => 'copy',  'data-clipboard-target' => '#copiar']])
	</div>
</div>
@endsection