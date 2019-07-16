<?php

namespace Maternite\Controller;
//use Maternite\Form\ConsultationForm;
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
use Maternite\Form\postnatale\AdmissionForm;
use Maternite\Form\postnatale\ConsultationForm;
use Maternite;
//use Maternite\Form\postnatale\PartoForm;
/* use Zend\Form\View\Helper\FormTextarea;
use Zend\Form\View\Helper\FormHidden;
use Maternite\Form\postnatale\LibererPatientForm;
use Zend\Form\View\Helper\FormText;
use Zend\Form\View\Helper\FormSelect; */
use Maternite\View\Helpers\DocumentPdf;
use Maternite\View\Helpers\DemandeExamenPdf;
use Maternite\View\Helpers\OrdonnancePdf;
use Maternite\View\Helpers\CertificatPdf;
use Maternite\View\Helpers\ProtocoleOperatoirePdf;
use Maternite\View\Helpers\TraitementChirurgicalPdf;
use Maternite\View\Helpers\TraitementInstrumentalPdf;
use Maternite\View\Helpers\RendezVousPdf;
use Maternite\View\Helpers\TransfertPdf;
use Maternite\View\Helpers\HospitalisationPdf;
use Maternite\View\Helpers\SuiteDeCouchePdf;
use Maternite\View\Helpers\ObservationPdf;
use Archivage\Model\Consultation;
use Zend\Console\Adapter\Windows;
use Zend\Code\Generator\DocBlock\Tag\TagInterface;
use Zend\Code\Generator\DocBlock\Tag;
use Doctrine\Common\Annotations\Annotation\Target;

class PostnataleController extends AbstractActionController

{
protected $controlDate;
    protected $patientTable;
    protected $evacuationTable;
    protected $referenceTable;
     protected $formPatient;                     
     protected $formAdmission;
    protected $batimentTable;
    protected $accouchementTable;
    protected $notesExamensBiologiqueTable;
    
    protected $consultationTable;
   protected $postnataleTable;
   protected $type_postnataleTable;
   protected $type_accouchementTable;
   protected $type_admissionTable;
    protected $grossesse;
    protected $grossesseTable;
    protected $preventionTable;
    
    protected $antecedent_grossesse;
    protected $naissanceTable;
    protected $dateHelper;
    protected $devenir_nouveau_neTable;
    protected $consultationMaterniteTable;
    protected $motifAdmissionTable;
    protected $rvPatientConsTable;
    protected $dateCponTable;
    protected $rangCponTable;
    protected $hereditaireTable;
    protected $serviceTable;
    protected $hopitalTable;
    protected $transfererPatientServiceTable;
    protected $consommableTable;
    protected $donneesExamensPhysiquesTable;
    protected $diagnosticsTable;
    protected $ordonnanceTable;
    protected $demandeVisitePreanesthesiqueTable;
    protected $notesExamensMorphologiquesTable;
    protected $demandeExamensTable;
    protected $conclusionTable;
    protected $ordonConsommableTable;
    protected $antecedantPersonnelTable;
    protected $antecedantsFamiliauxTable;
    protected $demandeHospitalisationTable;
    protected $soinhospitalisationTable;
    protected $soinsTable;
    protected $hospitalisationTable;
    protected $hospitalisationlitTable;
    protected $litTable;
    protected $salleTable;
    protected $allaitementTable;
    
    protected $tarifConsultationTable;
    protected $resultatVpaTable;
    protected $demandeActeTable;
    protected $admissionTable;
    protected $antecedenttype1Table;
   protected $antecedenttype2Table;
   protected $contraceptionTable;
    

	
	
public function testAction(){
	//var_dump('test');exit();
	$this->layout()->setTemplate('layout/postnatale');
}

public function getTransfererPatientServiceTable()
{
	if (!$this->transfererPatientServiceTable) {
		$sm = $this->getServiceLocator();
		$this->transfererPatientServiceTable = $sm->get('Maternite\Model\TransfererPatientServiceTable');
	}
	return $this->transfererPatientServiceTable;
}
public function getForm() {
	if (! $this->formPatient) {
		$this->formPatient = new PatientForm();
	}
	return $this->formPatient;
}


public function getAntecedantPersonnelTable()
{
	if (!$this->antecedantPersonnelTable) {
		$sm = $this->getServiceLocator();
		$this->antecedantPersonnelTable = $sm->get('Maternite\Model\AntecedentPersonnelTable');
	}
	return $this->antecedantPersonnelTable;
}

public function getAntecedantsFamiliauxTable()
{
	if (!$this->antecedantsFamiliauxTable) {
		$sm = $this->getServiceLocator();
		$this->antecedantsFamiliauxTable = $sm->get('Maternite\Model\AntecedentsFamiliauxTable');
	}
	return $this->antecedantsFamiliauxTable;
}
public function getOrdonnanceTable()
{
	if (!$this->ordonnanceTable) {
		$sm = $this->getServiceLocator();
		$this->ordonnanceTable = $sm->get('Maternite\Model\OrdonnanceTable');
	}
	return $this->ordonnanceTable;
}

public function getPreventionTable()
{
	if (!$this->preventionTable) {
		$sm = $this->getServiceLocator();
		$this->preventionTable = $sm->get('Maternite\Model\PreventionTable');
	}
	return $this->preventionTable;
}
public function getContraceptionTable()
{
	if (!$this->contraceptionTable) {
		$sm = $this->getServiceLocator();
		$this->contraceptionTable = $sm->get('Maternite\Model\ContraceptionTable');
	}
	return $this->contraceptionTable;
}
public function getDateCponTable()
{
	if (!$this->dateCponTable) {
		$sm = $this->getServiceLocator();
		$this->dateCponTable = $sm->get('Maternite\Model\DateCponTable');
	}
	return $this->dateCponTable;
}

public function getDonneesExamensPhysiquesTable()
{
	if (!$this->donneesExamensPhysiquesTable) {
		$sm = $this->getServiceLocator();
		$this->donneesExamensPhysiquesTable = $sm->get('Maternite\Model\DonneesExamensPhysiquesTable');
	}
	return $this->donneesExamensPhysiquesTable;
}

public function getRvPatientConsTable()
{
	if (!$this->rvPatientConsTable) {
		$sm = $this->getServiceLocator();
		$this->rvPatientConsTable = $sm->get('Maternite\Model\RvPatientConsTable');
	}
	return $this->rvPatientConsTable;
}

public function getPostnataleTable()
{
	if (!$this->postnataleTable) {
		$sm = $this->getServiceLocator();
		$this->postnataleTable = $sm->get('Maternite\Model\PostnataleTable');
	}
	//var_dump($$this->postnataleTable);exit();
	return $this->postnataleTable;
}

public function getNotesExamensBiologiqueTable()
{
	if (!$this->notesExamensBiologiqueTable) {
		$sm = $this->getServiceLocator();
		$this->notesExamensBiologiqueTable = $sm->get('Maternite\Model\NotesExamensBiologiqueTable');
	}
	return $this->notesExamensBiologiqueTable;
}
public function getDiagnosticsTable()
{
	if (!$this->diagnosticsTable) {
		$sm = $this->getServiceLocator();
		$this->diagnosticsTable = $sm->get('Maternite\Model\DiagnosticsTable');
	}
	return $this->diagnosticsTable;
}
public function getPatientTable() {
	if (! $this->patientTable) {
		$sm = $this->getServiceLocator ();
		$this->patientTable = $sm->get ( 'Maternite\Model\PatientTable' );
	}
	return $this->patientTable;
}
public function getNaissanceTable()
{
	if (!$this->naissanceTable) {
		$sm = $this->getServiceLocator();
		$this->naissanceTable = $sm->get('Maternite\Model\NaissanceTable');
	}
	//var_dump($$this->accouchementTable);exit();
	return $this->naissanceTable;
}
public function getDemandeHospitalisationTable()
{
	if (!$this->demandeHospitalisationTable) {
		$sm = $this->getServiceLocator();
		$this->demandeHospitalisationTable = $sm->get('Maternite\Model\DemandehospitalisationTable');
	}
	return $this->demandeHospitalisationTable;
}


public function getHospitalisationTable()
{
	if (!$this->hospitalisationTable) {
		$sm = $this->getServiceLocator();
		$this->hospitalisationTable = $sm->get('Maternite\Model\HospitalisationTable');
	}
	return $this->hospitalisationTable;
}

public function getNotesExamensMorphologiquesTable()
{
	if (!$this->notesExamensMorphologiquesTable) {
		$sm = $this->getServiceLocator();
		$this->notesExamensMorphologiquesTable = $sm->get('Maternite\Model\NotesExamensMorphologiquesTable');
	}
	return $this->notesExamensMorphologiquesTable;
}
public function getDevenirNouveauNeTable()
{
	if (!$this->devenir_nouveau_neTable) {
		$sm = $this->getServiceLocator();
		$this->devenir_nouveau_neTable = $sm->get('Maternite\Model\DevenirNouveauNeTable');
	}
	//var_dump($$this->accouchementTable);exit();
	return $this->devenir_nouveau_neTable;
}
public function getAdmissionTable() {
	if (! $this->admissionTable) {
		$sm = $this->getServiceLocator ();
		$this->admissionTable = $sm->get ( 'Maternite\Model\AdmissionTable' );
	}
	return $this->admissionTable;
}

public function getGrossesseTable() {
	if (! $this->grossesse) {
		$sm = $this->getServiceLocator ();
		$this->grossesse = $sm->get ( 'Maternite\Model\GrossesseTable' );
	}
	return $this->grossesse;
}
public function getConsultationTable()
{
	if (!$this->consultationTable) {
		$sm = $this->getServiceLocator();
		$this->consultationTable = $sm->get('Maternite\Model\ConsultationTable');
	}
	return $this->consultationTable;
}
public function getAntecedentType1Table() {
	if (! $this->antecedenttype1Table) {
		$sm = $this->getServiceLocator ();
		$this->antecedenttype1Table = $sm->get ( 'Maternite\Model\AntecedentType1Table' );
	}
	return $this->antecedenttype1Table;
}


public function getAllaitementTable() {
	if (! $this->allaitementTable) {
		$sm = $this->getServiceLocator ();
		$this->allaitementTable = $sm->get ( 'Maternite\Model\AllaitementTable' );
	}
	return $this->allaitementTable;
}
public function getHereditaireTable() {
	if (! $this->hereditaireTable) {
		$sm = $this->getServiceLocator ();
		$this->hereditaireTable = $sm->get ( 'Maternite\Model\HereditaireTable' );
	}
	return $this->hereditaireTable;
}

public function getRangCponTable() {
	if (! $this->rangCponTable) {
		$sm = $this->getServiceLocator ();
		$this->rangCponTable = $sm->get ( 'Maternite\Model\RangCponTable' );
	}
	return $this->rangCponTable;
}
public function getAntecedentType2Table() {
	if (! $this->antecedenttype2Table) {
		$sm = $this->getServiceLocator ();
		$this->antecedenttype2Table = $sm->get ( 'Maternite\Model\AntecedentType2Table' );
	}
	return $this->antecedenttype2Table;
}
public function getConsultationMaterniteTable()
{
	if (!$this->consultationMaterniteTable) {
		$sm = $this->getServiceLocator();
		$this->consultationMaterniteTable = $sm->get('Maternite\Model\ConsultationMaterniteTable');
	}
	return $this->consultationMaterniteTable;
}
public function getAccouchementTable() {
	if (! $this->accouchementTable) {
		$sm = $this->getServiceLocator ();
		$this->accouchementTable = $sm->get ( 'Maternite\Model\AccouchementTable' );
	}//var_dump(accouchementTable);exit();
	return $this->accouchementTable;
}

public function getTypeAccouchementTable()
{
	if (! $this->type_accouchementTable) {
		$sm = $this->getServiceLocator();
		$this->type_accouchementTable = $sm->get('Maternite\Model\TypeAccouchementTable');
	}
	//var_dump($$this->accouchementTable);exit();
	return $this->type_accouchementTable;
}


//ajouter un nouveau patient
	
