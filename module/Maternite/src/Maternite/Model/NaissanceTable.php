<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class NaissanceTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getNaissance($id) {
	
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*'
		) );
		$select->from ( array (
				'enf' => 'enfant'
		) );
		$select->join ( array (
				'acc' => 'accouchement'
		), 'acc.id_grossesse = enf.id_grossesse', array (
				'*'
		) );
		$select->join ( array (
				'c' => 'consultation'
		), 'c.id_cons = acc.id_cons', array (
				'*'
		) );
		$select->where ( array (
				'c.id_cons' => $id,
				
		) );
		$select->order ( 'enf.id_bebe ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		return $result;
		
	
	}
	
	public function getEnf($date_debut,$date_fin) {
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*'
		) );
		$select->from ( array (
				'enf' => 'enfant'
		) );
		$select->join(array('c'=>'consultation'),'c.id_cons=enf.id_cons');
		
		$select->where ( array (
				'c.DATEONLY>= ?' => $date_debut,'c.DATEONLY<= ? '=> $date_fin ) ); 
		$select->order ( 'id_bebe ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
	
		return $result;
	}
	

public function saveNaissance($values,$id_cons,$id_patient) {

	$tab_IdBebe = array();
	for($i = 1; $i <=  $values['nombre_enfant'] ; $i ++){
		$datanaissance = array (
				'sexe' => $values['sexe_'. $i],
				'note_sexe' => $values['n_sexe_' . $i],
				'poids' => $values['poids_'. $i],
				'taille' => $values['taille_'. $i],
				'note_taille' => $values['n_taille_'. $i],
				'note_poids' => $values['n_poids_'. $i],
				'apgar_1' => $values ['apgar1_'. $i],
				'apgar_5' => $values['apgar5_'. $i],
				'note_apgar' => $values['n_apgar_'. $i],
				'malf' => $values['malf_'. $i],
				'note_malf' => $values['n_malf_'. $i],
				'cri' => $values['cri_'. $i],
				'note_cri' => $values['n_cri_'. $i],
				'maintien_temp' => $values['mt_'. $i],
				'note_temp' => $values['n_mt_'. $i],
				'mise_soin_precoce' => $values['msp_'. $i],
				'note_soin_precoce' => $values['n_msp_'. $i],
				'soin_cordon' => $values['sc_'. $i],
				'note_cordon' => $values['n_sc_'. $i],
				'reanimation' => $values['reanim_'. $i],
				'note_reanim' => $values['n_reanim_'. $i],
				'vit_k' => $values['vitk_'. $i],
				'note_vitk' => $values['n_vitk_'. $i],
				'sat' => $values['sat_'. $i],
				'note_sat' => $values['n_sat_'. $i],
				'collyre' => $values['collyre_'. $i],
				'note_collyre' => $values['n_collyre_'. $i],
				'consult_j1_j2' => $values['consj1j2_'. $i],
				'perim_cranien' => $values['cranien_'. $i],
				'perim_cephalique' => $values['cephalique_'. $i],
				'perim_brachial' => $values['brachial_'. $i],
				'note_perim' => $values['n_perim_'. $i],
				'bcg' => $values['bcg_'. $i],
				'note_bcg' => $values['n_bcg_'. $i],
				'anti_hepatique' => $values['anti_hepa_'. $i],
				'note_hepa' => $values['n_anti_hepa_'. $i],
				'vpo' => $values['vpo_'. $i],
				'note_vpo' => $values['n_vpo_'. $i],
				'anti_tuberculeux' => $values['antiT_'. $i],
				'note_tuberculeux' => $values['n_antiT_'. $i],
				'autre_vacc' => $values['autre_vacc_'. $i],
				'type_autre_vacc' => $values['type_autre_vacc_'. $i],
				'note_autre_vacc' => $values['n_autre_vacc_'. $i],
				'id_cons' => $id_cons,
				//'id_grossesse' => $id_grossesse,
				'id_maman' => $id_patient,
		);
		
		$this->tableGateway->insert($datanaissance);
		$tab_IdBebe [] = $this->tableGateway->getLastInsertValue();	
	}
	return $tab_IdBebe;

}
public function getNbEnfantReanime($date_debut,$date_fin){
	
	
	$db = $this->tableGateway->getAdapter();
	$sql = new Sql($db);
	$sQuery = $sql->select()
	->from(array('enf' => 'enfant'))
	->columns( array( '*' ))
	->join(array('c'=>'consultation'),'c.id_cons=enf.id_cons')
	->where(array(
			'enf.reanimation'=>'Oui', 'c.DATEONLY>= ?' => $date_debut,'c.DATEONLY<= ? '=> $date_fin));
	$stat = $sql->prepareStatementForSqlObject($sQuery);
	$resultat = $stat->execute();
	//var_dump($resultat);exit();
	return count($resultat);
	
}
public function getNbEnfantNonCrier($date_debut,$date_fin){
	$db = $this->tableGateway->getAdapter();
	$sql = new Sql($db);
	$sQuery = $sql->select()
	->from(array('enf' => 'enfant'))
	->columns( array( '*' ))
	->join(array('c'=>'consultation'),'c.id_cons=enf.id_cons')
	
	->where(array(
			'enf.cri'=>'Non','c.DATEONLY>= ?' => $date_debut,'c.DATEONLY<= ? '=> $date_fin	
	));
	$stat = $sql->prepareStatementForSqlObject($sQuery);
	$resultat = $stat->execute();
	//var_dump($resultat);exit();
	return count($resultat);
}
public function getNbEnfantPoidsInferieur($date_debut,$date_fin){
	$db = $this->tableGateway->getAdapter();
	$sql = new Sql($db);
	$sQuery = $sql->select()
	->from(array('enf' => 'enfant'))
	->columns( array( '*' ))
	->join(array('c'=>'consultation'),'c.id_cons=enf.id_cons')
	
	->where(array(
			'enf.poids' <2500,'c.DATEONLY>= ?' => $date_debut,'c.DATEONLY<= ? '=> $date_fin
	));
	$stat = $sql->prepareStatementForSqlObject($sQuery);
	$resultat = $stat->execute();
	//var_dump($resultat);exit();
	return count($resultat);
}
public function getNbEnfantPoidsSuperieur($date_debut,$date_fin){
	$db = $this->tableGateway->getAdapter();
	$sql = new Sql($db);
	$sQuery = $sql->select()
	->from(array('enf' => 'enfant'))
	->columns( array( '*' ))
	->join(array('c'=>'consultation'),'c.id_cons=enf.id_cons')

	->where(array(
			'enf.poids >= ?' => 4000,'c.DATEONLY>= ?' => $date_debut,'c.DATEONLY<= ? '=> $date_fin
	));
	$stat = $sql->prepareStatementForSqlObject($sQuery);
	$resultat = $stat->execute();
	return count($resultat);
}

}