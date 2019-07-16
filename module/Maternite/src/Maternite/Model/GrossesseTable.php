<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Maternite\View\Helpers\DateHelper;

class GrossesseTable {
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}


	
	public function getAdmission() {
	
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->from ( array (
				'ad' => 'admission'
		) );
	}
		

	
	
	
	
	
	public function getGrossesse($id_pat,$id_cons){
		

		//$adapter = $this->tableGateway->getAdapter ();
		$db = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $db );
		$sQuery = $sql->select ();
		
		$sQuery->columns ( array (
				'*'
		) );
		
		$sQuery->from( array (
				'gro' => 'grossesse'
		) )->join ( array (
				'p' => 'patient'
		), 'gro.id_patient = p.ID_PERSONNE', array (
		
		));
		$sQuery->where ( array (
				'gro.id_patient' => $id_pat,
				'gro.id_cons' => $id_cons
		
		) );
		
		$sQuery->order ( 'gro.id_grossesse ASC' );
		
		$stat = $sql->prepareStatementForSqlObject ( $sQuery );
		
		$resultat = $stat->execute ()->current();
		//var_dump($resultat);exit();
		return $resultat;
		
	}
	

	
	public function updateGrossesse($donnees) {
		
		$Control = new DateHelper();
		 
		$this->tableGateway->delete ( array (
				'id_cons' => $donnees ['id_cons'],	
		) );		
				
		$ddr = $donnees['ddr'];
		$date_cons = $donnees['date_cons'];
		
		$nb_bb=$donnees['bb_attendu'];
		if($nb_bb==1){
			$b=1;}
			elseif($nb_bb==2){
				$b=2;}
				elseif($nb_bb==3){
					$b=3;}
					elseif ($nb_bb==0)
					{
						$b=$donnees['nombre_bb'];
					}
		if($ddr){ $ddr = $Control->convertDateInAnglais($ddr); }else{ $ddr = null;}
		if($date_cons){ $date_cons = $Control->convertDateInAnglais($date_cons); }else{ $date_cons = null;}
		
		$datagrossesse = array (
				'id_cons' => $donnees ['id_cons'],
				'id_patient'=>$donnees['id_patient'],
				'ddr'=>$ddr,
				'date_cons'=>$date_cons,
				
				'duree_grossesse'=>$donnees['duree_grossesse'],
				'nb_cpn'=>$donnees['nb_cpn'],
				'bb_attendu'=>$donnees['bb_attendu'],				
				'nombre_bb'=>$b,
				'vat_1'=>$donnees['vat_1'],
				'vat_2'=>$donnees['vat_2'],
				'vat_3'=>$donnees['vat_3'],
				'note_ddr'=>$donnees['note_ddr'],
				'note_bb'=>$donnees['note_bb'],
				'note_cpn'=>$donnees['note_cpn'],
				'note_vat'=>$donnees['note_vat'],
		);
		//var_dump($datagrossesse);exit();
		return $this->tableGateway->getLastInsertValue($this->tableGateway->insert($datagrossesse));
		var_dump($datagrossesse);exit();
		
	}
	
	
	//AVORTEMENT

	
	
 	public function updateAvortement($donnees,$id_cons,$id_grossesse) {
		$db = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $db );

			
	
					if($donnees['type_avortement']!=0){
					$db = $this->tableGateway->getAdapter ();
					$sql = new Sql ( $db );
					
					$sQuery = $sql->insert ()->into ( 'avortement' )->values ( array (
							'id_grossesse' => $id_grossesse,
							'id_cons' => $id_cons,
							'id_type_av'=>$donnees['type_avortement'],
							'id_traitement'=>$donnees['traitement_recu'],
							'periode_av'=>$donnees['periode_av'],
							
					));
					$requete = $sql->prepareStatementForSqlObject ( $sQuery );
					$requete->execute ();}
					
	
	
	}
	
	
	
	//statistique

	public function getNbGrossesseGemellaire(){
	
	
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('p' => 'patient'));
		$select->join(array('gro' => 'grossesse') ,'gro.id_patient = p.id_personne');
		$select->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type','date_accouchement'));
		$select->where(array('gro.nombre_bb' => 2));
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
	
	
		$variable =array();$i=1;
		foreach ($result as $r){
			$variable[$i] = $r['date_accouchement'];$i++;
		}
		//var_dump(count($variable));exit();
		$today = new \DateTime ();
		$dateToday = $today->format ( 'Y-m-d' );
		list($yearToday,$monthToday, $dayToday) = explode('-', $dateToday);
		$dates=array();
		$month=array();
		for($i=1;$i<=count($variable);$i++){
			list($year[$i],$month[$i], $day[$i]) = explode('-', $variable[$i]);
			if(($month[$i]==$monthToday)&&($year[$i]==$yearToday)){
	
				$dates[$i]=$variable[$i];
			}
		}
	
	
		return count($dates);
	}
	
	public function getAvortement($id_cons){

		$db = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $db );
		$sQuery = $sql->select ();
		
		$sQuery->columns ( array (
				'*'
		) );
		
		$sQuery->from( array (
				'av' => 'avortement'
		) )->join ( array (
				'g' => 'grossesse'
		), 'av.id_grossesse = g.id_grossesse', array (
		
		))->join ( array (
				't' => 'type_avortement'
		), 'av.id_type_av = t.id_type_av', array (
		
		))->join ( array (
				'tt' => 'traitement_recu'
		), 'av.id_traitement = tt.id_traitement', array (
			 ) );	
		$sQuery->where ( array (
				'av.id_cons' => $id_cons
		
		        
				));
		
		$sQuery->order ( 'av.id_avortement ASC' );
		
		$stat = $sql->prepareStatementForSqlObject ( $sQuery );
		
		$resultat = $stat->execute ()->current();
		//var_dump($resultat);exit();
		return $resultat;
		
		
	}

	public function getCPN1($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>1 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getnbVAT1($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->columns( array( '*' ))
		
		->where ( array (
				'gro.vat_1'=>1 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	
	}
	public function getnbVAT2($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->columns( array( '*' ))
	
		->where ( array (
				'gro.vat_2'=>1 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	
	}
	public function getnbVAT3($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->columns( array( '*' ))
	
		->where ( array (
				'gro.vat_3'=>1 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	
	}
	public function getnbVAT4($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->columns( array( '*' ))
	
		->where ( array (
				'gro.vat_4'=>1 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	
	}
	public function getnbVAT5($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->columns( array( '*' ))
	
		->where ( array (
				'gro.vat_5'=>1 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	
	}
	
	
	public function getCPN2($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>2 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPN3($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>3 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPN4($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>4 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getPrimiparePatho($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nouvelleGrossesse'=>2,'ant.geste'=>1 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getPrimipareRisque($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nouvelleGrossesse'=>1,'ant.geste'=>1 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getMultiparePatho($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nouvelleGrossesse'=>2,'ant.geste> ?'  => 1 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getMultipareRisque($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nouvelleGrossesse'=>1,'ant.geste> ?'  => 1 ,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPN1Primipare($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
		
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>1 ,'ant.geste'=>1,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPN2Primipare($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
	
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>2 ,'ant.geste'=>1,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPN3Primipare($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
	
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>3 ,'ant.geste'=>1,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPN4Primipare($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
	
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>4 ,'ant.geste'=>1,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	
	public function getCPNSup4Primipare($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
	
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn> ?'=>4 ,'ant.geste'=>1,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPN1Multipare($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
	
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>1 ,'ant.geste> ?'=>1,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPN2Multipare($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
	
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>2 ,'ant.geste> ?'=>1,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPN3Multipare($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
	
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>3 ,'ant.geste> ?'=>1,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPN4Multipare($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
	
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn'=>4 ,'ant.geste> ?'=>1,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getCPNSup4Multipare($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('gro' => 'grossesse'))
		->join(array('ant' => 'antecedent_type_1') ,'gro.id_cons = ant.id_cons')
	
		->columns( array( '*' ))
	
		->where ( array (
				'gro.nb_cpn> ?'=>4 ,'ant.geste> ?'=>1,'gro.ddr>= ?' => $date_debut,'gro.ddr<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	public function getNbNaissanePrematureMascSimpleEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
			->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
		))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
				'id_type' => 1,'nv.viv_premature'=>'Oui','enf.sexe'=>'M','gro.bb_attendu'=>1,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	public function getNbNaissanePrematureFemSimpleEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
			->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
		))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
		))->columns( array( '*' ))
		->where(array(
				'id_type' => 1,'nv.viv_premature'=>'Oui','enf.sexe'=>'F','gro.bb_attendu'=>1,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	public function getNbNaissaneTermMascSimpleEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
    	))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
				'id_type' => 1,'enf.sexe'=>'M','nv.viv_bien_portant'=>'Oui','gro.bb_attendu'=>1,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);//var_dump('test');exit();
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	public function getNbNaissaneTermFemSimpleEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
				))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
				'id_type' => 1,'nv.viv_bien_portant'=>'Oui','enf.sexe'=>'F','gro.bb_attendu'=>1,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	
	public function getNbNaissanePrematureMascDoubleEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
			->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
			))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
				'id_type' => 1,'nv.viv_premature'=>'Oui','enf.sexe'=>'M','gro.bb_attendu'=>2,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	public function getNbNaissanePrematureFemDoubleEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
       ))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
				'id_type' => 1,'nv.viv_premature'=>'Oui','enf.sexe'=>'F','gro.bb_attendu'=>2,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	public function getNbNaissaneTermMascDoubleEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
			->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
		))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
					'id_type' => 1,'nv.viv_bien_portant'=>'Oui','enf.sexe'=>'M','gro.bb_attendu'=>2,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	public function getNbNaissaneTermFemDoubleEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
			->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
    	))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
					'id_type' => 1,'nv.viv_bien_portant'=>'Oui','enf.sexe'=>'F','gro.bb_attendu'=>2,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	
	public function getNbNaissanePrematureMascTriplePlusEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
				->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
		))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
				'id_type' => 1,'nv.viv_premature'=>'Oui','enf.sexe'=>'M','gro.bb_attendu>= ?'=>3,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	public function getNbNaissanePrematureFemTriplePlusEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
			->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
		))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
				'id_type' => 1,'nv.viv_premature'=>'Oui','enf.sexe'=>'F','gro.bb_attendu>= ?'=>3,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	public function getNbNaissaneTermMascTriplePlusEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
		))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
				'id_type' => 1,'nv.viv_bien_portant'=>'Oui','enf.sexe'=>'M','gro.bb_attendu>= ?'=>3,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	public function getNbNaissaneTermFemTriplePlusEutocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
				) )->join ( array (
						'nv' => 'devenir_nouveau_ne'
				), 'nv.id_bebe = enf.id_bebe', array (
			))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
						
		))->columns( array( '*' ))
		->where(array(
				'id_type' => 1,'nv.viv_bien_portant'=>'Oui','enf.sexe'=>'F','gro.bb_attendu >= ?'=>3,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	public function getNbNaissanePrematureMascSimpleDystocique($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array ('enf' => 'enfant'
		) )->join ( array (
				'gro' => 'grossesse'
		), 'enf.id_cons = gro.id_cons', array (
		) )->join ( array (
				'nv' => 'devenir_nouveau_ne'
		), 'nv.id_bebe = enf.id_bebe', array (
		))->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'
	
		))->columns( array( '*' ))
		->where(array(
				'id_type!='=> 1,'nv.viv_premature'=>'Oui','enf.sexe'=>'M','gro.bb_attendu'=>1,'gro.ddr >= ?' => $date_debut, 'gro.ddr <= ?' => $date_fin
		));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
	
	}
	
}