	public function ajouterAction() {
		
		$this->layout ()->setTemplate ( 'layout/postnatale' );
		
		//$formAdmission = new AdmissionForm();
		$form = $this->getForm ();
		//var_dump('tests'); exit();
		$patientTable = $this->getPatientTable();
		//var_dump('tests'); exit();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('NATIONALITE_ORIGINE' => 'Sénégal', 'NATIONALITE_ACTUELLE' => 'Sénégal');
	
		$form->populateValues($data);
	
		return new ViewModel ( array (
				'form' => $form
		) );
		
	}
	
	public function admissionGrossesseNormalAction()
	{
	
		$this->layout()->setTemplate('layout/postnatale');
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
		$form = new AdmissionForm();
	
		$lespatients = $this->getConsultationTable()->listePatientsConsParMedecin($idService);
	
		// RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		$tabPatientRV = $this->getConsultationTable()->getPatientsRV($idService);
	
		return new ViewModel (array(
				'donnees' => $lespatients,
				'tabPatientRV' => $tabPatientRV,
				'form' => $form
		));
	}
	public function consultationpfAction() {
	
		$this->layout ()->setTemplate ( 'layout/postnatale' );
	
		//$formAdmission = new AdmissionForm();
		$form = $this->getForm ();
		//var_dump('tests'); exit();
		$patientTable = $this->getPatientTable();
		//var_dump('tests'); exit();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('NATIONALITE_ORIGINE' => 'Sénégal', 'NATIONALITE_ACTUELLE' => 'Sénégal');
	
		$form->populateValues($data);
	
		return new ViewModel ( array (
				'form' => $form
		) );
	
	}
	
	public function declarerDecesAction() {
		$this->layout ()->setTemplate ( 'layout/postnatale' );
	
		//INSTANCIATION DU FORMULAIRE DE DECES
		$ajoutDecesForm = new AjoutDecesForm ();
	
		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
				
			$personne = $this->getPatientTable()->miseAJourAgePatient($id);
			//*******************************
			//*******************************
			//*******************************
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getInfoPatient ( $id );
			$photo = $pat->getPhoto ( $id );
				
			$date = $unPatient['DATE_NAISSANCE'];
			if($date){ $date = $this->convertDate ($date); }else{ $date = null;}
	
			$html = "<div style='float:left;' ><div id='photo' style='float:left; margin-right:20px; margin-bottom: 10px;'> <img  src='../img/photos_patients/" . $photo . "'  style='width:105px; height:105px;'></div>";
			$html .= "<div style='margin-left:6px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div></div>";
				
				
			$html .= "<table>";
				
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
			$html .= "</tr>";
				
			$html .= "</table>";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
		return array (
				'form' => $ajoutDecesForm
		);
	}
	
	public function getTypeAdmissionTable()
	{
		if (!$this->type_admissionTable) {
			$sm = $this->getServiceLocator();
			$this->type_admissionTable = $sm->get('Maternite\Model\TypeAdmissionTAble');
		}
	
		return $this->type_admissionTable;
	}
public function admissionAction() {
		$layout = $this->layout ();
	
		$layout->setTemplate ( 'layout/postnatale' );
		$user = $this->layout()->user;	
		$idService = $user ['IdService'];
        //INSTANCIATION DU FORMULAIRE D'ADMISSION
		$formAdmission = new AdmissionForm();
		//var_dump($formAdmission);exit();	
		$pat = $this->getPatientTable ();
		
		if ($this->getRequest ()->isPost ()) {							
			$today = new \DateTime ();
			$dateAujourdhui = $today->format( 'Y-m-d' );
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			$donnee_ant = $pat->getInfoPatientAmise( $id );
			
			//MISE A JOUR DE L'AGE DU PATIENT
			$personne = $this->getPatientTable()->miseAJourAgePatient($id);
			//*******************************
	
			//Verifier si le patient a un rendez-vous et si oui dans quel service et a quel heure
			$RendezVOUS = $pat->verifierRV($id, $dateAujourdhui);
			
			$unPatient = $pat->getInfoPatient( $id );
			
	
			$photo = $pat->getPhoto ( $id );
		
			$date = $unPatient['DATE_NAISSANCE'];
			if($date){ $date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}

			$html  = "<div style='width:100%;'>";
			
			$html  = "<div style='width:100%;'>";
				
 			$html .= "<div style='width: 18%; height: 190px; float:left;'>";
 			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='../img/photos_patients/" . $photo . "' ></div>";
 			$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
 			$html .= "</div>";
				
			$html .= "<div id='vuePatientAdmission' style='width: 70%; height: 190px; float:left;'>";
			$html .= "<table style='margin-top:0px; float:left; width: 100%;'>";
				
			$html .= "<tr style='width: 100%;'>";
			
			$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Numero dossier:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NUMERO_DOSSIER'] . "</p></div></td>";
			$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['DATE_NAISSANCE'] . "</p></div></td>";

			$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
				
			$html .= "<td style='width: 29%; '></td>";
			
				$html .= "</tr><tr style='width: 100%;'>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
				$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
					
				$html .= "</tr><tr style='width: 100%;'>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['NOM'] . "</p></div></td>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></div></td>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['SEXE'] . "</p></div></td>";
				
			
			$html .= "<td style='width: 30%; height: 50px;'>";
			
			if($RendezVOUS){
				$html .= "<span> <i style='color:green;'>
					        <span id='image-neon' style='color:red; font-weight:bold;'>Rendez-vous! </span> <br>
					        <span style='font-size: 16px;'>Service:</span> <span style='font-size: 16px; font-weight:bold;'> ". $pat->getServiceParId($RendezVOUS[ 'ID_SERVICE' ])[ 'NOM' ]." </span> <br>
					        <span style='font-size: 16px;'>Heure:</span>  <span style='font-size: 16px; font-weight:bold;'>". $RendezVOUS[ 'HEURE' ]." </span> </i>
			              </span>";
			}
				$html .= "</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
			
			$html .= "<div style='width: 12%; height: 190px; float:left;'>";
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:10px; margin-left:5px; margin-top:5px;'> <img style='width:105px; height:105px;' src='../img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
			


			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
 		}
 		//var_dump($formAdmission);exit();
		return array (
				'form' => $formAdmission
		);
	
	}
	

