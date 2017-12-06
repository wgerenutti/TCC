<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade Conhecimento
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="conhecimento")
 *         
 */
class Conhecimento extends Entity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="titulo")
     */
    protected $titulo;

    /**
     * @ORM\ManyToMany(targetEntity="Empregado")
     * @ORM\JoinTable(name="empregado_conhecimento",
     * joinColumns={@ORM\JoinColumn(name="conhecimento_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="empregado_matricula", referencedColumnName="matricula")}
     * )
     */
    protected $matricula;

    public function __construct()
    {
        $this->matricula = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getMatricula()
    {
        return $this->matricula;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
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
                'name' => 'titulo',
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
                            'max' => 200
                        )
                    )
                )
            )));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}