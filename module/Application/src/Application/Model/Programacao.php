<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade Programacao da turma
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="turma_programacao")
 */
class Programacao extends Entity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", name="data_realizacao")
     */
    protected $dataRealizacao;

    /**
     * @ORM\Column(type="string", name="hora_inicial")
     */
    protected $horaInicial;

    /**
     * @ORM\Column(type="string", name="hora_final")
     */
    protected $horaFinal;

    /**
     * @ORM\Column(type="string", name="local")
     */
    protected $local;

    /**
     * @ORM\ManyToOne(targetEntity="Turma", inversedBy="programacao")
     * @ORM\JoinColumn(name="turma_id", referencedColumnName="id")
     */
    protected $turma;

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

    public function getId()
    {
        return $this->id;
    }

    public function getDataRealizacao()
    {
        return $this->dataRealizacao;
    }

    public function getHoraInicial()
    {
        return $this->horaInicial;
    }

    public function getHoraFinal()
    {
        return $this->horaFinal;
    }

    public function getLocal()
    {
        return $this->local;
    }

    public function getTurma()
    {
        return $this->turma;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDataRealizacao($dataRealizacao)
    {
        $this->dataRealizacao = $dataRealizacao;
    }

    public function setHoraInicial($horaInicial)
    {
        $this->horaInicial = $horaInicial;
    }

    public function setHoraFinal($horaFinal)
    {
        $this->horaFinal = $horaFinal;
    }

    public function setLocal($local)
    {
        $this->local = $local;
    }

    public function setTurma($turma)
    {
        $this->turma = $turma;
    }
}