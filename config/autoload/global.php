<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array (
		'service_manager' => array (
				'factories' => array (
						'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory' 
				) 
		),
		'db' => array (
				'driver' => 'Pdo',
				'dsn' => 'mysql:dbname=sigemp;host=localhost',
				'driver_options' => array (
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'' 
				) 
		),
		'doctrine' => array (
				'connection' => array (
						'orm_default' => array (
								'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
								'params' => array (
										'host' => 'localhost',
										'port' => '3306',
										'user' => 'root',
										'password' => 'Temp10!?',
										'dbname' => 'sigemp' 
								) 
						) 
				) 
		),
		'acl' => array (
				'roles' => array (
						'comum' => null,
						'admin' => 'comum' 
				),
				'resources' => array (
						'Admin\Controller\Auth.index',
						'Admin\Controller\Auth.login',
						'Admin\Controller\Auth.logout',
						'Application\Controller\Index.index',
						'Application\Controller\Empregado.index',
						'Application\Controller\Empregado.save',
						'Application\Controller\Empregado.delete',
						'Application\Controller\Empregado.buscaempregados',
						'Application\Controller\Cargo.index',
						'Application\Controller\Cargo.save',
						'Application\Controller\Cargo.delete',
						'Application\Controller\Conhecimento.index',
						'Application\Controller\Conhecimento.save',
						'Application\Controller\Conhecimento.delete',
						'Application\Controller\Curso.index',
						'Application\Controller\Curso.save',
						'Application\Controller\Curso.delete',
						'Application\Controller\Instituicao.index',
						'Application\Controller\Instituicao.save',
						'Application\Controller\Instituicao.delete',
						'Application\Controller\Professor.index',
						'Application\Controller\Professor.save',
						'Application\Controller\Professor.delete',
						'Application\Controller\Setor.index',
						'Application\Controller\Setor.save',
						'Application\Controller\Setor.delete',
						'Application\Controller\Turma.index',
						'Application\Controller\Turma.save',
						'Application\Controller\Turma.delete' 
				),
				'privilege' => array (
						'comum' => array (
								'allow' => array (
										'Admin\Controller\Auth.index',
										'Admin\Controller\Auth.login',
										'Admin\Controller\Auth.logout',
										'Application\Controller\Index.index'
								) 
						),
						'admin' => array (
								'allow' => array (
										'Application\Controller\Empregado.save',
										'Application\Controller\Empregado.delete',
										'Application\Controller\Empregado.buscaempregados',
										'Application\Controller\Cargo.save',
										'Application\Controller\Cargo.delete',
										'Application\Controller\Conhecimento.save',
										'Application\Controller\Conhecimento.delete',
										'Application\Controller\Curso.save',
										'Application\Controller\Curso.delete',
										'Application\Controller\Instituicao.save',
										'Application\Controller\Instituicao.delete',
										'Application\Controller\Setor.save',
										'Application\Controller\Setor.delete',
										'Application\Controller\Professor.save',
										'Application\Controller\Professor.delete',
										'Application\Controller\Turma.save',
										'Application\Controller\Turma.delete',
										'Application\Controller\Empregado.index',
										'Application\Controller\Cargo.index',
										'Application\Controller\Conhecimento.index',
										'Application\Controller\Curso.index',
										'Application\Controller\Setor.index',
										'Application\Controller\Professor.index',
										'Application\Controller\Turma.index',
										'Application\Controller\Instituicao.index',
								) 
						) 
				) 
		) 
);