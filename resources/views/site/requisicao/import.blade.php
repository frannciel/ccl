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

@isset($comunica['pulados'])
	<div class="alert alert-warning" role="alert">
		<div  class="row">
			<div class="col-lg-2 text-center">
				<i class="fa fa-exclamation-triangle fa-5x color-orange" aria-hidden="true" ></i>
			</div>
			<div class="col-lg-10">
				<strong>Atenção:</strong><button type="button" class="close text-right" data-dismiss="alert">x</button><br>
				@foreach($comunica['pulados']->all() as $pulado)
					<span class="sr-only">Alerta: </span> {{$pulado}}<br/>
				@endforeach 
			</div>
		</div>
	</div>
@endisset

@if($errors->any())
	<div class="alert alert-danger" role="alert">
		<div  class="row">
			<div class="col-lg-2 text-center">
				<i class="fa fa-exclamation-circle fa-5x color-danger" aria-hidden="true"></i>
			</div>
			<div class="col-lg-10">
				<strong>Falha Encontrada:</strong><button type="button" class="close text-right" data-dismiss="alert">x</button><br>
				@foreach($errors->all() as $error)
					<span class="sr-only">Erro: </span>{{$error}}<br/>
				@endforeach 
			</div>
		</div>
	</div>
@endif

<div class="panel panel-default mt-3">
	<div class="panel-heading"><label class="custom-file-label" for="texto">ITEM - Inserir a planilha em formato texto com colunas separadas por "&".</label></div>
	<div class="panel-body">
		{{ Form::open(['route' => ['item.importarTexto', $requisicao->uuid], 'method' => 'post', 'class' => 'form-padrao'])}}
			<div class="row centered">
				@include('form.textarea', [
				'input' => 'texto', 
				'largura' => '6',
				'attributes' => ['id' => 'texto', 'value' => '{{ old($input) }}', 'rows' => 2]])
			</div>
			<div class="row centered">
				@include('form.submit',	[
				'input' => 'Enviar', 
				'largura' => '4',
				'attributes' => ['class' => 'btn btn-success btn-block']])	
			</div>
		{{ Form::close()}}
	</div>
</div>

<div class="panel panel-default mt-3">
	<div class="panel-heading"><label class="custom-file-label" for="texto">PESQUISA DE PREÇOS - Inserir a planilha em formato texto com colunas separadas por "&".</label></div>
	<div class="panel-body">
		{{ Form::open(['route' => ['cotacao.importarTexto', $requisicao->uuid], 'method' => 'post', 'class' => 'form-padrao'])}}
			<div class="row centered">
				@include('form.textarea', [
				'input' => 'texto', 
				'largura' => '6',
				'attributes' => ['id' => 'texto', 'value' => '{{ old($input) }}', 'rows' => 2 ]
				])
			</div>
			<div class="row centered">
				@include('form.submit',  
				['input' => 'Enviar', 
				'largura' => '4',
				'attributes' => ['class' => 'btn btn-success btn-block']])
			</div>
		{{ Form::close()}}
	</div>
</div>

<div class="panel panel-default mt-3">
	<div class="panel-heading"><label far="arquivo" class="form-control-label" for="arquivo">PESQUISA DE PREÇOS - Selecione o arquivo Excel com extensão XLSX, XML e XLS </label></div>
	<div class="panel-body">
		{{ Form::open(['route' => ['cotacao.importarExcel', $requisicao->uuid], 'method'=>'post', 'class'=>'form-padrao', 'enctype'=>'multipart/form-data'])}}
			<div class="row centered">
				<div class="col-md-4">
					<input type="file" name="arquivo" class="form-control-file" id="arquivo" required="" value="{{ old('arquivo') }}">
				</div>
		
				@include('form.submit',  
				['input' => 'Enviar', 
				'largura' => '4',
				'attributes' => ['class' => 'btn btn-success btn-block']])
			</div>
		{{ Form::close() }}
	</div>
</div>
<div class="row centered mt-3">
	<div class="col-md-6">
		<a href="{{route('requisicao.show', $requisicao->uuid)}}" class="btn btn-primary btn-block" type="button">Voltar</a>
	</div><!-- / col-md-3  -->
</div>

<div class="panel panel-warning mt-3">
	<div class="panel-heading">
		<h3 class="panel-title text-center">Instruções para importação por texto</h3>
	</div>
	<div class="panel-body">
		<p>
			<strong>Etapa 01.</strong>  Elaborar planilha no Microsoft Word com cabeçalho conforme <b>Tabela 1</b> ou <b>Tabela 2</b> abaixo.<br>
			 - É necessário  que todas as celulas da última coluna mais à direita estejam vazias.<br />
			 - Caso os dados opcionais (Código e Hora) não existam, mantenha a celula vazia. <br />
			 - A linha do cabeçalho deve ser mantida exatamente com tabelas modelo abaixo.
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
			 - Podem ser realizadas sucessivas importações para itens e pesquisa de preços.<br>
			 - Dados repetidos enviados são ignorados pelo sistema.
		</p>
		<strong>Tabela 1. Planilha de itens</strong>
		<table class="table" border=1 cellspacing=0 cellpadding=2>
			<tr><th>Item</th><th>Descrição</th><th>Codigo</th><th>Unidade</th><th>Quantidade</th><th>Vazia</th></tr>
		</table>
		<p><small> - A coluna opcional Código pode ser mantida vazia</small></p>
		<br>
		<strong>Tabela 2. planilha de pesquisa de preço</strong>
		<table class="table" border=1 cellspacing=0 cellpadding=2>
			<tr><th>Item</th><th>Fonte</th><th>Valor</th><th>Data</th><th>Hora</th><th>Vazia</th></tr>
		</table>
		<small> - Informe na coluna "Item" apenas o número do item.</small><br>
		<small> - A coluna opcional "Hora" pode ser mantida vazia.</small><br>
		<small> - Na coluna "valor" deve ser informado o valor unitário cotado.</small><br>
		<small> - Na coluna "Fonte" deve ser informado a origen da cotação a saber, Painel de Preços, Razão Social, Site de domínio amplo.</small><br>
	</div>
</div>

<div class="panel panel-warning" style="margin-top:20px;">
	<div class="panel-heading">
		<h3 class="panel-title text-center">Instruções para importação por arquivo do Excel</h3>
	</div>
	<div class="panel-body">
		<p>
			<strong>Etapa 01.</strong>  Elaborar planilha no excel conforme <b>Tabela 3</b> abaixo.<br>
			- A linha do cabeçalho da planilha deverá ser mantida exatamente como a tabela modelo.<br>
			- Utilizar apenas a primeira planilha da pasta de trabalho do Excel.
		</p>
		<p>
			<strong>Etapa 02.</strong> Salve a planilha em um local acessível
		</p>
		<p>
			<strong>Etapa 03.</strong> clicar no botão "Escolher arquivo", localizar a planilha da Etapa 1 e clicar em "Enviar".
		</p>
		<strong>Tabela 3. Planilha de pesquisa de preço</strong>
		<table class="table" border=1 cellspacing=0 cellpadding=2>
			<tr><th>Item</th><th>Fonte </th><th>Valor</th><th>Data</th><th>Hora</th></tr>
		</table>
		<small> - Informe na coluna "Item" apenas o número do item.</small><br>
		<small> - A coluna opcional "Hora" pode ser mantida vazia.</small><br>
		<small> - Na coluna "valor" deve ser informado o valor unitário cotado.</small><br>
		<small> - Na coluna "Fonte" deve ser informado a origen da cotação a saber, Painel de Preços, Razão Social, Site de domínio amplo.</small><br>
	</div>
</div>
@endsection