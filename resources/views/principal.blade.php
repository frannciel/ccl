@extends('layouts.index')

@section('content')
<div class="row">
 	<div class="col-md-12 mt-4">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<!--<li data-target="#carousel-example-generic" data-slide-to="1"></li>
					<li data-target="#carousel-example-generic" data-slide-to="2"></li> -->
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<img src="{{ asset('img/pgc.JPG') }}" alt="...">
						<div class="carousel-caption">
						</div>
					</div>
				<!--<div class="item">
					<img src="..." alt="...">
					<div class="carousel-caption">
						...
					</div>
				</div>-->
				Testando infomações
			</div>

			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
</div>
	
<div class="row">
	<div class="col-md-12">
		<h1 Class="page-header">Sobre Nós</h1>
		<p>Ferramenta de software desenvolvida com intuito de assessorar a Coordenação de Compras e Licitações na realização de sua atividades regimentares e disponibilizar às demais unidades administrativas um interface simples e intuitiva para eleboração requisições de bens e serviços,  de modo a padronizar e dar seleridade às suas contratações públicas</p>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<h1 Class="page-header">Acesso Rápido</h1>
	</div>
</div>

<div class="p-2">
	<div class="row">
		<div class="col-md-3 col-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-users fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="{{route('fornecedor')}}">
					<div class="panel-footer">
						<span class="pull-left">Fornecedores</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-6">
			<div class="panel panel-green">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-shopping-cart fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="{{route('requisicao')}}">
					<div class="panel-footer">
						<span class="pull-left">Requisições</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-6">
			<div class="panel panel-yellow">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-dollar fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="{{route('requisicaoConsulta', ['acao' => 'preco'])}}">
					<div class="panel-footer">
						<span class="pull-left">Pesquisa de Preços</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-6">
			<div class="panel panel-red">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-upload fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="{{url('importar')}}">
					<div class="panel-footer">
						<span class="pull-left">Importar</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3 col-6">
			<div class="panel panel-gold"><!-- orchid -->
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-legal fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="{{route('licitacao')}}">
					<div class="panel-footer">
						<span class="pull-left">Licitações</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-6">
			<div class="panel panel-greenSea">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-tasks fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="{{route('enquadramentoNovo')}}">
					<div class="panel-footer">
						<span class="pull-left">Enquadramento</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-6">
			<div class="panel panel-default"><!-- salmon -->
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3  col-xs-offset-3">
							<i class="fa fa-suitcase fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">Bolsa e Auxílios</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-6">
			<div class="panel panel-Teal">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-check-square-o fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="http://pmieunapolis.herokuapp.com" target="_blank">
					<div class="panel-footer">
						<span class="pull-left">Plano de Metas</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3 col-6">
			<div class="panel panel-violet">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-user fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="https://my-cracha.000webhostapp.com/servidores/index.php" target="blank">
					<div class="panel-footer">
						<span class="pull-left">Crachá</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-6">
			<div class="panel panel-default"><!-- cade -->
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-file-text fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">Estudo Preliminar</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-6">
			<div class="panel panel-default"><!-- gold -->
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-warning fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="#" >
					<div class="panel-footer">
						<span class="pull-left">Mapa de Risco</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-6">
			<div class="panel panel-default"><!-- Não defiido no css -->
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 text-center">
							<i class="fa fa-bar-chart-o fa-5x"></i>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">Relatórios</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>

<!--
<div class="row">
	<div class="col-md-3 col-md-6">
		<a href="#">
			<div class="panel panel-green">
				<div class="row">
					<div class="col-md-4 text-center">
						<i class="fa fa-plus fa-3x"></i>
					</div>
					<div class="col-md-8 text-left posicao">
						<div>Adicionar Item</div>
					</div>
				</div>
			</div>
		</a>
	</div>

	<div class="col-md-3 col-md-6">
		<a href="#">
			<div class="panel panel-green">
				<div class="row">
					<div class="col-md-4 text-center">
						<i class="fa fa-upload fa-3x"></i>
					</div>
					<div class="col-md-8 text-left posicao">
						<div>Importar</div>
					</div>
				</div>
			</div>
		</a>
	</div>

	<div class="col-md-3 col-md-6">
		<a href="#">
			<div class="panel panel-green">
				<div class="row">
					<div class="col-md-4 text-center">
						<i class="fa fa-shopping-cart fa-3x"></i>
					</div>
					<div class="col-md-8 text-left posicao">
						<div>Pesquisa de Preços</div>
					</div>
				</div>
			</div>
		</a>
	</div>

	<div class="col-md-3 col-md-6">
		<a href="#">
			<div class="panel panel-green">
				<div class="row">
					<div class="col-md-3 text-center">
						<i class="fa fa-list-alt fa-3x"></i>
					</div>
					<div class="col-md-9 text-left posicao">
						<div>Relatorio de Pesquisa</div>
					</div>
				</div>
			</div>
		</a>
	</div>

	<div class="col-md-3 col-md-6">
		<a href="#">
			<div class="panel panel-yellow">
				<div class="row">
					<div class="col-md-4 text-center">
						<i class="fa fa-file-text-o fa-3x"></i>
					</div>
					<div class="col-md-8 text-left posicao">
						<div>Registro de Preços</div>
					</div>
				</div>
			</div>
		</a>
	</div>

	<div class="col-md-3 col-md-6">
		<a href="#">
			<div class="panel panel-yellow">
				<div class="row">
					<div class="col-md-4 text-center">
						<i class="fa fa-table fa-3x"></i>
					</div>
					<div class="col-md-8 text-left posicao">
						<div>Termo de Referência</div>
					</div>
				</div>
			</div>
		</a>
	</div>

	<div class="col-md-3 col-md-6">
		<a href="#">
			<div class="panel panel-yellow">
				<div class="row">
					<div class="col-md-4 text-center">
						<i class="fa fa-group fa-3x"></i>
					</div>
					<div class="col-md-8 text-left posicao">
						<div>Atribuir Fornecedor</div>
					</div>
				</div>
			</div>
		</a>
	</div>

	<div class="col-md-3 col-md-6">
		<a href="#">
			<div class="panel panel-Teal">
				<div class="row">
					<div class="col-md-4 text-center">
						<i class="fa fa-th-list fa-3x"></i>
					</div>
					<div class="col-md-8 text-left posicao">
						<div>Mapa de Compra</div>
					</div>
				</div>
			</div>
		</a>
	</div>
</div>
-->
@endsection
