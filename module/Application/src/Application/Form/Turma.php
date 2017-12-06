<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Turma extends Form
{

    public function __construct($em)
    {
        parent::__construct('Turma');
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/application/turma/save');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden'
            )
        ));
        
        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'style' => 'width:780px',
                'type' => 'text',
                'required' => true
            ),
            'options' => array(
                'label' => 'Nome da turma:*'
            )
        ));
        
        $this->add(array(
            'name' => 'aplicacao',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'aplicacao',
                'style' => 'width:800px',
                'required' => false,
                'options' => array(
                    'empty_option' => '--- Seleciona uma aplicação ---',
                    '1' => 'Á Distância',
                    '2' => 'Presencial',
                    '3' => 'Semi Presencial'
                
                )
            ),
            'options' => array(
                'label' => 'Aplicação:'
            )
        ));
        
        $this->add(array(
            'name' => 'inicial',
            'attributes' => array(
                'style' => 'width:100px',
                'type' => 'text',
                'id' => 'inicial',
                'required' => true
            ),
            'options' => array(
                'label' => 'Data Inicial:*'
            )
        ));
        
        $this->add(array(
            'name' => 'final',
            'attributes' => array(
                'style' => 'width:100px',
                'type' => 'text',
                'id' => 'final',
                'required' => true
            ),
            'options' => array(
                'label' => 'Data Final:*'
            )
        ));
        
        $this->add(array(
            'name' => 'valor',
            'attributes' => array(
                'style' => 'width:780px',
                'type' => 'text',
                'required' => false,
                'id' => 'valor'
            ),
            'options' => array(
                'label' => 'Valor total:'
            )
        ));
        
        $this->add(array(
            'name' => 'curso',
            
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'style' => 'width:800px',
                'required' => true,
                'id' => 'capacitacao'
            ),
            'options' => array(
                'label' => 'Curso:*',
                'empty_option' => '--- Escolha um Curso ---',
                'object_manager' => $em,
                'target_class' => 'Application\Model\Curso',
                'property' => 'descricao'
            )
        ));
        
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'instituicao',
            'attributes' => array(
                'style' => 'width: 800px',
                'id' => 'instituicao',
                'required' => true
            ),
            'options' => array(
                'label' => 'Instituição:*',
                'empty_option' => '--- Escolha uma instituição ---',
                'object_manager' => $em,
                'target_class' => 'Application\Model\Instituicao',
                'property' => 'razaoSocial'
            )
        ));
        
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'professores[0]',
            'attributes' => array(
                'style' => 'width: 800px',
                'id' => 'professor_0',
                'required' => false
            ),
            'options' => array(
                'label' => 'Professor(es):',
                'empty_option' => '--- Escolha um Professor ---',
                'object_manager' => $em,
                'target_class' => 'Application\Model\Professor',
                'property' => 'nome'
            )
        ));
        
        $this->add(array(
            'name' => 'dataRealizacao',
            'attributes' => array(
                'id' => 'dataRealizacao',
                'style' => 'width:210px',
                'type' => 'text',
                'required' => true
            ),
            'options' => array(
                'label' => 'Data de realiza��o:*'
            )
        ));
        
        $this->add(array(
            'name' => 'horaInicial',
            'attributes' => array(
                'id' => 'horaInicial',
                'style' => 'width:250px',
                'type' => 'text',
                'required' => true
            ),
            'options' => array(
                'label' => 'Horario de inicio:*'
            )
        ));
        
        $this->add(array(
            'name' => 'horaFinal',
            'attributes' => array(
                'id' => 'horaFinal',
                'style' => 'width:250px',
                'type' => 'text',
                'required' => true
            ),
            'options' => array(
                'label' => 'Horario final:*'
            )
        ));
        
        $this->add(array(
            'name' => 'local',
            'attributes' => array(
                'id' => 'local',
                'style' => 'width:550px',
                'type' => 'text',
                'required' => true
            ),
            'options' => array(
                'label' => 'Local de realiza��o:*'
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