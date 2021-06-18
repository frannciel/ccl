$(document).ready(function(){
    /*  
     *  Mascara de validação dos campos
     *  Fonte: http://blog.conradosaud.com.br/artigo/26
     */
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
    /*
     * Modal de confirmação de exclusão de uma cotação de preços
     */
    $('.apagar-cotacao').click(function(event) { 
        if (!$('#cotacao-confirma-delete').length) {
            $('body').append(`<div class="modal fade" id="cotacao-confirma-delete" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header bg-danger"><div class="row"><div class="col-md-6"><h4 class="modal-title" id="apagarCotacaoModal">Excluir Cotação</h4></div><div class="col-md-6"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div></div><div class="modal-body"><div class="row"><div class="col-md-12"><h5><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Tem certeza que deseja excluir esta cotação definitivamente?</h5></div></div></div><div class="modal-footer"><div class="row"><div class="col-md-3 col-md-offset-6"><button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button></div><div class="col-md-3"><form action="#" method="post"><input type="hidden" name="_token"><input type="hidden" name="_method" value="DELETE"><button type="submit" id='cotacao-delete' class="btn btn-danger btn-block">Excluir</button></form></div></div></div></div></div></div>`);
        } 
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
     * Modal de exclusão de pregão
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
     * Modal de remover todos os itens da requisição da licitação
     */
    $('button[data-modal="licitacao-requisicao"]').click(function(event) { 
        if (!$('#pregao-confirma-delete').length){ 
             $('body').append(`
                <div class="modal fade" id="lcitacao-requisicao-remove" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="modal-title" id="removeRequisicaoModal">Remover Itens</h4>
                                    </div><!-- / col-md-6 -->   
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
                                                Realmente deseja remover da licitação esta requisição?
                                            </p>
                                            <p> - Todos os itens da requisição serão removidos da licitação.</p>
                                            <p> - Você poderá incluir esta requisição novamente.</p>
                                            <p> - Será defeita a mesclagem de itens que contenha elementos desta requisição.</p>
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
                                     <form id="form-requisicao-remove" method="post">
                                        <input type="hidden" name="_token">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button  type="submit" class="btn btn-warning btn-block">Remover</button>
                                     </form>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div> `);
        }
        $('input[name="_token"]').val($('meta[name="csrf-token"]').attr('content')); 
        $('#form-requisicao-remove').attr('action', $(this).attr('data-route')); 
        $('#lcitacao-requisicao-remove').modal({show:true}); 
    });

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


    /*
     * Oculta a mensagem interessão com o usuário após transcorrido o tempo
     */
    /*$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });*/
    $(".alert").delay(5000).slideUp(200, function() {
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
});
