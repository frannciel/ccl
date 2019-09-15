@extends('layouts.index')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h1 Class="page-header">Alterar Pregão</h1>
	</div>
</div>

{{ Form::open(['url' => 'pregao/update', 'method' => 'post', 'class' => 'form-padrao']) }}
@include('licitacao.forms.licitacao_show')
@include('licitacao.forms.pregao_show')
@include('licitacao.forms.objeto_show')
{{ Form::close() }} 

<ul class="nav nav-tabs nav-justified">
	<li class="active"><a data-toggle="tab" href="#home">Requisições</a></li>
	<li><a data-toggle="tab" href="#menu1">Itens</a></li>
	<li><a data-toggle="tab" href="#menu2">Forncedores</a></li>
	<li><a data-toggle="tab" href="#">Participantes</a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
    <h3>HOME</h3>
    <p>Some content.</p>
  </div>
  <div id="menu1" class="tab-pane fade">
    <h3>Menu 1</h3>
    <p>Some content in menu 1.</p>
  </div>
  <div id="menu2" class="tab-pane fade">
    <h3>Menu 2</h3>
    <p>Some content in menu 2.</p>
  </div>
</div>
@endsection