<?php

use CodeIgniter\I18n\Time;

/**
 * Retorna o nome do mês com base no número passado, 01 até 12
 * @param $numero_mes
 * @return string
 */
function nomeMes($numero_mes): string
{
    switch($numero_mes){
        case '01' :
            $mes = 'Janeiro';
            break;
        case '02' :
            $mes = 'Fevereiro';
            break;
        case '03' :
            $mes = 'Março';
            break;
        case '04' :
            $mes = 'Abril';
            break;
        case '05' :
            $mes = 'Maio';
            break;
        case '06' :
            $mes = 'Junho';
            break;
        case '07' :
            $mes = 'Julho';
            break;
        case '08' :
            $mes = 'Agosto';
            break;
        case '09' :
            $mes = 'Setembro';
            break;
        case '10' :
            $mes = 'Outubro';
            break;
        case '11' :
            $mes = 'Novembro';
            break;
        case '12' :
            $mes = 'Dezembro';
            break;
    }
    return strtoupper($mes);
}

/**
 * Converte uma data do formato americano para o formato brasileiro
 * @param $data
 * @param false $mostrar_hora
 * @return string
 */
function toDataBR($data, bool $mostrar_hora = false): string
{
    return $mostrar_hora ? date('d/m/Y H:i', strtotime($data)) : date('d/m/Y', strtotime($data));
}

/**
 * Converte uma data no formato d/m/Y para EUA: Y-m-d
 * @param $data
 * @return bool|string
 * @throws Exception
 */
function toDataEUA($data)
{
    return Time::createFromFormat('d/m/Y', $data)->toDateString();
}

/**
 * Retorna um array de anos para ser usada dentro de um form dropdown
 * @param array|null $params
 * @return array
 */
function comboAnos(array $params = null): array
{
    $ano_inicial = $params['ano_inicial'];
    $ano_final = date("Y");
    $result = [];

    while ($ano_inicial <= $ano_final) {
        $result += [
            $ano_inicial => $ano_inicial
        ];
        $ano_inicial ++;
    }
    return $result;
}
if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($str)
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc.mb_substr($str, 1);
    }
}

if(!function_exists('consultaCep')) {
    function consultaCep(string $cep)
    {
        $urlViaCep = "https://viacep.com.br/ws/{$cep}/json/";

        /* Abre a conexão */
        $ch = curl_init();

        /* Definindo a URL*/
        curl_setopt($ch, CURLOPT_URL, $urlViaCep);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        /* Executando o POST*/
        $json = curl_exec($ch);

        return json_decode($json);
    }
}
