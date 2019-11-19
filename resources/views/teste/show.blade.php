@extends('layouts.index')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h1 Class="page-header">Alterar Pregão</h1>
	</div>
</div>

{{ Form::open(['url' => 'pregao/update', 'method' => 'post', 'class' => 'form-padrao']) }}
   @include('licitacao.forms.licitacao_show')

   <div class="row">

      @include('form.radioButton', [
      'input' => 'forma', 
      'label' => 'Forma*', 
      'value' => old($input ?? '') ?? $licitacao->licitacaoable->forma ?? '', 
      'largura' => 3,
      'options' => $formas ?? '', 
      'attributes' => ['id' => 'forma']])

      @include('form.radioButton', [
      'input' => 'srp',
      'label' => 'Registro de Preços*',
      'value' => old($input ?? '') ?? $licitacao->licitacaoable->srp ?? '',
      'largura' => 3, 
      'options' => ['1' => 'SIM', '2' => 'NÃO',], 
      'attributes' => ['id' => 'srp']])

      @include('form.radioButton', [
      'input' => 'srp_externo',
      'label' => 'Adesão/Participação',
      'value' => old($input ?? ''),
      'largura' => 3, 
      'options' => ['1' => 'Carona', '2' => 'Participante',], 
      'attributes' => ['id' => 'srp_externo']])

      @include('form.select', [
      'input' => 'tipo', 
      'label' => 'Tipo*', 
      'selected' => old($input ?? '') ?? '3', 
      'largura' => 3,
      'options' => $tipos ?? '', 
      'attributes' => ['id' => 'tipo', 'readonly' => '']])

   </div>

   @include('licitacao.forms.objeto_show')
{{ Form::close() }} 

<ul class="nav nav-tabs nav-justified ,">
	<li class="active"><a data-toggle="tab" href="#home">Requisições</a></li>
	<li><a data-toggle="tab" href="#menu1">Itens</a></li>
	<li><a data-toggle="tab" href="#menu2">Forncedores</a></li>
	<li><a data-toggle="tab" href="#">Participantes</a></li>
</ul>

<div class="tab-content">
   <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
   <div id="home" class="tab-pane fade in active">
      <div class="row mt-2">
         <div class="col-md-3">
            <label for="numeroAno" class="control-label">Numero da Requisição</label>
            <div class="input-group custom-search-form">
               <input type="text" name="requisicao"  id="requisicao" class="form-control form-control-sm" placeholder="Exemplo 012019 ...">
               <span class="input-group-btn">
                  <button class="btn btn-success" type="button" onclick="getDescricao('#requisicao', '#local')">
                     <i class="fa fa-search"></i>
                  </button>
               </span>
            </div>
         </div>

         {{ Form::open(['url' => 'licitacao/atribuir/requisicao', 'method' => 'post', 'class' => 'form-padrao']) }}

         @include('form.text', [
         'input' => 'descricao',
         'label' => 'Objeto', 
         'largura' => 6, 
         'value' => old($input ?? ''),
         'attributes' => ['id' => 'descricao', 'disabled' => '']])

         @include('form.submit', [
         'input' => 'Incluir', 
         'largura' => 3 ])

         <div id='local'></div>

         {{ Form::hidden('licitacao', $licitacao->uuid,  array('id' => 'licitacao')) }}
         {{ Form::close() }} 
      </div>


      <div class="row">
         <div class="col-md-6">
          <h3 Class="page-header">Lista de Requisições Incluidas:</h3>
       </div>
    </div>

      <table class="table table-hover tablesorter">
         <thead>
            <tr>
               <th>Requisição</th>
               <th>Descrição</th>
               <th>Solicitante</th>
            </tr>
         </thead>
         <tbody>
            @forelse ($licitacao->requisicoes as $value)
            <tr onclick="location.href ='{{route('itemEditar', [$licitacao->uuid])}}'; target='_blank';" style="cursor: hand;">
               <td>{{$value->numero}}/{{$value->ano}}</td>
               <td>{{$value->descricao}}</td>
               <td>{{$value->requisitante->first()['sigla']}}</td>
            </tr>
            @empty
            <tr><td colspan=4><center><i> Nenhuma unidade participante encontrada </i></center></td></tr>
            @endforelse
         </tbody>
      </table>
   </div>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div id="menu1" class="tab-pane fade">
   <div class="row">
     <div class="col-md-12">
       <h3 Class="page-header">Relação de Itens</h3>
    </div>
    </div>

    <table class="w-10">
     <thead>
       <tr>
         <th class="w-1 center">Número</th>
         <th class="w-4 center">Descrição Detalhada</th>
         <th class="w-2 center">Unidade</th>
         <th class="w-1 center">Código</th>
         <th class="w-1 center">Quantidade</th>
         <th class="w-1 center">Grupo</th>
      </tr>
   </thead>
   </table>
   <div class="row t-body table-responsive">
      <table class="table table-striped table-bordered">
         <tbody>
            @forelse ($licitacao->itens as $item)
            <tr onclick="location.href ='{{url('licitacao/item/editar', $item->uuid)}}'; target='_blank';" style="cursor: hand;">
               <td class="w-1 center">{{$item->licitacao()->first()->pivot->ordem}}</td>
               <td class="w-4 justicado">@php print($item->descricaoCompleta) @endphp</td>
               <td class="w-2 center">{{$item->unidade->nome}}</td>
               <td class="w-1 center">{{$item->codigo =='0'?'': $item->codigo}}</td>
               <td class="w-1 center">{{$item->quantidade}}</td>
               <td class="w-1 center"></td>
               <!--<td>isset($item->grupo->numero) ? $item->grupo->numero : ''</td>-->
            </tr>
            @empty
            <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
            @endforelse
         </tbody>
      </table>
   </div>
</div>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div id="menu2" class="tab-pane fade">
  <h3>Menu 2</h3>
  <p>Some content in menu 2.</p>
</div>
</div>
@endsection