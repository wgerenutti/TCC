<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class Conhecimento extends Form
{

    public function __construct($em)
    {
        parent::__construct('Conhecimento');
        $this->setHydrator(new ClassMethods());
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/application/conhecimento/save');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden'
            )
        ));
        $this->add(array(
            'name' => 'titulo',
            'attributes' => array(
                'style' => 'width:800px',
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Conhecimento:'
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