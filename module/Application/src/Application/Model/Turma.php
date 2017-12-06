<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade Turma
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="turma")
 */
class Turma extends Entity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\column(type="string", name="nome")
     */
    protected $nome;

    /**
     * @ORM\column(type="decimal", precision=2, name="valor")
     */
    protected $valor;

    /**
     * @ORM\column(type="string", name="aplicacao")
     */
    protected $aplicacao;

    /**
     * @ORM\ManyToOne(targetEntity="Curso")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     */
    protected $curso;

    /**
     * @ORM\ManyToOne(targetEntity="Instituicao")
     * @ORM\JoinColumn(name="instituicao_id", referencedColumnName="id")
     */
    protected $instituicao;

    /**
     * @ORM\ManyToMany(targetEntity="Empregado")
     * @ORM\JoinTable(name="empregado_turma",
     * joinColumns={@ORM\JoinColumn(name="turma_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="empregado_matricula", referencedColumnName="matricula")}
     * )
     */
    protected $participantes;

    /**
     * @ORM\ManyToMany(targetEntity="Professor")
     * @ORM\JoinTable(name="turma_professor",
     * joinColumns={@ORM\JoinColumn(name="turma_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="professor_id", referencedColumnName="id")}
     * )
     */
    protected $professores;

    /**
     * @ORM\OneToMany(targetEntity="Programacao", mappedBy="turma")
     */
    protected $programacao;

    public function __construct()
    {
        $this->programacao = new \Doctrine\Common\Collections\ArrayCollection();
        $this->participantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->professores = new \Doctrine\Common\Collections\ArrayCollection();
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
                'name' => 'professores[0]',
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

    public function getNome()
    {
        return $this->nome;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function getAplicacao()
    {
        return $this->aplicacao;
    }

    public function getCurso()
    {
        return $this->curso;
    }

    public function getInstituicao()
    {
        return $this->instituicao;
    }

    public function getParticipantes()
    {
        return $this->participantes;
    }

    public function getProfessores()
    {
        return $this->professores;
    }

    public function getProgramacao()
    {
        return $this->programacao;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function setAplicacao($aplicacao)
    {
        $this->aplicacao = $aplicacao;
    }

    public function setCurso($curso)
    {
        $this->curso = $curso;
    }

    public function setInstituicao($instituicao)
    {
        $this->instituicao = $instituicao;
    }

    public function setParticipantes($participantes)
    {
        $this->participantes = $participantes;
    }

    public function setProfessores($professores)
    {
        $this->professores = $professores;
    }

    public function setProgramacao($programacao)
    {
        $this->programacao = $programacao;
    }
}