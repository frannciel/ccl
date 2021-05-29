@extends('layouts.index')

@section('content')
   <h2 align="center">Relatório de Pesquisa de Preços</h2>
   <br/>
   @if (count($requisicao->itens) > 0)

      <div id="pesquisa">
         <table bgcolor="#f0f0f5"  width='95%' align="center" frame=box>
             <tr>
               <td><b>REQUISIÇÃO:</b> {{$requisicao->ordem}}</td>
            </tr>
            <tr>
               <td><b>SETOR REQUISITANTE:</b> {{$requisicao->requisitante->nome}}</td>
            </tr>
            <tr>
               <td><b>OBJETO:</b> {{$requisicao->descricao}}</td>
            </tr>
         </table> 
        
         <br/>
         <table width='80%' align="center" frame=box>
            <tr bgcolor="#f0f0f5"><td><font size="2" align="justify">
                  Pesquisa de preços em conformidade com a Instrução Normativa Nº 5 de 27 de Junho de 2014 alterada pela Instrução Normativa nº 3, de 20 de abril de 2017. Os preços constantes no presente relatório atendem aos seguntes incisos Art. 2º: Inciso I - Painel de Preços - (http://paineldeprecos.planejamento.gov.br), Inciso III - pesquisa publicada em mídia especializada, sítios eletrônicos especializados ou de domínio amplo (...) e Inciso IV - pesquisa com os fornecedores. O resultado da pesquisa será a média dos preços obtidos conforme Art. 2º Paragrafo §2º.
            </font></td></tr>
         </table>
         <br/>

         @foreach ($requisicao->itens as $item)
            <table width='95%' align="center" frame="box">
               <tr bgcolor="#f0f0f5">
                  <td width='50%'> Item: {{$item->numero}} - {{$item->objeto}} </td>
                  <td width='15%'> Quantidade: {{$item->quantidade}}</td>
                  <td width='15%'> Valor Médio: {{$item->valorMedio}}</td>
                  <td width='20%'> Valor Total: {{$item->valorTotal}} </td>
               </tr>
            </table>
            @if ($item->media > 0)
            <table frame="box"  width="80%"  align="center" >
         		<tr bgcolor="#12E0E4">
         			<th width="10%" align="center" class="center">Numero</th>
         			<th width="50%" align="center" class="center">Fonte dos dados</th>
         			<th width="20%" align="center" class="center">Data e Hora</th>
         			<th width="20%" align="center" class="center">Valor Cotado</th>
         		</tr>
         		@foreach ($item->cotacoes as  $key => $cotacao)
         			<tr bgcolor="#fff">
         				<td width="10%" align="center">{{$key + 1}}</td>
         				<td width="50%" align="left">{{$cotacao->fonte ?? ''}}</td>
         				<td width="20%" align="center">{{$cotacao->data ?? ''}}</td>
         				<td width="20%" align="center" >{{$cotacao->contabil ?? ''}}</td> 
         			</tr> 
         		@endforeach
            </table>
            @endif
            <br/>
         @endforeach

         <table width='95%' align="center" frame="box">
            <tr bgcolor="#ccc">
               <td align="center"><h4> Total: R$ {{$requisicao->valorTotal}}</h4></td>
            </tr>
         </table>
      </div>
   
      <div class="row mt-2">
         <div class="col-md-3 col-md-offset-1">
            <a class="btn btn-primary btn-block" type="button" href="{{url('requisicao/exibir', $requisicao->uuid)}}" >Voltar</a>
         </div>
         <div class="col-md-3">
            <button class='btn btn-block btn-success' data-clipboard-action='copy' data-clipboard-target='#pesquisa'>Copiar </button>
         </div>
         <div class="col-md-3">
            <a class="btn btn-default btn-block" type="button" href="{{route('cotacao.relatorioPdf', $requisicao->uuid)}}" role="button" target="_black">
               Exportar PDF
            </a> 
         </div>
      </div>
   @else   
      <table align="center"><tr><td><font size="3"><i> Nenhuma Cotação Encontrada </i></font></td></tr></table>
   @endif
@endsection