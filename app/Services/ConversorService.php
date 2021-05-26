<?php

namespace App\Services;

class ConversorService
{
	/**
     * Converte string data e String hora para o formato Datetime a ser registrado na baase de dados
     *
     * @param String $data
     * @param Strng $hora
     * @return Datetime 
     */
    public static function dataHoraToDatetime($data, $hora)
    { 
        $hora = preg_replace("/[^0-9]/", "", $hora);
        $data = preg_replace("/[^0-9]/", "", $data);
        if(strlen($data) == 8){
            $data = preg_replace('/^([0-9]{2})([0-9]{2})([0-9]{4})$/', '$1-$2-$3', $data);
        } elseif (strlen($data) == 6) {
            $data = preg_replace('/^([0-9]{2})([0-9]{2})([0-9]{2})$/', '$1-$2-20$3', $data); // acrescenta 20 caso a data tenha formato dd/mm/aa
        } else {
            $data = NULL;  // data invalida é definada como nula
        }

        if(strlen($hora) == 4){
            $hora = preg_replace('/^([0-9]{2})([0-9]{2})$/', '$1:$2', $hora);
        } else {
            $hora = '00:00';
        }

        if($data == NULL){
            return NULL;
        } else {
            return date_format(date_create($data.' '.$hora), 'Y-m-d H:i:s');
        }
    }

    /** 
	 * Converte string valor para o formato numérico float
	 *
	 * @param String $valor,
	 * @return float $valor
	 */
	public static function stringToFloat($valor)
	{ 
	  	if(strstr($valor, ",")) { 
		    $valor = str_replace(",", ".", str_replace(".", "", $valor));
	  	} 
	   // search for number that may contain '.' 
	    if(preg_match("#([0-9\.]+)#", $valor, $match)) {
		    return floatval($match[0]); 
	    } else { 
	    	// take some last chances with floatval 
	    	return floatval($valor); 
	  	}
	}

	/**
     * Retorno o nome do estado a partir da sigla
	 * 
	 * @param  String $sigla 
	 * @return String $nome 
	 */
	public function siglaToUF($sigla)
	{
		switch (strtoupper($sigla)) {
			case 'AC': return 'Acre';
			case 'AL': return 'Alagoas';
			case 'AP': return 'Amapá';
			case 'AM': return 'Amazonas';
			case 'BA': return 'Bahia';
			case 'CE': return 'Ceará';
			case 'DF': return 'Distrito Federal';
			case 'ES': return 'Espírito Santo';
			case 'GO': return 'Goiás';
			case 'MA': return 'Maranhão';
			case 'MT': return 'Mato Grosso';
			case 'MS': return 'Mato Grosso do Sul';
			case 'MG': return 'Minas Gerais';
			case 'PA': return 'Pará';
			case 'PB': return 'Paraíba';
			case 'PR': return 'Paraná';
			case 'PE': return 'Pernambuco';
			case 'PI': return 'Piauí';
			case 'RJ': return 'Rio de Janeiro';
			case 'RN': return 'Rio Grande do Norte';
			case 'RS': return 'Rio Grande do Sul';
			case 'RO': return 'Rondônia';
			case 'RR': return 'Roraima';
			case 'SC': return 'Santa Catarina';
			case 'SP': return 'São Paulo';
			case 'SE': return 'Sergipe';
			case 'TO': return 'Tocantins';
			default: return 'Inconsistente';
		}
	}
	
}