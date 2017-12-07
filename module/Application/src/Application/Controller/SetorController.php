<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Setor;
use Application\Form\Setor as SetorForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Setores
 *
 * @category Application
 * @package Controller
 * @author William Gerenutti <williamgerenuttidm@gmail.com>
 *        
 */
class SetorController extends ActionController {
	
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
	 * Mostra os Setores cadastrados
	 *
	 * @return void
	 */
	public function indexAction() {
		$setores = $this->getEntityManager ()->getRepository ( "Application\Model\Setor" )->findAll ( array (), array (
				'nome' => 'ASC' 
		) );
		// adiciona o arquivo jquery.dataTable.min.js
		// ao head da p�gina
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		return new ViewModel ( array (
				'setores' => $setores 
		) );
	}
	
	/**
	 * Cria ou edita um Setor
	 *
	 * @return void
	 */
	public function saveAction() {
		$form = new SetorForm ( $this->getEntityManager () );
		$request = $this->getRequest ();
		// Hidratar classe
		$form->setHydrator ( new \Zend\Stdlib\Hydrator\ClassMethods ( false ) );
		if ($request->isPost ()) {
			$setor = new Setor ();
			$form->setInputFilter ( $setor->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				$matricula = $this->params ()->fromPost ( "gerente" );
				$participantes = $this->params ()->fromPost ( 'participantes' );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$setor = $this->getEntityManager ()->find ( 'Application\Model\Setor', $data ['id'] );
				}
				$setor->getParticipantes ()->clear ();
				foreach ( $participantes as $participanteId ) {
					$participante = $this->getEntityManager ()->find ( "Application\Model\Empregado", $participanteId );
					$setor->getParticipantes ()->add ( $participante );
				}
				$gerente = $this->getEntityManager ()->find ( 'Application\Model\Empregado', $matricula );
				unset ( $data ['gerente'] );
				$setor->setData ( $data );
				$setor->setGerente ( $gerente );
				$this->getEntityManager ()->persist ( $setor );
				$this->getEntityManager ()->flush ();
				
				return $this->redirect ()->toUrl ( '/application/setor' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$setor = $this->getEntityManager ()->find ( 'Application\Model\Setor', $id );
			$form->bind ( $setor );
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
			$empregados = $setor->getParticipantes();
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/setor.js' );
		return new ViewModel ( array (
				'form' => $form,
				'empregados' => $empregados 
		) );
	}
	
	/**
	 * Exclui um Setor
	 *
	 * @return void
	 */
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \ErrorException ( "C�digo obrigat�rio" );
		}
		$setor = $this->getEntityManager ()->find ( 'Application\Model\Setor', $id );
		if ($setor) {
			$this->getEntityManager ()->remove ( $setor );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/setor' );
	}
}