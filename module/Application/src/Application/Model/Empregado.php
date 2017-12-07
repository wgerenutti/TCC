<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade de Empregados
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="empregado")
 *          @ORM\Entity(repositoryClass="Application\Repository\EmpregadoRepository")
 *         
 */
class Empregado extends Entity {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="matricula")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $matricula;
	
	/**
	 * @ORM\Column(type="string", name="nome")
	 */
	protected $nome;
	
	/**
	 * @ORM\Column(type="date", name="data_admissao")
	 */
	protected $admissao;
	
	/**
	 * @ORM\Column(type="bigint", name="telefone")
	 */
	protected $telefone;
	
	/**
	 * @ORM\Column(type="decimal", precision=2, name="salario")
	 */
	protected $salario;
	
	/**
	 * @ORM\Column(type="bigint", name="cpf")
	 */
	protected $cpf;
	
	/**
	 * @ORM\OneToMany(targetEntity="Cargo", mappedBy="empregado")
	 */
	protected $cargo;
	/**
	 * @ORM\Column(name="gerente", type="string")
	 */
	protected $gerente;
	public function getMatricula() {
		return $this->matricula;
	}
	public function getNome() {
		return $this->nome;
	}
	public function getAdmissao() {
		return $this->admissao->format ( "d-m-Y" );
	}
	public function getTelefone() {
		return $this->telefone;
	}
	public function getSalario() {
		return $this->salario;
	}
	public function getCpf() {
		return $this->cpf;
	}
	public function getCargo() {
		return $this->cargo;
	}
	public function getGerente() {
		return $this->gerente;
	}
	public function setMatricula($matricula) {
		$this->matricula = $matricula;
	}
	public function setNome($nome) {
		$this->nome = $nome;
	}
	public function setAdmissao($admissao) {
		$this->admissao = $admissao;
	}
	public function setTelefone($telefone) {
		$this->telefone = $telefone;
	}
	public function setSalario($salario) {
		$this->salario = $salario;
	}
	public function setCpf($cpf) {
		$this->cpf = $cpf;
	}
	public function setGerente($gerente) {
		$this->gerente = $gerente;
	}
	public function setCargo($cargo) {
		$this->cargo = $cargo;
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'matricula',
					'required' => false 
			) ) );
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}
?>