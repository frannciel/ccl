@extends('layouts.index')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Incluir Pregão</h1>
		</div>
	</div>

	{{ Form::open(['url' => 'pregao/store', 'method' => 'post', 'class' => 'form-padrao']) }}
		@include('licitacao.forms.licitacao_create')
		@include('licitacao.forms.pregao_create')
		@include('licitacao.forms.objeto_create')
	{{ Form::close() }} 
@endsection