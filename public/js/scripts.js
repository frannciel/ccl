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

    /*
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
    /*
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

    /*
     * Método que formata o Modal para realizar a exclusão de multiplos itens da view show requisição
    */
    $("#removeAll").click(function(){
        $('#divItens').empty();// limpa os itens listados no modal
        if ($('input[name^="itens"]:checked').length == 0) {
            $("#btnRemoveItem").attr("type", "button"); // altera a propriedade do botão excluir
            $("#msgRemoveItem").html('Nenhum item foi selecionado para exclusão!'); // altera o texto de exclusão do modal
        } else{
            $("#msgRemoveItem").html('Tem certeza que deseja excluir definitivamente os item selecionados?');// altera o texto de exclusão do modal
            $("#btnRemoveItem").attr("type", "submit");// altera a propriedade do botão excluir
                $('input[name^="itens"]').each(function() {
                if ($(this).is(':checked')) {
                    $('#divItens').append("<div class='row'><div class='col-md-12'>"+$(this).attr("data-object")+"</div></div>");
                }
            });
        }
    });

    /*
     * Function necessária para apagar uma cotãção de preços 
     */
    $('.apagarCotacao').click(function(){
        $('#formApagarCotacao').removeAttr("action");
        $('#formApagarCotacao').prop("action", $(this).attr("data-route"));
    });

    /*
     * Function necessária para apagar uma cotãção de preços 
     */
    $('.removeRequisicao').click(function(){
        $('#formRemoveRequisicao').removeAttr("action");
        $('#formRemoveRequisicao').prop("action", $(this).attr("data-route"));
    });

    $('.desmesclar').click(function(){
        $('#formDesmesclar').removeAttr("action");
        $('#formDesmesclar').prop("action", $(this).attr("data-route"));
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
