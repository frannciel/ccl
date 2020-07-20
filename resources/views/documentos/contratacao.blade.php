@extends('layouts.index')

@section('content')
<h2 align="center">Solicitação de Empenho</h2>
<br/>
<table  cellspacing=0 cellpadding=2 border=1 width=100% id='home'>
   <tr bgcolor='#ddd'>
      <td colspan=3 align=center><b>PROCESSO</b></td>
      <td colspan=2 align=center><b>MODALIDADE</b></td>
   </tr>
   <tr>
      <td colspan=3 align=center height=40px>
         <div>Instituto Federal da Bahia Campus Eunápolis - 
            Processo {{ $contratacao->licitacao->processo}}
         </div>
      </td>
      <td colspan=2 align=center>
         {{$contratacao->licitacao->licitacaoable_type}} 
         <div>
            <b>{{$contratacao->licitacao->ordem}}</b>
         </div>
      </td>
   </tr>
   <tr bgcolor='#ddd'>
      <td align=center width="10%"><b>CONTRATO</b></td>
      <td align=center width="55%"><b>FORNECEDOR/FAVORECIDO</b></td>
      <td align=center width="15%"><b>CPF/CNPJ</b></td>
      <td colspan=2 align=center width="20%"><b>E-MAIL/FONE</b></td>
   </tr>
   <tr>
      <td align=center><font color="#333">{{$contratacao->contrato}}</font></td>
      <td>{{$contratacao->fornecedor->nome}}</td> 
      <td align=center>{{$contratacao->fornecedor->cpfCnpj}} </td> 
      <td  colspan=2 >
         <div>
            <font size="1">{{$contratacao->fornecedor->email}}</font>
         </div>
         <div> 
            <font size="1">
            {{$contratacao->fornecedor->telefone_1}} /
            {{$contratacao->fornecedor->telefone_2}}
            </font>
         </div>
      </td>
   </tr>
   <tr bgcolor='#ddd'>
      <td align=center><b>ITEM</b></td>
      <td align=center><b>DESCRIÇÃO</b></td>
      <td align=center><b>QUANTIDADE</b></td>
      <td align=center><b>VALOR UNITÁRIO</b></td>
      <td align=center><b>TOTAL</b></td>
   </tr>
   @foreach ($contratacao->itens->sortBy('ordem') as $item)
   <tr>
      <td align='center'>{{$item->ordem}}</td>
      <td>
         @php print($item->descricaoCompleta);@endphp
      </td>
      <td align=center>{{$item->pivot->quantidade}}</td>
      <td align=center>R$ {{number_format($item->pivot->valor, 4, ',', '.')}}</td>
      <td align=center>R$ {{number_format(($item->pivot->quantidade * $item->pivot->valor),2, ',', '.')}}</td>
   </tr>
   @endforeach
<tr>
   <td colspan=4 align=right><b>TOTAL GERAL</b></td>
   <td align=center><b>
     R$ {{$contratacao->total}}
   </b></td>
</tr>
<tr>
   <td colspan=5><b>Observações:</b> {{$contratacao->observacao}}</td>
</tr>
</table>
      <div class="row  mt-2">
         <div class="col-md-6 col-md-offset-3">
            <button class='btn btn-block btn-success' data-clipboard-action='copy' data-clipboard-target='#home'>COPIAR RELATÓRIO</button>
         </div>
      </div>
@endsection
