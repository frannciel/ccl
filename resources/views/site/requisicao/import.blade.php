@extends('site.layouts.index')

@section('content')
<div class="flex">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb mb-0">
			<li class="breadcrumb-item"><a href="{{route('.home')}}">Home</a></li>
			<li class="breadcrumb-item"><a href="{{route('requisicao.index')}}">Requisicões</a></li>
			<li class="breadcrumb-item"><a href="{{route('requisicao.show',  $requisicao->uuid)}}">Requisicao nº {{$requisicao->ordem ?? '' }}</a></li>
			<li class="breadcrumb-item active" aria-current="page">Importar</li>
		</ol>
	</nav>
	<h1 Class="page-header page-title">Importar Dados</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h3>
					<i class="fa fa-shopping-cart "></i>
					Requisição n° {{$requisicao->ordem ?? '' }}
				</h3>
				<p><label> Objeto:</label> {{$requisicao->descricao ?? ''}}</p>
			</div>
		</div><!-- / row -->
	</div><!-- / panel-heading -->
</div>

{{ Form::open(['route' => ['item.importarTexto', $requisicao->uuid], 'method' => 'post', 'class' => 'form-padrao'])}}
	<div class="row">
		@include('form.textarea', [
		'input' => 'texto', 
		'label' => 'ITEM - Inserir a planilha em formato texto com colunas separadas por "&".', 
		'largura' => '8',
		'attributes' => ['id' => 'texto', 'value' => '{{ old($input) }}', 'rows' => 3]])
	</div>
	<div class="row">
		@include('form.submit',	[
		'input' => 'Enviar', 
		'largura' => '4',
		'attributes' => ['class' => 'btn btn-success btn-block']])
	</div>
{{ Form::close()}}

{{ Form::open(['route' => ['cotacao.importarTexto', $requisicao->uuid], 'method' => 'post', 'class' => 'form-padrao'])}}
	<div class="row mt-4 row-center">
		@include('form.textarea', [
		'input' => 'texto', 
		'label' => 'PESQUISA DE PREÇOS - Inserir a planilha em formato texto com colunas separadas por "&".', 
		'largura' => '8',
		'attributes' => ['id' => 'texto', 'value' => '{{ old($input) }}', 'rows' => 3 ]
		])
	</div>
	<div class="row row-center">
		@include('form.submit',  
		['input' => 'Enviar', 
		'largura' => '4',
		'attributes' => ['class' => 'btn btn-success btn-block']])
	</div>
{{ Form::close() }}

{{ Form::open(['route' => ['cotacao.importarExcel', $requisicao->uuid], 'method'=>'post', 'class'=>'form-padrao', 'enctype'=>'multipart/form-data'])}}
	<div class="row mt-4">
		<div class="col-md-8 {{$errors->has('arquivo') ? ' has-error' : '' }}">
			<label class="custom-file-label" for="arquivo">PESQUISA DE PREÇOS - Selecinone o arquivo Excel com extensão XLSX, XML e XLS </label>
			<input type="file" name="arquivo" class="custom-file-input" id="arquivo" required="" value="{{ old('arquivo') }}">

			@if ($errors->has('arquivo'))
			    <span class="help-block ">
			    	<strong>{{ $errors->first($input)}}</strong>
			    </span>
			@endif
		</div>
	</div>

	<div class="row">
		@include('form.submit',  
		['input' => 'Enviar', 
		'largura' => '4',
		'attributes' => ['class' => 'btn btn-success btn-block']])
	</div>
{{ Form::close() }}

<div class="{{$errors->has('principal') ? ' has-error' : '' }} col-lg-12">
	@if ($errors->has('principal'))
	<span class="help-block">
		<strong>Falha Encontrada: {{ $errors->first('principal') }}</strong>
	</span>
	@endif 
</div>


<div class="panel panel-warning" style="margin-top:20px;">
	<div class="panel-heading">
		<h3 class="panel-title text-center">Instruções para importação por texto</h3>
	</div>
	<div class="panel-body">
		<p>
			<strong>Etapa 01.</strong>  Elabora no Word uma planilha conforme as <b>Tabela 1</b> ou <b>Tabela 2</b>, abaixo.
			É necessário  que todas as celulas da ultima coluna mais à direita estejam vazias.
			Caso algum dado opcional (*), não exista mantenha a celula vazia.
			É obrigatório manter a linha de cabeçalho da tabela.
		</p>
		<p>
			<strong>Etapa 02.</strong> Ainda no Word Selecione toda a tabela, localize o menu "Ferramenta de Tabela" em seguida "Converter em Texto". Na caixa de diálogo
			marcar a opção "Outro", adicionar o caracter "&" e clicar em  "OK".
		</p>
		<p>
			<strong>Etapa 03.</strong> Copiar o texto resultante da <b>Etapa 02</b>, colar na campo de texto correspondente neste formulário e clicar em "Enviar".
		</p>
		<p>
			<b>Observações:</b><br>		
			 - O procedimento acima é idêntico para importar pesquisa de preços e itens da requisição.<br>
			 - Só é possivel importar pesquisa de preços para itens já cadastrado. <br>
			 - Pode ser realizada sucessivas importações uma de cada vez.<br>
			 - Dados repetidos enviados são ignorados pelo sistema.
		</p>

		<table class="table" border=1 cellspacing=0 cellpadding=2>
			<tr><th>Item</th><th>Descrição</th><th>Código *</th><th>Unidade</th><th>Quantidade</th><th>Vazia</th></tr>
			<small>Tabela 1. Item</small>
		</table>

		<table class="table" border=1 cellspacing=0 cellpadding=2>
			<tr><th>Item</th><th>Fonte (Forncedor, Site, Painel) </th><th>Valor Unitário</th><th>Data</th><th>Hora * 	</th><th>Vazia</th></tr>
			<small>Tabela 2. Pesquisa de Preço</small>
		</table>
	</div>
</div>

<div class="panel panel-warning" style="margin-top:20px;">
	<div class="panel-heading">
		<h3 class="panel-title text-center">Instruções para importação por arquivo do Excel</h3>
	</div>
	<div class="panel-body">
		<p>
			<strong>Etapa 01.</strong>  Elabora planilha no excel conforme <b>Tabela 1</b> abaixo. A linha de cabeçalho deverá ser identica a tabela modelo. 
			Caso algum dado opcional (*), não exista mantenha a celula vazia.
			Utilizar apenas a primeira planilha da pasta de trabalho de Excel.
		</p>
		<p>
			<strong>Etapa 02.</strong> Salve a planilha em um local acessível
		</p>
		<p>
			<strong>Etapa 03.</strong> clicar no botão "Escolher arquivo" localizar a planilha da Etapa 1 e clicar em "Enviar".
		</p>

		<table class="table" border=1 cellspacing=0 cellpadding=2>
			<tr><th>Item</th><th>Fonte </th><th>Valor Unitário</th><th>Data</th><th>Hora *</th></tr>
			<small>Tabela 1. Pesquisa de Preço</small>
		</table>
	</div>
</div>
@endsection