<?php

namespace Maternite;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Maternite\Model\Consultation;
use Maternite\Model\ConsultationMaternite;
use Maternite\Model\ConsultationTable;
use Maternite\Model\ConsultationMaterniteTable;
use Zend\Db\TableGateway\TableGateway;
use Maternite\Model\MotifAdmission;
use Maternite\Model\RvPatientConsTable;
use Maternite\Model\RvPatientCons;
use Maternite\Model\MotifAdmissionTable;
use Maternite\Model\TransfererPatientServiceTable;
use Maternite\Model\TransfererPatientService;
use Maternite\Model\DonneesExamensPhysiquesTable;
use Maternite\Model\DonneesExamensPhysiques;
use Maternite\Model\DiagnosticsTable;
use Maternite\Model\Diagnostics;
use Maternite\Model\Ordonnance;
use Maternite\Model\OrdonnanceTable;
use Maternite\Model\DemandeVisitePreanesthesiqueTable;
use Maternite\Model\DemandeVisitePreanesthesique;
use Maternite\Model\NotesExamensMorphologiquesTable;
use Maternite\Model\NotesExamensMorphologiques;
use Maternite\Model\DemandeTable;
use Maternite\Model\Demande;
use Maternite\Model\GynecologieTable;
use Maternite\Model\Gynecologie;
use Maternite\Model\PrenataleTable;
use Maternite\Model\Prenatale;



use Maternite\Model\Conclusion;
use Maternite\Model\ConclusionTable;

use Maternite\Model\OrdonConsommable;
use Maternite\Model\OrdonConsommableTable;
use Maternite\Model\AntecedentPersonnelTable;
use Maternite\Model\AntecedentPersonnel;
use Maternite\Model\AntecedentsPersonnelsAccTable;
use Maternite\Model\AntecedentsPersonnelsAcc;
use Maternite\Model\AntecedentsFamiliauxTable;
use Maternite\Model\AntecedentsFamiliaux;
use Maternite\Model\DemandehospitalisationTable;
use Maternite\Model\Demandehospitalisation;
use Maternite\Model\Soinhospitalisation;
use Maternite\Model\SoinhospitalisationTable;
use Maternite\Model\SoinsTable;
use Maternite\Model\Soins;
use Maternite\Model\HospitalisationTable;
use Maternite\Model\Hospitalisation;
use Maternite\Model\HospitalisationlitTable;
use Maternite\Model\Hospitalisationlit;
use Maternite\Model\LitTable;
use Maternite\Model\Lit;
use Maternite\Model\SalleTable;
use Maternite\Model\Salle;
use Maternite\Model\BatimentTable;
use Maternite\Model\Batiment;
use Maternite\Model\ResultatVisitePreanesthesiqueTable;
use Maternite\Model\ResultatVisitePreanesthesique;
use Maternite\Model\DemandeActeTable;
use Maternite\Model\DemandeActe;
use Maternite\Model\PatientTable;
use Maternite\Model\Patient;
//use Maternite\Model\Demandehospitalisation;
//use Maternite\Form\PatientForm;
use Maternite\Model\AdmissionTable;
use Maternite\Model\Service;
use Maternite\Model\ServiceTable;
use Maternite\Model\TarifConsultation;
use Maternite\Model\Admission;
use Maternite\Model\Accouchement;
use Maternite\Model\AccouchementTable;
use Maternite\Model\Postnatale;
use Maternite\Model\PostnataleTable;
use Maternite\Model\TypeAccouchement;
use Maternite\Model\TypeAccouchementTable;

use Maternite\Model\Naissance;
use Maternite\Model\NaissanceTable;
use Maternite\Model\Evacuation;
use Maternite\Model\EvacuationTable;
use Maternite\Model\Reference;
use Maternite\Model\ReferenceTable;
use Maternite\Model\Grossesse;
use Maternite\Model\GrossesseTable;
use Maternite\Model\DevenirNouveauNe;
use Maternite\Model\DevenirNouveauNeTable;
use Maternite\Model\AntecedentType1;
use Maternite\Model\AntecedentType1Table;
use Maternite\Model\AntecedentType2;
use Maternite\Model\AntecedentType2Table;
use Maternite\Model\DateCponTable;
use Maternite\Model\DateCpon;
use Maternite\Model\RangCpon;
use Maternite\Model\RangCponTable;
use Maternite\Model\Prevention;
use Maternite\Model\PreventionTable;
use Maternite\Model\AllaitementTable;
use Maternite\Model\Allaitement;
use Maternite\Model\ContraceptionTable;
use Maternite\Model\Contraception;
use Maternite\Model\HereditaireTable;
use Maternite\Model\Hereditaire;
use Maternite\Model\Planification;
use Maternite\Model\PlanificationTable;



