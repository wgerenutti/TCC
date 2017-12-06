<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Cargo;
use Application\Form\Cargo as CargoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Cargos
 *
 * @category Application
 * @package Controller
 * @author William Gerenutti <williamgerenuttidm@gmail.com>
 *        
 */
class CargoController extends ActionController {
	
	/**
	 *
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	public function setEntityManager(EntityManager $em) {
		$this->em = $em;
	}
	public function getEntityManager() {
		if (null === $this->em) {
			$this->em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
		}
		return $this->em;
	}
	
	/**
	 * Mostra os cargos cadastrados
	 *
	 * @return void
	 */
	public function indexAction() {
		$cargos = $this->getEntityManager ()->getRepository ( "Application\Model\Cargo" )->findAll ( array (), array (
				'descricao' => 'ASC' 
		) );
		// adiciona o arquivo jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		return new ViewModel ( array (
				'cargos' => $cargos 
		) );
	}
	
	/**
	 * Cria ou edita um Cargo
	 *
	 * @return void
	 */
	public function saveAction() {
		$form = new CargoForm ( $this->getEntityManager () );
		$empregados = array ();
		$request = $this->getRequest ();
		// Hidratar classe
		$form->setHydrator ( new \Zend\Stdlib\Hydrator\ClassMethods ( false ) );
		if ($request->isPost ()) {
			$cargo = new Cargo ();
			$form->setInputFilter ( $cargo->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				$matriculas = $this->params ()->fromPost ( "matricula" );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$cargo = $this->getEntityManager ()->find ( 'Application\Model\Cargo', $data ['id'] );
					$cargo->getMatricula ()->clear ();
				}
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$cargo = $this->getEntityManager ()->find ( 'Application\Model\Cargo', $data ['id'] );
				}
				$cargo->setData ( $data );
				$this->getEntityManager ()->persist ( $cargo );
				foreach ( $matriculas as $matricula ) {
					$empregado = $this->getEntityManager ()->find ( "Application\Model\Empregado", $matricula );
					$cargo->getMatricula ()->add ( $empregado );
				}
				$this->getEntityManager ()->flush ();
				
				return $this->redirect ()->toUrl ( '/application/cargo' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$cargo = $this->getEntityManager ()->find ( 'Application\Model\Cargo', $id );
			$form->bind ( $cargo );
			$empregados = $cargo->getMatricula ();
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/cargo.js' );
		return new ViewModel ( array (
				'form' => $form,
				'empregados' => $empregados 
		) );
	}
	
	/**
	 * Exclui um Cargo
	 *
	 * @return void
	 */
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \ErrorException ( "Código obrigatório" );
		}
		$Cargo = $this->getEntityManager ()->find ( 'Application\Model\Cargo', $id );
		if ($Cargo) {
			$this->getEntityManager ()->remove ( $Cargo );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/cargo' );
	}
}