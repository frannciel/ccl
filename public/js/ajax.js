function enviar(nome){
    $.ajax({
        method:'POST',
        url: '/ajax',
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

function getDescricao(id){
	$.ajax({
		method:'POST',
		url: '/requisicao/ajax',
		data: {
			numeroAno: $('#'+id).val(),
			"_token": "{{ csrf_token() }}"
		},
		success: function(data) {
			$('#descricao').val(data.requisicao.descricao);
			$('form').append("<input type='hidden' id='requisicao' name='requisicao' value='"+data.requisicao.id+"'>");
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