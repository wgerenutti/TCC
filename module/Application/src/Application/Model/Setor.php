<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade de Setor
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="setor")
 *         
 */
class Setor extends Entity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="nome")
     */
    protected $nome;

    /**
     * @ORM\ManyToOne(targetEntity="Empregado")
     * @ORM\JoinColumn(name="gerente_id", referencedColumnName="matricula")
     */
    protected $gerente;
    
    /**
     * @ORM\ManyToMany(targetEntity="Empregado")
     * @ORM\JoinTable(name="empregado_setor",
     * joinColumns={@ORM\JoinColumn(name="setor_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="empregado_matricula", referencedColumnName="matricula")}
     * )
     */
    protected $participantes;
    public function __construct()
    {
    	$this->participantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function getParticipantes()
    {
    	return $this->participantes;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getGerente()
    {
    	return $this->gerente;
    }
    
    public function setGerente($gerente)
    {
    	$this->gerente = $gerente;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function setParticipantes($participantes)
    {
    	$this->participantes = $participantes;
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
            $inputFilter->add($factory->createInput(array(
                'name' => 'nome',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 100
                        )
                    )
                )
            )));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}