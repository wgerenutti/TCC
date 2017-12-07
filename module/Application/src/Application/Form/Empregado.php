<?php

namespace Application\Form;

use Zend\Form\Form;
use Application\Validator\Cpf;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;

class Empregado extends Form implements InputFilterProviderInterface {
	public function __construct($em) {
		parent::__construct ( 'Empregado' );
		$this->setHydrator ( new ClassMethods () );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/empregado/save' );
		
		$this->add ( array (
				'name' => 'matricula',
				'attributes' => array (
						'style' => 'width:800px',
						'type' => 'hidden' 
				),
				'options' => array (
						'label' => 'Matricula:*' 
				) 
		) );
		$this->add ( array (
				'name' => 'nome',
				'attributes' => array (
						'style' => 'width:800px',
						'type' => 'text',
						'required' => true 
				),
				'options' => array (
						'label' => 'Nome:*' 
				) 
		) );
		$this->add ( array (
				'name' => 'cargo',
				
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'attributes' => array (
						'style' => 'width:800px',
						'required' => true,
						'id' => 'cargo' 
				),
				'options' => array (
						'label' => 'Cargo:*',
						'empty_option' => '--- Escolha um Cargo ---',
						'object_manager' => $em,
						'target_class' => 'Application\Model\Cargo',
						'property' => 'descricao' 
				) 
		) );
		$this->add ( array (
				'name' => 'cpf',
				'attributes' => array (
						'type' => 'text',
						'style' => 'width:800px',
						'required' => true,
						'id' => 'cpf' 
				),
				'options' => array (
						'label' => 'CPF:*' 
				) 
		) );
		$this->add ( array (
				'name' => 'admissao',
				'attributes' => array (
						'required' => true,
						'style' => 'width:100px',
						'type' => 'text',
						'id' => 'admissao' 
				),
				'options' => array (
						'label' => 'Data de admissão:*' 
				) 
		) );
		$this->add ( array (
				'name' => 'telefone',
				'attributes' => array (
						'style' => 'width:800px',
						'type' => 'text',
						'id' => 'telefone',
						'required' => true 
				),
				'options' => array (
						'label' => 'Telefone:*' 
				) 
		) );
		$this->add ( array (
				'name' => 'salario',
				'attributes' => array (
						'style' => 'width:800px',
						'type' => 'text',
						'id' => 'salario',
						'required' => true 
				),
				'options' => array (
						'label' => 'Salário:*' 
				) 
		) );
		$this->add ( array (
				'type' => 'Zend\Form\Element\Select',
				'name' => 'gerente',
				'required' => true,
				'options' => array (
						'label' => 'Esse empregado é o gerente do seu setor?*',
						'empty_option' => '-- Selecione um --',
						'value_options' => array (
								'inativo' => 'Não',
								'ativo' => 'Sim' 
						) 
				) 
		) );
		
		$this->add ( array (
				'name' => 'inicial',
				'attributes' => array (
						'style' => 'width:100px',
						'type' => 'text',
						'id' => 'inicial',
						'required' => true 
				),
				'options' => array (
						'label' => 'Data Inicial:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'final',
				'attributes' => array (
						'style' => 'width:100px',
						'type' => 'text',
						'id' => 'final',
						'required' => true 
				),
				'options' => array (
						'label' => 'Data Inicial:*' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'submit',
				'attributes' => array (
						'type' => 'submit',
						'value' => 'Enviar',
						'id' => 'submit' 
				) 
		) );
	}
	public function getInputFilterSpecification() {
		return array (
				array (
						'name' => 'cpf',
						'required' => true,
						'validators' => array (
								array (
										'name' => 'Application\Validator\Cpf' 
								) 
						) 
				) 
		);
	}
}