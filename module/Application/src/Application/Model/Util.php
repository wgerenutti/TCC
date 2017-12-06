<?php
/*
 * Author: Paulo Roberto Silla - paulo.silla@embrapa.br
 * Author: William Gerenutti - williamgerenuttidm@gmail.com
 */
namespace Application\Model;

class Util
{

    /*
     * @return Array contendo os nomes dos Estados brasileiros identificados
     * por suas siglas (UF)
     */
    public static function getEstadosBr()
    {
        return array(
            '' => '--- Escolha um Estado ---',
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AM' => 'Amazonas',
            'AP' => 'Amapá',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RO' => 'Rondônia',
            'RS' => 'Rio Grande do Sul',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SE' => 'Sergipe',
            'SP' => 'São Paulo',
            'TO' => 'Tocantins'
        );
    }

    /*
     * Converte a data para os formatos AAAA/MM/DD e DD/MM/AAAA
     * @param string $data - data no formato AAAA/MM/DD ou DD/MM/AAAA
     * @return string (data convertida)
     */
    public static function converteData($data)
    {
        $data_aux = explode("/", $data);
        return $data_aux[2] . "-" . $data_aux[1] . "-" . $data_aux[0];
    }

    /*
     * Remove os carecteres alfabéticos e os símbolos da string,
     * deixando apenas os dígitos de 0 a 9
     */
    public static function removeCaracteres($valor)
    {
        return preg_replace("/[^0-9]/", "", $valor);
    }

    /*
     * Recebe um valor decimal no formato 999.999.999,99 (máscara de entrada na
     * tela) e o converte para o formato 999999999.99 (padrão do banco de dados)
     */
    public static function converteDecimal($valor)
    {
        $valor = str_replace(".", "", $valor);
        return (float) str_replace(",", ".", $valor);
    }

    /*
     * Função de validação de cpf.
     */
    public static function validaCpf($cpf = NULL)
    {
        
        // verifica se um número foi informado
        if (empty($cpf)) {
            return false;
        }
        // elimina possivel mascara
        $cpf = ereg_replace('[^0-9]', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
        
        // verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            return false;
        } // verifica se nenuma das sequências invalidas abaixo
          // foi digitada. caso afirmativo, retorna falso
        else if ($cpf == "00000000000" || $cpf == "11111111111" || $cpf == "22222222222" || $cpf == "33333333333" || $cpf == "44444444444" || $cpf == "55555555555" || $cpf == "66666666666" || $cpf == "77777777777" || $cpf == "88888888888" || $cpf == "99999999999") {
            return false;
        } // calcula os digitos verificadores para verificar
          // se o CPF é valido
        else {
            for ($i = 9; $i < 11; $i ++) {
                for ($j = 0, $k = 0; $k < $i; $k ++) {
                    $j += $cpf{$k} * (($i + 1) - $k);
                }
                $j = ((10 * $j) % 11) % 10;
                if ($cpf{$k} != $j) {
                    return false;
                }
            }
            return true;
        }
    }
}
?>