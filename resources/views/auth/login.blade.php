<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{asset('css/styles.css') }}" rel="stylesheet" media="all">
</head>
<body>        
	<main class="py-4">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header page-scroll">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#page-top">Coordenação de Compras e Licitações</a>
				</div>
			</div>
			<!-- /.container-fluid -->
		</nav>
		<div class="modal-dialog mt-10"  id="login-overlay">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Seja bem vindo!</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-6">
							<div class="well">
								<form id="form" class="form-horizontal" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
									@csrf
									<div class="input-group mb-5">
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="E-mail" value="{{ old('email') }}" required autofocus>

										@if ($errors->has('email'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
										@endif                                      
									</div>

									<div class="input-group mb-5">
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Senha" required>

										@if ($errors->has('password'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
										@endif
									</div>  

									<div class="form-group">
										<div class="col-sm-12">
											<div class="checkbox">
												<label style="color: #ccc;">
													<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>Lembrar?
												</label>
											</div>
										</div>
									</div>  

									<div class="form-group">
										<div class="col-sm-12 ">
											<button type="submit" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-log-in"></i> Acessar</button>                          
										</div>
									</div>
								</form>   
								<a href="{{ route('password.request') }}" class="btn btn-default btn-block">Esqueceu a senha?</a>
							</div>
						</div>
						<div class="col-xs-6">
							<p class="lead">Solicite seu acesso junto à <span class="text-success">CCL</span></p>
							<ul class="list-unstyled" style="line-height: 2">
								<li><span class="fa fa-check text-success"></span> Elabore suas requisições</li>
								<li><span class="fa fa-check text-success"></span> Gere os formulários</li>
								<li><span class="fa fa-check text-success"></span> Consulte catálogo de produtos</li>
								<li><span class="fa fa-check text-success"></span> Acompanhe a pesquisa de preços</li>
								<li><span class="fa fa-check text-success"></span> Procedimentos de licitação</li>
							</ul>
							<p><a href="/new-customer/" class="btn btn-info btn-block">Yes please, register now!</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>
</body>
    <!-- jQuery  -->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Metis Menu Plugin JavaScript-->
    <!-- Scripts próprios  -->
    <script src="{{asset('js/scripts.js')}}"></script>
</html>
