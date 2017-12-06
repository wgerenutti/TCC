<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class Setor extends Form
{

    public function __construct($em)
    {
        parent::__construct('Setor');
        $this->setHydrator(new ClassMethods());
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/application/setor/save');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'id'
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
                'label' => 'Nome do setor:*'
            )
        ));
        
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'gerente',
            'attributes' => array(
                'style' => 'width: 800px',
                'id' => 'gerente',
                'required' => true
            ),
            'options' => array(
                'label' => 'Gerente:*',
                'empty_option' => '--- Escolha um gerente ---',
                'object_manager' => $em,
                'target_class' => 'Application\Model\Empregado',
                'property' => 'nome',
                'find_method' => array(
                    'name' => 'getGerentes'
                )
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