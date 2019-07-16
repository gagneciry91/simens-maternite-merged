<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Sql;

use Maternite\View\Helpers\DateHelper;
class DevenirNouveauNeTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getNouveauNe($id_cons) {
	
		//$adapter = $this->tableGateway->getAdapter ();
		$db = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $db );
		$sQuery = $sql->select ();
	
				$sQuery->columns ( array (
				'*'
		) );
				
		$sQuery->from( array (
				'nv' => 'devenir_nouveau_ne'
		) )->join ( array (
				'enf' => 'enfant' 
		), 'enf.id_bebe = nv.id_bebe', array (

		));
		$sQuery->where ( array (
				'acc.id_cons' => $id_cons
		
		) );
		
		$sQuery->order ( 'nv.id_devenir_nouveau_ne ASC' );
		
		$stat = $sql->prepareStatementForSqlObject ( $sQuery );
	
		$resultat = $stat->execute ()->current();
		//var_dump($resultat);exit();
		return $resultat;
	}

	public function getDevenu($id_cons) {
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*'
		) );
		$select->from ( array (
				'nv' => 'devenir_nouveau_ne'
		) );
		$select->join ( array (
				'enf' => 'enfant'
		), 'nv.id_bebe = enf.id_bebe', array (
					
		) );
$select->join ( array (
				'g' => 'grossesse'
		), 'enf.id_grossesse = g.id_grossesse', array (
					
		) );
		$select->where ( array (
				'g.id_cons' => $id_cons,
	
		) );
		$select->order ( 'id_devenir_nouveau_ne ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
	
		return $result;//var_dump(count($result));exit();
	}
	
	
	public function saveNouveauNe($values,$id_cons,$tabIdEnfant) {
		$Control = new DateHelper();       	
		for($i = 1; $i <= $values['nombre_enfant'] ; $i ++){
			$date_dece = $values ['date_deces_'. $i];
			if($date_dece){ $date_dece = $Control->convertDateInAnglais($date_dece); }else{ $date_dece = null;}
			$datanouveauNe = array (
					'viv_bien_portant' => $values['viv_bien_portant_'. $i],
					'note_viv_bien_portant' => $values['n_viv_bien_portant_' . $i]?$values['viv_bien_portant_'. $i]:null,
					'viv_mal_formation' => $values['viv_mal_form_'. $i],
					'note_viv_mal_formation' => $values['n_viv_mal_form_'. $i]?$values['n_viv_mal_form_'. $i]:null,
					'malade' => $values['malade_'. $i],
					'viv_premature' =>$values['viv_premature_'. $i],
					'note_malade' => $values['n_malade_'. $i]?$values['n_malade_'. $i]:null,
					'decede' => $values ['decede_'. $i],					
					'id_bebe' => $tabIdEnfant[$i-1],						
			);		//var_dump($datanouveauNe);exit();
							
					
			
			
			if($values['decede_'. $i]=='Oui'){
				$datanouveauNe['date_deces'] =  $date_dece;
				$datanouveauNe['heure_deces' ]= $values['heure_deces_'. $i];
				$datanouveauNe['cause_deces' ]=$values['cause_deces_'. $i];			
						
				
			}
			
			$this->tableGateway->insert ( $datanouveauNe );
		}
	}
	public function getNbMortNe($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array ('nv' => 'devenir_nouveau_ne'))
			->columns( array( '*' ))
			//->join(array('gros' => 'grossesse'), 'enf.id_cons = gros.id_cons' , array('*'))
			->where(array(
					'nv.decede'=>'Oui'
			));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$resultat = $stat->execute();
			//var_dump(count($resultat));exit();
			return count($resultat);
	
	}

}