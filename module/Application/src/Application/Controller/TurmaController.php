<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Turma;
use Application\Form\Turma as TurmaForm;
use Doctrine\ORM\EntityManager;
use Application\Model\Programacao;

/**
 * Controlador que gerencia o cadastro de Turmas
 *
 * @category Application
 * @package Controller
 * @author William Gerenutti <williamgerenuttidm@gmail.com>
 */
class TurmaController extends ActionController {
	
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
	 * Mostra as turmas cadastradas
	 *
	 * @return void
	 */
	public function indexAction() {
		$turmas = $this->getEntityManager ()->getRepository ( "Application\Model\Turma" )->findAll ( array (), array (
				'inicial' => 'ASC' 
		) );
		
		// adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
		// ao head da página
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/indexcomum.js' );
		return new ViewModel ( array (
				'turmas' => $turmas 
		) );
	}
	public function saveAction() {
		$form = new TurmaForm ( $this->getEntityManager () );
		$request = $this->getRequest ();
		// Hidratar classe
		$turma = new Turma ();
		$form->setHydrator ( new \Zend\Stdlib\Hydrator\ClassMethods ( false ) );
		if ($request->isPost ()) {
			$form->setInputFilter ( $turma->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				$cursoId = $this->params ()->fromPost ( 'curso' );
				$curso = $this->getEntityManager ()->find ( 'Application\Model\Curso', $cursoId );
				$dataRealizacao = $this->params ()->fromPost ( 'dataRealizacao' );
				$horaInicial = $this->params ()->fromPost ( 'horaInicial' );
				$horaFinal = $this->params ()->fromPost ( 'horaFinal' );
				$valor = $this->params ()->fromPost ( 'valor' );
				$local = $this->params ()->fromPost ( 'local' );
				$idProgramacao = $this->params ()->fromPost ( 'idProgramacao' );
				$codigo = $this->params ()->fromPost ( 'instituicao' );
				$instituicao = $this->getEntityManager ()->find ( 'Application\Model\Instituicao', $codigo );
				$professores = $this->params ()->fromPost ( 'professores' );
				$participantes = $this->params ()->fromPost ( 'matricula' );
				if (isset ( $data ['id'] ) && $data ['id'] > 0) {
					$turma = $this->getEntityManager ()->find ( 'Application\Model\Turma', $data ['id'] );
				}
				$valor = preg_replace ( '/R\$/', '', $valor );
				$valor = \Application\Model\Util::converteDecimal ( $valor );
				$turma->getParticipantes ()->clear ();
				foreach ( $participantes as $participanteId ) {
					$participante = $this->getEntityManager ()->find ( "Application\Model\Empregado", $participanteId );
					$turma->getParticipantes ()->add ( $participante );
				}
				$turma->getProfessores ()->clear ();
				foreach ( $professores as $professorId ) {
					$professor = $this->getEntityManager ()->find ( "Application\Model\Professor", $professorId );
					$turma->getProfessores ()->add ( $professor );
				}
				unset ( $data ["professoreses"] );
				unset ( $data ["matricula"] );
				unset ( $data ["valor"] );
				unset ( $data ["curso"] );
				unset ( $data ["horaInicial"] );
				unset ( $data ["professor"] );
				unset ( $data ["dataFinal"] );
				unset ( $data ["instituicao"] );
				unset ( $data ["submit"] );
				$turma->setData ( $data );
				$turma->setInstituicao ( $instituicao );
				$turma->setValor ( $valor );
				$turma->setCurso ( $curso );
				$this->getEntityManager ()->persist ( $turma );
				$programacoesAux = array ();
				foreach ( $horaInicial as $i => $hI ) {
					$programacao = new Programacao ();
					if ((isset ( $idProgramacao [$i] )) && (null != $idProgramacao [$i])) {
						$programacao = $this->getEntityManager ()->find ( "Application\Model\Programacao", $idProgramacao [$i] );
					}
					$programacao->setHoraInicial ( $hI );
					$programacao->setHoraFinal ( $horaFinal [$i] );
					$programacao->setLocal ( $local [$i] );
					$realizacao = new \DateTime ( $dataRealizacao [$i] );
					$programacao->setDataRealizacao ( $realizacao );
					$programacao->setTurma ( $turma );
					$this->getEntityManager ()->persist ( $programacao );
					$this->getEntityManager ()->flush ();
					$turma->getProgramacao ()->add ( $programacao );
					array_push ( $programacoesAux, $programacao );
				}
				foreach ( $turma->getProgramacao () as $prog ) {
					if (! in_array ( $prog, $programacoesAux )) {
						$this->getEntityManager ()->remove ( $prog );
					}
				}
				$this->getEntityManager ()->flush ();
				$this->getEntityManager ()->persist ( $turma );
				$this->getEntityManager ()->flush ();
				return $this->redirect ()->toUrl ( '/application/turma' );
			}
		}
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id > 0) {
			$turma = $this->getEntityManager ()->find ( 'Application\Model\Turma', $id );
			$professores = $turma->getProfessores ();
			$form->get ( 'professores[0]' )->setAttribute ( 'value', $professores [0]->getId () );
			for($i = 1; $i < $professores->count (); $i ++) {
				$form->add ( array (
						'type' => 'DoctrineModule\Form\Element\ObjectSelect',
						'name' => 'professores[' . $i . ']',
						'attributes' => array (
								'style' => 'width: 800px',
								'id' => 'professor_' . $i,
								'required' => false 
						),
						'options' => array (
								'label' => 'Professor(es):',
								'empty_option' => '--- Escolha um Professor ---',
								'object_manager' => $this->getEntityManager(),
								'target_class' => 'Application\Model\Professor',
								'property' => 'nome' 
						) 
				) );
				
				$form->get ( 'professores[' . $i . ']' )->setAttribute ( 'value', $professores [$i]->getId () );
			}
			$form->bind ( $turma );
		}
		$renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
		$renderer->headScript ()->appendFile ( '/js/jquery.dataTables.min.js' );
		$renderer->headScript ()->appendFile ( '/js/turma.js' );
		$renderer->headScript ()->appendFile ( '/js/jquery.mask.js' );
		$renderer->headScript ()->appendFile ( '/js/jquery.priceformat.min.js' );
		return new ViewModel ( array (
				'form' => $form,
				'turma' => $turma 
		) );
	}
	
	/**
	 * Exclui uma Turma
	 *
	 * @return void
	 */
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			throw new \ErrorException ( "Código obrigatório" );
		}
		$turma = $this->getEntityManager ()->find ( 'Application\Model\Turma', $id );
		if ($turma) {
			$turma->getParticipantes ()->clear ();
			foreach ( $turma->getProgramacao () as $programacao ) {
				$this->getEntityManager ()->remove ( $programacao );
				$this->getEntityManager ()->flush ();
			}
			$turma->getProgramacao ()->clear ();
			$this->getEntityManager ()->remove ( $turma );
			$this->getEntityManager ()->flush ();
		}
		return $this->redirect ()->toUrl ( '/application/turma' );
	}
}