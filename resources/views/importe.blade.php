@extends('layouts.index')

@section('content')
<div style="padding: 20px;">
	
	<div class="row">
		<div class="col-md-12">
			<h1 Class="page-header">Importação de Dados</h1>
		</div>
	</div>

	{{ Form::open(['url' => '/importar/store', 'method' => 'post', 'class' => 'form-padrao']) }}
		{{ Form::hidden('uuid', $uuid)}}
		<div class="row">
			@include('form.select', [
			'input' => 'tipo', 
			'label' => 'Tipo de Importação', 
			'selected' => '{{ old($input) }}', 
			'largura' => '3',
			'options' => $opcoes ?? '', 
			'attributes' => ['id' => 'tipo', 'required' => '', 'class' => 'form-control form-control-sm']])
		</div>
		
		<div class="row">
			@include('form.textarea', [
			'input' => 'dados', 
			'label' => 'Dados para importação', 
			'largura' => '12',
			'attributes' => ['id' => 'dados', 'required' => '', 'class' => 'form-control form-control-sm', 'value' => '{{ old($input) }}' ]
			])
		</div>
		
		<div class="row">
			@include('form.button', [
			'value' => 'Cancelar',
			'largura' 	=> 3,
			'class'		=> 'btn btn-primary btn-block',
			'url' 		=> 	route('principal'),
			'recuo' 	=> 3 ])

			@include('form.submit',  
			['input' => 'Enviar', 
			'largura' => '3',
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
			<h3 class="panel-title">Instruções para Importação  </h3>
		</div>
		<div class="panel-body">
			<p>
				Esta tela é responsável pela importação de dados importantes para elaboração dos documentos necessários para 
				o processo de compras e licitações de forma padronizada.
				Será possivel a importação de dados dos itens, participantes, forncedores, cotações e infomações do Portal 
				Comprasnet necessárias para a elaboração de das atas de registro de preços.
			</p>
			<p>
				A partir dos dados e infomações importados por esta tela será possível a elaboração dos seguintes documentos:
				Formulário de Aquisição, Relatório de Cotação de Preços, Tabela de Itens do Termo de Referência, Ata de Registro de Preços,
				Mapa Demostrativo para empenho e outros que se tornem possível.
			</p>
			<p>
				PASSO A PASSO PARA IMPORTAÇÃO:
			</p>
			<p>
				1° Passo: Elabora no Word planilha conforme tabela 1.
				É necessário  que todas as celulas da ultima coluna mais à direita estejam vazias.
				Lembra-se também de remover a linha de cabeçalho antes do passo 2. Caso algum dado opcional não exita mantenha a celula vaiza.
			</p>
			<p>
				2° Passo: No menu "Ferramenta de Tabela" e em seguida "Converter em Texto", na caixa de diálogo seguinte
				marcar a opção "Outro" e escolher o caracter "&" e depois em "OK".
			</p>
			<p>
				3° Passo: Nesta tela, no campo "Tipo de Importação" e selecionar a opção  "1 - Item".
			</p>
			<p>
				4° Passo: Copiar o texto resultante do 2° passo e colar na campo "Dados da Importação" e por final click em "Envair".
			</p>
			<p>
				Para os itens das opções "2 - Pesquisa de Preços", "3 - Unidade participante" e "4 - Fornecedor" o processo é semelhante.
			</p>

			<table class="table" border=1 cellspacing=0 cellpadding=2>
				<tr><th>Item</th><th>Descrição</th><th>Código</th><th>Unidade</th><th>Quantidade</th><th>Vazia</th></tr>
				<small>Tabela 2. Item</small>
			</table>

			<table class="table" border=1 cellspacing=0 cellpadding=2>
				<tr><th>Item</th><th>Fonte (Forncedor, Site, Painel) </th><th>Valor Unitário</th><th>Data</th><th>Hora</th><th>Vazia</th></tr>
				<small>Tabela 2. Pesquisa de Preço</small>
			</table>

			<table class="table" border=1 cellspacing=0 cellpadding=2>
				<tr><th>Item</th><th>Uasg - Nome</th><th>Cidade/UF</th><th>Quantidade</th><th>Vazia</th></tr>
				<small>Tabela 3. Unidade Participante</small>
			</table>

			<table class="table" border=1 cellspacing=0 cellpadding=2>
				<tr><th>CPF/CNPJ</th><th>Razão Social</th><th>Endereço</th><th>CEP</th><th>Cidade</th><th>Estado</th><th>E-mail</th><th>Telefone 01</th><th>Telefone 02 (Opicional)</th><th>Representante Legal</th><th>Vazia</th></tr>
				<small>Tabela 4. Fornecedor</small>
			</table>
		</div>
	</div>

		
</div>
@endsection