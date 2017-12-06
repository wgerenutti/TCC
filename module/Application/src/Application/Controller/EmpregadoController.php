<?php
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Empregado;
use Application\Form\Empregado as EmpregadoForm;
use Doctrine\ORM\EntityManager;

/**
 * Controlador que gerencia os empregados
 *
 * @category Application
 * @package Controller
 * @author William Gerenutti <williamgerenuttidm@gmail.com>
 *        
 */
class EmpregadoController extends ActionController
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

    public function buscaempregadosAction() {
    	$request = $this->getRequest ();
    	$response = $this->getResponse ();
    	$response->setContent ( \Zend\Json\Json::encode ( array (
    			'dataType' => 'json',
    			'response' => false
    	) ) );
    	if ($request->isPost ()) {
    		$qb = $this->getEntityManager ()->createQueryBuilder ();
    		$qb->select ( 'e' )->from ( 'Application\Model\Empregado', 'e' )->orderby ( 'e.nome' );
    		$empregados = $qb->getQuery ()->getResult ();
    		$stringEmpregados = '[';
    		foreach ( $empregados as $key => $empregado ) { 
    			$stringEmpregados .= '{"matricula": "' . $empregado->getMatricula () . '", "nome": "' . $empregado->getNome () .'"}';
    			if (isset ( $empregados [$key + 1] )) {
    				$stringEmpregados .= ',';
    			}
    		}
    		$stringEmpregados .= ']';
    		$response->setContent ( \Zend\Json\Json::encode ( array (
    				'dataType' => 'json',
    				'response' => true,
    				'empregados' => $stringEmpregados
    		) ) );
    	}
    	return $response;
    }

    public function indexAction()
    {
        $empregados = $this->getEntityManager()
            ->getRepository("Application\Model\Empregado")
            ->findAll(array(), array(
            'nome' => 'ASC'
        ));
        
        // adiciona o arquivo jquery.dataTable.min.js
        // ao head da p�gina
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.dataTables.min.js');
        return new ViewModel(array(
            'empregados' => $empregados
        ));
    }

    /**
     * Cria ou edita um Empregado
     *
     * @return void
     */
    public function saveAction()
    {
        $form = new EmpregadoForm($this->getEntityManager());
        $request = $this->getRequest();
        $empregado = new Empregado();
        $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods(false));
        if ($request->isPost()) {
            $form->setInputFilter($empregado->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $admissao = new \DateTime($this->params()->fromPost("admissao"));
                $salario = $this->params()->fromPost('salario');
                $telefone = preg_replace("/[^0-9]/", "", $this->params()->fromPost('telefone'));
                $cpf = preg_replace('/[^0-9]/', '', $this->params()->fromPost("cpf"));
                $cargoId = $this->params ()->fromPost ( 'cargo' );
                $cargo = $this->getEntityManager ()->find ( 'Application\Model\Cargo', $cargoId );
                unset($data['submit']);
                unset($data['admissao']);
                unset($data['salario']);
                unset($data['telefone']);
                unset($data['cargo']);
                unset($data['cpf']);
                if (isset($data['matricula']) && $data['matricula'] > 0) {
                    $empregado = $this->getEntityManager()->find('Application\Model\empregado', $data['matricula']);
                }
                $salario = preg_replace('/R\$/', '', $salario);
                $salario = \Application\Model\Util::converteDecimal($salario);
                $empregado->setData($data);
                $empregado->setAdmissao($admissao);
                $empregado->setTelefone($telefone);
                $empregado->setSalario($salario);
                $empregado->setCpf($cpf);
                $empregado->setCargo($cargo);
                $this->getEntityManager()->persist($empregado);
                $this->getEntityManager()->flush();
                
                return $this->redirect()->toUrl('/application/empregado');
            }
        }
        $matricula = (int) $this->params()->fromRoute('matricula', 0);
        if ($matricula > 0) {
            $empregado = $this->getEntityManager()->find('Application\Model\Empregado', $matricula);
            $form->bind($empregado);
            $form->get('gerente')->setAttribute('value', $empregado->getGerente());
            $form->get('admissao')->setAttribute('value', $empregado->getAdmissao());
            $form->get('submit')->setAttribute('value', 'Edit');
        }
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.mask.js');
        $renderer->headScript()->appendFile('/js/jquery.priceformat.min.js');
        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * Exclui um Empregado
     *
     * @return void
     */
    public function deleteAction()
    {
        $matricula = (int) $this->params()->fromRoute('matricula', 0);
        if ($matricula == 0) {
            throw new \ErrorException("C�digo obrigat�rio");
        }
        $empregado = $this->getEntityManager()->find('Application\Model\Empregado', $matricula);
        if ($empregado) {
            $this->getEntityManager()->remove($empregado);
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toUrl('/application/empregado');
    }
}
?>