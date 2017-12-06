<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class Curso extends Form
{

    public function __construct()
    {
        parent::__construct('Curso');
        $this->setHydrator(new ClassMethods());
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/application/curso/save');
        
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
                'label' => 'Descrição:*'
            )
        ));
        
        $this->add(array(
            'name' => 'cargaHoraria',
            'attributes' => array(
                'required' => true,
                'style' => 'width:800px',
                'type' => 'text',
                'id' => 'cargaHoraria'
            ),
            'options' => array(
                'label' => 'Carga Horária:*'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'cursoTipo',
            'required' => true,
            'id' => 'cursoTipo',
            'options' => array(
                'label' => 'Tipo de curso:*',
                'empty_option' => '-- Selecione uma opção --',
                'value_options' => array(
                    'Técnico' => 'Técnico',
                    'Graduação' => 'Graduação',
                    'Pós-gradua��o' => 'Pós-graduação',
                    'Mestrado' => 'Mestrado',
                    'Doutorado' => 'Doutorado'
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