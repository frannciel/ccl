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

    
    $('.apagar-cotacao').click(function(event) {
        if (!$('#cotacao-confirma-delete').length) {
            $('body').append(`<div class="modal fade" id="cotacao-confirma-delete" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header bg-danger"><div class="row"><div class="col-md-6"><h4 class="modal-title" id="apagarCotacaoModal">Excluir Cotação</h4></div><div class="col-md-6"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div></div><div class="modal-body"><div class="row"><div class="col-md-12"><h5><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Tem certeza que deseja excluir esta cotação definitivamente?</h5></div></div></div><div class="modal-footer"><div class="row"><div class="col-md-3 col-md-offset-6"><button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button></div><div class="col-md-3"><form action="#" method="post"><input type="hidden" name="_token"><input type="hidden" name="_method" value="DELETE"><button type="submit" id='cotacao-delete' class="btn btn-danger btn-block">Excluir</button></form></div></div></div></div></div></div>`);
        }
        $('input[name="_token"]').val($('meta[name="csrf-token"]').attr('content'));
        $('#cotacao-delete').attr('formaction', $(this).attr('data-route'));
        $('#cotacao-confirma-delete').modal({show:true});
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
                $('#buscarItem').attr("href",  $("#buscarItem").attr("data-route")+"/item/atribuir/"+$("#buscarItem").attr("data-licitacao")+"/"+data.requisicao.uuid);
            }
        });
    });
});
