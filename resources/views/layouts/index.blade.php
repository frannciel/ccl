<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CCL</title>
    <!-- Bootstrap Core CSS 
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    -->
    <link href="{{ elixir('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS 
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    -->
    <link href="{{ elixir('vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS 
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    -->
    <link href="{{ elixir('dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Morris Charts CSS 
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">
    -->
    <link href="{{ elixir('vendor/morrisjs/morris.css') }}" rel="stylesheet">

    <!-- Custom Fonts
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    -->
    <link href="{{ elixir('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
        .notActive{ 
            color: #4cae4c;
            background-color: #fff;
        }
		.t-body {
		   height: 500px;
		   overflow-y: scroll;
		}
		.t-display {display: block;}
		.t-float{ float: center; }
		.w-1 { width: 10%;}
		.w-2 { width: 20%;}
		.w-3 { width: 30%;}
		.w-4 { width: 40%;}
		.w-5 { width: 50%;}
		.w-10 { width: 100%;}
        .mt-2 { margin-top: 2%;}
        .mt-4 { margin-top: 4%;}
        .mb-2 { margin-bottom: 2%;}
        .mb-4 { margin-bottom: 4%;}
        .p-2 {padding: 2%}
        .p-4 {padding: 4%}
        .justicado{text-align: justify;}
        .center{text-align: center;} 
        .posicao{ position: relative; transform: translateY(50%);}
        .panel-Teal {border-color: #008080;}
        .panel-Teal > .panel-heading { border-color: #008080; color: white; background-color: #008080;}
        .panel-Teal > a {color: #008080;}
        .panel-Teal > a:hover {color: #008080;}
        .panel-orchid {border-color: #BA55D3;}
        .panel-orchid > .panel-heading { border-color: #BA55D3; color: white; background-color: #BA55D3;}
        .panel-orchid > a {color: #BA55D3;}
        .panel-orchid > a:hover {color: #BA55D3;}
        .panel-greenSea {border-color: #8FBC8F;}
        .panel-greenSea > .panel-heading { border-color: #8FBC8F; color: white; background-color: #8FBC8F;}
        .panel-greenSea > a {color: #8FBC8F;}
        .panel-greenSea > a:hover {color: #8FBC8F;}
        .panel-salmon {border-color: #FA8072;}
        .panel-salmon > .panel-heading { border-color: #FA8072; color: white; background-color: #FA8072;}
        .panel-salmon > a {color: #FA8072;}
        .panel-salmon > a:hover {color: #FA8072;}
        .panel-violet {border-color: #DB7093;}
        .panel-violet > .panel-heading { border-color: #DB7093; color: white; background-color: #DB7093;}
        .panel-violet > a {color: #DB7093;}
        .panel-violet > a:hover {color: #DB7093;}
        .panel-gold {border-color: #CDAD00;}
        .panel-gold > .panel-heading { border-color: #CDAD00; color: white; background-color: #CDAD00;}
        .panel-gold > a {color: #CDAD00;}
        .panel-gold > a:hover {color: #CDAD00;}
        .panel-cade {border-color: #6CA6CD;}
        .panel-cade > .panel-heading { border-color: #6CA6CD; color: white; background-color: #6CA6CD;}
        .panel-cade > a {color: #6CA6CD;}
        .panel-cade > a:hover {color: #6CA6CD;}
	</style>
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">CCL - Coordenação de Compras e Licitações</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>

            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="{{route('principal')}}"><i class="fa fa-dashboard fa-fw"></i> Principal</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Requisição<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('requisicaoNova')}}">Nova</a>
                                </li>
                                <li>
                                    <a href="{{route('requisicao')}}">Consultar</a>
                                </li>
                                <li>
                                    <a href="{{route('itemFornecNovo')}}">Atribuir Fornecedor</a>
                                </li>
                                <li>
                                    <a href="#">Documentos</a>
                                </li>
                            </ul><!-- /.nav-second-level -->
                        </li>
                          <li>
                            <a href="{{route('fornecedor')}}"><i class="fa fa-group fa-fw"></i>Fornecedor<span class="fa arrow"></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('fornecedorNovo')}}">Novo</a>
                                </li>
                                <li>
                                    <a href="{{route('fornecedor')}}">Consultar</a>
                                </li>
                                <li>
                                    <a href="{{route('importarNovo',  ['id' => 0])}}">Importar Dados</a>
                                </li>
                            </ul><!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-exclamation-circle fa-fw"></i> Enquadramento<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('enquadramentoNovo')}}"> Novo</a>
                                </li>
                                <li>
                                    <a href="{{route('enquadramento')}}">Consultar</a>
                                </li>
                                <li>
                                    <a href="{{route('enquadramento')}}">Modelo Antigo</a>
                                </li>
                            </ul><!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="http://pmieunapolis.herokuapp.com" target="_blank"><i class="fa fa-table fa-fw"></i> Plano de Metas</a>
                        </li>
                        <li>
                            <a href="https://my-cracha.000webhostapp.com/servidores/index.php" target="blank"><i class="fa fa-edit fa-fw"></i> Solicitação de Crachá</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-exclamation-circle fa-fw"></i> Dispensa de Licitação<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Nova</a>
                                </li>
                                <li>
                                    <a href="login.html">Alterar ou Excluir</a>
                                </li>
                                <li>
                                    <a href="login.html">Buscar</a>
                                </li>
                            </ul><!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Relatórios<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Licitação<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="icons.html"> Icons</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <!--<li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="google">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-.- /.nav-third-level -.->
                                </li>
                            </ul>
                            <!-.- /.nav-second-level -.->
                        </li>-->
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul><!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-link fa-fw"></i>Links Importantes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="https://www.comprasgovernamentais.gov.br" target="_blank">Comprasnet</a>
                                </li>
                                <li>
                                    <a href="https://pgc.planejamento.gov.br/login" target="_blank">PGC</a>
                                </li>
                                <li>
                                    <a href="http://paineldeprecos.planejamento.gov.br" target="_blank">Painel de Preços</a>
                                </li>
                                 <li>
                                    <a href="https://siasgnet-consultas.siasgnet.estaleiro.serpro.gov.br/siasgnet-catalogo/" target="_blank">CATMAT / CATSER</a>
                                </li>
                                
                            </ul><!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="p-2">
                @yield('content')
            </div>
        </div><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->
    <!-- jQuery 
    <script src="../vendor/jquery/jquery.min.js"></script>
    -->
    <script src="{{ elixir('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
     -->
    <script src="{{ elixir('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Metis Menu Plugin JavaScript 
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    -->
    <script src="{{ elixir('vendor/metisMenu/metisMenu.min.js') }}"></script>
    <!-- Morris Charts JavaScript 
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>
    -->
    <script src="{{ elixir('vendor/raphael/raphael.min.js') }}"></script>
    <script src="{{ elixir('vendor/morrisjs/morris.min.js') }}"></script>
    <script src="{{ elixir('data/morris-data.js') }}"></script>
    <!-- Custom Theme JavaScript 
    <script src="../dist/js/sb-admin-2.js"></script>
    -->
    <script src="{{ elixir('dist/js/sb-admin-2.js') }}"></script>
    <!-- 
    Custom JavaScript Clipboard copiar para area de transferecia
    -->
    <script src='https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js'></script>
    <!-- 
    Jquery Mask Input
    -->
    <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script> 
    <!-- 
    Chama o arquivo de mascaras
    -->
    <script src="{{ elixir('js/mascaras.js') }}"></script>

    <!-- 
        http://blog.conradosaud.com.br/artigo/26
    -->
    <script type="text/javascript">


/*   $('#radioBtn a').on('change', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel); 
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
});*/

    $(document).ready(function(){
        /*
         * A clicar no botão copiar o conteudo da <div> para a àrea de transferêcia
         */
         var clipboard = new Clipboard('.btn'); 
         clipboard.on('success', function(e){
            console.log(e); 
        });     
         clipboard.on('error', function(e){
            console.log(e);  
        });

        /*
         * Exibe a opção escolhida no radio durante o carregamento da página
         */
        $(window).on("load", function(){
            $('input:hidden').each(function() {
                radioButton($(this).attr('name'), $(this).val());
            });
        });
    });

    $('#modalidade').change(function () {
        $.ajax({
            method:'POST',
            url: '/licitacao/modalidade',
            data: {
                opcao: $('#modalidade').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                if ( data.length > 0) {
                    $('#adicioanis').empty();
                    $('#adicioanis').html(data);
                    $('.page-header').text('Incluir '+$('#modalidade option:selected').text())
                }else{
                    $('#adicioanis').empty();
                }
            }
        });
    });


        function radioButton(toggle, title){
            var group = 'G'+toggle;       
            $('#'+toggle).prop('value', title); 
            $('a[data-toggle="'+toggle+'"]').not('[data-title="'+title+'"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="'+toggle+'"][data-title="'+title+'"]').removeClass('notActive').addClass('active');
        }

        function enviar(nome){
            $.ajax({
                method:'POST',
                url: '/enquadramento/dados',
                data: {
                    selecao: nome,
                    opcao: $('#'+nome).val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    if ( data.length > 0) {
                        if (nome == 'normativa'){
                            $('#conteudo').html(data);
                            $('#complemento').empty();
                        }
                        if (nome == 'modalidade' )
                            $('#complemento').html(data);
                    }else{
                        if (nome == 'normativa')
                            $('#complemento, #conteudo').empty();
                    }
                }
            });
        }

        function enviar(nome){
            $.ajax({
                method:'POST',
                url: '/enquadramento/dados',
                data: {
                    selecao: nome,
                    opcao: $('#'+nome).val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    if ( data.length > 0) {
                        if (nome == 'normativa'){
                            $('#conteudo').html(data);
                            $('#complemento').empty();
                        }
                        if (nome == 'modalidade' )
                            $('#complemento').html(data);
                    }else{
                        if (nome == 'normativa')
                            $('#complemento, #conteudo').empty();
                    }
                }
            });
        }

        function getRazaoSocial(id){
            $.ajax({
                method:'POST',
                url: '/fornecedor/ajax',
                data: {
                    cpf_cnpj: $('#'+id).val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#razao_social').val(data.fornecedor.razao_social);
                    $('form').append("<input type='hidden' id='fornecedor' name='fornecedor'  value='"+data.fornecedor.id+"'>");
                }
            });
        }

        function getDescricao(id, local){
            $.ajax({
                method:'POST',
                url: '/requisicao/ajax',
                data: {
                    numeroAno: $(id).val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#descricao').val(data.requisicao.descricao);
                    $(local).empty().append("<input  id='requisicao' name='requisicao' type='hidden' value='"+data.requisicao.uuid+"'>");
                }
            });
        }

        function getItensTabela(){
            $.ajax({
                method:'POST',
                url: '/item/ajax',
                data: {
                    requisicao: $('#requisicao').val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    $('form').append(data);
                }
            });
        }
    </script>
</body>
</html>
