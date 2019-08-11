@extends('layouts.app')

@section('content')
<div class="container">
   <div class="py-5 text-center">
      <img class="d-block mx-auto mb-3" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="50">
      <h2>Solicitações de Contratação</h2>
      <p class="lead">Below is an example form built entirely with Bootstrap's form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
   </div>

   <div class="row">
      <div class="col-md-9 ">
         <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Objeto da Aquisição" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
               <button class="btn btn-outline-primary" type="button">Buscar</button>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <a href="/requisicao/create" class="btn btn-outline-primary">Nova Requisição</a>
      </div>
   </div>

   <div class="row">
      <table id="myTable" class="table table-hover tablesorter">
         <thead>
            <tr>
               <th>Numero</th>
               <th>Ano</th>
               <th>Objeto</th>
               <th>Solicitante</th>
               <th>Data</th>
            </tr>
         </thead>
         <tbody>
            @forelse ($requisicoes as $requisicao)
            <tr onclick="location.href ='{{url('/requisicao', $requisicao->id)}}'; target='_blank';" style="cursor: hand;">
               <td>{{$requisicao->numero}}</td>
               <td>{{$requisicao->ano}}</td>
               <td>{{$requisicao->descricao}}</td>
               <td>{{$requisicao->requisitante}}</td>
               <td>{{$requisicao->created_at}}</td>
            </tr>
            @empty
            <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
            @endforelse
         </tbody>
      </table>
   </div>
</div>
@endsection
