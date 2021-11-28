//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////// REQUISIÇÕES ASSÍNCRONAS VIA AJAX /////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 *  Função que busca o endereço a partir do cep informado no campo CEP
 *  View create fornecedor
 *  
 *  @paran $cep
 */
$(document).on("click", "#buscarCep", function(){
    $.ajax({
       method:'GET',
       url: '/endereco/cep/'+$('#cep').val(),
       data: {
           "_token": $('meta[name="csrf-token"]').attr('content')
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


/*
* Exibe a opção escolhida no radio durante o carregamento da página
*/
$(window).on("load", function(){
    $('input:hidden').each(function() {
        radioButton($(this).attr('name'), $(this).val());
    });
});

$(document).ready(function(){
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////// MÁSCARA DE VALIDAÇÃO DE CAMPOS DE FORMUÁRIO ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //  Fonte: http://blog.conradosaud.com.br/artigo/26   
   
    $('#processo').mask('00000.000000/0000-00');
    $('#valor').mask('#.##0,00', {reverse: true});
    $('#pregao').mask('000/0000');
    $('#numero').mask('000/0000');
    $('#data').mask('00/00/0000');
    $('#hora').mask('00:00');
    $('#processoOrigem').mask('00000.000000/0000-00');
    $('#cep').mask('00000-000');
    $('#cpf_cnpj').mask('00.000.000/0000-00');
    $('.telefone').mask('(00)00000-00000');
    $('.contrato').mask('000/0000');
    $('#ordem').mask('000/0000')
   
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////// CONFIGURAÇÕES //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $('.dataTable').DataTable( {
        "language": {
            "lengthMenu": "Display _MENU_ itens por página",
            "zeroRecords": "Nada encontrado com esse parâmetro de busca",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum item cadastrado",
            "infoFiltered": "(Filtrados de _MAX_ registros)",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
        }
    });

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////// SCRIPTS DIVERSOS //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
     * Oculta a mensagem de interação com usuário por meio de alert
     */
    $(".ocultar").delay(5000).slideUp(200, function() {
        $(this).alert('close');
    });

    $('#buscar').click(function(){
        $.ajax({
            method:'POST',
            url: '/requisicao/ajax',
            data: {
                numeroAno: $("#seachKey").val(),
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('#descricao').val(data.requisicao.descricao);
                $('#buscarItem').attr("href",  $("#buscarItem").attr("data-route")+"/"+data.requisicao.uuid);
            }
        });
    });

    $("button").click(function(){
        $(this).toggleClass("ativo");
        $(".busca").slideToggle();
    });

    $("#limpar").click(function(){
        $('input[name="data"]').val("");
        $('input[name="hora"]').val("");
        $('input[name="valor"]').val("");
        $('input[name="fonte"]').val("");
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
    /**
     * Ordenador de lista de itens da licitação e requisição
     */
    $(function(){
        $(".sortable").sortable({
            connectWith: ".sortable",
            placeholder: 'dragHelper',
            scroll: true,
            revert: true,
            cursor: "move",
            update: function(event, ui) {
                var itens = $(this).sortable('toArray');
                var route = $(this).attr('data-route');
                $.ajax({
                    url: route,
                    method: 'POST',
                    data: {
                        itens: itens,
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(data) {

                    }
                });
            },
        });
    }); 
    /*
    * Valida o campo quantidade solicitada e calcula o total para cada item iserido na solicitação de empenho
    */
    $(document).on("click", "#salvar", function(){
        $.ajax({
            method:'POST',
            url: '/fornecedor/item/atribuir/assincrono/'+$('#item').val()+'/'+$('#fornecedor').val(),
            data: {
                licitacao: $('#licitacao').val(),
                quantidade: $('#quantidade').val(),
                marca: $('#marca').val(),
                modelo: $('#modelo').val(),
                valor: $('#valor').val(),
                "_token": $('meta[name="csrf-token"]').attr('content')
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
    /*
    * Valida o campo quantidade solicitada e calcula o total para cada item iserido na solicitação de empenho
    */   
    $('input[name^="campos"]').focusout(function() {
        var quantidade = $(this).val();
        var numero = $(this).attr("data-numero");
        if (quantidade != "") {
            quantidade = parseInt(quantidade);
            var max = parseInt($("#max" + numero).html());

            if (quantidade > 0 && quantidade <= max ) {
                remover(numero);
                adicionar(numero, quantidade);
                var valor =  parseFloat($("#valor" + numero).html().replace(".", "").replace(",", ".")).toFixed(2);
                $('#totalItem'+numero).val((quantidade * valor).toLocaleString('pt-BR', { minimumFractionDigits: 2 }));             
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
            } else{
                remover(numero);
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $('#totalItem'+numero).val("");
                alert("A quanitidade solicitada dever maior que 0 e menor ou igual ao saldo");
            }
        } else{
            remover(numero);
            $(this).removeClass("is-valid");
            $(this).removeClass("is-invalid");
            $('#totalItem'+numero).val("");
        }
        $('#total').val(calculaTotal());
    });
    /**
     * Executa todo as etapas de calcular, inserir e remover todos os itens disponíves na solicitação de empenho
     */
     $('#btnTudo').click(function(){
        if($(this).attr("data-clicked") === '0'){
            $(this).text("Remover Tudos");
            $(this).removeClass("btn-primary");
            $(this).addClass("btn-warning");
            $(this).attr("data-clicked", "1");
            $('input[name^="campos"]').each(function() {
                var numero = $(this).attr("data-numero");
                var max = parseInt($("#max" + numero).html());
                var valor =  parseFloat($("#valor" + numero).html().replace(".", "").replace(",", ".")).toFixed(2);
                $(this).val(max); // atribui o valor máximo ao field campos
                $('#totalItem'+numero).val((max * valor).toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
                $('#total').val(calculaTotal());
                $(this).addClass("is-valid");
                remover(numero);
                adicionar(numero, max);
            });
        }else{
            $(this).attr("data-clicked", "0");
            $(this).removeClass("btn-warning");
            $(this).addClass("btn-primary");
            $(this).text("Incluir Tudos");
            $('#total').val("");
            $('input[name^="totalItem"]').each(function() {
                $(this).val("");
            });
            $('input[name^="campos"]').each(function() {
                $(this).val(""); 
                $(this).removeClass("is-valid");
                remover($(this).attr("data-numero"));                  
            });

        }
    });
    /**
     * calcula o valor total geral da contratação
     */
    function calculaTotal(){
        var total = 0.0;
        $('input[name^="totalItem"]').each(function() {
            if ($(this).val() != '') {
                total += parseFloat($(this).val().replace(".", "").replace(",", "."));
            }
        });
        return total.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
    }
    /*
     * Exibe e esconde o dropdown com a descrição detalahada
     */
    $(".botao").hover(function() { 
        $(this).parent().children(".dropdown").children(".dropdown-menu").toggle();
    })
    /*
     * Remove o input item e quantidade do formulário "form"
     */
    function remover(numero){
        if ($("#item"+numero).length) { 
            $("#item"+numero).remove();
            $("#quant"+numero).remove();
        }
    }
    /*
     * Adiciona os input hidden 'items' e 'quantidades' no formulário "form"
     */
    function adicionar(numero, quantidade){
        $('#form').append("<input  id='quant"+numero+"' name='quantidades[]' type='hidden' value='"+quantidade+"'>");
        $('#form').append("<input  id='item"+numero+"' name='itens[]' type='hidden' value='"+numero+"'>");
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////// RELAÇÃO DE MODALS DA APLICAÇÃO /////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Modal de confirmação de exclusão de  cotação de preços
     */
    $('button[data-modal="cotacao-delete"]').click(function(event) { 
        if (!$('#cotacao-confirma-delete').length) {
            $('body').append(`<div class="modal fade" id="cotacao-confirma-delete" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><div class="row"><div class="col-md-6"><h4 class="modal-title" id="apagarCotacaoModal">Excluir Cotação</h4></div><div class="col-md-6"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div></div><div class="modal-body">    <div class="row"> <div class="col-md-2 text-center"> <i class="fa fa-exclamation-triangle fa-5x color-danger" aria-hidden="true"></i> </div> <div class="col-md-10"><h5>Tem certeza que deseja excluir esta cotação de preço?</h5> </div></div></div><div class="modal-footer"><div class="row"><div class="col-md-3 col-md-offset-6"><button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button></div><div class="col-md-3"><form action="#" method="post"><input type="hidden" name="_token"><input type="hidden" name="_method" value="DELETE"><button type="submit" id='cotacao-delete' class="btn btn-danger btn-block">Excluir</button></form></div></div></div></div></div></div>`); }
        $('input[name="_token"]').val($('meta[name="csrf-token"]').attr('content'));
        $('#cotacao-delete').attr('formaction', $(this).attr('data-route')); 
        $('#cotacao-confirma-delete').modal({show:true}); 
    });
    /*
    * Modal de confirmação de encerramento da sessão
    */
    $('#logout').click(function(event) { 
        if (!$('#confirma-logout').length){ 
            $('body').append(`<div class="modal fade" id="confirma-logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header bg-primary"><div class="row"><div class="col-md-6"><h4 class="modal-title" id="apagarCotacaoModal">Aviso</h4></div><div class="col-md-6"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> </div> </div> </div> <div class="modal-body"> <div class="row"> <div class="col-md-12"> <h5> <i class="fa fa-exclamation-triangle fa-2x text-warning" aria-hidden="true"></i> Você realmente deseja sair? <h5> </div> </div> </div> <div class="modal-footer"> <div class="row"> <div class="col-md-3 col-md-offset-6"> <button class="btn btn-block btn-secondary" type="button" data-dismiss="modal">Cancel</button></div> <div class="col-md-3"> <form id="form-sair" method="POST"> <input type="hidden" name="_token"> <button type="submit" class="btn btn-block btn-danger">Sair</button> </form> </div> </div> </div> </div> </div> </div>`); 
        }
        $('input[name="_token"]').val($('meta[name="csrf-token"]').attr('content')); 
        $('#form-sair').attr('action', $(this).attr('data-route')); 
        $('#confirma-logout').modal({show:true}); 
    });
    /*
    * Modal de confirmação de exclusão de pregão
    */
    $('button[data-modal="pregao"]').click(function(event) { 
        if (!$('#pregao-confirma-delete').length){ 
            $('body').append(`<div class="modal fade" id="pregao-confirma-delete" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"> <div class="modal-content"><div class="modal-header bg-primary"><div class="row"> <div class="col-md-6"><h4 class="modal-title" id="excluirLicitacaoModal">Excluir Licitação</h4></div><div class="col-md-6"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div> </div><div class="modal-body"><div class="row"> <div class="col-md-2 text-center"><i class="fa fa-exclamation-triangle fa-5x text-danger" aria-hidden="true"></i> </div> <div class="col-md-10"> <h5><p class="font-weight-bold"> Tem certeza que deseja excluir definitivamente esta licitação?</p><p>Esta ação também excluirá:</p> <ul><li>Itens mesclados e duplicados;</li><li>Item criado a partir desta licitação e não relacionado a requisição;</li> <li>Fornecedores dos itens desta licitação;</li><li>Atas de Registros de Preços desta licitação;</li> <li>Todas as contratações relacionadas a esta licitação; e</li><li>Participantes desta licitação.</li></ul></h5> </div></div> </div> <div class="modal-footer"> <div class="row"><div class="col-md-3 col-md-offset-6"><button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button></div><div class="col-md-3"><form  id="pregao-delete" method="post"><input type="hidden" name="_token"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger btn-block">Excluir</button></form></div> </div> </div></div> </div> </div> `);
        }
        $('input[name="_token"]').val($('meta[name="csrf-token"]').attr('content')); 
        $('#pregao-delete').attr('action', $(this).attr('data-route')); 
        $('#pregao-confirma-delete').modal({show:true}); 
    });
    /*
    * Modal confirma a remoção de todos os itens de uma requisição específica da relação de itens da licitação
    */
    $('button[data-modal="licitacao-requisicao"]').click(function(event) { 
        if (!$('#licitacao-requisicao-remove').length){ 
            $('body').append(`<div class="modal fade" id="licitacao-requisicao-remove" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <div class="row"> <div class="col-md-6"> <h4 class="modal-title" id="removeRequisicaoModal">Remover Itens</h4> </div><!-- / col-md-6 --> <div class="col-md-6"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> </div> </div> <div class="modal-body"> <div class="row"> <div class="col-md-2 text-center"> <i class="fa fa-exclamation-triangle fa-5x color-orange" aria-hidden="true"></i> </div> <div class="col-md-10"> <h5> <p class="font-weight-bold"> Realmente deseja remover da licitação esta requisição? </p> <p> - Todos os itens da requisição serão removidos da licitação.</p> <p> - Você poderá incluir esta requisição novamente.</p> <p> - Será defeita a mesclagem de itens que contenha elementos desta requisição.</p> </h5> </div> </div> </div> <div class="modal-footer"> <div class="row"> <div class="col-md-3 col-md-offset-6"> <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button> </div> <div class="col-md-3"> <form id="form-requisicao-remove" method="post"> <input type="hidden" name="_token"> <input type="hidden" name="_method" value="DELETE"> <button  type="submit" class="btn btn-warning btn-block">Remover</button> </form> </div> </div> </div> </div> </div> </div> `);
            }
        $('input[name="_token"]').val($('meta[name="csrf-token"]').attr('content')); 
        $('#form-requisicao-remove').attr('action', $(this).attr('data-route')); 
        $('#licitacao-requisicao-remove').modal({show:true}); 
    });
    /*
    * Modal para confirmar a exclusão um item específico
    */
    $('button[data-modal="item-delete"]').click(function(event) { 
        if (!$('#confirma-item-delete').length){ 
            $('body').append(`<div class="modal fade" id="item-confirma-delete" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <div class="row"> <div class="col-md-6"> <h4 class="modal-title" id="mediumModalLabel">Apagar item</h4> </div> <div class="col-md-6"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> </div> </div> <div class="modal-body"> <div class="row"> <div class="col-md-2 text-center"> <i class="fa fa-exclamation-triangle fa-5x color-danger" aria-hidden="true"></i> </div> <div class="col-md-10"> <h5>  Tem certeza que deseja excluir este item? </h5> </div> </div> </div> <div class="modal-footer"> <div class="row"> <div class="col-md-3 col-md-offset-6"> <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button> </div> <div class="col-md-3"> <form id="form-item-delete" method="POST"> <input type="hidden" name="_token"> <input type="hidden" name="_method" value="DELETE"> <button type="submit" class="btn btn-danger btn-block">Excluir</button> </form> </div> </div> </div> </div> </div> </div>`);
        }
        $('input[name="_token"]').val($('meta[name="csrf-token"]').attr('content')); 
        $('#form-item-delete').attr('action', $(this).attr('data-route')); 
        $('#item-confirma-delete').modal({show:true}); 
    });
    /*
    * Modal para confirmar a exclusão da requisição
    */
    $('button[data-modal="requisicao-delete"]').click(function(event) { 
        if (!$('#requisicao-confirma-delete').length){ 
            $('body').append(`<div class="modal fade" id="requisicao-confirma-delete" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <div class="row"> <div class="col-md-6"> <h4 class="modal-title" id="mediumModalLabel">Apagar Requisição</h4> </div> <div class="col-md-6"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> </div> </div> <div class="modal-body"> <div class="row"> <div class="col-md-2 text-center"> <i class="fa fa-exclamation-triangle fa-5x color-danger" aria-hidden="true"></i> </div> <div class="col-md-10"> <h5> <p class="font-weight-bold">Tem certeza que deseja excluir esta Requisição? </p> <p>Está ação também apaga:</p> <p> - definitivamente todos os itens desta requisição; e</p> <p> - as cotações de preços dos itens relacionaos.</p> </h5> </div> </div> </div> <div class="modal-footer"> <div class="row"> <div class="col-md-3 col-md-offset-6"> <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button> </div> <div class="col-md-3"> <form method="post" id="form-requisicao-delete"> <input type="hidden" name="_token"> <input type="hidden" name="_method" value="DELETE"> <button type="submit" class="btn btn-danger btn-block">Excluir</button> </form> </div> </div> </div> </div> </div> </div>`);
        } 
        $('input[name="_token"]').val($('meta[name="csrf-token"]').attr('content'));
        $('#form-requisicao-delete').attr('action', $(this).attr('data-route')); 
        $('#requisicao-confirma-delete').modal({show:true}); 
    });
    /*
    * Modal para apagar multiplos itens da requisição
    */
    $('button[data-modal="itens-delete"]').click(function(event) { 
        if (!$('#itens-confirma-delete').length){ 
            $('body').append(`<div class="modal fade" id="itens-confirma-delete" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <div class="row"> <div class="col-md-6"> <h4 class="modal-title">Apagar Itens</h4> </div> <div class="col-md-6"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> </div> </div> <div class="modal-body"> <div class="row"> <div class="col-md-2 text-center"> <i class="fa fa-exclamation-triangle fa-5x color-danger" aria-hidden="true"></i> </div> <div class="col-md-10 mb-2"> <h5> <p class="font-weight-bold"> Tem certeza que deseja apagar os itens selecionados ? </p> </h5> </div> </div> <div id="divItens"></div> </div> <div class="modal-footer"> <div class="row"> <div class="col-md-3 col-md-offset-6"> <button type="button" class="btn btn-primary btn-block font-weight-bold" data-dismiss="modal">Cancelar</button> </div> <div class="col-md-3"> <button id="form-itens-submit" class="btn btn-danger btn-block font-weight-bold">Excluir</button> </div> </div> </div> </div> </div> </div>`); 
        }
        $('#form-requisicao-itens').attr('action', $(this).attr('data-route')); 
        $('#itens-confirma-delete').modal({show:true}); 
    });

    $('body').on('click', '#form-itens-submit', function() {
        $('#form-requisicao-itens').submit();
    });
    /*
    * Modal para apagar multiplos itens da licitacao
    */
    $('button[data-modal="licitacao-itens-delete"]').click(function(event) { 
        if (!$('#licitacao-itens-delete').length){ 
            $('body').append(`<div class="modal fade" id="licitacao-itens-delete" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <div class="row"> <div class="col-md-6"> <h4 class="modal-title">Apagar Itens</h4> </div> <div class="col-md-6"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> </div> </div> <div class="modal-body"> <div class="row"> <div class="col-md-2 text-center"> <i class="fa fa-exclamation-circle fa-5x color-danger" aria-hidden="true"></i> </div> <div class="col-md-10 mb-2"> <h5> <p class="font-weight-bold"> Tem certeza que deseja remover o(s) item(ns) selecionado(s) da licitação? </p> </h5> </div> </div> <div id="divItens"></div> </div> <div class="modal-footer"> <div class="row"> <div class="col-md-3 col-md-offset-6"> <button type="button" class="btn btn-primary btn-block font-weight-bold" data-dismiss="modal">Cancelar</button> </div> <div class="col-md-3"> <button id="form-licitacao-itens-submit" class="btn btn-danger btn-block font-weight-bold">Excluir</button> </div> </div> </div> </div> </div> </div>`); 
        }
        $('#form-licitacao-itens').attr('action', $(this).attr('data-route')); 
        $('#licitacao-itens-delete').modal({show:true}); 
    });

    $('body').on('click', '#form-licitacao-itens-submit', function() { 
        $('#form-licitacao-itens').submit();
    });
        /*
    * Modal para confirmação da separação de itens mesclados 
    *
    */
    $('button[data-modal="separar"]').click(function(event) { 
        if (!$('#confirma-mesclar-delete').length){ 
            $('body').append(`
                    <div class="modal fade" id="confirma-mesclar-delete" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="modal-title" id="desmesclarModal">Separar Itens</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>     
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-2 text-center">
                                            <i class="fa fa-exclamation-triangle fa-5x color-orange" aria-hidden="true"></i>
                                        </div>                                         
                                        <div class="col-md-10">
                                            <h5>
                                                <p class="font-weight-bold">
                                                    Tem certeza que deseja desfazer a mesclado deste item?
                                                </p>
                                                <p>Está ação remove:</p>
                                                <p> - Definitivamente edições no item mesclado.</p>
                                                <p> - Órgão e entidades participantes do item mesclado.</p>
                                                <p> - Fornecedor atribuido ao item mesclado.</p>
                                                <p>Os itens separados serão inseridos ao final da relação de itens.</p>
                                                <br>
                                                <p>Observação: Não é possível desfazer mescla de item que tenha Ata SRP e contraçãoes realizadas.</p>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-md-3 col-md-offset-6">
                                            <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
                                        </div>
                                        <div class="col-md-3">
                                            <form  id="mesclar-delete" method="post">
                                                <input type="hidden" name="_token">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button  type="submit" class="btn btn-warning btn-block">Remover</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);
        }
        $('input[name="_token"]').val($('meta[name="csrf-token"]').attr('content')); 
        $('#mesclar-delete').attr('action', $(this).attr('data-route')); 
        $('#confirma-mesclar-delete').modal({show:true}); 
    });

    /*
    * Modal para duplicar um ou mais itens da requisição
    */
    $('button[data-modal="itens-duplicar"]').click(function(event) { 
        if (!$('#itens-confirma-duplicar').length){ 
            $('body').append(`<div class="modal fade" id="itens-confirma-duplicar" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="modal-title">Duplicar Itens</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>  
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-2 text-center">
                                            <i class="fa fa-exclamation-triangle fa-5x color-success" aria-hidden="true"></i>
                                        </div>  
                                        <div class="col-md-10 mb-2">
                                            <h5>
                                                <p class="font-weight-bold">
                                                    Tem certeza que deseja duplicar o(s) item(ns) selecionado(s) ?
                                                </p>   
                                            </h5>
                                        </div>
                                    </div>
                                    <div id="divItens"></div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-md-3 col-md-offset-6">
                                            <button type="button" class="btn btn-primary btn-block font-weight-bold" data-dismiss="modal">Cancelar</button>
                                        </div>
                                        <div class="col-md-3">
                                            <button id="form-itens-submit" class="btn btn-success btn-block font-weight-bold">Duplicar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);
        }
        $('#form-requisicao-itens').attr('action', $(this).attr('data-route')); 
        $('#itens-confirma-duplicar').modal({show:true}); 
    });
    $('body').on('click', '#btn-itens-duplicar', function() {
        $('#form-requisicao-itens').submit();
    }); 

    /*<div class="modal fade" id="mediumModalLabel" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="modal-title" id="mediumModalLabel">Apagar item</h4>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>	
            </div><!-- /.modal-header -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5>
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            Tem certeza que deseja excluir definitivamente este item?
                        </h5>
                    </div>
                </div>
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-3 col-md-offset-6">
                        <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div class="col-md-3">
                        <form action="#" method="post">
                            {{csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-block">Excluir</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal --></div>*/
});
