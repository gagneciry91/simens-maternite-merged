<?php
namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Crypt\PublicKey\Rsa\PublicKey;
use Zend\Validator\File\Count;
class PostnataleTable {
    
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	
	}

	public function getDAteAcc(){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'date_accouchement'
		) );
		$select->from ( array (
				'pos' => 'postnatale'
		) );
		$select->order ( 'pos.id_accouchement ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		$variable =array();$i=1;
		foreach ($result as $r){
			$variable[$i] = $r['date_accouchement'];$i++;
			}
			return $variable;
			}
				
	
	public function getLesPostnatale($monthToday,$yearToday) {
			
		$today = new \DateTime ();
		$dateToday = $today->format ( 'Y-m-d' );
		//list($yearToday,$monthToday, $dayToday) = explode('-', $dateToday);
		$dates=array();
		$date=$this->getDAteAcc();
		$month=array();
		for($i=1;$i<=count($date);$i++){
			list($year[$i],$month[$i], $day[$i]) = explode('-', $date[$i]);
			if(($month[$i]==$monthToday)&&($year[$i]==$yearToday)){
				$dates[$i]=$date[$i];
			}
		}
		return $dates;
	}
	public function getPostnatale($id_cons) {
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		
		$select->from ( array (
				'p' => 'patient'
						
				
		)
		 );
		
		$select->columns ( array ('numero_dossier'=>'NUMERO_DOSSIER') );
		$select->join(array('pers' => 'personne'), 'pers.ID_PERSONNE = p.ID_PERSONNE', array(
	
				'Nom' => 'NOM',
				'Prenom' => 'PRENOM',
				'Age' => 'AGE',
				'Sexe' => 'SEXE',
				'Adresse' => 'ADRESSE',
				'Nationalite' => 'NATIONALITE_ACTUELLE',
				'Id' => 'ID_PERSONNE'
		));
		$select->join ( array (
				'a' => 'admission'
		), 'p.ID_PERSONNE = a.id_patient', array (
				'Id_admission' => 'id_admission'
		) );
		
		
				$select->where ( array (
				'a.date_cons' => $date
		) );
		
		$select->order ( 'id_admission DESC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute()->count();		//var_dump($result);exit();
				return $result;
		//var_dump($result); exit();
		
	}
	



	public function updatePostnatale($values) {
	
	
		$donnees = array (
				'ID_CONS' => $values['ID_CONS'],
				//'etat_de_la_mere' => $values['etat_de_la_mere'],
				'parite' => $values['parite'],
				
				//'type_accouchement' => $values['type_accouchement'],
				'lieu_accouchement' => $values['lieu_accouchement'],
				//'numero_d_ordre' => $values['numero_d_ordre'],
		);  
			return $this->tableGateway->getLastInsertValue($this->tableGateway->insert ( $donnees ));
						var_dump($donnees);exit();
		}
		//$this->tableGateway->insert ( $donnees );
	
		//var_dump('test');exit();
	
	
}