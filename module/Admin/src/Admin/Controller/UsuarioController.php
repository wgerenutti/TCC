<?php
namespace Admin\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Admin\Model\Usuario;
use Admin\Form\Usuario as UserForm;

use Doctrine\ORM\EntityManager;
 
/**
* Controlador que gerencia os posts
*
* @category Admin
* @package Controller
* @author Elton Minetto <eminetto@coderockr.com>
*/
class UsuarioController extends ActionController
{
 
	/**
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
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}
		return $this->em;
	}
	
	/**
	* Mostra os usuário cadastrados
	* @return void
	*/
	public function indexAction()
	{
		$users = $this->getEntityManager()
			->getRepository('Admin\Model\Usuario')
			->findAll();
        
        // adiciona os arquivos indexcomum.js e jquery.dataTables.min.js
        // ao head da página
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/jquery.dataTables.min.js');
        $renderer->headScript()->appendFile('/js/indexcomum.js');
        
		return new ViewModel(array(
			'users' => $users
		));
	}
	
	/**
	 * Busca os usuários cadastrados no sistema e retorna o html de um select box
	 * 
	 */
	public function buscausuariosAction()
	{
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
			
			$session = $this->getServiceLocator()->get('Zend\ServiceManager\ServiceManager')->get('Session');
			$usuario_id = $session->offsetGet('user')->id;
			$usuario = $this->getEntityManager()->find('Admin\Model\Usuario', $usuario_id);
			$users = [];
			$options = "";
			$filtro = false;
			if($usuario->getFuncao() == "cliente") {
				array_push($users, $usuario);
				$filtro = true;
			} else {
				$qb = $this->getEntityManager()->createQueryBuilder();
				$qb->select('u')
				   ->from('Admin\Model\Usuario', 'u')
				   ->orderBy('u.nome');
				$users = $qb->getQuery()->getResult();
				$options = "<option value=''>Todos</option>";
			}
			foreach ($users as $user) {
				if ($user->getFuncao() == "cliente" || $user->getFuncao() == 'admin' ) {
					$options .= "<option value='".$user->id."'>".$user->nome."</option>";
				} 
			}
			$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 
														        'response' => true,
																'filtro' => $filtro,
																'options' => $options)));
		}
		return $response;
	}
	
	/**
	* Cria ou edita um user
	* @return void
	*/
	public function saveAction()
	{
		$form = new UserForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$usuario = new Usuario;
			$form->setInputFilter($usuario->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				$data['valido'] = 1;
                $usaldap = ($data['usaldap'] == '') ? 0 : 1;
                $recebenotificacao = ($data['recebenotificacao'] == '') ? 0 : 1;
                $senha = $data['senha'];
				unset($data['submit']);
                unset($data['senha']);
				unset($data['usaldap']);
                unset($data['recebenotificacao']);
                                
				if (isset($data['id']) && $data['id'] > 0) {
					$usuario = $this->getEntityManager()->find('Admin\Model\Usuario', $data['id']);
				}
                if ($usaldap == 1) {
                    $usuario->senha = '';
                }
                elseif ($usuario->senha != $senha) {
                    $usuario->senha = md5($senha);
                }
                $usuario->usaldap = $usaldap;
                $usuario->recebenotificacao = $recebenotificacao;
                $usuario->setData($data);

                $this->getEntityManager()->persist($usuario);
				$this->getEntityManager()->flush();
				
				return $this->redirect()->toUrl('/admin/usuario');
			}
            else {
                //exibe o erro quando o formulário não é válido
                echo $form->getMessages();
            }
		}
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id > 0) {
			$usuario = $this->getEntityManager()->find('Admin\Model\Usuario', $id);
			$form->bind($usuario);
            $form->get('usaldap')->setAttribute('value', $usuario->usaldap);
            $form->get('recebenotificacao')->setAttribute('value', $usuario->recebenotificacao);
			$form->get('submit')->setAttribute('value', 'Edit');
		}
                
        //adiciona arquivo usuario.js ao head da página
        $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        $renderer->headScript()->appendFile('/js/usuario.js');

		return new ViewModel(
			array('form' => $form)
		);
	}
	/**
	* Exclui um user
	* @return void
	*/
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if ($id == 0) {
			throw new \exception("Código obrigatório");
		}
		$usuario = $this->getEntityManager()->find('Admin\Model\Usuario', $id);
		if ($usuario) {
			$this->getEntityManager()->remove($usuario);
			$this->getEntityManager()->flush();
		}
		return $this->redirect()->toUrl('/admin/usuario');
	}
    
}