<?php
namespace Maternite\Model;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Sql;

use Maternite\View\Helpers\DateHelper;

class GynecologieTable {
	
	
		protected $tableGateway;
		public function __construct(TableGateway $tableGateway) {
			$this->tableGateway = $tableGateway;
	
		}
}