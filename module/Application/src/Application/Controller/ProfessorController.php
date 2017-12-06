<?php
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Professor;
use Application\Form\Professor as ProfessorForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Professores
 *
 * @category Application
 * @package Controller
 * @author William Gerenutti <william.alves@colaborador.embrapa.br>
 */
class ProfessorController extends ActionController
{

    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction()
    {
        $professores = $this->getEntityManager()
            ->getRepository("Application\Model\Professor")
            ->findAll(array(), array(
            'nome' => 'ASC'
        ));
        // adiciona os arquivos indexcomum.js e jquery.dataTable.min.js
        // ao head da p�gina
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.dataTables.min.js');
        $renderer->headScript()->appendFile('/js/indexcomum.js');
        return new ViewModel(array(
            'professores' => $professores
        ));
    }

    /**
     * Cria ou edita um Professor
     */
    public function saveAction()
    {
        $form = new ProfessorForm($this->getEntityManager());
        $request = $this->getRequest();
        // Hidratar classe
        $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
        if ($request->isPost()) {
        	$professor = new Professor();
        	$form->setInputFilter($professor->getInputFilter());
        	$form->setData($request->getPost());
        	if ($form->isValid()) {
                $data = $form->getData();
                $telefone = preg_replace('/[^0-9]/', '', $this->params()->fromPost("telefone"));
                unset($data['submit']);
                unset($data['telefone']);
                if (isset($data['id']) && $data['id'] > 0) {
                    $professor = $this->getEntityManager()->find('Application\Model\Professor', $data['id']);
                }
                $professor->setData($data);
                $professor->setTelefone($telefone);
                $this->getEntityManager()->persist($professor);
                $this->getEntityManager()->flush();
                return $this->redirect()->toUrl('/application/professor');
            }
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $professor = $this->getEntityManager()->find('Application\Model\Professor', $id);
            $form->bind($professor);
            $form->get('submit')->setAttribute('value', 'Edit');
        }
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.mask.js');
        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * Exclui um Professor
     *
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id == 0) {
            throw new \ErrorException("C�digo obrigat�rio");
        }
        $professor = $this->getEntityManager()->find('Application\Model\Professor', $id);
        if ($professor) {
            $this->getEntityManager()->remove($professor);
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toUrl('/application/professor');
    }
}