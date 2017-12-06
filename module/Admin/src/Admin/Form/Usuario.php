<?php
namespace Admin\Form;
 
use Zend\Form\Form;
 
class Usuario extends Form
{
	public function __construct()
	{
		parent::__construct('usuario');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/admin/usuario/save');
		$this->add(array(
			'name' => 'id',
			'attributes' => array(
			'type' => 'hidden',
			),
		));
		$this->add(array(
			'name' => 'nome',
			'attributes' => array(
				'type' => 'text',
                'required' => true,
				),
			'options' => array(
			'label' => 'Nome',
			),
		));
		$this->add(array(
			'name' => 'login',
			'attributes' => array(
                'required' => true,
				'type' => 'text',
			),
			'options' => array(
				'label' => 'Login',
			),
		));
		
		$this->add(array(
			'name' => 'funcao',
            'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
                'required' => true,
                'id' => 'funcao',
                'options' => array(
                    '' => '--- Escolha uma função ---',
                    'cliente' => 'Cliente',
               		'spa' => 'SPA',
               		'sce' => 'SCE',
               		'laboratorio' => 'Laboratório', 
                	'admin' => 'Administrador do sistema',
                ),
			),
			'options' => array(
				'label' => 'Função',
			),
		));
                
		$this->add(array(
			'name' => 'email',
			'attributes' => array(
                'required' => true,
                'type' => 'text',
            ),
			'options' => array(
				'label' => 'E-mail',
			),
		));
                
        $this->add(array(
			'name' => 'ramal',
			'attributes' => array(
                'required' => true,
                'type' => 'text',
			),
			'options' => array(
				'label' => 'Ramal',
			),
		));

        $this->add(array(
			'name' => 'usaldap',
			'attributes' => array(
				'type' => 'Checkbox',
                'value' => '1',
//                'checked' => 'True',
			),
			'options' => array(
				'label' => 'Autenticar na base Ldap (usuário interno)',
			),
		));

        $this->add(array(
			'name' => 'senha',
			'attributes' => array(
				'type' => 'password',
//              'disabled' => 'true',
			),
			'options' => array(
				'label' => 'Senha (usuário externo)',
			),
		));
        
        $this->add(array(
            'name' => 'recebenotificacao',
			'attributes' => array(
                'required' => false,
				'type' => 'Checkbox',
                'value' => '1',
//                'checked' => 'True',
			),
			'options' => array(
				'label' => 'Recebe notificações do sistema por e-mail?',
			),
        ));
                
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Enviar',
				'id' => 'submitbutton',
			),
		));
	}
}