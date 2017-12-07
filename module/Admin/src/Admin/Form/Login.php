<?php
namespace Admin\Form;
 
use Zend\Form\Form;
 
class Login extends Form
{
	public function __construct()
	{
		parent::__construct('login');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/admin/auth/login');
        
		$this->add(array(
			'name'       => 'nome',
			'attributes' => array(
					'id' => 'nome',
					'required' => true,
                'type'   => 'text',
					'style' => 'width:200px',
		),
			'options'    => array(
			'label'      => 'Nome do usuário',
		),
		));
		$this->add(array(
			'name'       => 'senha',
			'attributes' => array(
                'type'   => 'password',
					'id' => 'senha',
					'required' => true,
					'style' => 'width:200px',
		),
			'options'    => array(
                'label'  => 'Senha',
		),
		));
		$this->add(array(
			'name'       => 'submit',
			'attributes' => array(
			'type'       => 'submit',
			'value'      => 'Entrar',
			'id'         => 'submitbutton',
		),
		));
	}
}