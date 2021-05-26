@extends('layouts.index')

@section('content')
<div class="panel panel-default mt-4">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2 class="center">Importar Dados</h2>
			</div>
		</div><!-- / row -->

		<div class="row">
			<div class="col-md-12">
				<h3>
					<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
					<a href="{{route('requisicaoShow', [$requisicao->uuid])}}">Requisição n° {{$requisicao->ordem ?? '' }}</a>
				</h3>
				<p><label> Objeto:</label> {{$requisicao->descricao ?? ''}}</p>
			</div>
		</div><!-- / row -->
	</div><!-- / panel-heading -->

	<div class="panel-body">

		{{ Form::open(['route' => ['importeText.item', $requisicao->uuid], 'method' => 'post', 'class' => 'form-padrao'])}}
			<div class="row">
				@include('form.textarea', [
				'input' => 'dados', 
				'label' => 'ITEM - Inserir a planilha em formato texto com colunas separadas por "&".', 
				'largura' => '8',
				'attributes' => ['id' => 'dados', 'value' => '{{ old($input) }}', 'rows' => 3]])
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
	</div><!-- / panel-body -->
</div>

<div class="panel panel-warning" style="margin-top:20px;">
	<div class="panel-heading">
		<h3 class="panel-title text-center">Instruções para importação por texto</h3>
	</div>
	<div class="panel-body">
		<p>
			O procedimento abaixo é idêntico para importar dados da pesquisa de preços e itens da requisição. Só é possivel importar dados de pesquisa de preços de itens já cadastrado. É realizada um tipo de importação cada vez.
		</p>
		<p>
			<strong>Etapa 01.</strong>  Elabora no Word planilha conforme <b>tabela 1</b>.
			É necessário  que todas as celulas da ultima coluna mais à direita estejam vazias.
			Caso algum dado opcional não exista mantenha a celula vazia.
			Remover a linha de cabeçalho da tabela antes do etapa 02. 
		</p>
		<p>
			<strong>Etapa 02.</strong> Selecione toda a tabela, no menu "Ferramenta de Tabela" em seguida "Converter em Texto", na caixa de diálogo
			marcar a opção "Outro", adicionar o caracter "&" e clicar em  "OK".
		</p>
		<p>
			<strong>Etapa 03.</strong> Copiar o texto resultante da etapa 02, colar na campo de texto click em "Enviar".
		</p>

		<table class="table" border=1 cellspacing=0 cellpadding=2>
			<tr><th>Item</th><th>Descrição</th><th>Código</th><th>Unidade</th><th>Quantidade</th><th>Vazia</th></tr>
			<small>Tabela 1. Item</small>
		</table>

		<table class="table" border=1 cellspacing=0 cellpadding=2>
			<tr><th>Item</th><th>Fonte (Forncedor, Site, Painel) </th><th>Valor Unitário</th><th>Data</th><th>Hora</th><th>Vazia</th></tr>
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
			<strong>Etapa 01.</strong>  Elabora planilha no excel conforme <b>tabela 1</b>. Os cabelhas deverão ser 
			Caso algum dado opcional não exista mantenha a celula vazia. 
			Utilizar apenas uma planilha da pasta de trabalho de Excel.
		</p>
		<p>
			<strong>Etapa 02.</strong> Selecione toda a tabela, no menu "Ferramenta de Tabela" em seguida "Converter em Texto", na caixa de diálogo
			marcar a opção "Outro", adicionar o caracter "&" e clicar em  "OK".
		</p>
		<p>
			<strong>Etapa 03.</strong> Copiar o texto resultante da etapa 02, colar na campo de texto click em "Enviar".
		</p>

		<table class="table" border=1 cellspacing=0 cellpadding=2>
			<tr><th>Item</th><th>Fonte </th><th>Valor Unitário</th><th>Data</th><th>Hora</th></tr>
			<small>Tabela 1. Pesquisa de Preço</small>
		</table>
	</div>
</div>
@endsection