	public function infoPostnataleAction() {
		//var_dump('test');exit();
		$this->layout ()->setTemplate ( 'layout/postnatale' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
	
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
		$form = new ConsultationForm ();
	
		//var_dump($form);exit();
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
	
		$id_cons = $form->get ( "id_cons" )->getValue ();//var_dump($id_cons);exit();
		$postnatale = $this->getConsultationTable()->listePostnatale($id_pat);
		$nb= $this->getConsultationTable()->nbenf($id_pat);
	
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInformationPatient( $id_pat);
	
		return array (
				//'nb_enf'=>$nb,
				'donnees_pos'=>$postnatale,
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	}
	
	//visualiser le patient
	public function infoPatientAction() {
		//var_dump('test');exit();
		$this->layout ()->setTemplate ( 'layout/postnatale' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
	
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInfoPatient( $id_pat );
	
		return array (
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				//'id_patient' => $unPatient['ID_PERSONNE'],
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	}
	

	public function listeAdmissionAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->laListePatientsAjax();
		//$output = $patient->getListePatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function vuePatientAdmisAction(){
		$this->getDateHelper();
		$idPatient = (int)$this->params()->fromPost ('idPatient');
		$idAdmission = (int)$this->params()->fromPost ('idAdmission');
	
		$unPatient = $this->getPatientTable()->getInfoPatient($idPatient);
		$photo = $this->getPatientTable()->getPhoto($idPatient);
	
		$today = new \DateTime ();
		$dateAujourdhui = $today->format( 'Y-m-d' );
		$RendezVOUS = $this->getPatientTable ()->verifierRV($idPatient, $dateAujourdhui);
		$date = $unPatient['DATE_NAISSANCE'];
		//if($date){ $date = (new DateHelper())->convertDate ( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='../img/photos_patients/". $photo ."' ></div>";
		$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 70%; height: 180px; float:left;'>";
		$html .= "<table id='vuePatientAdmission' style='margin-top:10px; float:left'>";
	
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nmero dossier:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NUMERO_DOSSIER'] . "</p></div></td>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['DATE_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
		$html .= "<td style='width: 29%; '></td>";
	
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom  :</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" .$unPatient['NOM']  . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['SEXE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['ADRESSE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></div></td>";
		if($RendezVOUS){
			$html .= "<span> <i style='color:green;'>
					        <span id='image-neon' style='color:red; font-weight:bold;'>Rendez-vous! </span> <br>
					        <span style='font-size: 16px;'>Service:</span> <span style='font-size: 16px; font-weight:bold;'> ". $RendezVOUS[ 'NOM' ]." </span> <br>
					        <span style='font-size: 16px;'>Heure:</span>  <span style='font-size: 16px; font-weight:bold;'>". $RendezVOUS[ 'HEURE' ]." </span> </i>
			              </span>";
		}
	
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 12%; height: 180px; float:left; '>";
	
		$html .= "</div>";
			
		$html .= "</div>";
	
	
		$html .="<div id='barre_separateur'></div>";
	
		$html .="<table style='margin-top:10px; margin-left:18%; width: 80%; margin-bottom: 60px;'>";
	
		$html .="<tr style='width: 80%; '>";
		// $html .="<td style='width: 50%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Date d'admission </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $this->controlDate->convertDateTime($InfoAdmis->date_enregistrement) ." </p></td>";
	
		//$html .="<td style='width: 50%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Service </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-size:15px;'> ". $InfoService->nom ." </p></td>";
	
		//$html .="</tr>";
	
	
		$html .="</table>";
		$html .="<table style='margin-top:10px; margin-left:18%; width: 80%;'>";
		$html .="<tr style='width: 80%;'>";
	
		$html .="<td class='block' id='thoughtbot' style='width: 35%; display: inline-block;  vertical-align: bottom; padding-left:350px; padding-bottom: 15px; padding-right: 150px;'><button type='submit' id='terminer'>Terminer</button></td>";
	
		$html .="</tr>";
		$html .="</table>";
	
	
			
		$html .="<script>listepatient();
				  function FaireClignoterImage (){
                    $('#image-neon').fadeOut(900).delay(300).fadeIn(800);
                  }
                  setInterval('FaireClignoterImage()',2200);
	
				  $('#button_pdf').click(function(){
				     vart='/simens/public/facturation/impression-facture';
				     var formulaire = document.createElement('form');
			         formulaire.setAttribute('action', vart);
			         formulaire.setAttribute('method', 'POST');
			         formulaire.setAttribute('target', '_blank');
	
				     var champ = document.createElement('input');
				     champ.setAttribute('type', 'hidden');
				     champ.setAttribute('name', 'idAdmission');
				     champ.setAttribute('value', ".$idAdmission.");
				     formulaire.appendChild(champ);
	
				     formulaire.submit();
	              });
	
				  $('a,img,hass').tooltip({
                  animation: true,
                  html: true,
                  placement: 'bottom',
                  show: {
                    effect: 'slideDown',
                      delay: 250
                    }
                  });
	
				 </script>";
		//var_dump($photo);exit();
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($html));
	
	}
	public function listePatientAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/postnatale' );
		$view = new ViewModel ();
		return $view;
	}
	public function listePatientAjaxAction() {
		
		$output = $this->getPatientTable()->getListePatient();
		
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	public function getDateHelper()
	{
		$this->controlDate = new DateHelper ();
	}	
	public function convertDate($date) {
		$nouv_date = substr ( $date, 8, 2 ) . '/' . substr ( $date, 5, 2 ) . '/' . substr ( $date, 0, 4 );
		return $nouv_date;
	}
 
	public function modifierAction() {
		
		$control = new DateHelper();
		$this->layout ()->setTemplate ( 'layout/postnatale' );
		$id_patient = $this->params ()->fromRoute ( 'id_patient', 0 );
	
		$infoPatient = $this->getPatientTable ();
		try {
			$info = $infoPatient->getInfoPatient( $id_patient );
		} catch ( \Exception $ex ) {
			return $this->redirect ()->toRoute ( 'postnatale', array (
					'action' => 'liste-patient'
			) );
		}
		$form = new PatientForm();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($infoPatient->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($infoPatient->listeDeTousLesPays());
	
		$date_naissance = $info['DATE_NAISSANCE'];
		if($date_naissance){ $info['DATE_NAISSANCE'] =  $control->convertDate($info['DATE_NAISSANCE']); }else{ $info['DATE_NAISSANCE'] = null;}
	
		$form->populateValues ( $info );
	
		if (! $info['PHOTO']) {
			$info['PHOTO'] = "identite";
		}
		return array (
				'form' => $form,
				'photo' => $info['PHOTO']
		);
	}
public function enregistrementAction() {
		
		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connect�
	
		// CHARGEMENT DE LA PHOTO ET ENREGISTREMENT DES DONNEES
		if (isset ( $_POST ['terminer'] )||isset($_POST ['terminer_ad']))  // si formulaire soumis
		{
			$Control = new DateHelper();
			$form = new PatientForm();
			$Patient = $this->getPatientTable ();
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'dmy_His' );
			$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			$fileBase64 = substr ( $fileBase64, 23 );
	
			if($fileBase64){
				$img = imagecreatefromstring(base64_decode($fileBase64));
			}else {
				$img = false;
			}
	
			$date_naissance = $this->params ()->fromPost ( 'DATE_NAISSANCE' );
			if($date_naissance){ $date_naissance = $Control->convertDateInAnglais($this->params ()->fromPost ( 'DATE_NAISSANCE' )); }else{ $date_naissance = null;}
				
			$donnees = array(
					'LIEU_NAISSANCE' => $this->params ()->fromPost ( 'LIEU_NAISSANCE' ),
					'EMAIL' => $this->params ()->fromPost ( 'EMAIL' ),
					'NOM' => $this->params ()->fromPost ( 'NOM' ),
					'TELEPHONE' => $this->params ()->fromPost ( 'TELEPHONE' ),
					'NATIONALITE_ORIGINE' => $this->params ()->fromPost ( 'NATIONALITE_ORIGINE' ),
					'PRENOM' => $this->params ()->fromPost ( 'PRENOM' ),
					'PROFESSION' => $this->params ()->fromPost ( 'PROFESSION' ),
					'NATIONALITE_ACTUELLE' => $this->params ()->fromPost ( 'NATIONALITE_ACTUELLE' ),
					'DATE_NAISSANCE' => $date_naissance,
					'ADRESSE' => $this->params ()->fromPost ( 'ADRESSE' ),
					'SEXE' => $this->params ()->fromPost ( 'SEXE' ),
					'AGE' => $this->params ()->fromPost ( 'AGE' ),
					'DATE_MODIFICATION' => $today->format ( 'Y-m-d' ),
					//'NUMERO_DOSSIER' => $this->params ()->fromPost ( 'NUMERO_DOSSIER' ),
			);
			
			
			
			if ($img != false) {
	
				$donnees['PHOTO'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, 'C:\wamp64\www\simens-maternite\public\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
			
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				//var_dump('test');exit();
				if (isset($_POST ['terminer'])){
					
						
				return $this->redirect ()->toRoute ( 'postnatale', array (
						'action' => 'liste-patient'
				) );}
				if (isset($_POST ['terminer_ad'])){
					return $this->redirect ()->toRoute ( 'postnatale', array (
							'action' => 'admission'	
					));
					
				}
			} else {
			
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				
			if (isset($_POST ['terminer'])){
				return $this->redirect ()->toRoute ( 'postnatale', array (
						'action' => 'liste-patient'
				) );}
				if (isset($_POST ['terminer_ad'])){
					return $this->redirect ()->toRoute ( 'postnatale', array (
							'action' => 'admission'
					) );
					
					
				}
			
			
			}
		}

		return $this->redirect ()->toRoute ( 'postnatale', array (
				'action' => 'liste-patient'
		) );
	}
	
	public function listeDesPostnatalesAction() {
		
	$layout = $this->layout ();
		$layout->setTemplate ( 'layout/postnatale' );
		//$output = $this->getPatientTable()->getPatientPostnatale();
		//var_dump($output);exit();
		$view = new ViewModel ();
		
		return $view;
	}

	
	
	
	public function listeDesPostnatalesAjaxAction() {
		$id_pat = $this->params()->fromQuery('id_patient', 0);
		
		$output = $this->getPatientTable()->getPatientPostnatale();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}

	
public function complementPostnataleAction()
	{
		$this->layout()->setTemplate('layout/postnatale');
	
		$user = $this->layout()->user;
		$IdDuService = $user ['IdService'];
		$id_medecin = $user ['id_personne'];
		$this->getDateHelper();
		$id_pat = $this->params()->fromQuery('id_patient', 0);
		$id = $this->params()->fromQuery('id_cons');
		$inf=$this->getConsultationTable()->infpat($id_pat, $id);
		//var_dump($id);exit();
		$id_admi = $this->params()->fromQuery('id_admission', 0);
		$listeMedicament = $this->getConsultationTable()->listeDeTousLesMedicaments();
		
		$listeForme = $this->getConsultationTable()->formesMedicaments();
		$listetypeQuantiteMedicament = $this->getConsultationTable()->typeQuantiteMedicaments();
		
		
		$Naissances = $this->getNaissanceTable()->getEnf($id);		
		
		$nombre=count($Naissances);
		$Nouveau = $this->getDevenirNouveauNeTable()->getDevenu($id);
		//$listesDecesMaternel = $this->conclusionTable()->getCausesDeces($id);
		$tabNv=array();$j=1;
		$tabEnf=array();$k=1;
		//var_dump($this->Nouveau));exit();
foreach ($Naissances as $enfant){
	$tabEnf['sexe_'.$k]=$enfant['sexe'];
	$tabEnf['n_sexe_'.$k]=$enfant['note_sexe'];
	$tabEnf['poids_'.$k]=$enfant['poids'];
	$tabEnf['n_poids_'.$k]=$enfant['note_poids'];
	$tabEnf['taille_'.$k]=$enfant['taille'];
	$tabEnf['n_taille_'.$k]=$enfant['note_taille'];
	$tabEnf['cri_'.$k]=$enfant['cri'];
	$tabEnf['n_cri_'.$k]=$enfant['note_cri'];
	$tabEnf['malf_'.$k]=$enfant['malf'];
	$tabEnf['n_malf_'.$k]=$enfant['note_malf'];
	$tabEnf['sat_'.$k]=$enfant['sat'];
	$tabEnf['n_sat_'.$k]=$enfant['note_sat'];
	$tabEnf['vitk_'.$k]=$enfant['vit_k'];
	$tabEnf['n_vitk_'.$k]=$enfant['note_vitk'];
	$tabEnf['mt_'.$k]=$enfant['maintien_temp'];
	$tabEnf['n_mt_'.$k]=$enfant['note_temp'];
	$tabEnf['msp_'.$k]=$enfant['mise_soin_precoce'];
	$tabEnf['n_msp_'.$k]=$enfant['note_soin_precoce'];
	$tabEnf['sc_'.$k]=$enfant['soin_cordon'];
	$tabEnf['n_sc_'.$k]=$enfant['note_cordon'];
	$tabEnf['reanim_'.$k]=$enfant['reanimation'];
	$tabEnf['n_reanim_'.$k]=$enfant['note_reanim'];
	$tabEnf['collyre_'.$k]=$enfant['collyre'];
	$tabEnf['n_collyre_'.$k]=$enfant['note_collyre'];
	$tabEnf['vpo_'.$k]=$enfant['vpo'];
	$tabEnf['n_vpo_'.$k]=$enfant['note_vpo'];
	$tabEnf['antiT_'.$k]=$enfant['anti_tuberculeux'];
	$tabEnf['n_antiT_'.$k]=$enfant['note_tuberculeux'];
	$tabEnf['bcg_'.$k]=$enfant['bcg'];
	$tabEnf['n_bcg_'.$k]=$enfant['note_bcg'];
	$tabEnf['anti_hepa_'.$k]=$enfant['anti_hepatique'];
	$tabEnf['n_anti_hepa_'.$k]=$enfant['note_hepa'];
	$tabEnf['autre_vacc_'.$k]=$enfant['autre_vacc'];
	$tabEnf['type_autre_vacc_'.$k]=$enfant['type_autre_vacc'];
	$tabEnf['n_autre_vacc_'.$k]=$enfant['note_autre_vacc'];
	$tabEnf['cranien_'.$k]=$enfant['perim_cranien'];
	$tabEnf['cephalique_'.$k]=$enfant['perim_cephalique'];
	$tabEnf['brachial_'.$k]=$enfant['perim_brachial'];
	$tabEnf['n_perim_'.$k]=$enfant['note_perim'];
	$tabEnf['apgar1_'.$k]=$enfant['apgar_1'];
	$tabEnf['apgar5_'.$k]=$enfant['apgar_5'];
	$tabEnf['n_apgar_'.$k]=$enfant['note_apgar'];
	$tabEnf['consj1j2_'.$k]=$enfant['consult_j1_j2'];
	$k++;		
	
}

foreach ($Nouveau as $Nv){
	$tabNv['viv_bien_portant_'.$j]=$Nv['viv_bien_portant'];
	$tabNv['n_viv_bien_portant_'.$j]=$Nv['note_viv_bien_portant'];
	$tabNv['viv_mal_form_'.$j]=$Nv['viv_mal_formation'];
	$tabNv['n_viv_mal_form_'.$j]=$Nv['note_viv_mal_formation'];
	$tabNv['malade_'.$j]=$Nv['malade'];
	$tabNv['n_malade_'.$j]=$Nv['note_malade'];
	$tabNv['decede_'.$j]=$Nv['decede'];
	$tabNv['date_deces_'.$j]=$Nv['date_deces'];
	$tabNv['heure_deces_'.$j]=$Nv['heure_deces'];
	$tabNv['cause_deces_'.$j]=$Nv['cause_deces'];
	$j++;
}

//var_dump($tabNv);exit();
         $liste = $this->getConsultationTable()->getInfoPatient($id_pat);
		$id_admission=$liste['id_admission'];

		// instancier la consultation et r�cup�rer l'enregistrement
		$consult = $this->getConsultationTable()->getConsult($id);
		$pos = strpos($consult->pression_arterielle, '/');
		$tensionmaximale = substr($consult->pression_arterielle, 0, $pos);
		$tensionminimale = substr($consult->pression_arterielle, $pos + 1);		
		
		// POUR LES HISTORIQUES OU TERRAIN PARTICULIER

		// *** Liste des consultations
		$listeConsultation = $this->getConsultationTable()->getConsultationPatient($id_pat, $id);		
		
		$image = $this->getConsultationTable()->getPhoto($id_pat);
		$this->getDateHelper();
		$donne_ante=$this->getAntecedentType1Table()->getAntecedentType1($id_pat);
		$donne_ante2=$this->getAntecedentType2Table()->getAntecedentType2($id);
		$donne_grossesses=$this->getGrossesseTable()->getGrossesse($id_pat,$id);
		$avortement=$this->getGrossesseTable()->getAvortement($id);		
		
		$donne_examen=$this->getDonneesExamensPhysiquesTable()->getExamensPhysiques($id);
		 $date_rupt_pde = $this->controlDate->convertDate( $donne_examen['date_rupt_pde']);
		 //var_dump($id);exit();
		$donne_accouchement=$this->getAccouchementTable()->getAccouchement($id);
		
		// var_dump($donne_accouchement);exit();
			// recuperer le mois dans la date
		 	
		$date = $donne_accouchement['date_accouchement'];
		
		
		 $donne_prenome=$this->getAccouchementTable()->getPrenomme($donne_accouchement['id_accouchement']);
		// var_dump($donne_prenome);exit();
		 $date_accouchement = $this->controlDate->convertDate( $donne_accouchement['date_accouchement']);
		$form = new ConsultationForm ();		
		
		//var_dump($form);exit();
		$donne_ant1=array(
					
				'enf_viv'=>$donne_ante['enf_viv'],
				'geste'=>$donne_ante['geste'],
				//'parite'=>$donne_ante['parite'],
				'note_enf'=>$donne_ante['note_enf'],
				'note_geste'=>$donne_ante['note_geste'],
				'note_parite'=>$donne_ante['note_parite'],
				'mort_ne'=>$donne_ante['mort_ne'],
				'note_mort_ne'=>$donne_ante['note_mort_ne'],
				'cesar'=>$donne_ante['cesar'],
				'note_cesar'=>$donne_ante['note_cesar'],
				'groupe_sanguins'=>$donne_ante['groupe_sanguin'],
				'rhesus'=>$donne_ante['rhesus'],
				'note_gs'=>$donne_ante['note_gs'],
				'test_emmel'=>$donne_ante['test_emmel'],
				'profil_emmel'=>$donne_ante['profil_emmel'],
				'note_emmel'=>$donne_ante['note_emmel'],
				
			
					
		);	
		
		$form->populateValues($donne_ant1);
		
		$donne_antecedent2=array(
				'dystocie'=>$donne_ante2['dystocie'],
				'eclampsie'=>$donne_ante2['eclampsie'],
				'regularite'=>$donne_ante2['cycle'],
				'quantite_regle'=>$donne_ante2['quantite_regle'],
				'duree_cycle'=>$donne_ante2['duree_cycle'],
				'note_dystocie'=>$donne_ante2['note_dystocie'],
				'note_eclampsie'=>$donne_ante2['note_eclampsie'],
				'autre_go'=>$donne_ante2['autre_go'],
				'note_autre_go'=>$donne_ante2['note_autre'],
				'nb_garniture_jr'=>$donne_ante2['nb_garniture_jr'],
				'contraception'=>$donne_ante2['contraception'],
				'type_contraception'=>$donne_ante2['type_contraception'],
				'duree_contraception'=>$donne_ante2['duree_contraception'],
				'note_contraception'=>$donne_ante2['note_contraception'],
		);//var_dump($donne_antecedent2);exit();
		
		$form->populateValues($donne_antecedent2);
		
		
		
	
	
		// recuperer le mois dans la date
		//$date = "04/30/1973";
		//list($month, $day, $year) = explode('/', $date);
		//echo "Mois : $month; Jour : $day; Ann�e : $year<br />\n";
	//var_dump($month);exit();
		
		
		
		
		
	
		$donne_examenp=array(
				
					'examen_maternite_donnee1' => $donne_examen ['toucher_vaginale'],
						'examen_maternite_donnee2' => $donne_examen ['hauteur_uterine'],
						'examen_maternite_donnee3' => $donne_examen ['bdc'],			
						'examen_maternite_donnee5' => $donne_examen ['pde'],
						'examen_maternite_donnee6' => $date_rupt_pde,
						'examen_maternite_donnee7' => $donne_examen ['heure_rupt_pde'],
						'examen_maternite_donnee8' => $donne_examen['id_pres'],
						'examen_maternite_donnee9' => $donne_examen ['bassin'],
						'examen_maternite_donnee10' => $donne_examen ['nb_bdc'],
						'note_tv' => $donne_examen ['note_tv'],
						'note_hu' => $donne_examen ['note_hu'],
						'note_bdc' => $donne_examen ['note_bdc'],
						'note_bassin' => $donne_examen ['note_bassin'],
						'examen_maternite_donnee11' => $donne_examen ['aspect'],
		);//var_dump($donne_examenp);exit();
		$form->populateValues($donne_examenp);
		$today = new \DateTime ( "now" );
		$date_numero = $today->format ( 'Y-m-d' );
		
        $numeroOrdre = $this->getPatientTable()->getNumeroOrdre( $date_numero,"3" );
		$suivant = array(
				'numeroOrdre'=>$numeroOrdre,
			
		);
		
		$form->populateValues($suivant); 
		
	//var_dump($numeroOrdre);exit();
		
		
	 	$postnatale=$this->getPostnataleTable()->getPostnatale($id);
		$donne_postnatale=array(
				'parite'=>$postnatale['parite'],
				'lieu_accouchement'=>$postnatale['lieu_accouchement'],
				'type_accouchement'=>$postnatale['type_accouchement'],
				'etat_de_la_mere'=>$postnatale['etat_de_la_mere'],
				
				
					
		);
		$form->populateValues($donne_postnatale); 
		//var_dump($donne_postnatale);exit();
		$Control = new DateHelper();
		
		$postnatale=$this->getRangCponTable()->getCpon($id);
		$date_intervalle1 = $Control->convertDate($postnatale['date_intervalle1']);
		
		
		$info_datecpon = array(
				'intervalle1' => $this->params()->fromPost('intervalle1'),
				'intervalle2' => $this->params()->fromPost('intervalle2'),
				'intervalle3' => $this->params()->fromPost('intervalle3'),
				'date_intervalle1' => $date_intervalle1,
				'date_intervalle2' => $this->params()->fromPost('date_intervalle2'),
				'date_intervalle3' => $this->params()->fromPost('date_intervalle3'),
				'details' => $this->params()->fromPost('details'),
		
		
				//'ID_CONS' => $id_cons
		);
		
		$form->populateValues($info_datecpon);

		$donnees_accouchement=array(
		
					'type_accouchement' => $donne_accouchement['id_type'],					
 					'motif_type' => $donne_accouchement['motif_type'],
 					'date_accouchement' => $date_accouchement,
					'heure_accouchement' => $donne_accouchement['heure_accouchement'],
 					'delivrance' => $donne_accouchement['delivrance'],
					'ru' => $donne_accouchement['ru'],
					'quantite_hemo' => $donne_accouchement['quantite_hemo'],
					'hemoragie' => $donne_accouchement['hemoragie'],
					'ocytocique_per' => $donne_accouchement['ocytocique_per'],
					'ocytocique_post' => $donne_accouchement['ocytocique_post'],
					'antibiotique' => $donne_accouchement['antibiotique'],
					'anticonvulsant' => $donne_accouchement ['anticonvulsant'],
					'transfusion' => $donne_accouchement['transfusion'],
					'note_delivrance' => $donne_accouchement['note_delivrance'],
					'note_hemorragie' => $donne_accouchement['note_hemorragie'],
					'text_observation' => $donne_accouchement['text_observation'],
					'suite_de_couches' => $donne_accouchement['suite_de_couche'],
					'note_ocytocique' => $donne_accouchement['note_ocytocique'],
					'note_antibiotique' => $donne_accouchement['note_antibiotique'],
					'note_anticonv' => $donne_accouchement['note_anticonv'],
					'note_transfusion' => $donne_accouchement['note_transfusion'],	
		);//
		$form->populateValues($donnees_accouchement);
		
		$donne_pre=array(
				'prenome'=>$donne_prenome['prenomme']
				
		);//var_dump($donne_antecedent2);exit();
		
		$form->populateValues($donne_pre);
	$type_admission = $this->getConsultationTable()->RecuperTousLesIdAdmis($inf['id_admission']);
		//var_dump($type_admission['motif_admission']);exit();
  		if($type_admission['type_admission']=='Normal'){
 			$form->get('motif_ad')->setValue($type_admission['type_admission']);
 			
  		}
	   
		else{
				$form->get('motif_ad')->setValue($type_admission['motif_admission']);
			$form->get('motif')->setValue($type_admission['motif_transfert_evacuation']);
			$form->get('service_origine')->setValue($type_admission['service_dorigine']);
			
		}
	$liste_pres = $this->getDonneesExamensPhysiquesTable ()->listePresentation ();
	
		$tab_pres = $liste_pres ;
		$form->get('examen_maternite_donnee8')->setValueOptions($tab_pres);
		
		
		//pour la presentation du foetus
		$liste_type = $this->getTypeAccouchementTable ()->listeTypeAccouchement ();
		
		$afficheTous = array ("" => 'Selectionnez un Type');
		//	var_dump($liste_type);exit();
		$tab_type = $liste_type ;
		$form->get('type_accouchement')->setValueOptions($tab_type);
		
		
		
		
		// instancier la consultation et r�cup�rer l'enregistrement
		$consult = $this->getConsultationTable()->getConsult($id);
		$pos = strpos($consult->pression_arterielle, '/');
		$tensionmaximale = substr($consult->pression_arterielle, 0, $pos);
		$tensionminimale = substr($consult->pression_arterielle, $pos + 1);		
		
		// POUR LES HISTORIQUES OU TERRAIN PARTICULIER

		// *** Liste des consultations
		$listeConsultation = $this->getConsultationTable()->getConsultationPatient($id_pat, $id);
	
	/* 	// Liste des examens biologiques
		$listeDesExamensBiologiques = $this->demandeExamensTable()->getDemandeDesExamensBiologiques();
		$listeDesComplication = $this->conclusionTable()->getComplicationObstetricale();
		$listeDesCauseDeces = $this->conclusionTable()->getCauseDecesMaternel(); */
		// Liste des examens Morphologiques
		
		//$listeDesExamensMorphologiques = $this->demandeExamensTable()->getDemandeDesExamensMorphologiques();
		
		
		// *** Liste des Hospitalisations
		$listeHospitalisation = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdPatient($id_pat);
		$infoDiagnostics = $this->getDiagnosticsTable()->getDiagnostics($id);
		// POUR LES DIAGNOSTICS
		$k = 1;$tabdiagons=array();
		foreach ($infoDiagnostics as $diagnos) {
			$tabdiagons ['diagnostic' . $k] = $diagnos ['libelle_diagnostics'];
			//$data ['decisions']=$diagnos['decision'];
			$k++;
		}
		$Decision = $this->getDiagnosticsTable()->getDecision($id);
		$donne_dec=array(
				'decisions'=>$Decision['decision']
		
		);
		
		$form->populateValues($donne_dec);

		// POUR LE TRANSFERT
		// INSTANCIATION DU TRANSFERT
		// RECUPERATION DE LA LISTE DES HOPITAUX
		$hopital = $this->getTransfererPatientServiceTable()->fetchHopital();
		
		// LISTE DES HOPITAUX
	 	$form->get('hopital_accueil')->setValueOptions($hopital);
		// RECUPERATION DU SERVICE OU EST TRANSFERE LE PATIENT
		$transfertPatientService = $this->getTransfererPatientServiceTable()->getServicePatientTransfert($id);
		
		if ($transfertPatientService) {
			$idService = $transfertPatientService ['ID_SERVICE'];
			// RECUPERATION DE L'HOPITAL DU SERVICE
			$transfertPatientHopital = $this->getTransfererPatientServiceTable()->getHopitalPatientTransfert($idService);
			$idHopital = $transfertPatientHopital ['ID_HOPITAL'];
			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU IL EST TRANSFERE
			$serviceHopital = $this->getTransfererPatientServiceTable()->fetchServiceWithHopital($idHopital);
		
			// LISTE DES SERVICES DE L'HOPITAL
			 $form->get('service_accueil')->setValueOptions($serviceHopital);
			// SELECTION DE L'HOPITAL ET DU SERVICE SUR LES LISTES
			$data ['hopital_accueil'] = $idHopital;
			$data ['service_accueil'] = $idService;
			$data ['motif_transfert'] = $transfertPatientService ['MOTIF_TRANSFERT'];
			$hopitalSelect = 1;
		} else {
				
			$hopitalSelect = 0;
			// RECUPERATION DE L'HOPITAL DU SERVICE
			$transfertPatientHopital = $this->getTransfererPatientServiceTable()->getHopitalPatientTransfert($IdDuService);
			$idHopital = $transfertPatientHopital ['ID_HOPITAL'];
			$data ['hopital_accueil'] = $idHopital;
			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
			$serviceHopital = $this->getTransfererPatientServiceTable()->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
			// LISTE DES SERVICES DE L'HOPITAL
			$form->get('service_accueil')->setValueOptions($serviceHopital);
		}
		
		$data = array(
			
				'id_cons' => $consult->id_cons,
				'id_medecin' => $id_medecin,
				'id_patient' => $consult->id_patient,
				'date_cons' => $consult->date,
				'tensionmaximale' => $tensionmaximale,
				'tensionminimale' => $tensionminimale,
				'glycemie_capillaire' => $consult->glycemie_capillaire,
				'temperature' => $consult->temperature,
				'paleur' => $consult->paleur,
				'pouls' => $consult->pouls,
				'poids' => $consult->poids,
				
				'pressionarterielle' => $consult->pression_arterielle,
				//'hopital_accueil' => $idHopital,		
				'id_admission' => $id_admission,
				
		);			
				
		$donneesHospi = $this->getDemandeHospitalisationTable()->getDemandehospitalisationParIdcons($id);
		if ($donneesHospi) {
			$data ['motif_hospitalisation'] = $donneesHospi->motif_demande_hospi;
			$data ['date_fin_hospitalisation_prevue'] = $this->controlDate->convertDate($donneesHospi->date_fin_prevue_hospi);
		}
	
	   // var_dump($data);exit();
		$leRendezVous = $this->getRvPatientConsTable()->getRendezVous($id);
		//$heure= array(	$leRendezVous->heure);
	 
		if ($leRendezVous) {
			$data ['heure_rv'] = $leRendezVous->heure;
			$data ['date_rv'] = $this->controlDate->convertDate($leRendezVous->date);
			$data ['motif_rv'] = $leRendezVous->note;
		}
		
		// date cpon
		$laDateCpon = $this->getRvPatientConsTable()->getDateCpon($id);
		
		if ($laDateCpon) {
				
			$data ['j1_j3'] = $this->controlDate->convertDate($laDateCpon->date);
			$data ['j4_j8'] = $this->controlDate->convertDate($laDateCpon->date);
			$data ['j9_j16'] = $this->controlDate->convertDate($laDateCpon->date);
			$data ['j16_j41'] = $this->controlDate->convertDate($laDateCpon->date);
			$data ['j42'] = $this->controlDate->convertDate($laDateCpon->date);
				
				
					}
					//var_dump('test');exit();
						
		
		$Tranfer = $this->getTransfererPatientServiceTable()->getServicePatientTransfert($id);
			if ($Tranfer) {
			$data ['motif_transfert'] = $Tranfer['MOTIF_TRANSFERT'];
			$data ['service_accueil'] = $Tranfer['ID_SERVICE'];
		}
		
		if ($leRendezVous) {
			$data ['heure_rv'] = $leRendezVous->heure;
			$data ['date_rv'] = $this->controlDate->convertDate($leRendezVous->date);
			$data ['motif_rv'] = $leRendezVous->note;
		}
		
		
		// Pour recuper les bandelettes
		$bandelettes = $this->getConsultationTable()->getBandelette($id);
		
		// RECUPERATION DES ANTECEDENTS
		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		$donneesAntecedentsFamiliaux = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);

			// Recuperer les antecedents medicaux ajouter pour le patient
		$antMedPat = $this->getConsultationTable()->getAntecedentMedicauxPersonneParIdPatient($id_pat);
	
		// Recuperer les antecedents medicaux
		// Recuperer les antecedents medicaux
		$listeAntMed = $this->getConsultationTable()->getAntecedentsMedicaux();
		// //RESULTATS DES EXAMENS MORPHOLOGIQUE
		$examen_morphologique = $this->getNotesExamensMorphologiquesTable()->getNotesExamensMorphologiques($id);
		
		$data ['radio'] = $examen_morphologique ['radio'];
		$data ['ecographie'] = $examen_morphologique ['ecographie'];
		$data ['fibrocospie'] = $examen_morphologique ['fibroscopie'];
		$data ['scanner'] = $examen_morphologique ['scanner'];
		$data ['irm'] = $examen_morphologique ['irm'];
		

		
		$form->populateValues(array_merge($data,$tabdiagons, $bandelettes, $donneesAntecedentsPersonnels, $donneesAntecedentsFamiliaux));
		////var_dump('test');exit();
		
		return array(
				'lesdetails' => $liste,
				'id_cons' => $id,
				
				'image' => $image,
				'form' => $form,
				'heure_cons' => $consult->heurecons,
				'dateonly' => $consult->dateonly,
				'liste_med' => $listeMedicament,
				'temoin' => $bandelettes ['temoin'],
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament' => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux' => $donneesAntecedentsFamiliaux,
				'liste' => $listeConsultation,
				'nbDiagnostics'=> $infoDiagnostics->count(),
				//'resultRV' => $resultRV,
				'listeHospitalisation' => $listeHospitalisation,
				
				  'Naissances'   =>$tabEnf,
				'Nouveau'   =>$tabNv,
				 'nombre_enf' => $nombre,
				//'listesDecesMaternel'=>$listesDecesMaternel,
				//'listeDesExamensMorphologiques' => $listeDesExamensMorphologiques,
				'listeAntMed' => $listeAntMed,
				'antMedPat' => $antMedPat,
				'nbAntMedPat' => $antMedPat->count(),
				
		);		
				

	}
	
	public function updateComplementPostnataleAction()
	{
		$this->layout()->setTemplate('layout/postnatale');
		$this->getDateHelper();
		$Control = new DateHelper();
		$user = $this->layout()->user;
		$IdDuService = $user ['IdService'];
		$id_medecin = $user ['id_personne'];
		$this->getDateHelper();
		$id_pat = $this->params()->fromQuery('id_patient', 0);
		$id = $this->params()->fromPost('id_cons');
		var_dump($id);
		$id_admission = $this->params()->fromQuery('id_admission', 0);
		
		$id_accouchement = $this->params()->fromPost('$id_accouchement');
		$form = new ConsultationForm ();
		$formData = $this->getRequest()->getPost();
		$form->setData($formData);
		//var_dump($id);exit();
		      
		
		// **********-- MODIFICATION DES CONSTANTES --********
		// **********-- MODIFICATION DES CONSTANTES --********
		// **********-- MODIFICATION DES CONSTANTES --********
	
		// les antecedents medicaux du patient a ajouter addAntecedentMedicauxPersonne
		$this->getConsultationTable()->addAntecedentMedicaux($formData);
		$this->getConsultationTable()->addAntecedentMedicauxPersonne($formData);
		// $this->getMotifAdmissionTable()->deleteMotifAdmission($id_cons);
	
		
		$this->getConsultationTable()->updateLesConsultation($form);
		//var_dump($form);exit();
		// Recuperer les donnees sur les bandelettes urinaires
		// Recuperer les donnees sur les bandelettes urinaires
		$bandelettes = array(
				'id_cons' => $id,
				'albumine' => $this->params()->fromPost('albumine'),
				'sucre' => $this->params()->fromPost('sucre'),
				'corpscetonique' => $this->params()->fromPost('corpscetonique'),
				'croixalbumine' => $this->params()->fromPost('croixalbumine'),
				'croixsucre' => $this->params()->fromPost('croixsucre'),
				'croixcorpscetonique' => $this->params()->fromPost('croixcorpscetonique')
		);
		// mettre a jour les bandelettes urinaires
		$this->getConsultationTable()->deleteBandelette($id);
		$this->getConsultationTable()->addBandelette($bandelettes);
		
		//$id_grossesse= $this->getGrossesseTable()->updateGrossesse($formData);
	
		//$id_accouchement=$this->getAccouchementTable()->updateAccouchement($id_cons, $id_grossesse);
		//$this->getGrossesseTable()->updateAvortement($formData,$id_cons,$id_grossesse);
		//$this->getConsultationMaterniteTable()->addConsultationMaternite($id_cons,$id_grossesse);
		
		$datadonnee = array (
				'id_cons' => $this->params()->fromPost ('id_cons'),
				'id_patient' => $this->params()->fromPost('id_patient'),
				'enf_viv' => $this->params()->fromPost('enf_viv'),
				'parite' => $this->params()->fromPost ('parite'),
				'geste' => $this->params()->fromPost ('geste'),
				'note_enf' => $this->params()->fromPost('note_enf'),
				'note_parite' => $this->params()->fromPost ('note_parite'),
				'note_geste' => $this->params()->fromPost('note_geste'),
				'mort_ne' => $this->params()->fromPost ('mort_ne'),
				'note_mort_ne' => $this->params()->fromPost ('note_mort_ne'),
				'cesar' => $this->params()->fromPost ('cesar'),
				'note_cesar' => $this->params()->fromPost ('note_cesar'),
				'groupe_sanguin' => $this->params()->fromPost ('groupe_sanguins'),
				'rhesus' => $this->params()->fromPost ('rhesus'),
				'note_gs' => $this->params()->fromPost ('note_gs'),
				'test_emmel' => $this->params()->fromPost ('test_emmel'),
				'profil_emmel' => $this->params()->fromPost ('profil_emmel'),
				'avortement' => $this->params()->fromPost ('avortement'),
				'note_avortement' => $this->params()->fromPost ('note_avortement'),
				'allaitement' => $this->params()->fromPost ('allaitement'),
				'note_allaitement' => $this->params()->fromPost ('note_allaitement'),
				'age' => $this->params()->fromPost ('age'),
				'regularite' => $this->params()->fromPost ('regularite'),
				'note_emmel' => $this->params()->fromPost ('note_emmel')
				 
		
		);
		
		// var_dump($formData['prenome']); exit();
		//$enfant=$formData['nombre_enfant'];
	
		//$tab_bebes = $this->getNaissanceTable()->saveNaissance($formData,$id_cons,$id_patient,$id_accouchement);
	
		//$this->getDevenirNouveauNeTable()->saveNouveauNe($formData, $id_cons, $tab_bebes);
		 
		//var_dump('test');exit();
	
		//Nouveau ne
	
		//pour les conclusion: complication et deces maternel
		$nombre_cause = $this->params()->fromPost('nb_comp');
		$nombre_causeDC = $this->params()->fromPost('nbcauseDC');
		//$this->conclusionTable()->updateConclusionComp($formData, $id_cons,$nombre_cause,$id_patient);
		
		//$this->conclusionTable()->updateConclusionDeces($formData, $id_cons,$nombre_causeDC,$id_patient);
		// POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
		// POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
		// POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
	
		$donneesDesAntecedents = array(
				// **=== ANTECEDENTS PERSONNELS
				// **=== ANTECEDENTS PERSONNELS
				// LES HABITUDES DE VIE DU PATIENTS
				/* Alcoolique */
				'AlcooliqueHV' => $this->params()->fromPost('AlcooliqueHV'),
				'DateDebutAlcooliqueHV' => $this->params()->fromPost('DateDebutAlcooliqueHV'),
				'DateFinAlcooliqueHV' => $this->params()->fromPost('DateFinAlcooliqueHV'),
				/*Fumeur*/
				'FumeurHV' => $this->params()->fromPost('FumeurHV'),
				'DateDebutFumeurHV' => $this->params()->fromPost('DateDebutFumeurHV'),
				'DateFinFumeurHV' => $this->params()->fromPost('DateFinFumeurHV'),
				'nbPaquetFumeurHV' => $this->params()->fromPost('nbPaquetFumeurHV'),
				'AutresHV' => $this->params()->fromPost('AutresHV'),
				'NoteAutresHV' => $this->params()->fromPost('NoteAutresHV'),
				/*Droguer*/
		'DroguerHV' => $this->params()->fromPost('DroguerHV'),
		'DateDebutDroguerHV' => $this->params()->fromPost('DateDebutDroguerHV'),
		'DateFinDroguerHV' => $this->params()->fromPost('DateFinDroguerHV'),
	
		// LES ANTECEDENTS MEDICAUX
		'DiabeteAM' => $this->params()->fromPost('DiabeteAM'),
		'htaAM' => $this->params()->fromPost('htaAM'),
		'drepanocytoseAM' => $this->params()->fromPost('drepanocytoseAM'),
		'dislipidemieAM' => $this->params()->fromPost('dislipidemieAM'),
		'asthmeAM' => $this->params()->fromPost('asthmeAM'),
	
		// **=== ANTECEDENTS FAMILIAUX
		'DiabeteAF' => $this->params()->fromPost('DiabeteAF'),
		'NoteDiabeteAF' => $this->params()->fromPost('NoteDiabeteAF'),
		'DrepanocytoseAF' => $this->params()->fromPost('DrepanocytoseAF'),
		'NoteDrepanocytoseAF' => $this->params()->fromPost('NoteDrepanocytoseAF'),
		'htaAF' => $this->params()->fromPost('htaAF'),
		'NoteHtaAF' => $this->params()->fromPost('NoteHtaAF'),
		'NoteAutresAF' => $this->params()->fromPost('NoteAutresAF'),
		'text_chirur' => $this->params()->fromPost('text_chirur')
	
		);
		
		//var_dump($donneesDesAntecedents);exit();
		$id_personne = $this->getAntecedantPersonnelTable()->getIdPersonneParIdCons($id);
		$this->getAntecedantPersonnelTable()->addAntecedentsPersonnels($donneesDesAntecedents, $id_personne, $id_medecin);
		$this->getAntecedantsFamiliauxTable()->addAntecedentsFamiliaux($donneesDesAntecedents, $id_personne, $id_medecin);
		// POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		// POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		// POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
	
		$info_examen_morphologique = array(
				'id_cons' => $id,
				'8' => $this->params()->fromPost('radio_'),
				'9' => $this->params()->fromPost('ecographie_'),
				'12' => $this->params()->fromPost('irm_'),
				'11' => $this->params()->fromPost('scanner_'),
				'10' => $this->params()->fromPost('fibroscopie_')
		);
	
		$this->getNotesExamensMorphologiquesTable()->updateNotesExamensMorphologiques($info_examen_morphologique);
	
	
	
	
		$info_examen_biologique = array(
				'id_cons' => $id,
				'1' => $this->params()->fromPost('groupe_sanguin'),
				'2' => $this->params()->fromPost('hemogramme_sanguin'),
				'3' => $this->params()->fromPost('bilan_hemolyse'),
				'4' => $this->params()->fromPost('bilan_hepatique'),
				'5' => $this->params()->fromPost('bilan_renal'),
				'6' => $this->params()->fromPost('bilan_inflammatoire')
		);
		// var_dump($info_examen_biologique);exit();
		//$this->getNotesExamensBiologiqueTable()->updateNotesExamensBiologiques($info_examen_biologique);
	
		// POUR LES DIAGNOSTICS
		// POUR LES DIAGNOSTICS
		// POUR LES DIAGNOSTICS
		$info_diagnostics = array(
				'id_cons' => $id,
				'diagnostic1' => $this->params()->fromPost('diagnostic1'),
				'diagnostic2' => $this->params()->fromPost('diagnostic2'),
				'diagnostic3' => $this->params()->fromPost('diagnostic3'),
				'diagnostic4' => $this->params()->fromPost('diagnostic4'),
		);
	
		
		$id_diagn= $this->getDiagnosticsTable()->updateDiagnostics($info_diagnostics);
		
		$decision=$this->params()->fromPost('decisions');
		
		//$this->getDiagnosticsTable()->addDecision($decision,$id_cons);
		
		// POUR LES TRAITEMENTS
		// POUR LES TRAITEMENTS
		// POUR LES TRAITEMENTS
		/**
		 * ** MEDICAUX ***
		*/
		/**
		 * ** MEDICAUX ***
		*/
		$dureeTraitement = $this->params()->fromPost('duree_traitement_ord');
		$donnees = array(
				'id_cons' => $id,
				'duree_traitement' => $dureeTraitement
		);
		//$Consommable = $this->getOrdonConsommableTable();
		
        
				
	
		
		
		
		// POUR LES RENDEZ VOUS
        // POUR LES RENDEZ VOUS
        // POUR LES RENDEZ VOUS
        
        $id_patient = $this->params()->fromPost('id_patient');
        $date_RV_Recu = $this->params()->fromPost('date_rv');
        if ($date_RV_Recu) {
            $date_RV = $this->controlDate->convertDateInAnglais($date_RV_Recu);
        } else {
            $date_RV = $date_RV_Recu;
        }
        $infos_rv = array(
            'ID_CONS' => $id,
            'NOTE' => $this->params()->fromPost('motif_rv'),
            'HEURE' => $this->params()->fromPost('heure_rv'),
            'DATE' => $date_RV
        );
        $this->getRvPatientConsTable()->updateRendezVous($infos_rv);
       
		// POUR LES TRANSFERT




		// POUR LES TRANSFERT
		// POUR LES TRANSFERT
		$info_transfert = array(
				'ID_SERVICE' => $this->params()->fromPost('id_service'),
				'ID_MEDECIN' => $this->params()->fromPost('med_id_personne'),
				'MOTIF_TRANSFERT' => $this->params()->fromPost('motif_transfert'),
				'ID_CONS' => $id
		);		
				
	
		$this->getTransfererPatientServiceTable()->updateTransfertPatientService($info_transfert);
	
		$info_postnatale = array(
				'parite' => $this->params()->fromPost('parite'),
				//'numero_d_ordre' => $this->params()->fromPost('numero_d_ordre'),
				//'etat_de_la_mere' => $this->params()->fromPost('etat_de_la_mere'),
				//'type_accouchement' => $this->params()->fromPost('type_accouchement'),
				'lieu_accouchement' => $this->params()->fromPost('lieu_accouchement'),
				//'id_accouchement' => $id_accouchement,
				'id_cons' => $id
		); //
			$this->getPostnataleTable()->updatePostnatale($info_postnatale);
			//var_dump($info_postnatale);exit();
			
		// Date Cpon
		
		$info_datecpon = array(
			    'intervalle1' => $this->params()->fromPost('intervalle1'),
				'intervalle2' => $this->params()->fromPost('intervalle2'),
				'intervalle3' => $this->params()->fromPost('intervalle3'),
				'date_intervalle1' => $this->params()->fromPost('date_intervalle1'),
				'date_intervalle2' => $this->params()->fromPost('date_intervalle2'),
				'date_intervalle3' => $this->params()->fromPost('date_intervalle3'),
				'details' => $this->params()->fromPost('details'),
				
				
				'ID_CONS' => $id
		);			
		//var_dump($info_datecpon);exit();
		
		
		$this->getRangCponTable()->updateRangCpon($info_datecpon);
		//var_dump('test');exit();
		
		//prevention
		
		$info_prevention = array(
				'FER' => $this->params()->fromPost('fer'),
				'VAT' => $this->params()->fromPost('vat'),
				'VIH' => $this->params()->fromPost('vih'),
				'ID_CONS' => $id
		);//var_dump($info_prevention);exit();
		//var_dump('test');exit();
		$this->getPreventionTable()->updatePrevention($info_prevention);
	
		//allaitement
		
		$info_allaitement = array(
				'AME' => $this->params()->fromPost('ame'),
				'AUTRE' => $this->params()->fromPost('autre'),
				'ID_CONS' => $id
		);//var_dump($info_prevention);exit();
		
        	$this->getAllaitementTable()->updateAllaitement($info_allaitement);
        	
		/*  Hereditaires*/
        	$info_Hereditaire = array(
        			'DiabeteAF' => $this->params()->fromPost('DiabeteAF'),
        			'NoteDiabeteAF' => $this->params()->fromPost('NoteDiabeteAF'),
        			'DrepanocytoseAF' => $this->params()->fromPost('DrepanocytoseAF'),
        			'NoteDrepanocytoseAF' => $this->params()->fromPost('NoteDrepanocytoseAF'),
        			'noteHtaAF' => $this->params()->fromPost('noteHtaAF'),
        			'htaAF' => $this->params()->fromPost('htaAF'),        			 
        			'ID_CONS' => $id
        	);//var_dump($info_Hereditaire);exit();
        	$this->getHereditaireTable()->updateHereditaire($info_Hereditaire);
        	
        	
        	//contraception
        	
        	$info_contraception = array(
        			'mama' => $this->params()->fromPost('mama'),
        			'autres' => $this->params()->fromPost('autres'),
        			'ID_CONS' => $id
        	);//var_dump($info_prevention);exit();
        	
        	$this->getContraceptionTable()->updateContraception($info_contraception);
        	
        	
		// POUR LES HOSPITALISATION
		// POUR LES HOSPITALISATION
		// POUR LES HOSPITALISATION
		$today = new \DateTime ();
		$dateAujourdhui = $today->format('Y-m-d H:i:s');
		$infoDemandeHospitalisation = array(
				'motif_demande_hospi' => $this->params()->fromPost('motif_hospitalisation'),
				'date_demande_hospi' => $dateAujourdhui,
				'date_fin_prevue_hospi' => $this->controlDate->convertDateInAnglais($this->params()->fromPost('date_fin_hospitalisation_prevue')),
				'id_cons' => $id
		);
	
		$this->getDemandeHospitalisationTable()->saveDemandehospitalisation($infoDemandeHospitalisation);
	
		// POUR LA PAGE complement-accouchement
		if ($this->params()->fromPost('terminer') == 'save') {
	
			// VALIDER EN METTANT '1' DANS CONSPRISE Signifiant que le medecin a consulter le patient
			// Ajouter l'id du medecin ayant consulter le patient
			$valide = array(
					'VALIDER' => 1,
					'ID_CONS' => $id,
					'ID_MEDECIN' => $this->params()->fromPost('med_id_personne')
			);
			$this->getConsultationTable()->validerConsultation($valide);
				
		}
	
		return $this->redirect()->toRoute('postnatale', array(
				'action' => 'postnatale',
		));
	
	}

	
	
	//ENREGISTREMNT MODIFICATION
	public function enregistrementModificationAction() {

		
		$user = $this->layout()->user;
		
		//var_dump('test');exit();
		$id_employe = $user['id_personne']; //L'utilisateur connect�
		
		if (isset ( $_POST ['terminer'] ))
		{
			$Control = new DateHelper();
			$Patient = $this->getPatientTable ();
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'dmy_His' );//var_dump('test'); exit();
			$date_modification = $today->format ( 'Y-m-d H:i:s' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			$fileBase64 = substr ( $fileBase64, 23 );
	
			if($fileBase64){
				$img = imagecreatefromstring(base64_decode($fileBase64));
			}else {
				$img = false;
			}
	
			$date_naissance = $this->params ()->fromPost ( 'DATE_NAISSANCE' );
			if($date_naissance){ $date_naissance = $Control->convertDateInAnglais($this->params ()->fromPost ( 'DATE_NAISSANCE' )); }else{ $date_naissance = null;}
	
			$donnees = array(
					'LIEU_NAISSANCE' => $this->params ()->fromPost ( 'LIEU_NAISSANCE' ),
					'EMAIL' => $this->params ()->fromPost ( 'EMAIL' ),
					'NOM' => $this->params ()->fromPost ( 'NOM' ),
					'TELEPHONE' => $this->params ()->fromPost ( 'TELEPHONE' ),
					'NATIONALITE_ORIGINE' => $this->params ()->fromPost ( 'NATIONALITE_ORIGINE' ),
					'PRENOM' => $this->params ()->fromPost ( 'PRENOM' ),
					'PROFESSION' => $this->params ()->fromPost ( 'PROFESSION' ),
					'NATIONALITE_ACTUELLE' => $this->params ()->fromPost ( 'NATIONALITE_ACTUELLE' ),
					'DATE_NAISSANCE' => $date_naissance,
					'ADRESSE' => $this->params ()->fromPost ( 'ADRESSE' ),
					'SEXE' => $this->params ()->fromPost ( 'SEXE' ),
					'AGE' => $this->params ()->fromPost ( 'AGE' ),
					'NOM_CONJOINT' => $this->params ()->fromPost ( 'NOM_CONJOINT' ),
					'PRENOM_CONJOINT' => $this->params ()->fromPost ( 'PRENOM_CONJOINT' ),
					'PROFESSION_CONJOINT' => $this->params ()->fromPost ( 'PROFESSION_CONJOINT' ),
			);		
			
	
			$id_patient =  $this->params ()->fromPost ( 'ID_PERSONNE' );
			if ($img != false) {
	
				$lePatient = $Patient->getInfoPatient ( $id_patient );
				$ancienneImage = $lePatient['PHOTO'];
	
				if($ancienneImage) {
					unlink ( 'C:\wamp64\www\simens-maternite\public\img\photos_patients\\' . $ancienneImage . '.jpg' );
				}
				imagejpeg ( $img, 'C:\wamp64\www\simens-maternite\public\img\photos_patients\\' . $nomfile . '.jpg' );
	
				$donnees['PHOTO'] = $nomfile;
				$Patient->updatePatient ( $donnees , $id_patient, $date_modification, $id_employe);
				return $this->redirect ()->toRoute ( 'postnatale', array (
						'action' => 'liste-patient'
				) );
			} else {
				$Patient->updatePatient($donnees, $id_patient, $date_modification, $id_employe);
				return $this->redirect ()->toRoute ( 'postnatale', array (
						'action' => 'liste-patient'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'postnatale', array (
				'action' => 'liste-patient'
		) );
	}
	
	
   public function enregistrerAdmissionAction() {
	
		$user = $this->layout()->user;
		$id_employe = $user['id_personne'];
		$Control = new DateHelper();
		$idService = $user ['IdService'];
		$service= $user ['NomService'];
		//var_dump($user); exit();
		$today = new \DateTime ( "now" );
		$date_cons = $today->format ( 'Y-m-d' );
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
		
		$id_patient = ( int ) $this->params ()->fromPost ( 'id_patient', 0 );

		

		//pour  evacuation reference
		
		//donnee pour admission
			$donnees = array (
		
				'id_patient' => $id_patient,
				'sous_dossier'=>$this->params ()->fromPost('sous_dossier'),
					'type_admission'=>$this->params ()->fromPost('type_admission'),
					'motif_admission'=>$this->params ()->fromPost('motif_admission'),
					'motif_transfert_evacuation'=>$this->params ()->fromPost('motif_transfert_evacuation'),
					'service_dorigine'=>$this->params ()->fromPost('service_dorigine'),
					'moyen_transport'=>$this->params ()->fromPost('moyen_transport'),
				'id_service' => $idService,
				'date_cons' => $date_cons,
				'date_enregistrement' => $date_enregistrement,
				'id_employe' => $id_employe,
		);
			$form = new ConsultationForm ();
			$this->getAdmissionTable ()-> addConsultation ( $form,$idService ,12);
			//var_dump($form);exit();
		$id_admission=	$this->getAdmissionTable ()->addAdmissio($donnees);
		
		
		
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
	  
		$this->getAdmissionTable ()-> addConsultation ( $form,$idService ,$id_admission);
	
		$id_cons = $form->get ( "id_cons" )->getValue ();
		
		$this->getAdmissionTable ()->addConsultationMaternite($id_cons);
		
 		return $this->redirect()->toRoute('postnatale', array(
 				'action' =>'admission'));

	}
	
	
public function listePatientsAdmisAction() {
		
		 $this->layout ()->setTemplate ( 'layout/postnatale' );
		 
		//INSTANCIATION DU FORMULAIRE
		
		$formAdmission = new AdmissionForm ();
	
		//var_dump('$layout'); exit();
		$patientsAdmis = $this->getAdmissionTable ();
		return new ViewModel ( array (
				'listePatientsAdmis' => $patientsAdmis->getPatientsAdmis (),
				
				'form' => $formAdmission,
				'listePatientsCons' => $patientsAdmis->getPatientAdmisCons(),
		) );
		

	}

	public function listePostnataleAjaxAction() {
		$output = $this->getPatientTable ()->getListePatientsAdmisAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	public function listePostnataleAction() {
	
		$this->layout ()->setTemplate ( 'layout/postnatale' );
		$user = $this->layout()->user;
		$idService = $user['IdService'];
	
		return new ViewModel ( array (
		) );
	}
	
	public function postnataleAction(){
		$this->layout()->setTemplate('layout/postnatale');
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
		//var_dump($user); exit();
	
		$lespatients = $this->getConsultationTable()->listeDesPostnatale($idService);
		// RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		
		$tabPatientRV = $this->getConsultationTable()->getPatientsRV($idService);
		return new ViewModel (array(
				'donnees' => $lespatients,
				'tabPatientRV' => $tabPatientRV
		));
	
	}

	public function infoPatientAdmisAction() {
		//var_dump('test');exit();
		$this->layout ()->setTemplate ( 'layout/postnatale' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
	
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInfoPatient( $id_pat );
	
		return array (
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'id_patient' => $unPatient['ID_PERSONNE'],
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	} 

	public function impressionPdfAction()
	{
		$user =$this->layout()->setTemplate('layout/postnatale');
		$user = $this->layout()->user;
		$serviceMedecin = $user ['NomService'];
		$nomMedecin = $user ['Nom'];
		$prenomMedecin = $user ['Prenom'];
		$donneesMedecin = array(
				'nomMedecin' => $nomMedecin,
				'prenomMedecin' => $prenomMedecin
		);
		$form = new ConsultationForm ();
	var_dump('test');exit();
		$formData = $this->getRequest()->getPost();
		$object=$this->params('pdf');
		 
		// *************************************
		// *************************************
		// ***DONNEES COMMUNES A TOUS LES PDF***
		// *************************************
		// *************************************
		$id_patient = $this->params()->fromPost('id_patient', 0);
		$id_cons = $this->params()->fromPost('id_cons', 0);
	
		// *************************************
		$donneesPatientOR = $this->getConsultationTable()->getInfoPatient($id_patient);
	
	
	
		// var_dump($donneesPatientOR); exit();
		// **********ORDONNANCE*****************
		// **********ORDONNANCE*****************
		// **********ORDONNANCE*****************
		if (isset ($_POST ['suitedecouche'])) {
			// R�cup�ration des donn�es
			$donneesDemande ['suite_de_couches'] = $this->params()->fromPost('suite_de_couches');
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new SuiteDeCouchePdf();
	
			// var_dump($donneesDemande); exit();
	
			// Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeTC($donneesDemande);
	
			// Ajouter les donnees a la page
			$page->addNoteTC();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		}
		 
		else
		if (isset ($_POST ['observation_go'])) {
			// R�cup�ration des donn�es
			$donneesDemande ['text_observation'] = $this->params()->fromPost('text_observation');
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new ObservationPdf();
	
			// var_dump($donneesDemande); exit();
	
			// Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeTC($donneesDemande);
	
			// Ajouter les donnees a la page
			$page->addNoteTC();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		}
	
		else
		if (isset ($_POST ['ordonnance'])) {
			// r�cup�ration de la liste des m�dicaments
			$medicaments = $this->getConsultationTable()->fetchConsommable();
	
			$tab = array();
			$j = 1;
	
			// NOUVEAU CODE AVEC AUTOCOMPLETION
			for ($i = 1; $i < 10; $i++) {
				$nomMedicament = $this->params()->fromPost("medicament_0" . $i);
				if ($nomMedicament == true) {
					$tab [$j++] = $this->params()->fromPost("medicament_0" . $i);
					$tab [$j++] = $this->params()->fromPost("forme_" . $i);
					$tab [$j++] = $this->params()->fromPost("nb_medicament_" . $i);
					$tab [$j++] = $this->params()->fromPost("quantite_" . $i);
				}
			}
	
			// -***************************************************************
			// Cr�ation du fichier pdf
			// *************************
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new OrdonnancePdf ();
	
			// Envoyer l'id_cons
			$page->setIdCons($id_cons);
			$page->setService($serviceMedecin);
			// Envoyer les donn�es sur le partient
			$page->setDonneesPatient($donneesPatientOR);
			// Envoyer les m�dicaments
			$page->setMedicaments($tab);
	
			// Ajouter une note � la page
			$page->addNote();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//**********TRAITEMENT CHIRURGICAL*****************
		//**********TRAITEMENT CHIRURGICAL*****************
		//**********TRAITEMENT CHIRURGICAL*****************
		if (isset ($_POST['traitement_chirurgical'])) {
			// R�cup�ration des donn�es
			$donneesDemande ['diagnostic'] = $this->params()->fromPost('diagnostic_traitement_chirurgical');
			$donneesDemande ['intervention_prevue'] = $this->params()->fromPost('intervention_prevue');
			$donneesDemande ['observation'] = $this->params()->fromPost('observation');
	
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new TraitementChirurgicalPdf ();
	
			// Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeTC($donneesDemande);
	
			// Ajouter les donnees a la page
			$page->addNoteTC();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//********** PROTOCOLE OPERATOIRE *****************
		//********** PROTOCOLE OPERATOIRE *****************
		//********** PROTOCOLE OPERATOIRE *****************
		if (isset ($_POST ['protocole_operatoire'])) {
			// R�cup�ration des donn�es
			$donneesDemande ['diagnostic'] = $this->params()->fromPost('diagnostic_traitement_chirurgical');
			$donneesDemande ['intervention_prevue'] = $this->params()->fromPost('intervention_prevue');
			$donneesDemande ['observation'] = $this->params()->fromPost('observation');
			$donneesDemande ['note_compte_rendu_operatoire'] = $this->params()->fromPost('note_compte_rendu_operatoire');
			$donneesDemande ['resultatNumeroVPA'] = $this->params()->fromPost('resultatNumeroVPA');
			$donneesDemande ['resultatTypeIntervention'] = $this->params()->fromPost('resultatTypeIntervention');
	
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new ProtocoleOperatoirePdf ();
	
			// var_dump($donneesDemande); exit();
	
			// Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeTC($donneesDemande);
	
			// Ajouter les donnees a la page
			$page->addNoteTC();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//**********TRANSFERT DU PATIENT*****************
		//**********TRANSFERT DU PATIENT*****************
		//**********TRANSFERT DU PATIENT*****************
		if (isset ($_POST ['transfert'])) {
			$id_hopital = $this->params()->fromPost('hopital_accueil');
			$id_service = $this->params()->fromPost('service_accueil');
			$motif_transfert = $this->params()->fromPost('motif_transfert');
	
			// R�cup�rer le nom du service d'accueil
			$service = $this->getServiceTable();
			//var_dump($id_service);exit();
			$infoService =$service->getServiceParNom($serviceMedecin);
			// var_dump($infoService);exit();
			// R�cup�rer le nom de l'hopital d'accueil
			$hopital = $this->getHopitalTable();
			 
			$infoHopital = $hopital->getHopitalParId($id_hopital);
	
			$donneesDemandeT ['NomService'] = $infoService ['NOM'];
	
			$donneesDemandeT ['NomHopital'] = $infoHopital ['NOM_HOPITAL'];
			$donneesDemandeT ['MotifTransfert'] = $motif_transfert;
	
			// -***************************************************************
			// Cr�ation du fichier pdf
			// -***************************************************************
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new TransfertPdf ();
			 
			// Envoi Id de la consultation
			$page->setIdConsT($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientT($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinT($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeT($donneesDemandeT);
	
			//var_dump($serviceMedecin,$page);exit();
			// Ajouter les donnees a la page
			$page->addNoteT();
	
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			 
			$DocPdf->getDocument();
		} else
		//**********RENDEZ VOUS ****************
		//**********RENDEZ VOUS ****************
		//**********RENDEZ VOUS ****************
		if (isset ($_POST ['rendezvous'])) {
	
			$donneesDemandeRv ['dateRv'] = $this->params()->fromPost('date_rv_tampon');
			$donneesDemandeRv ['heureRV'] = $this->params()->fromPost('heure_rv_tampon');
			$donneesDemandeRv ['MotifRV'] = $this->params()->fromPost('motif_rv');
	
			// Cr�ation du fichier pdf
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new RendezVousPdf ();
	
			// Envoi Id de la consultation
			$page->setIdConsR($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientR($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinR($donneesMedecin);
			// Envoi les donn�es du redez vous
			$page->setDonneesDemandeR($donneesDemandeRv);
	
			// Ajouter les donnees a la page
			$page->addNoteR();
			//var_dump($page);exit();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//**********TRAITEMENT INSTRUMENTAL ****************
		//**********TRAITEMENT INSTRUMENTAL ****************
		//**********TRAITEMENT INSTRUMENTAL ****************
		if (isset ($_POST ['traitement_instrumental'])) {
			// R�cup�ration des donn�es
			$donneesTraitementChirurgical ['endoscopieInterventionnelle'] = $this->params()->fromPost('endoscopieInterventionnelle');
			$donneesTraitementChirurgical ['radiologieInterventionnelle'] = $this->params()->fromPost('radiologieInterventionnelle');
			$donneesTraitementChirurgical ['cardiologieInterventionnelle'] = $this->params()->fromPost('cardiologieInterventionnelle');
			$donneesTraitementChirurgical ['autresIntervention'] = $this->params()->fromPost('autresIntervention');
	
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new TraitementInstrumentalPdf ();
	
			// Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeTC($donneesTraitementChirurgical);
	
			// Ajouter les donnees a la page
			$page->addNoteTC();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//**********HOSPITALISATION ****************
		//**********HOSPITALISATION ****************
		//**********HOSPITALISATION ****************
		if (isset ($_POST ['hospitalisation'])) {
			// R�cup�ration des donn�es
			$donneesHospitalisation ['motif_hospitalisation'] = $this->params()->fromPost('motif_hospitalisation');
			$donneesHospitalisation ['date_fin_hospitalisation_prevue'] = $this->params()->fromPost('date_fin_hospitalisation_prevue');
	
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new HospitalisationPdf ();
			// Envoi Id de la consultation
			$page->setIdConsH($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientH($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinH($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeH($donneesHospitalisation);
	
			// Ajouter les donnees a la page
			$page->addNoteH();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//**********DEMANDES D'EXAMENS****************
		//**********DEMANDES D'EXAMENS****************
		//**********DEMANDES D'EXAMENS****************
		if (isset ($_POST ['demandeExamenBioMorpho'])) {
			$i = 1;
			$j = 1;
			$donneesExamensBio = array();
			$notesExamensBio = array();
			// R�cup�ration des donn�es examens biologiques
			for (; $i <= 6; $i++) {
				if ($this->params()->fromPost('examenBio_name_' . $i)) {
					$donneesExamensBio [$j] = $this->params()->fromPost('examenBio_name_' . $i);
					$notesExamensBio [$j++] = $this->params()->fromPost('noteExamenBio_' . $i);
				}
			}
	
			$k = 1;
			$l = $j;
			$donneesExamensMorph = array();
			$notesExamensMorph = array();
			// R�cup�ration des donn�es examens morphologiques
			for (; $k <= 11; $k++) {
				if ($this->params()->fromPost('element_name_' . $k)) {
					$donneesExamensMorph [$l] = $this->params()->fromPost('element_name_' . $k);
					$notesExamensMorph [$l++] = $this->params()->fromPost('note_' . $k);
				}
			}
	
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new DemandeExamenPdf ();
			// Envoi Id de la consultation
			$page->setIdConsBio($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientBio($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinBio($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeBio($donneesExamensBio);
			$page->setNotesDemandeBio($notesExamensBio);
			$page->setDonneesDemandeMorph($donneesExamensMorph);
			$page->setNotesDemandeMorph($notesExamensMorph);
	
			// Ajouter les donnees a la page
			$page->addNoteBio();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();		
			
		}
	
	
	}
	
	
	
	
	
	

	


}