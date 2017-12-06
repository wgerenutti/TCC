<?php
namespace Application\Validator;

use Zend\Validator\AbstractValidator;

class Cpf extends AbstractValidator
{

    const INVALIDO = 'INVALIDO';

    protected $messageTemplates = array(
        self::INVALIDO => 'Cpf inválido'
    );

    public function __construct(array $options = array())
    {
        parent::__construct($options);
    }

    public function isValid($cpf = null)
    {
        // elimina possivel mascara
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
        
        // verifica se o numero de digitos informados � igual a 11
        if (strlen($cpf) != 11) {
            $this->error(self::INVALIDO);
            return false;
        } // verifica se nenuma das sequ�ncias invalidas abaixo
          // foi digitada. caso afirmativo, retorna falso
        else if (preg_match('/(\d)\1{10}/', $cpf)) {
            $this->error(self::INVALIDO);
            return false;
        } // calcula os digitos verificadores para verificar
          // se o CPF � valido
        else {
            for ($t = 9; $t < 11; $t ++) {
                for ($d = 0, $c = 0; $c < $t; $c ++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    $this->error(self::INVALIDO);
                    return false;
                }
            }
            return true;
        }
    }
}