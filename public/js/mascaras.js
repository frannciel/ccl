/*
    Mascara de validação dos campos
 */
$('#processo').mask('00000.000000/0000-00');
$('#valor').mask('#.##0,00', {reverse: true});
$('#pregao').mask('000/0000');
$('#numero').mask('000/0000');
$('#data').mask('00/00/0000');
$('#hora').mask('00:00');


/*
* Toda vez que um valor for digitado ONKEYUP está função e chamada para formatar o valor
* colocando-o no formato de moeda.
*/
/*
$('#valor').keyup(function(){
    valor = $(this).val();
    // remove simbolos e letras do valor
    valor  = valor.replace(/[^0-9]/g, '');
    // Verifica se o valor não esta vazio
    if (valor.length > 0) {
        // convert em inteiro para remover 0 a esquerda
        valor  = parseInt( valor.replace(/[\D]+/g,''));
        // converte novamente para string 
        valor = valor+'';
        switch(valor.length){
            case 1:
                valor = '0,0'+ valor.substr(0);
                break;
            case 2:
                valor = '0,'+valor.substr(0,2);
                break;
            case 3:
                valor = valor.replace(/(\d{1})(\d{2})/, '$1,$2');
                break;
            case 4:
                valor = valor.replace(/(\d{2})(\d{2})/, '$1,$2');
                break;
            case 5:
                valor = valor.replace(/(\d{3})(\d{2})/, '$1,$2');
                break;
            case 6:
                valor = valor.replace(/(\d{1})(\d{3})(\d{2})/, '$1.$2,$3');
                break;
            case 7:
                valor = valor.replace(/(\d{2})(\d{3})(\d{2})/, '$1.$2,$3');
                break;
            case 8:
                valor = valor.replace(/(\d{3})(\d{3})(\d{2})/, '$1.$2,$3');
                break;
            case 9:
                valor = valor.replace(/(\d{1})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3,$4');
                break;
            case 10:
                valor = valor.replace(/(\d{2})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3,$4');
                break;
            case 11:
                valor = valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3,$4');
                break;
        }
    }
    // insere o valor da string no campo valor do formulário
    $(this).val( valor);//document.getElementById("valor").value = valor;
});
*/

$('#processo').focusout(function(){
    var processo = $(this).val();
    // Remove caracteres especiais e letras restando apenas números
    processo = processo.replace(/[^0-9]/g, '');
    if(processo.length == 17){
        // Formata o CPF ###.###.###-##
        $(this).val(processo.replace(/(\d{5})(\d{6})(\d{4})(\d{2})/, '$1.$2/$3-$4'));
    }else{
        if (processo.length > 0)
            alert("Verificar Número de processo inválido");
    }
});