class Module implements AutoloaderProviderInterface {
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
						) 
				) 
		);
	}
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	public function getServiceConfig() {
		return array (
				'factories' => array (
						'Maternite\Model\ConsultationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ConsultationTableConsGateway' );
							$table = new ConsultationTable ( $tableGateway );
							return $table;
						},
						'ConsultationTableConsGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Consultation () );
							return new TableGateway ( 'consultation', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Maternite\Model\PatientTable' => function ($sm) {
							$tableGateway = $sm->get ( 'PatientTable1Gateway' );
							$table = new PatientTable ( $tableGateway );
							return $table;
						},


						
						
						'ReferenceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Reference () );
							return new TableGateway ( 'reference', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Maternite\Model\ReferenceTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ReferenceTableGateway' );
							$table = new ReferenceTable ( $tableGateway );
							return $table;
						},
						
						

						'GynecologieTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Gynecologie () );
							return new TableGateway ( 'gynecologie', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Maternite\Model\GynecologieTable' => function ($sm) {
							$tableGateway = $sm->get ( 'GynecologieTableGateway' );
							$table = new GynecologieTable ( $tableGateway );
							return $table;
						},
						
						'PrenataleTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Prenatale () );
							return new TableGateway ( 'prenatale', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Maternite\Model\PrenataleTable' => function ($sm) {
							$tableGateway = $sm->get ( 'PrenataleTableGateway' );
							$table = new PrenataleTable ( $tableGateway );
							return $table;
						},
						
						
						
						'PatientTable1Gateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Patient () );
							return new TableGateway ( 'patient', $dbAdapter, null, $resultSetPrototype );
						},

						'Maternite\Model\AdmissionTable' => function ($sm) {
							$tableGateway = $sm->get( 'AdmissionTableGateway' );
							$table = new AdmissionTable($tableGateway);
							return $table; 
						},
						
						'AdmissionTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Admission());
							return new TableGateway ( 'admission', $dbAdapter, null, $resultSetPrototype );
						},
						
						'GrossesseTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Grossesse());
							return new TableGateway ( 'grossesse', $dbAdapter, null, $resultSetPrototype );
						},
						
						
						'Maternite\Model\GrossesseTable' => function ($sm) {
							$tableGateway = $sm->get( 'GrossesseTableGateway' );
							$table = new GrossesseTable($tableGateway);
							return $table;
						},
						
						


						'Maternite\Model\AntecedentType1Table' => function ($sm) {
							$tableGateway = $sm->get( 'AntecedentType1TableGateway' );
							$table = new AntecedentType1Table($tableGateway);
							return $table;
						},
							
						'AntecedentType1TableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentType1());
							return new TableGateway ( 'antecedent_type_1', $dbAdapter, null, $resultSetPrototype );
						},
						
						
					
						
						
						'AntecedentType2TableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentType2());
							return new TableGateway ( 'antecedent_type_2', $dbAdapter, null, $resultSetPrototype );
						},
						
						
						'Maternite\Model\AntecedentType2Table' => function ($sm) {
							$tableGateway = $sm->get( 'AntecedentType2TableGateway' );
							$table = new AntecedentType2Table($tableGateway);
							return $table;
						},
						
							
						
					
						'ServiceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Service());
							return new TableGateway ( 'service', $dbAdapter, null, $resultSetPrototype );
						},
						
						
						'Maternite\Model\ServiceTable' => function ($sm) {
							$tableGateway = $sm->get( 'ServiceTableGateway' );
							$table = new ServiceTable($tableGateway);
							return $table;
						},
						
						
						'Maternite\Model\TarifConsultationTable' => function ($sm) {
							$tableGateway = $sm->get( 'TarifConsultationTableGateway' );
							$table = new TarifConsultation( $tableGateway );
							return $table;
						},
						'TarifConsultationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype (new TarifConsultation());
							return new TableGateway ( 'tarif_consultation', $dbAdapter, null, $resultSetPrototype );
							
						},
						
						
						'Maternite\Model\AccouchementTable' => function ($sm) {
							$tableGateway = $sm->get( 'AccouchementTableGateway' );
							$table = new AccouchementTable($tableGateway);
							return $table;
						},
					
						'AccouchementTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Accouchement());
							return new TableGateway ( 'accouchement', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Maternite\Model\PlanificationTable' => function ($sm) {
							$tableGateway = $sm->get( 'PlanificationTableGateway' );
							$table = new PlanificationTable($tableGateway);
							return $table;
						},
							
						'PlanificationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Planification());
							return new TableGateway ( 'planification', $dbAdapter, null, $resultSetPrototype );
						},
						
						
						
						'Maternite\Model\HereditaireTable' => function ($sm) {
							$tableGateway = $sm->get( 'HereditaireTableGateway' );
							$table = new HereditaireTable($tableGateway);
							return $table;
						},
							
						'HereditaireTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Hereditaire());
							return new TableGateway ( 'hereditaire', $dbAdapter, null, $resultSetPrototype );
						},

						'Maternite\Model\RangCponTable' => function ($sm) {
							$tableGateway = $sm->get ('RangCponTableGateway');
							$table = new RangCponTable($tableGateway);
							return $table;
						},
							
						'RangCponTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new RangCpon());
							return new TableGateway ( 'rangcpon', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\PreventionTable' => function ($sm) {
							$tableGateway = $sm->get( 'PreventionTableGateway' );
							$table = new PreventionTable($tableGateway);
							return $table;
						},
						'PreventionTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Prevention());
							return new TableGateway ( 'prevention', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Maternite\Model\ContraceptionTable' => function ($sm) {
							$tableGateway = $sm->get( 'ContraceptionTableGateway' );
							$table = new ContraceptionTable($tableGateway);
							return $table;
						},
						'ContraceptionTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Contraception());
							return new TableGateway ( 'contraception', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Maternite\Model\AllaitementTable' => function ($sm) {
							$tableGateway = $sm->get( 'AllaitementTableGateway' );
							$table = new AllaitementTable($tableGateway);
							return $table;
						},
						'AllaitementTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Allaitement());
							return new TableGateway ( 'allaitement', $dbAdapter, null, $resultSetPrototype );
						},
						
						
						'Maternite\Model\PostnataleTable' => function ($sm) {
							$tableGateway = $sm->get( 'PostnataleTableGateway' );
							$table = new PostnataleTable($tableGateway);
							return $table;
						},
							
						'PostnataleTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Postnatale());
							return new TableGateway ( 'postnatale', $dbAdapter, null, $resultSetPrototype );
						},
						
						
						

						'Maternite\Model\TypeAccouchementTable' => function ($sm) {
							$tableGateway = $sm->get( 'TypeAccouchementTableGateway' );
							$table = new TypeAccouchementTable($tableGateway);
							return $table;
						
						},
						'TypeAccouchementTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype (new TypeAccouchement());
							return new TableGateway ( 'type_accouchement', $dbAdapter, null, $resultSetPrototype );
						
						},
						
						/* 'Maternite\Model\TypeAdmissionTable' => function ($sm) {
							$tableGateway = $sm->get( 'TypeAdmissionTableGateway' );
							$table = new TypeAdmissionTable($tableGateway);
							return $table;
						
						},
						'TypeAdmissionTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype (new TypeAdmission());
							return new TableGateway ( 'type_admission', $dbAdapter, null, $resultSetPrototype );
						
						}, */
						
						'Maternite\Model\NaissanceTable' => function ($sm) {
							$tableGateway = $sm->get( 'NaissanceTableGateway' );
							$table = new NaissanceTable($tableGateway);
							return $table;
						},
						'NaissanceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype (new Naissance());
							return new TableGateway ( 'enfant', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Maternite\Model\DevenirNouveauNeTable' => function ($sm) {
							$tableGateway = $sm->get( 'DevenirNouveauNeTableGateway' );
							$table = new DevenirNouveauNeTable($tableGateway);
							return $table;
						},
						'DevenirNouveauNeTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype (new DevenirNouveauNe());
							return new TableGateway ( 'devenir_nouveau_ne', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\ConsultationMaterniteTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ConsultationMaterniteTableConsGateway' );
							$table = new ConsultationMaterniteTable ( $tableGateway );
							return $table;
						},
						'ConsultationMaterniteTableConsGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new ConsultationMaternite () );
							return new TableGateway ( 'consultation_maternite', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\MotifAdmissionTable' => function ($sm) {
							$tableGateway = $sm->get ( 'MotifAdmissionTableGateway' );
							$table = new MotifAdmissionTable ( $tableGateway );
							return $table;
						},
						'MotifAdmissionTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new MotifAdmission () );
							return new TableGateway ( 'motif_admission', $dbAdapter, null, $resultSetPrototype );
						},
						
						'Maternite\Model\RvPatientConsTable' => function ($sm) {
							$tableGateway = $sm->get ( 'RvPatientConsTableGateway' );
							$table = new RvPatientConsTable ( $tableGateway );
							return $table;
						},
						'RvPatientConsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new RvPatientCons () );
							return new TableGateway ( 'rendezvous_consultation', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\TransfererPatientServiceTable' => function ($sm) {
							$tableGateway = $sm->get ( 'TransfererPatientServiceTableGateway' );
							$table = new TransfererPatientServiceTable ( $tableGateway );
							return $table;
						},
						'TransfererPatientServiceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new TransfererPatientService () );
							return new TableGateway ( 'transferer_patient_service', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\DonneesExamensPhysiquesTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DonneesExamensPhysiquesTableGateway' );
							$table = new DonneesExamensPhysiquesTable ( $tableGateway );
							return $table;
						},
						'DonneesExamensPhysiquesTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new DonneesExamensPhysiques () );
							return new TableGateway ( 'Donnees_examen_physique', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\DiagnosticsTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DiagnosticsTableGateway' );
							$table = new DiagnosticsTable ( $tableGateway );
							return $table;
						},
						'DiagnosticsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Diagnostics () );
							return new TableGateway ( 'diagnostic', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\OrdonnanceTable' => function ($sm) {
							$tableGateway = $sm->get ( 'OrdonnanceTableGateway' );
							$table = new OrdonnanceTable ( $tableGateway );
							return $table;
						},
						'OrdonnanceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Ordonnance () );
							return new TableGateway ( 'ordonnance', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\DemandeVisitePreanesthesiqueTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandeVisitePreanesthesiqueTableGateway' );
							$table = new DemandeVisitePreanesthesiqueTable ( $tableGateway );
							return $table;
						},
						'DemandeVisitePreanesthesiqueTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new DemandeVisitePreanesthesique () );
							return new TableGateway ( 'demande_visite_preanesthesique', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\NotesExamensMorphologiquesTable' => function ($sm) {
							$tableGateway = $sm->get ( 'NotesExamensMorphologiquesTableGateway' );
							$table = new NotesExamensMorphologiquesTable ( $tableGateway );
							return $table;
						},
						'NotesExamensMorphologiquesTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new NotesExamensMorphologiques () );
							return new TableGateway ( 'note_examen_morphologique', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\DemandeTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandeTableGateway' );
							$table = new DemandeTable ( $tableGateway );
							return $table;
						},
						'DemandeTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Demande () );
							return new TableGateway ( 'demande', $dbAdapter, null, $resultSetPrototype );
						},
						
						
						
						
						
						
						
						'Maternite\Model\ConclusionTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ConclusionTableGateway' );
							$table = new ConclusionTable ( $tableGateway );
							return $table;
						},
						'ConclusionTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Conclusion () );
							return new TableGateway ( 'conclusion', $dbAdapter, null, $resultSetPrototype );
						},
						
						
						
						
						
						
						
						'Maternite\Model\OrdonConsommableTable' => function ($sm) {
							$tableGateway = $sm->get ( 'OrdonConsommableTableGateway' );
							$table = new OrdonConsommableTable ( $tableGateway );
							return $table;
						},
						'OrdonConsommableTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new OrdonConsommable () );
							return new TableGateway ( 'ordon_consommable', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\AntecedentPersonnelTable' => function ($sm) {
							$tableGateway = $sm->get ( 'AntecedentPersonnelPatientTableGateway' );
							$table = new AntecedentPersonnelTable ( $tableGateway );
							return $table;
						},
						'AntecedentPersonnelPatientTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentPersonnel () );
							return new TableGateway ( 'ant_personnels_patient', $dbAdapter, null, $resultSetPrototype );
						},
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						'Maternite\Model\AntecedentsFamiliauxTable' => function ($sm) {
							$tableGateway = $sm->get ( 'AntecedentsFamiliauxPatientTableGateway' );
							$table = new AntecedentsFamiliauxTable ( $tableGateway );
							return $table;
						},
						'AntecedentsFamiliauxPatientTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentsFamiliaux () );
							return new TableGateway ( 'ant_familiaux_patient', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\DemandehospitalisationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandehospitalisationTableeGateway' );
							$table = new DemandehospitalisationTable ( $tableGateway );
							return $table;
						},
						'DemandehospitalisationTableeGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Demandehospitalisation () );
							return new TableGateway ( 'demande_hospitalisation', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\SoinhospitalisationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'SoinhospitalisationConsTableGateway' );
							$table = new SoinhospitalisationTable ( $tableGateway );
							return $table;
						},
						'SoinhospitalisationConsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Soinhospitalisation () );
							return new TableGateway ( 'soins_hospitalisation', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\SoinsTable' => function ($sm) {
							$tableGateway = $sm->get ( 'SoinsTableGateway' );
							$table = new SoinsTable ( $tableGateway );
							return $table;
						},
						'SoinsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Soins () );
							return new TableGateway ( 'soins', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\HospitalisationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'HospitalisationTableGateway' );
							$table = new HospitalisationTable ( $tableGateway );
							return $table;
						},
						'HospitalisationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Hospitalisation () );
							return new TableGateway ( 'hospitalisation', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\HospitalisationlitTable' => function ($sm) {
							$tableGateway = $sm->get ( 'HospitalisationlitTableGateway' );
							$table = new HospitalisationlitTable ( $tableGateway );
							return $table;
						},
