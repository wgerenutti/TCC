<?php
namespace Application\Form;

use Zend\Form\Form;
use Application\Validator\Cnpj;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;

class Instituicao extends Form implements InputFilterProviderInterface
{

    public function __construct()
    {
        parent::__construct('Instituicao');
        $this->setHydrator ( new ClassMethods () );
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/application/instituicao/save');
        $this->add(array(
            
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'id'
            )
        ));
        $this->add(array(
            'name' => 'cnpj',
            'attributes' => array(
                'type' => 'text',
                'style' => 'width:800px',
                'required' => true,
                'id' => 'cnpj'
            ),
            'options' => array(
                'label' => 'CNPJ:*'
            )
        ));
        $this->add(array(
            'name' => 'razaoSocial',
            'attributes' => array(
                'type' => 'text',
                'style' => 'width:800px',
                'required' => true,
                'id' => 'razaoSocial'
            ),
            'options' => array(
                'label' => 'Razão Social:*'
            )
        ));
        $this->add(array(
            'name' => 'endereco',
            'attributes' => array(
                'type' => 'text',
                'style' => 'width:800px',
                'required' => true,
                'id' => 'endereco'
            ),
            'options' => array(
                'label' => 'Endereço:*'
            )
        ));
        $this->add(array(
            'name' => 'cep',
            'attributes' => array(
                'type' => 'text',
                'style' => 'width:800px',
                'required' => true,
                'id' => 'cep'
            ),
            'options' => array(
                'label' => 'CEP:*'
            )
        ));
        $this->add(array(
            'name' => 'bairro',
            'attributes' => array(
                'type' => 'text',
                'style' => 'width:800px',
                'required' => true,
                'id' => 'bairro'
            ),
            'options' => array(
                'label' => 'Bairro:*'
            )
        ));
        $this->add(array(
            'name' => 'telefone',
            'attributes' => array(
                'type' => 'text',
                'style' => 'width:800px',
                'required' => true,
                'id' => 'telefone'
            ),
            'options' => array(
                'label' => 'Telefone:*'
            )
        ));
        $this->add(array(
            'name' => 'localizacao',
            'attributes' => array(
                'type' => 'text',
                'style' => 'width:800px',
                'required' => true,
                'id' => 'localizacao'
            ),
            'options' => array(
                'label' => 'Cidade - UF:*'
            )
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'style' => 'width:800px',
                'required' => false,
                'type' => 'Zend\Form\Element\Email',
                'id' => 'email'
            ),
            'options' => array(
                'label' => 'Email:'
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

    public function getInputFilterSpecification()
    {
        return array(
            array(
                'name' => 'cnpj',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Application\Validator\Cnpj'
                    )
                )
            )
        );
    }
}