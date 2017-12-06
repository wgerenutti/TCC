<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade de Institui��o
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="instituicao")
 *         
 */
class Instituicao extends Entity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="bigint", name="cnpj")
     */
    protected $cnpj;

    /**
     * @ORM\Column(type="string", name="razao_social")
     */
    protected $razaoSocial;

    /**
     * @ORM\Column(type="string", name="email")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", name="endereco")
     */
    protected $endereco;

    /**
     * @ORM\Column(type="integer", name="cep")
     */
    protected $cep;

    /**
     * @ORM\Column(type="string", name="bairro")
     */
    protected $bairro;

    /**
     * @ORM\Column(type="bigint", name="telefone")
     */
    protected $telefone;

    /**
     * @ORM\Column(type="string", name="localizacao")
     */
    protected $localizacao;

    public function getId()
    {
        return $this->id;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getLocalizacao()
    {
        return $this->localizacao;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function setRazaoSocial($razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;
    }

    public function setLocalizacao($localizacao)
    {
        $this->localizacao = $localizacao;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => false
            )));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}

