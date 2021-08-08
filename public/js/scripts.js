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
                    success: function(data) { }
                });
            },
        });
    }); 
});