// 						'HospitalisationlitTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet ();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Hospitalisationlit () );
// 							return new TableGateway ( 'hospitalisation_lit', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Maternite\Model\LitTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'LitTableGateway' );
// 							$table = new LitTable ( $tableGateway );
// 							return $table;
// 						},
// 						'LitTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet ();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Lit () );
// 							return new TableGateway ( 'lit', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Maternite\Model\SalleTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'SalleTableGateway' );
// 							$table = new SalleTable ( $tableGateway );
// 							return $table;
// 						},
// 						'SalleTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet ();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Salle () );
// 							return new TableGateway ( 'salle', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Maternite\Model\BatimentTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'BatimentTableGateway' );
// 							$table = new BatimentTable ( $tableGateway );
// 							return $table;
// 						},
// 						'BatimentTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet ();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Batiment () );
// 							return new TableGateway ( 'batiment', $dbAdapter, null, $resultSetPrototype );
// 						},
						'Maternite\Model\ResultatVisitePreanesthesiqueTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ResultatVisitePreanesthesiqueTableGateway' );
							$table = new ResultatVisitePreanesthesiqueTable ( $tableGateway );
							return $table;
						},
						'ResultatVisitePreanesthesiqueTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new ResultatVisitePreanesthesique () );
							return new TableGateway ( 'resultat_vpa', $dbAdapter, null, $resultSetPrototype );
						},
						'Maternite\Model\DemandeActeTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandeActeTableGateway' );
							$table = new DemandeActeTable ( $tableGateway );
							return $table;
						},
						'DemandeActeTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new DemandeActe () );
							return new TableGateway ( 'demande_acte', $dbAdapter, null, $resultSetPrototype );
						} 
				) 
		);
	}
}