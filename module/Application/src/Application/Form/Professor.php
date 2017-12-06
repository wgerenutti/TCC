<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class Professor extends Form
{

    public function __construct()
    {
        parent::__construct('Professor');
        $this->setHydrator(new ClassMethods());
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/application/professor/save');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden'
            )
        ));
        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'required' => true,
                'style' => 'width:800px',
                'type' => 'text',
                'id' => 'nome'
            ),
            'options' => array(
                'label' => 'Nome:*'
            )
        ));
        
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'required' => true,
                'style' => 'width:800px',
                'type' => 'Zend\Form\Element\Email'
            ),
            'options' => array(
                'label' => 'Email:*'
            )
        ));
        
        $this->add(array(
            'name' => 'telefone',
            'attributes' => array(
                'required' => false,
                'style' => 'width:800px',
                'type' => 'text',
                'id' => 'telefone'
            ),
            'options' => array(
                'label' => 'Telefone:*'
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Enviar',
                'id' => 'submit'
            )
        ));
    }
}