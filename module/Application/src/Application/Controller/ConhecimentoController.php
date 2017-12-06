<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Conhecimento;
use Application\Form\Conhecimento as ConhecimentoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Conhecimentos
 *
 * @category Application
 * @package Controller
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class ConhecimentoController extends ActionController {
	
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
	 * Mostra os Conhecimentos cadastrados
	 *
	 * @return void
	 */
	public function indexAction() {
		$conhecimentos = $this->getEntityManager ()->getRepository ( "Application\Model\Conhecimento" )->findAll ( array (), array (
				'titulo' => 'ASC' 
		) );
		
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'conhecimentos' => $conhecimentos 
		) );
	}
	public function buscaconhecimentoAction() {
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		$response->setContent ( \Zend\Json\Json::encode ( array (
				'dataType' => 'json',
				'response' => false 
		) ) );
		if ($request->isPost ()) {
			$conhecimentos = $this->getEntityManager ()->getRepository ( "Application\Model\Conhecimento" )->findAll ( array (), array (
					'titulo' => 'ASC' 
			) );
			$stringConhecimentos = '[';
			foreach ( $conhecimentos as $key => $conhecimento ) {
				$stringConhecimentos .= '{"id": "' . $conheimento->getId () . '", "titulo": "' . $conhecimento->getTitulo () . '"}';
				if (isset ( $conhecimentos [$key + 1] )) {
					$stringConhecimentos .= ',';
				}
			}
			$stringConhecimentos .= ']';
			$response->setContent ( \Zend\Json\Json::encode ( array (
					'dataType' => 'json',
					'response' => true,
					'conhecimentos' => $stringConhecimentos 
			) ) );
		}
		
		return $response;
	}
	public function saveAction() {
		$form = new ConhecimentoForm ( $this->getEntityManager () );
		$empregados = array ();
		$request = $this->getRequest ();
		// Hidratar classe
		$form->setHydrator ( new \Zend\Stdlib\Hydrator\ClassMethods ( false ) );
		if ($request->isPost ()) {
			$conhecimento = new Conhecimento ();
			$form->setInputFilter ( $conhecimento->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				unset ( $data ['submit'] );
				$matriculas = $this->params ()->fromPost ( "matricula" );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$conhecimento = $this->getEntityManager ()->find ( 'Application\Model\Conhecimento', $data ['id'] );
					$conhecimento->getMatricula ()->clear ();
				}
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$conhecimento = $this->getEntityManager ()->find ( 'Application\Model\Conhecimento', $data ['id'] );
				}
				$conhecimento->setData ( $data );
				$this->getEntityManager ()->persist ( $conhecimento );
				foreach ( $matriculas as $matricula ) {
					$empregado = $this->getEntityManager ()->find ( "Application\Model\Empregado", $matricula );
					$conhecimento->getMatricula ()->add ( $empregado );
				}
				$this->getEntityManager ()->flush ();
				
				return $this->redirect ()->toUrl ( '/application/conhecimento' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$conhecimento = $this->getEntityManager ()->find ( 'Application\Model\Conhecimento', $id );
			$form->bind ( $conhecimento );
			$empregados = $conhecimento->getMatricula ();
			$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/conhecimento.js' );
		return new ViewModel ( array (
				'form' => $form,
				'empregados' => $empregados 
		) );
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \ErrorException ( "Código obrigatório" );
		}
		$conhecimento = $this->getEntityManager ()->find ( 'Application\Model\Conhecimento', $id );
		if ($conhecimento) {
			$this->getEntityManager ()->remove ( $conhecimento );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/conhecimento' );
	}
}