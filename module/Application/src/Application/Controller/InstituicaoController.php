<?php
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Instituicao;
use Application\Form\Instituicao as InstituicaoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia o cadastro de Instrutores
 *
 * @category Application
 * @package Controller
 * @author William Gerenutti <williamgerenuttidm@gmail.com>
 */
class InstituicaoController extends ActionController
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
        $instituicoes = $this->getEntityManager()
            ->getRepository("Application\Model\Instituicao")
            ->findAll(array(), array(
            'razao' => 'ASC'
        ));
        
        // adiciona o arquivo jquery.dataTable.min.js
        // ao head da p�gina
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.dataTables.min.js');
        return new ViewModel(array(
            'instituicoes' => $instituicoes
        ));
    }

    /**
     * Cria ou edita uma Instituicao
     *
     * @return void
     */
    public function saveAction()
    {
        $form = new InstituicaoForm($this->getEntityManager());
        $request = $this->getRequest();
        // Hidratar classe
        $instituicao = new Instituicao();
        $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
        if ($request->isPost()) {
            $form->setInputFilter ( $instituicao->getInputFilter () );
            $form->setData ( $request->getPost () );
            if ($form->isValid ()) {
                $data = $form->getData();
                $cnpj = preg_replace('/[^0-9]/', '', $this->params()->fromPost("cnpj"));
                $telefone = preg_replace("/[^0-9]/", "", $this->params()->fromPost('telefone'));
                $cep = preg_replace('/[^0-9]/', '', $this->params()->fromPost("cep"));
                unset($data['cnpj']);
                unset($data['cep']);
                unset($data['telefone']);
                unset($data['submit']);
                if (isset($data['id']) && $data['id'] > 0) {
                    $instituicao = $this->getEntityManager()->find('Application\Model\instituicao', $data['id']);
                }
                $instituicao->setData($data);
                $instituicao->setCnpj($cnpj);
                $instituicao->setCep($cep);
                $instituicao->setTelefone($telefone);
                $this->getEntityManager()->persist($instituicao);
                $this->getEntityManager()->flush();
                return $this->redirect()->toUrl('/application/instituicao');
            }
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $instituicao = $this->getEntityManager()->find('Application\Model\Instituicao', $id);
            $form->bind($instituicao);
            $form->get('telefone')->setAttribute('value', $instituicao->getTelefone());
            $form->get('submit')->setAttribute('value', 'Edit');
        }
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.mask.js');
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id == 0) {
            throw new \ErrorException("C�digo obrigat�rio");
        }
        $instituicao = $this->getEntityManager()->find('Application\Model\Instituicao', $id);
        if ($instituicao) {
            $this->getEntityManager()->remove($instituicao);
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toUrl('/application/instituicao');
    }
}