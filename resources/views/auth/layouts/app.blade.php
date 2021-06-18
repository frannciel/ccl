<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CCL</title>
    <!-- Bootstrap Core CSS  -->
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="{{asset('vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Custom CSS  -->
    <link href="{{asset('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- Morris Charts CSS   -->
    <link href="{{asset('vendor/morris-0.5.1/morris.css') }}" rel="stylesheet">
    <!-- Custom Fonts   -->
    <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Page-Level Plugin CSS - Tables -->
    <link href="{{asset('vendor/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- folha de estilização própria CSS -->
    <link href="{{asset('css/styles.css') }}" rel="stylesheet" media="all">
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <style type="text/css">

        .content-wrapper{
            background-color: white;
            min-height: 12%;
            position:absolute;
            z-index: 2;
            width: 100%;    
        }

        section {
            width: 100%;
            padding-top: 100px;
            padding-bottom: 50px;
        }

        section h2 {
            margin: 0;
            font-size: 3em;
        }
        hr.star-light,
        hr.star-primary {
            margin: 25px auto 30px;
            padding: 0;
            max-width: 250px;
            border: 0;
            border-top: solid 5px;
            text-align: center;
        }

        hr.star-light:after,
        hr.star-primary:after {
            content: "\f005";
            display: inline-block;
            position: relative;
            top: -.8em;
            padding: 0 .25em;
            font-family: FontAwesome;
            font-size: 2em;
        }

        hr.star-light {
            border-color: #fff;
        }

        hr.star-light:after {
            color: #fff;
            background-color: #18bc9c;
        }

        hr.star-primary {
            border-color: #2c3e50;
        }

        hr.star-primary:after {
            color: #2c3e50;
            background-color: #fff;
        }

        section.primary h2{    
            color: #2c3e50;
        }

        section.success{
            background-color: #18bc9c;
            color: #fff;
        } 

        #form > div {
            margin-bottom: 25px;
        }

        #form > div:last-child {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    @yield('content')

