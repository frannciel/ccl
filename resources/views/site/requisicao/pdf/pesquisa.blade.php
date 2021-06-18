<style type="text/css">
   .bolder{
      font-weight: bolder;
   }
</style>
@include('site.pdf.cabecalho')
<h2 align="center">Solicitação de Pesquisa de Preços</h2>
<br/>

<table style="border: 1px solid black;width:100%;">
   <tr>
      <td class="bolder">REQUISIÇÃO:</td>
      <td>{{$requisicao->ordem}}</td>
   </tr>
   <tr>
      <td class="bolder">SOLICITANTE:</td>
      <td>{{$requisicao->requisitante->nome}}</td>
   </tr>
   <tr>
      <td class="bolder">RAMAL:</td>
      <td>{{$requisicao->requisitante->ramal}}</td>
   </tr>
   <tr>
      <td class="bolder">E-MAIL:</td>
      <td>{{$requisicao->requisitante->email}}</td>
   </tr>
   <tr>
      <td class="bolder">OBJETO:</td>
      <td>{{$requisicao->descricao}}</td>
   </tr>
</table> 
<br/>

<table border=1 width=100% cellspacing=0 cellpadding=2>
   <thead>
      <tr bgcolor="#F5F5F5">
         <th align="center" class="center">Item</th>
         <th align="center" class="center">Descrição detalhada dos materiais ou serviços</th>
         <th align="center" class="center">Código</th>
         <th align="center" class="center">Unidade</th>
         <th align="center" class="center">Quantidade</th>
      </tr>
   </thead>

   <tbody>
      @forelse ($requisicao->itens->sortBy('numero') as $item)
      <tr>
         <td align="center" class="center">{{$item->numero}}</td>
         <td align="justify" class="justificado">@php print($item->descricaoCompleta) @endphp</td>
         <td align="center" class="center">{{$item->codigo =='0'?'': $item->codigo}}</td>
         <td align="center" class="center">{{$item->unidade->nome}}</td>
         <td align="center" class="center">{{$item->quantidade}}</td>
      </tr>
      @empty
      <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
      @endforelse
   </tbody>
</table>
<br/>
<br/>

