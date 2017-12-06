<?php
namespace Application\Validator;

use Zend\Validator\AbstractValidator;

class Cnpj extends AbstractValidator
{

    const INVALIDO = 'INVALIDO';

    protected $messageTemplates = array(
        self::INVALIDO => 'Cnpj inválido'
    );

    public function __construct(array $options = array())
    {
        parent::__construct($options);
    }

    public function isValid($cnpj = null)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);
        // Valida tamanho
        if (strlen($cnpj) != 14) {
            $this->error(self::INVALIDO);
            return false;
        }
        if (($cnpj == "00000000000000") || ($cnpj == "11111111111111")) {
            $this->error(self::INVALIDO);
            return false;
        }
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i ++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto)) {
            $this->error(self::INVALIDO);
            return false;
        }
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i ++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        
        if ($cnpj{13} == ($resto < 2 ? 0 : 11 - $resto)) {
            return true;
        } else {
            $this->error(self::INVALIDO);
            return false;
        }
    }
}