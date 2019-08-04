<?php
namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Maternite\View\Helpers\DateHelper;

class PreventionTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	



	

	public function updatePrevention($values) {
		
		//var_dump('test');exit();
		
		$Control = new DateHelper();
				//var_dump('test');exit();
				
	
		$donnees = array (
				'ID_CONS' => $values['ID_CONS'],
				'VAT' => $values['VAT'],
				'FER' => $values['FER'],
				'VIH' => $values['VIH'],
						);  //var_dump($donnees);exit();
		 $this->tableGateway->insert ( $donnees );
		
				//var_dump('test');exit();
		}		
	}
	

