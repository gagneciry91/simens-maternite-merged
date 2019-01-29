<?php

namespace Maternite\src\Maternite\Controller;

use Zend\Json\Json;
//use Zend\Form\Form;
use Zend\Form\View\Helper\FormRow;
//use Zend\Form\View\Helper\FormInput;
use Maternite\View\Helpers\DateHelper;
use Zend\Mvc\Controller\AbstractActionController;
use Maternite\Form\PatientForm;
use Zend\View\Model\ViewModel;
//use Zend\Db\Sql\Sql;
use Maternite\Form\AjoutDecesForm;
use Maternite\Form\admission\AdmissionForm;
use Maternite\Form\admission\ConsultationForm;
use Maternite;
class GynechologieController extends AbstractActionController{
	protected $consultationTable;
	protected $admissionTable;
	protected $type_admissionTable;
	protected $type_accouchementTable;
	//protected $type_admissionTable;
	//protected $admissionTable;
	protected $patientTable;
	protected $formPatient;
	protected $formAdmission;
	
	
	
}

?>