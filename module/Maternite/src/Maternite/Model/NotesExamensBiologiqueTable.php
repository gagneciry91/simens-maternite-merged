<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class NotesExamensBiologiqueTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getNotesExamensBiologiques($id_cons) {
		//var_dump('test');exit();
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*' 
		) );
		$select->from ( array (
				'neb' => 'note_examen_biologique' 
		) );
		$select->where ( array (
				'neb.id_cons' => $id_cons 
		) );
		$select->order ( 'neb.code ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		$tab = array (
				'groupe_sanguin' => '',
				'hemogramme_sanguin' => '',
				'bilan_hemolyse' => '',
				'bilan_hepatique' => '',
				'bilan_renal' => '',
				'bilan_inflammatoire' => ''
		);
		
		foreach ( $result as $donnes ) {
			if ($donnes ['id_examen'] == 1) {
				$tab ['groupe_sanguin'] = $donnes ['note'];
			}
			if ($donnes ['id_examen'] == 2) {
				$tab ['hemogramme_sanguin'] = $donnes ['note'];
			}
			if ($donnes ['id_examen'] == 3) {
				$tab ['bilan_hemolyse'] = $donnes ['note'];
			}
			if ($donnes ['id_examen'] == 4) {
				$tab ['bilan_hepatique'] = $donnes ['note'];
			}
			if ($donnes ['id_examen'] == 5) {
				$tab ['bilan_renal'] = $donnes ['note'];
			}
			if ($donnes ['id_examen'] == 6) {
				$tab ['bilan_inflammatoire'] = $donnes ['note'];
			}
		}
		return $tab;
	}
	public function updateNotesExamensBiologiques($donnees) {var_dump('test');exit();
		$this->tableGateway->delete ( array (
				'id_cons' => $donnees ['id_cons'] 
		) );
		
		for($i = 1; $i <=6; $i ++) {
			if ($donnees [$i]) {
				$dataNotesExamens = array (
						'id_cons' => $donnees ['id_cons'],
						'id_examen' => $i,
						'note' => $donnees [$i] 
				);
				$this->tableGateway->insert ( $dataNotesExamens );
			}
		}
	}
}

