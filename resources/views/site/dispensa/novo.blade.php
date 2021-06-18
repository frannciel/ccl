@extends('layouts.app')

@section('content')
<div class="container">
   <div class="card mb-2">
      <div class="p-2 card-body"> 
         {{ Form::open(['url' => '/requisicao', 'method' => 'POST', 'class' => 'form-padrao']) }}
            <div class="row mb-3">
               @include('form.select', ['input' => 'requisitante', 'label' => 'Requisitante', 'selected' => '{{ old($input) }}', 'options' => [
                  '1' => 'DEPAD',
                  '2' => 'GGTI', 
                  '3' => 'Diretoria Acadêmica',
                  '4' => 'Gestão de Pessoas', 
                  '5' => 'Diretoria Administrativa',
                  '6' => 'Comunicacão Social', 
                  '7' => 'Segurança do Trabalho',
                  '8' => 'Almoxarifado', 
                  '9' => 'DEPAE',
                  '10' => 'Coordenação de Segurança do Trabalho', 
                  '11' => 'Laboratório de segurança do Trabalho'
               ], 
               'attributes' => ['id' => 'requisitante', 'class' => 'form-control form-control-sm']])

               @include('form.select', ['input' => 'tipo', 'label' => 'Tipo de Despesa', 'selected' => '{{ old($input) }}', 'options' =>  ['1' => 'Material','2' => 'Serviço', '3' => 'Obra', '4' => 'Serviço de Engenharia'],  'attributes' => ['id' => 'requisitante', 'class' => 'form-control form-control-sm']])

            </div>
            <div class="row mb-3">
                  @include('form.select', ['input' => 'tipo', 'label' => 'Tipo de Despesa', 'selected' => '{{ old($input) }}', 'options' =>  ['1' => 'Consumo','2' => 'Permanente'],  'attributes' => ['id' => 'requisitante', 'class' => 'form-control form-control-sm']])
                  @include('form.select', ['input' => 'tipo', 'label' => 'Tipo de Despesa', 'selected' => '{{ old($input) }}', 'options' =>  ['1' => 'Não Continuado','2' => 'Continuado','2' => 'Prazo Indeterminado'],  'attributes' => ['id' => 'requisitante', 'class' => 'form-control form-control-sm']])
            </div>
            <div class="row mb-3">
               @include('form.text', ['input' => 'descricao', 'label' => 'Objeto', 'attributes' => ['id' => 'objeto', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}' ]])
            </div>
             <div class="row mb-3">
               @include('form.submit', ['input' => 'Cadastrar', 'attributes' => ['class' => 'btn btn-primary btn-block']])
            </div>    
         {{ Form::close() }}
      </div>
   </div>   

   <div class="card mb-2">
      <div class="card-herder">
         <h2 align="center">Item da Requisição</h2>
      </div>
      <div class="p-2 card-body">          
            <table id="myTable" class="table table-hover tablesorter">
               <thead>
                  <tr>
                     <th>Número</th>
                     <th>Descrição Detalhada</th>
                     <th>Código</th>
                     <th>Unidade </th>
                     <th>Quantidade</th>
                     <th>Valor</th>
                     <th>Grupo</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse ($requisicao->itens as $item)
                  <tr>
                     <td>{{$item->numero}}</td>
                     <td class="justificado">@php print($item->descricao_detalhada) @endphp</td>
                     <td>{{$item->codigo ?? '' =='0'?'':'' }}</td>
                     <td>{{$item->unidade->nome}}</td>
                     <td>{{$item->quantidade}}</td>
                     <td>{{number_format($item->media, 2, ',', '.')}}</td>
                     <td>{{isset($item->grupo->numero) ? $item->grupo->numero : ''}}</td>
                  </tr>
                  @empty
                     <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
                  @endforelse
               </tbody>
            </table>

@endsection