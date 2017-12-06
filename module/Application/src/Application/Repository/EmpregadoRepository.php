<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
class EmpregadoRepository extends EntityRepository {
	public function getEmpregados() {
		$qb = $this->createQueryBuilder ( 'e' );
		return $qb->select ( 'e' )
					->where ( 'e.matricula <= 400000' )
					->orderby ( 'e.nome' )
					->getQuery ()
					->getResult ();
	}
	public function getGerentes() {
		$qb = $this->createQueryBuilder ( 'e' );
		return $qb->select ( 'e' )
		->where ( 'e.matricula <= 400000' )
		->andWhere ( 'e.gerente = :ativo' )
		->setParameter ( "ativo", "ativo" )
		->orderby ( 'e.nome' )
		->getQuery ()
		->getResult ();
	}
}