<?php
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Curso;
use Application\Form\Curso as CursoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Cursos
 *
 * @category Application
 * @package Controller
 * @author William Gerenutti <williamgerenuttidm@gmail.com>
 *        
 */
class CursoController extends ActionController
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

    /**
     * Mostra os Cursos cadastrados
     *
     * @return void
     */
    public function indexAction()
    {
        $cursos = $this->getEntityManager()
            ->getRepository("Application\Model\Curso")
            ->findAll(array(), array(
            'descricao' => 'ASC'
        ));
        // adiciona o arquivo jquery.dataTable.min.js
        // ao head da p�gina
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.dataTables.min.js');
        return new ViewModel(array(
            'cursos' => $cursos
        ));
    }

    /**
     * Cria ou edita um Curso
     *
     * @return void
     */
    public function saveAction()
    {
        $form = new CursoForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $curso = new Curso();
            $form->setInputFilter($curso->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                if (isset($data['id']) && $data['id'] > 0) {
                    $curso = $this->getEntityManager()->find('Application\Model\Curso', $data['id']);
                }
                $curso->setData($data);
                $this->getEntityManager()->persist($curso);
                $this->getEntityManager()->flush();
                
                return $this->redirect()->toUrl('/application/curso');
            }
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $curso = $this->getEntityManager()->find('Application\Model\Curso', $id);
            $form->bind($curso);
            $form->get('cargaHoraria')->setAttribute('value', $curso->getCargaHoraria());
            $form->get('cursoTipo')->setAttribute('value', $curso->getCursoTipo());
            $form->get('submit')->setAttribute('value', 'Edit');
        }
        $renderer = $this->getServiceLocator ()->get ( 'Zend\View\Renderer\PhpRenderer' );
        $renderer->headScript ()->appendFile ( '/js/jquery.mask.js' );
        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * Exclui um Curso
     *
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id == 0) {
            throw new \ErrorException("C�digo obrigat�rio");
        }
        $curso = $this->getEntityManager()->find('Application\Model\Curso', $id);
        if ($curso) {
            $this->getEntityManager()->remove($curso);
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toUrl('/application/curso');
    }
}