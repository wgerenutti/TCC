<?php

namespace Admin\Service;

use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapterDbTable;

/**
 * Serviço responsável pela autenticação dos usuários na aplicação
 *
 * @category Admin
 * @package Service
 * @author William Gerenutti <williamgerenuttidm@gmail.com>
 */
class Auth extends Service {
	
	/**
	 * Adapter usado para a autenticação
	 * 
	 * @var Zend\Db\Adapter\Adapter
	 */
	private $dbAdapter;
	
	/**
	 * Construtor da classe
	 *
	 * @return void
	 */
	public function __construct($dbAdapter = null) {
		$this->dbAdapter = $dbAdapter;
	}
	
	/**
	 * Faz a autenticação dos usuários
	 *
	 * @param array $params        	
	 * @return array
	 */
	public function authenticate($params) {
		if (! isset ( $params ['nome'] ) || ! isset ( $params ['senha'] )) {
			throw new \exception ( "Parâmetros inválidos" );
		}
		$nome = $params ['nome'];
		$senha = $params ['senha'];
		
		$auth = new AuthenticationService ();
		
		// Realiza a autenticação através da tabela usuarios
		$authAdapter = new AuthAdapterDbTable ( $this->dbAdapter );
		$authAdapter->setTableName ( 'usuario' )->setIdentityColumn ( 'login' )->setCredentialColumn ( 'senha' )->setIdentity ( $nome )->setCredential ( ( $senha ) );
		
		$result = $auth->authenticate ( $authAdapter );
		
		if (! $result->isValid ()) {
			//return 'Login ou senha inválidos';
			throw new \exception("Login ou senha inválidos");
		}
		
		// salva o usuario na sessão
		$session = $this->getServiceManager ()->get ( 'Session' );
		$session->offsetSet ( 'user', $authAdapter->getResultRowObject() );
		return true;
	}
	
	/**
	 * Faz a autorização do usuário para acessar o recurso
	 * 
	 * @param string $moduleName
	 *        	Nome do módulo sendo acessado
	 * @param string $controllerName
	 *        	Nome do controller
	 * @param string $actionName
	 *        	Nome da ação
	 * @return boolean
	 */
	public function authorize($moduleName, $controllerName, $actionName) {
		$auth = new AuthenticationService ();
		$role = 'comum';
		if ($auth->hasIdentity ()) {
			$session = $this->getServiceManager ()->get ( 'Session' );
			$user = $session->offsetGet ( 'user' );
			$role = $user->autorizacao;
		}
		$resource = $controllerName . '.' . $actionName;
		$acl = $this->getServiceManager ()->get ( 'Core\Acl\Builder' )->build ();
		if ($acl->isAllowed ( $role, $resource )) {
			return true;
		}
		return false;
	}
	
	/**
	 * Faz o logout do sistema
	 *
	 * @return void
	 */
	public function logout() {
		$auth = new AuthenticationService ();
		$session = $this->getServiceManager ()->get ( 'Session' );
		$session->offsetUnset ( 'user' );
		$auth->clearIdentity ();
		return true;
	}
}