<!-- jQuery  -->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- Metis Menu Plugin JavaScript-->
<script src="{{ asset('vendor/metisMenu/metisMenu.min.js') }}"></script>
<!-- Morris Charts JavaScript     -->
<script src="{{asset('vendor/raphael-2.3.0/raphael.min.js') }}"></script>
<script src="{{asset('vendor/morris-0.5.1/morris.min.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{asset('dist/js/sb-admin-2.js') }}"></script>
<!--  Custom JavaScript Clipboard copiar para area de transferecia  -->
<script src='https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js'></script>
<!--  Jquery Mask Input    -->
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script> 
<!--  Page-Level Plugin Scripts - Tables     -->
<script src="{{asset('vendor/datatables/js/jquery.dataTables.js') }}"></script>
<script src="{{asset('vendor/datatables/js/dataTables.bootstrap.js') }}"></script>
<!-- Scripts próprios  -->
<script src="{{asset('js/scripts.js')}}"></script>
<script type="text/javascript">
    /*variavel.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL'}) coverte em formato contábil com cifrão R$ 0,00*/
    /*variavel.toLocaleString('pt-BR', { minimumFractionDigits: 2 }) coverte formato em contábil sem cifrão 0,00*/
    $("button[name^=update]").on( "click", function() {
        var numero = $(this).attr("data-numero");
        alert(numero);
        $.ajax({
            method:'POST',
            url:'/contratacao/update',
            data: {
                contratacao: numero,
                contrato: $('#contrato'+numero).val(),
                observacao: $('#observacao'+numero).val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                console.log(data);
            },
            error: function(e){
                console.log(e);
            }
        });
    });

    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });

        $("#ckAll").click(function()  {  // minha chk que marcará as outras
            if ($("#ckAll").prop("checked"))   // se ela estiver marcada... 
                $(".chk").prop("checked", true);  // as que estiverem nessa classe ".chk" tambem serão marcadas
            else 
                $(".chk").prop("checked", false);   // se não, elas tambem serão desmarcadas
        });

        /*
         * Método utilizado pela view importe registro de preços para marcar todos os itens a serem importados
         */
         $(document).on("click", "#marcarTodos", function(){
            if($(this).attr("data-check") == 'true'){
                $('input[type="checkbox"]').prop("checked", false);
                $(this).attr("data-check", 'false');
                $(this).html("Marcar Todos");
            } else{
                $('input[type="checkbox"]').prop("checked", true);
                $(this).attr("data-check", 'true');
                $(this).html("Desmarcar Todos");
            }
        });

        /*
         * Método utilizado pela view importe registro de preços para marcar todos os itens de um determinado fornecedor a serem importados
         */
        $(".checkboxAll").click(function() {  // minha chk que marcará as outras
            if ($(this).prop("checked"))   // se ela estiver marcada... 
                $(".checkbox"+$(this).attr('name')).prop("checked", true);  // as que estiverem nessa classe ".chk" tambem serão marcadas
            else 
                $(".checkbox"+$(this).attr('name')).prop("checked", false);   // se não, elas tambem serão desmarcadas
        });


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


    /**
     *  Função do botão que  insere a quantdade disponível no campo quantidade
     *  View item.atribuir fornecedor
     */
     $(document).on("click", "#disponivel", function(){
        $("#quantidade").val(parseInt($(this).attr("data-disponivel")));
    });

    /**
     *  Função do botão que  seleciona o item da tabela de itens a atribuir fornecedor
     *  View item.atribuir fornecedor
     */
     $(document).on("click", ".linha", function(){
       setValores(this);
   });

    /**
     *  Função do botão de navegação que retorna os dados do item selecionador 
     *  View item.atribuir fornecedor
     */
     function setValores(elemento){
        var anterior = parseInt($(elemento).attr("id"))-1;
        var proximo = parseInt($(elemento).attr("id"))+1;
        var qtd = parseInt($("#qtd").val());
        $("#modelo").val(''); // limpa campo troca de item
        $("#marca").val(''); // limpa campo troca de item
        $("#valor").val(''); // limpa campo troca de item
        $("#quantidade").val(''); // limpa campo troca de item
        $('#ordem').html("<label>Item</label>"+": "+      $(elemento).find(".ordem").text());
        $('#descricao').html(                             $(elemento).find(".descricao").html());
        $('#unidade').html("<label>Unidade</label>"+": "+ $(elemento).find(".unidade").text());
        $('#grupo').html("<label>Grupo</label>"+": "+     $(elemento).find(".grupo").text());
        $("#disponivel").attr("data-disponivel",          $(elemento).attr("data-disponivel"));
        $("#disponivel > i > span").text(                 $(elemento).attr("data-disponivel"));
        $("#item").val(                                   $(elemento).attr("data-uuid"));
        
        if (anterior > 0 && anterior < qtd) {
            $('.previous').attr("data-item", anterior).attr("class", "previous");
        }else{
            $('.previous').attr("data-item", 0).attr("class", "previous disabled");
        }

        if (proximo >= 0 && proximo < qtd ) {
            $('.next').attr("data-item", proximo).removeClass("disabled");
        }else{ 
            $('.next').attr("data-item", 0).addClass("disabled");
        }
    }

    /**
     *  Função do botão de navegação movendo para o item anterior
     *  View item.atribuir fornecedor
     */
     $('.previous').click(function(){
        var qtd = parseInt($("#qtd").val());
        var anterior = $(this).attr("data-item");
        if (anterior > 0 && anterior < qtd){
            if (!$("#"+anterior).get().length) { // verifica se o elemento HTML existe
                for(i = anterior; i > 0; i-- ){
                    if ($("#"+i).get().length){
                        setValores($("#"+i).get());// caso não exista avança para o imediatemente anterior
                        break;
                    }
                }
            }else{
                setValores($("#"+anterior).get()) // elemento existe
            }
        }
    });

    /**
     *  Função do botão de navegação para frente
     *  View item.atribuir fornecedor
     */
     $('.next').click(function(){
        var qtd = parseInt($("#qtd").val());
        var proximo = $(this).attr("data-item");
        if (proximo > 0 && proximo < qtd){
            if (!$("#"+proximo).get().length) { // verifica se o elemento HTML existe
                for(i = proximo; i < qtd; i++ ){
                    if ($("#"+i).get().length){
                        setValores($("#"+i).get()); // caso n existe avança para imediatemente mais próximo
                        break;
                    }
                }
            }else{
                setValores($("#"+proximo).get())
            }
        }
    });


     $(document).on("click", "#salvar", function(){
        $.ajax({
            method:'GET',
            url: '/item/segundo',
            data: {
                licitacao: $('#licitacao').val(),
                fornecedor: $('#fornecedor').val(),
                item: $('#item').val(),
                quantidade: $('#quantidade').val(),
                marca: $('#marca').val(),
                modelo: $('#modelo').val(),
                valor: $('#valor').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                //console.log(data);
                if (data.codigo == 100) {
                    if(data.quantidade == 0){
                        $('tr[data-uuid="'+data.item+'"').remove();

                    } else{
                        $('tr[data-uuid="'+data.item+'"').attr('data-disponivel', data.quantidade);
                    }
                    $("#disponivel").attr("data-disponivel", '');// excluir valor do data do button
                    $("#disponivel > i > span").text(''); // excluir a quantidade do button
                    $("#item").val(''); // excluir valor do input item
                    $("#modelo").val(''); // excluir valor do input modelo
                    $("#marca").val(''); // excluir valor do input modelom
                    $("#valor").val(''); // excluir valor do input valor
                    $("#quantidade").val(''); // excluir valor do input quantidade
                    $('#ordem').html('Selecione');// excluir valor do campo ordem
                    $('#descricao').html('Selecione');// excluir valor do campo descricao
                    $('#unidade').html('Selecione');// excluir valor do campo unidade
                    $('#grupo').html('Selecione');// excluir valor do campo grupo
                } 
                alert(data.message);

            }
        });
    });

    /**
     *  Função que busca o endereço a partir do cep informado no campo CEP
     *  View create fornecedor
     *  
     *  @paran $cep
     */
     $(document).on("click", "#buscarCep", function(){
       $.ajax({
        method:'POST',
        url: '/cep',
        data: {
            cep: $('#cep').val(),
            "_token": "{{ csrf_token() }}"
        },
        success: function(data) {
            var endereco = JSON.parse(data);
            if (endereco.erro) {
                $('#cidade').removeAttr("readonly", "").val('');
                $('#estado').removeAttr("readonly", "").val('');
                $('#endereco').val(''); 
                alert('CEP inválido ou não encontrado !!!')
            } else {
                $('#cidade').val(endereco.localidade).attr("readonly", "");
                $('#estado').val(endereco.uf).attr("readonly", "");
                $('#endereco').val(endereco.logradouro + ', ' + endereco.bairro);
            }               
        }
    });
   });

     $(document).on("click", "#buscarForncecedor", function(){
        $.ajax({
            method:'POST',
            url: '/fornecedor/fornecedor',
            data: {
                cpf_cnpj: $('#cpf_cnpj').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.fornecedor == true) {
                    alert("CPF / CNPJ inválido ou Fornecedor não encontrado !!!");
                } else{
                    $('#razaoSocial').val(data.fornecedor);
                    $('#fornecedor').val(data.uuid);
                }
            },
            error: function(e){
               alert("Falha ao buscar fornecedor, tente novamente mais tarde");
           }
       });
    });

     $(document).on("click", ".buscar", function(){
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
                console.log(data);
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
