<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
//use Zend\XmlRpc\Value\String;

class OrdonnanceTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getOrdonnance($id) {
		$rowset = $this->tableGateway->select ( array (
				'ID_CONS' => $id 
		) );
		$row = $rowset->current ();
		if (! $row) {
			return $row = null;
		}
		return $row;
	}
	public function getOrdonnanceNonHospi($id) {
		$rowset = $this->tableGateway->select ( array (
				'ID_CONS' => $id,
				'HOSP' => 0 
		) );
		$row = $rowset->current ();
		if (! $row) {
			return $row = null;
		}
		return $row;
	}
	public function getOrdonnanceHospi($id) {
		$rowset = $this->tableGateway->select ( array (
				'ID_CONS' => $id,
				'HOSP' => 1 
		) );
		$row = $rowset->current ();
		if (! $row) {
			return $row = null;
		}
		return $row;
	}
	public function getMedicamentsParIdOrdonnance($idOrdonnance) {
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*' 
		) );
		$select->from ( array (
				'oc' => 'ordon_consommable' 
		) );
		$select->join ( array (
				'o' => 'ordonnance' 
		), 'oc.ID_DOCUMENT = o.ID_DOCUMENT', array (
				'DureeTraitementOrdonnance' => 'DUREE_TRAITEMENT' 
		) );
		
		$select->join ( array (
				'c' => 'consommable' 
		), 'c.ID_MATERIEL = oc.ID_MATERIEL', array (
				'Intitule' => 'INTITULE' 
		) );
		
		$select->where ( array (
				'o.ID_DOCUMENT' => $idOrdonnance 
		) );
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		return $result;
	}
	
	/**
	 *
	 * @param $tab :
	 *        	Tableau des m�dicaments
	 * @param $donnees :
	 *        	Duree traitement et id_cons
	 */
	public function updateOrdonnance($tab, $donnees) {
		$today = new \DateTime ();
		$date = $today->format ( 'Y-m-d H:i:s' );           		     
		//var_dump('test');exit();
		/**
		 * On v�rifie s'il y a des m�dicaments et si oui on proc�de a la modification sinon on ne fait rien
		 * car l'ordonnance doit etre supprimer
		 */
		if ($tab) {
			$donneesOrdonnance = array (
					'DATE_PRESCRIPTION' => $date,
					'DUREE_TRAITEMENT' => $donnees ['duree_traitement'] 
			);
			$result = $this->tableGateway->update ( $donneesOrdonnance, array (
					"ID_CONS" => $donnees ['id_cons'] 
			) );
			/**
			 * S'il y a des m�dicaments alors qu'il n'y avait pas d'ordonnance on la cr�e
			 */
			if ($result == 0) {
				$donneesOrdonnance = array (
						'DATE_PRESCRIPTION' => $date,
						'DUREE_TRAITEMENT' => $donnees ['duree_traitement'],
						'ID_CONS' => $donnees ['id_cons'] 
				);//var_dump($donneesOrdonnance);exit();
				$this->tableGateway->insert ( $donneesOrdonnance );//var_dump('test');exit();
				
			}
		}
		/**
		 * Envoi de l'id de l'ordonnance pour sa suppression ou pour la mise � jour des m�dicaments de l'ordonnance
		 */
		$ordonnance = $this->getOrdonnance ( $donnees ['id_cons'] );//var_dump('test');exit();
		$idOrdonnance = null;
		if ($ordonnance) {
			$idOrdonnance = $ordonnance->id_document;
		}
		return $idOrdonnance;
	}
	public function deleteOrdonnance($idOrdonnance) {
		$this->tableGateway->delete ( array (
				"ID_DOCUMENT" => $idOrdonnance 
		) );
	}
	
	/**
	 *
	 * @param $tab :
	 *        	Tableau des m�dicaments
	 * @param $donnees :
	 *        	Duree traitement et id_cons
	 */
	public function updateOrdonnanceForHospi($tab, $donnees) {
		$today = new \DateTime ();
		$date = $today->format ( 'Y-m-d H:i:s' );
		/**
		 * On v�rifie s'il y a des m�dicaments et si oui on proc�de a la modification sinon on ne fait rien
		 * car l'ordonnance doit etre supprimer
		 */
		if ($tab) {
			$donneesOrdonnance = array (
					'DATE_PRESCRIPTION' => $date,
					'DUREE_TRAITEMENT' => $donnees ['duree_traitement'],
					'HOSP' => 1 
			);
			$result = $this->tableGateway->update ( $donneesOrdonnance, array (
					"ID_CONS" => $donnees ['id_cons'] 
			) );
			/**
			 * S'il y a des m�dicaments alors qu'il n'y avait pas d'ordonnance on la cr�e
			 */
			if ($result == 0) {
				$donneesOrdonnance = array (
						'DATE_PRESCRIPTION' => $date,
						'DUREE_TRAITEMENT' => $donnees ['duree_traitement'],
						'ID_CONS' => $donnees ['id_cons'],
						'HOSP' => 1 
				);
				$this->tableGateway->insert ( $donneesOrdonnance );
			}
		}
		/**
		 * Envoi de l'id de l'ordonnance pour sa suppression ou pour la mise � jour des m�dicaments de l'ordonnance
		 */
		$ordonnance = $this->getOrdonnance ( $donnees ['id_cons'] );
		$idOrdonnance = null;
		if ($ordonnance) {
			$idOrdonnance = $ordonnance->id_document;
		}
		return $idOrdonnance;
	}
}
