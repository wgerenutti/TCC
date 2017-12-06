<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class Cargo extends Form
{

    public function __construct()
    {
        parent::__construct('Cargo');
        $this->setHydrator(new ClassMethods());
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/application/cargo/save');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'id'
            )
        ));
        
        $this->add(array(
            'name' => 'descricao',
            'attributes' => array(
                'required' => true,
                'style' => 'width:800px',
                'type' => 'text',
                'id' => 'descricao'
            ),
            'options' => array(
                'label' => 'Descricao:*'
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