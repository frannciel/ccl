@extends('layouts.app')

@section('content')

<table id="myTable" class="table table-hover tablesorter">
   <thead>
      <tr>
         <th>Número</th>
         <th>Descrição Detalhada</th>
         <th>Unidade </th>
         <th>Código </th>
         <th>Quantidade</th>
         <th>Valor</th>
         <th>Grupo</th>
      </tr>
   </thead>
   <tbody>
      @forelse ($requisicao->itens as $item)
      <tr>
         <td>{{$item->numero}}</td>
         <td>{{$item->descricao_detalhada}}</td>
         <td>{{$item->unidade->nome}}</td>
         <td>{{$item->codigo}}</td>
         <td>{{$item->quantidade}}</td>
         <td>{{number_format($item->media, 2, ',', '.')}}</td>
         <td>{{isset($item->grupo->numero) ? $item->grupo->numero : ''}}</td>
      </tr>
      @empty
      <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
      @endforelse
   </tbody>
</table>

@if (!empty($requisicao))
   <!--=============================================================================================-->
   <div class="card mb-2">
      <div class="p-2 card-body">
         <form action="#" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="number" name="requisicao" value="{{$requisicao->id }}" hidden>
            <div class="row">
               <div class="col-lg-3 text-center">
                 <label  class="label-control">Importar Itens</label>
               </div>
               <div class="col-lg-6">
                  <input type="file" name="arquivo"  required>
               </div>
               <div class="col-lg-2">
                  <button type="submit" class="btn btn-outline-info">Importar</button>
               </div>
            </div>
         </form>
      </div>
   </div>
   <!--=============================================================================================-->
   <div class="card mb-2">
      <div class="p-2 card-body">
         <form action="#" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="number" name="requisicao" value="{{$requisicao->id}}" hidden>
            <div class="row">
               <div class="col-lg-3 text-center">
                 <label  class="label-control">Importar Locais</label>
               </div>
               <div class="col-lg-6">
                  <input type="file" name="arquivo"  required>
               </div>
               <div class="col-lg-2">
                  <button type="submit" class="btn btn-outline-info">Importar</button>
               </div>
            </div>
         </form>
      </div>
   </div>
   <!--=============================================================================================-->
   <div class="card mb-2">
      <div class="p-2 card-body">
         <form action="#" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="number" name="requisicao" value="{{$requisicao->id}}" hidden>
            <div class="row">
               <div class="col-lg-3 text-center">
                 <label  class="label-control">Importar Cotações</label>
               </div>
               <div class="col-lg-6">
                  <input type="file" name="arquivo" required>
               </div>
               <div class="col-lg-2">
                  <button type="submit" class="btn btn-outline-info">Importar</button>
               </div>
            </div>
         </form>
      </div>
   </div>
    @endif
</div>
@endsection