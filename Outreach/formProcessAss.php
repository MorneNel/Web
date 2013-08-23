<!--<meta http-equiv="refresh" content="5; URL=patDmg.php?lnkID=<?php echo $_POST['hiddenLNKID']; ?>#page-8">-->
<?php
include './MelaClass/functions.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

error_reporting(E_ALL ^ E_NOTICE);

var_dump($_POST);
$preferences = $Mela_SQL->getPreferences();
if ($Mela_SQL->Exec4DSQL("SQLLock_IsLocked", $_POST['hiddenLNKID']) == 1) {
       
       // array of all form fields for convenience
       $formFields = array ('dmg-ID','dmg-hospitalNumber','dmg-NHSNumber','dmg-hospitalAdmissionDate','dmg-firstName','dmg-middleName','dmg-surname','dmg-DOB','dmg-sex','dmg-ethnicity','dmg-language','dmg-pregnant','dmg-weight',
			    'dmg-height','dmg-bodyMassIndex','dmg-normalBP','dmg-eventNumber','dmg-outreachResus','dmg-address','dmg-town','dmg-county','dmg-postCode','dmg-country','dmg-phone','dmg-NOK','dmg-NOKPhone',
			    'dmg-NOKRelation','dmg-NOKAddress','dmg-NOKTown','dmg-NOKCounty','dmg-NOKPostCode','dmg-NOKCountry',
			    'adm-status','adm-originalhospitalAdmission','adm-ICUAdmission','adm-hospitalAdmissionDate','adm-ICUDischarge','adm-referralDate','adm-HDUAdmission','adm-HDUDischarge','adm-ICUHDUDischargeDelay',
			    'adm-CCUAdmission','adm-delayReason','adm-CCUDischarge','adm-referrer','adm-timeOfCall','adm-responder','adm-timeOfResponse','adm-scoredByWard','adm-delay','adm-triggeredByWard','adm-myScoreOnREF',
			    'adm-outreachNumber','adm-location','adm-consultant','adm-speciality','adm-sourceOfAdmission','adm-locationPriorToSource','adm-plannedAdmission','adm-ORReaddmission','adm-priorSurgeryUndertaken',
			    'adm-surgeryClassification','adm-researchTags','adm-hospital','adm-primaryDiagnosisNotes',
			    'pdi-primaryDiagnosisType','pdi-primaryDiagnosisSystem','pdi-primaryDiagnosisSite','pdi-primaryDiagnosisProcess','pdi-primaryDiagnosisCondition','pdi-primaryDiagnosisCode',
			    'sdi-secondaryDiagnosisType','sdi-secondaryDiagnosisSystem','sdi-secondaryDiagnosisSite','sdi-secondaryDiagnosisProcess','sdi-secondaryDiagnosisCondition','sdi-secondaryDiagnosisCode',
			    'surgery',
			    'cmo-paragraph[1]',
			    'pmh-evidenceAvailableToAssess','pmh-pastMedicalHistory','pmh-biopsyProvenCirrhosis','pmh-radiotherapy','pmh-portalHypertension','pmh-chemotherapy','pmh-hepaticEncephalopathy',
			    'pmh-metastaticDisease','pmh-verySevereCardiovascularDisease','pmh-acuteMyelogenousLeukaemia','pmh-severeRespiratoryDisease','pmh-chronicMyelogenousLeukaemia','pmh-homeVentilation',
			    'pmh-lymphoma','pmh-chronicRenalReplacementTherapy','pmh-congenitalImmunohormonal','pmh-AIDS','pmh-steroidTreatment',
			    'otr-outreachDischargeOutcome','otr-outreachDischargeStatusOutcome','otr-outreachDischargeDate','otr-outreachDischargeTime','otr-lengthOfCare','otr-lengthOfCare',
			    'otr-hospitalDischargeStatus','otr-hospitalDischargeDate','otr-hospitalDischargeTime','otr-hospitalLengthStay','otr-destination','otr-summary'
			    );
       
       /*
	* Due to the way some unusual form elements (comorbidity) are handled
	* ong big update query is not feasible.
	* Multiple queries are used for easier debugging
	*
	* There is a bug in the ODBC driver for PHP which prevents the use
	* of prepared statements so values must be manually sanitised as best they can
	* instead - see http://stackoverflow.com/questions/16148322/binding-php-variables-to-odbc-sql-update-statement
	*/
       
	/*
	 * Data sanitisation
	 */
	
	$sanitiseArgs = array(
	   'ass-location' => FILTER_SANITIZE_STRING,
	   'ass-bay' => FILTER_SANITIZE_STRING,
	   'ass-bed' => FILTER_SANITIZE_STRING,
	   'ass-scoringSystem' => FILTER_SANITIZE_STRING,
	   'ass-assessmentReason' => FILTER_SANITIZE_STRING,
	   'ass-detail' => FILTER_SANITIZE_STRING,
	   'ass-reason' => FILTER_SANITIZE_STRING,
	   'ass-seenByRole' => FILTER_SANITIZE_STRING,
	   'ass-seenByRole1' => FILTER_SANITIZE_STRING,
	   'ass-seenByRole2' => FILTER_SANITIZE_STRING,
	   'ass-seenByName' => FILTER_SANITIZE_STRING,
	   'ass-seenByName1' => FILTER_SANITIZE_STRING,
	   'ass-seenByName2' => FILTER_SANITIZE_STRING,
	   'ass-actionTaken' => FILTER_SANITIZE_STRING,
	   'ass-visitType' => FILTER_SANITIZE_STRING,
	   'ass-appointmentType' => FILTER_SANITIZE_STRING,
	   'ass-reasonNotAttended' => FILTER_SANITIZE_STRING,
	   'ass-followUp' => FILTER_SANITIZE_STRING,
	   'painass-painAtRest' => FILTER_SANITIZE_STRING,
	   'painass-painAtActivity' => FILTER_SANITIZE_STRING,
	   'painass-painScoreWard' => FILTER_SANITIZE_STRING,
	   'painass-nausea' => FILTER_SANITIZE_STRING,
	   'painass-pruritus' => FILTER_SANITIZE_STRING,
	   'painass-sedation' => FILTER_SANITIZE_STRING,
	   'painass-paedFacesScore' => FILTER_SANITIZE_NUMBER_INT,
	   'painass-paedCRIESScore' => FILTER_SANITIZE_NUMBER_INT,
	   'painass-paedVAS' => FILTER_SANITIZE_NUMBER_INT,
	   'painass-paedFLACCScore' => FILTER_SANITIZE_NUMBER_INT,
	   'phye-medical' => FILTER_SANITIZE_STRING,
	);
	
	$myinputs = filter_input_array(INPUT_POST, $sanitiseArgs);
	/*PRINT "TEST INPUT <BR />";
	   var_dump($myinputs);*/
       
	for ($i = 0; $i < count($formFields); $i++) {
	       $_POST[$formFields[$i]] = checkValues(soft_Clean($_POST[$formFields[$i]]));
	       //if ($sanitiseArgs[$formFields[$i]])
	       $sanitisedInput[$i] = ($myinputs[$formFields[$i]]) ? "<font color=red>Sanitised\.</font>".$myinputs[$formFields[$i]] : $_POST[$formFields[$i]];
	       //print "".$formFields[$i].": ".$_POST[$formFields[$i]]." = ".$sanitisedInput[$i]."<br />";	
	}
	
	/*
	 * End data sanitisation
	 */
	
	/*
	 * Required fields
	 *
	 * If a field contained within this array is not present, an error will be thrown
	 * This only checks the existence of the field and that it has a non-empty value
	 */
	$requiredFields = array();
	
	foreach ($requiredFields as $row => $val) {
	      //echo $_POST[$row];
	      if ((!isset($_POST[$row])) || (empty($_POST[$row]))) {
		     echo "<div style='height:100%; width:100%;'>
			       <div class='failurebox' style='vertical-align: middle; text-align: center; margin-left: auto; margin-right: auto; border: 3px solid #A52A2A; background-color: #CD5C5C; color: #330000; height:25%; width:25%;'>
				   <span style='vertical-align: middle; height: 100%;'>
				       <h2>
					   Data Error
				       </h2>
				       Data did not successfully validate and was not saved - the following required field/s were empty: <br />
				       $val
				       <br />
				       <a href='patDmg.php?lnkID=".$_POST['hiddenLNKID']."'>Please click here to return</a>
				   </span>
			       </div>
			   </div>";
		     exit;
	      }
	}
	
	// Assessment Details
	
	// Assessment tags
	$assResearchTagsSQL = "";
	foreach($_POST as $key => $value){
	      $exp_key = explode('_', $key);
	      if($exp_key[0] == 'ass-ResearchTag'){
		   $assResearchTags[] = $value;
	      }
	}
	if ($assResearchTags) {
	   $gluedAssResearchTags = implode(',',$assResearchTags);
	   $gluedAssResearchTags .= ",";
	   $assResearchTagsSQL = ",ResearchTag='".$gluedAssResearchTags."'";
	}
	
	$assLastSeenByDateSQL = "";
	if (strlen($_POST['ass-lastSeenByDate']) != 0) {
	   $assLastSeenByDateSQL = "otr_LastSeenBy_Date='".$_POST['ass-lastSeenByDate']."',";
	}
	
	$assLastSeenByTimeSQL = "";
	if (strlen($_POST['ass-lastSeenByTime']) != 0) {
	   $assLastSeenByTimeSQL = "otr_LastSeenBy_Time='".$_POST['ass-lastSeenByTime']."',";
	}
	
	$ass_updQuery = "UPDATE Outreach SET Timeliness_visit='".$_POST['ass-timeliness']."', otr_Ward='".$_POST['ass-location']."', Location_bay='".$_POST['ass-bay']."', Location_bed='".$_POST['ass-bed']."', otr_ScoringSystem='".$_POST['ass-scoringSystem']."',
	otr_AssessmentReason='".$_POST['ass-assessmentReason']."', otr_FollowUp='".$_POST['ass-detail']."', InapReason='".$_POST['ass-reason']."', otr_SeenBy='".$_POST['ass-seenByRole']."', otr_SeenBy1='".$_POST['ass-seenByRole1']."', otr_CareLevel='".$_POST['rcl-requiredCareLevel']."',
	otr_SeenBy2='".$_POST['ass-seenByRole2']."', otr_Accompanied_By='".$_POST['ass-accompanied']."', otr_SeenBy_Name='".$_POST['ass-seenByName']."', otr_SeenBy_Name1='".$_POST['ass-seenByName1']."', otr_SeenBy_Name2='".$_POST['ass-seenByName2']."',
	otr_ActionTaken='".$_POST['ass-actionTaken']."', otr_LastSeenBy_Grade='".$_POST['ass-lastSeenBy']."', chr_VisitType='".$_POST['ass-visitType']."', chr_AppointmentType='".$_POST['ass-appointmentType']."', chr_Attended='".$_POST['ass-attended']."',
	chr_WhyNotAttended='".$_POST['ass-reasonNotAttended']."', $assLastSeenByDateSQL $assLastSeenByTimeSQL  otr_SuggestedNextAssess='".$_POST['ass-followUp']."' $assResearchTagsSQL
	WHERE otr_ID=".$_POST['patDLK']."";
	try { 
	     $ass_updResult = odbc_exec($connect,$ass_updQuery);
	    } 
	catch (RuntimeException $e) { 
	      print("Exception caught: $e");
	      echo $ass_updQuery;
	} //echo $ass_updQuery;
	
	// Pain Assessment
	// Need to convert strings to the number codes Pain Assessment uses taking preferences into account
       switch ($preferences['PainAtRest_ScoreScale']) {
	      case 0:
		  $painAtRestScale = "Pain Score At Rest (0-3)";
		  $numPrefix = 30;
	      break;
	      
	      case 4:
		  $painAtRestScale = "Pain Score At Rest (0-4)";
		  $numPrefix = 40;
	      break;
	      
	      case 10:
		  $painAtRestScale = "Pain Score At Rest (0-10)";
		  $numPrefix = 1;
	      break;
	  
	      default:
		  $painAtRestScale = "Pain Score At Rest (0-3)";
		  $numPrefix = 30;
	      break;
       }
	
       $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TL.List_Name='$painAtRestScale' AND TLI.Long_Name='".$_POST['painass-painAtRest']."'";
       try { 
	   $result = odbc_exec($connect,$sql); 
	   if($result){ 
	      $paAtRest = odbc_fetch_array($result);
	   } 
	   else { 
	      throw new RuntimeException("Failed to connect."); 
	   } 
       } 
       catch (RuntimeException $e) { 
	   print("Exception caught: $e");
       }
       
       switch ($preferences['PainAtActivity_ScoreScale']) {
	      case 0:
		  $painAtActivityScale = "Pain Score In Activity (0-3)";
	      break;
	      
	      case 4:
		  $painAtActivityScale = "Pain Score In Activity (0-4)";
	      break;
	      
	      case 10:
		  $painAtActivityScale = "Pain Score In Activity (0-10)";
	      break;
	  
	      default:
		  $painAtActivityScale = "Pain Score In Activity";
	      break;
       }
	
       $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TL.List_Name='$painAtActivityScale' AND TLI.Long_Name='".$_POST['painass-painAtActivity']."' AND TL.TBL_ID=TLI.tbi_TBLID";
       try { 
	   $result = odbc_exec($connect,$sql); 
	   if($result){ 
	      $paAtActivity = odbc_fetch_array($result);
	   } 
	   else { 
	      throw new RuntimeException("Failed to connect."); 
	   } 
       } 
       catch (RuntimeException $e) { 
	   print("Exception caught: $e");
       }
       
       switch ($preferences['Pain_Nausia_ScoreScale']) {
	      case 0:
		  $nauseaScale = "Pain Score - Nausea (0-3)";
	      break;
	      
	      case 4:
		  $nauseaScale = "Pain Score - Nausea (0-4)";
	      break;
	      
	      case 10:
		  $nauseaScale = "Pain Score - Nausea (0-10)";
	      break;
	  
	      default:
		  $nauseaScale = "Pain Score - Nausea";
	      break;
       } 
       
       $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TL.List_Name='$nauseaScale' AND TLI.Long_Name='".$_POST['painass-nausea']."' AND TL.TBL_ID=TLI.tbi_TBLID";
       try { 
	   $result = odbc_exec($connect,$sql); 
	   if($result){ 
	      $paNausea = odbc_fetch_array($result);
	   } 
	   else { 
	      throw new RuntimeException("Failed to connect."); 
	   } //echo $sql;
       } 
       catch (RuntimeException $e) { 
	   print("Exception caught: $e");
       } 
       
       switch ($preferences['Pain_Pruritus_ScoreScale']) {
	      case 0:
		  $pruritusScale = "Pain Score - Pruritus (0-3)";
	      break;
	      
	      case 4:
		  $pruritusScale = "Pain Score - Pruritus (0-4)";
	      break;
	      
	      case 10:
		  $pruritusScale = "Pain Score - Pruritus (0-10)";
	      break;
	  
	      default:
		  $pruritusScale = "Pain Score - Pruritus";
	      break;
       }
       
       $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TL.List_Name='$pruritusScale' AND TLI.Long_Name='".$_POST['painass-pruritus']."' AND TL.TBL_ID=TLI.tbi_TBLID";
       try { 
	   $result = odbc_exec($connect,$sql); 
	   if($result){ 
	      $paPruritus = odbc_fetch_array($result);
	   } 
	   else { 
	      throw new RuntimeException("Failed to connect."); 
	   } 
       } 
       catch (RuntimeException $e) { 
	   print("Exception caught: $e");
       } 
       
       switch ($preferences['Pain_Sedation_ScoreScale']) { 
	      case 4:
		  $sedationScale = "Pain Score - Sedation (0-4)";
	      break;
	      
	      case 10:
		  $sedationScale = "Pain Score - Sedation (0-10)";
	      break;
	  
	      default:
		  $sedationScale = "Pain Score - Sedation";
	      break;
       }
       
       $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TL.List_Name='$sedationScale' AND TLI.Long_Name='".$_POST['painass-sedation']."' AND TL.TBL_ID=TLI.tbi_TBLID";
       try { 
	   $result = odbc_exec($connect,$sql); 
	   if($result){ 
	      $paSedation = odbc_fetch_array($result);
	   } 
	   else { 
	      throw new RuntimeException("Failed to connect."); 
	   } 
       } 
       catch (RuntimeException $e) { 
	   print("Exception caught: $e");
       }
       
	$painass_updQuery = "UPDATE Outreach SET otr_PainAtRest='".$paAtRest['SHORT_NAME']."', otr_PainAtActivity='".$paAtActivity['SHORT_NAME']."',
	otr_PainScoreWard='".$_POST['painass-painScoreWard']."',
	otr_Nausea='".$paNausea['SHORT_NAME']."', otr_Pruritus='".$paPruritus['SHORT_NAME']."', otr_Sedation='".$paSedation['SHORT_NAME']."'
	WHERE otr_ID=".$_POST['patDLK']."";
	try { 
	     $painass_updResult = odbc_exec($connect,$painass_updQuery); 
	    } 
	catch (RuntimeException $e) { 
	      print("Exception caught: $e");
	} //echo $painass_updQuery;
	
	// Physical Examination & phyisology 1B
	$physexam_updQuery = "UPDATE PhyAssess_AtTime SET pat_PhysExam='".$_POST['phye-medical']."', pat_PsycoExam='".$_POST['phye-pyscho']."', pat_PhyioExam='".$_POST['phye-physio']."',
	pat_Serum_Bicarbonate=".$_POST['phys2-serumBicarbonate'].", pat_Serum_Na=".$_POST['phys2-serumSodium'].", pat_Serum_K=".$_POST['phys2-serumPotassium'].",
	pat_Serum_Urea=".$_POST['phys2-serumUrea'].", pat_Serum_Creatinine=".$_POST['phys2-serumCreatinine'].", pat_Serum_Glucose=".$_POST['phys2-serumGlucose'].",
	pat_Serum_Ca=".$_POST['phys2-serumCalcium'].", pat_InorganicPhosphate=".$_POST['phys2-InorganicPhosphate'].", pat_TotalProtein=".$_POST['phys2-TotalProtein'].",
	pat_Serum_Albumin=".$_POST['phys2-SerumAlbumin'].", pat_Serum_Mg=".$_POST['phys2-SerumMagnesium'].", pat_Blood_Lactate=".$_POST['phys2-BloodLactate'].",
	pat_White_Cell_Count=".$_POST['phys2-WBCCount'].", pat_Serum_Haematocrit=".$_POST['phys2-Haematocrit'].", pat_Serum_Hb=".$_POST['phys2-Haematoglobin'].",
	pat_Platelet=".$_POST['phys2-PlateletCount'].", pat_Prothrombin=".$_POST['phys2-ProthrombinTime'].", pat_Thromboplastin=".$_POST['phys2-APTT'].", pat_INR=".$_POST['phys2-INR'].",
	pat_Amylase=".$_POST['phys2-Amylase'].", Pat_AlkalinePO4=".$_POST['phys2-AlkalinePhosphate'].", pat_AST=".$_POST['phys2-AST'].", pat_ALT=".$_POST['phys2-ALT'].",
	pat_Serum_Bilirubin=".$_POST['phys2-SerumBilirubin'].", pat_GGT=".$_POST['phys2-GGT']."
	WHERE pat_ID=".$_POST['hiddenpatDLK']."";
	try { 
	     $physexam_updResult = odbc_exec($connect,$physexam_updQuery); 
	    } 
	catch (RuntimeException $e) { 
	      print("Exception caught: $e");
	} //echo $physexam_updQuery;
	
	// Physiology 1A
	$phys1O2ReceivedUnitsSQL = "";
	if (strlen($_POST['phys-O2Received']) != 0) {
	   $phys1O2ReceivedUnitsSQL = "pat_O2Rec_Unit='".$_POST['phys-SpO2']."',";   
	}
	
	$phys1UrineDDSQL = "";
	if (strlen($_POST['phys-Urine']) != 0) {
	   $phys1UrineDDSQL = "pat_UrineDD='".$_POST['phys-Urine']."',";
	}
	
	$phys1Urine2DDSQL = "";
	if (strlen($_POST['phys-Urine2']) != 0) {
	   $phys1Urine2DDSQL = "Urine_in_last_hrs='".$_POST['phys-Urine2']."',";
	}
	
	$ABGDateSQL = "";
	if (strlen($_POST['phys-ABGDate']) != 0 && ($_POST['phys-ABGDate'] != '00/00/0')) {
	   $ABGDateSQL = "pat_ABG_Test_Date='".$_POST['phys-ABGDate']."',";
	}
	
	$ABGTimeSQL = "";
	if (strlen($_POST['phys-ABGTime']) != 0 && ($_POST['phys-ABGTime'] != '00:00')) {
	   $ABGTimeSQL = "pat_ABG_Test_Time='".$_POST['phys-ABGTime']."',";
	}
	
	$physCRPSQL = "";
	if (strlen($_POST['phys-CRP']) != 0) {
	   $physCRPSQL = "pat_CRP=".$_POST['phys-CRP'].",";
	}
	
	$physDDimersSQL = "";
	if (strlen($_POST['phys-DDimers']) != 0) {
	   $physDDimersSQL = "pat_DDimers=".$_POST['phys-DDimers'].",";
	}
	
	$physTroponinSQL = "";
	if (strlen($_POST['phys-TroponinLevel']) != 0) {
	   $physTroponinSQL = "pat_Troponin_Level=".$_POST['phys-TroponinLevel'].",";
	}
	
	$physCardiacKinase = "";
	if (strlen($_POST['phys-CardiacKinase']) != 0) {
	   $physCardiacKinase = "pat_Cardiac_Kinase=".$_POST['phys-CardiacKinase'].",";
	}
	
	$physESR = "";
	if (strlen($_POST['phys-ESR']) != 0) {
	   $physESR = "pat_ESR=".$_POST['phys-ESR'].",";
	}
	
	$physRAP = "";
	if (strlen($_POST['phys-RAP']) != 0) {
	   $physRAP = "pat_RAP=".$_POST['phys-RAP'].",";
	}
	
	$physRhythm = "";
	if (strlen($_POST['phys-Rhythm']) != 0) {
	   $physRhythm = "pat_Rhythm='".$_POST['phys-Rhythm']."',";
	}
	
	$physPaced = "";
	if (strlen($_POST['phys-Paced']) != 0) {
	   $physPaced = "pat_Paced='".$_POST['phys-Paced']."',";
	}
	
	$physGCSEyes = "";
	if (strlen($_POST['phys-Eyes']) != 0) {
	   $physGCSEyes = "pat_GCS_Eyes='".$_POST['phys-Eyes']."',";
	}
	
	$physGCSMotor = "";
	if (strlen($_POST['phys-Motor']) != 0) {
	   $physGCSMotor = "pat_GCS_Motor='".$_POST['phys-Motor']."',";
	}
	
	$physGCSVerbal = "";
	if (strlen($_POST['phys-Verbal']) != 0) {
	   $physGCSVerbal = "pat_GCS_Verbal='".$_POST['phys-Verbal']."',";
	}
	
	$physGCSTotal = "";
	if (strlen($_POST['phys-GCS']) != 0) {
	   $physGCSTotal = "pat_GCS=".$_POST['phys-GCS'].",";
	}
	
	$physLimbLeftArmSQL = "";
	if (strlen($_POST['phys-LimbLeftArm']) != 0) {
	   $physLimbLeftArmSQL = "Limb_LeftArm='".$_POST['phys-LimbLeftArm']."',";
	}
	
	$physLimbLeftLegSQL = "";
	if (strlen($_POST['phys-LimbLeftLeg']) != 0) {
	   $physLimbLeftLegSQL = "Limb_LeftLeg='".$_POST['phys-LimbLeftLeg']."',";
	}
	
	$physLimbRightArmSQL = "";
	if (strlen($_POST['phys-LimbRightArm']) != 0) {
	   $physLimbRightArmSQL = "Limb_RightArm='".$_POST['phys-LimbRightArm']."',";
	}
	
	$physLimbRightLegSQL = "";
	if (strlen($_POST['phys-LimbRightLeg']) != 0) {
	   $physLimbRightLegSQL = "Limb_RightLeg='".$_POST['phys-LimbRightLeg']."',";
	}
	
	$physLimbTotalSQL = "";
	if (strlen($_POST['phys-LimbTotal']) != 0) {
	   $physLimbTotalSQL = "LimbTotal=".$_POST['phys-LimbTotal'].",";
	}
	
	$physSeizureTypeSQL = "";
	if (strlen($_POST['phys-SeizureType']) != 0) {
	   $physSeizureTypeSQL = "Seizure_Type='".$_POST['phys-SeizureType']."',";
	}
	
	$physSeizureDescSQL = "";
	if (strlen($_POST['phys-SeizureDescription']) != 0) {
	   $physSeizureDescSQL = "Seizure_Desc='".$_POST['phys-SeizureDescription']."',";
	}
	
	$physPupilReactLeftSQL = "";
	if (strlen($_POST['phys-PupilReactLeft']) != 0) {
	   $physPupilReactLeftSQL = "PupilReact_Left='".$_POST['phys-PupilReactLeft']."',";
	}
	
	$physPupilReactRightSQL = "";
	if (strlen($_POST['phys-PupilReactRight']) != 0) {
	   $physPupilReactRightSQL = "PupilReact_Right='".$_POST['phys-PupilReactRight']."',";
	}
	
	$physPupilDilationLeftSQL = "";
	if (strlen($_POST['phys-PupilDilationLeft']) != 0) {
	   $physPupilDilationLeftSQL = "PupilDilation_Left='".$_POST['phys-PupilDilationLeft']."',";
	}
	
	$physPupilDilationRightSQL = "";
	if (strlen($_POST['phys-PupilDilationRight']) != 0) {
	   $physPupilDilationRightSQL = "PupilDilation_Right='".$_POST['phys-PupilDilationRight']."',";
	}
	// These are from physiology 2
	$phys2TestDateSQL = "";
	if (strlen($_POST['phys2-testDate']) != 0) {
	   $phys2TestDateSQL = "pat_Blood_Test_Date='".$_POST['phys2-testDate']."',";
	}
	$phys2TestTimeSQL = "";
	if ($_POST['phys2-testTime'] != '00:00') {
	   $phys2TestTimeSQL = "pat_Blood_Test_Time='".$_POST['phys2-testTime']."',";
	}
	
	$SOFASQL = "";
	if (strlen($_POST['phys-SOFAScore']) != 0) {
	      $SOFASQL = "SOFA=".$_POST['phys-SOFAScore'].", ";      
	}
	// pat_Mean_arterial_bp=".$_POST['phys-MeanArterialBP'].", - for some reason inserting this throws up an error and I cannot see why at all, data type is fine, no typos (copied/pasted from 4D DB itself), data is getting passed fine...no idea
	$phys1_updQuery = "UPDATE PhyAssess_AtTime SET pat_Temperature=".$_POST['phys-temperature'].", pat_Systolic_BP=".$_POST['phys-systolicBP'].", pat_Diastolic_BP=".$_POST['phys-diastolicBP'].", pat_Mean_arterial_bp=".$_POST['phys-meanBP'].",
	pat_HeartRate=".$_POST['phys-heartRate1'].", pat_RespiratoryRate=".$_POST['phys-respRate'].", pat_O2Saturation=".$_POST['phys-SpO2'].", $phys1O2ReceivedUnitsSQL pat_O2deliv_by='".$_POST['phys-O2Received2']."', $phys1UrineDDSQL $phys1Urine2DDSQL
	pat_AVPU='".$_POST['phys-AVPU']."', pat_Pain='".$_POST['phys-Pain']."', pat_PaO2=".$_POST['phys-heartRate'].", pat_FIO2=".$_POST['phys-AssociatedFIO2'].", pat_PaCO2=".$_POST['phys-AssociatedPACO2'].", pat_pH=".$_POST['phys-AssociatedPHH'].",
	pat_Base_Excess=".$_POST['phys-BaseExcess'].", pat_SaO2=".$_POST['phys-SaO2'].", pat_HCO3=".$_POST['phys-HCO3'].", $ABGDateSQL $ABGTimeSQL $physCRPSQL $physDDimersSQL $physTroponinSQL
	$physCardiacKinase $physESR $physRAP $physRhythm $physPaced $physGCSEyes $physGCSMotor $physGCSVerbal $physGCSTotal $physLimbLeftArmSQL $physLimbLeftLegSQL $physLimbRightArmSQL $physLimbRightLegSQL $physLimbTotalSQL $physSeizureTypeSQL
	$physSeizureDescSQL $physPupilReactLeftSQL $physPupilReactRightSQL $physPupilDilationLeftSQL $physPupilDilationRightSQL $phys2TestDateSQL $phys2TestTimeSQL pat_EWSSFDDCI='".$_POST['phys-EWSSScore']."', $SOFASQL NEWS_Score='".$_POST['phys-NEWSScore']."',
	ABG_type='".$_POST['phys-Type']."'
	WHERE pat_ID=".$_POST['hiddenpatDLK']."";
	try { 
	     $phys1_updResult = @odbc_exec($connect,$phys1_updQuery); 
	    } 
	catch (RuntimeException $e) { 
	      print("Exception caught: $e");
	} //echo $phys1_updQuery;
	
	// Physiology 2 
	$phys2_updQuery = "UPDATE PhyAssess_PrevTime SET ppa_LowestCTemperature=".$_POST['ppa-LowestCTemp'].", ppa_HighestCTemperature=".$_POST['ppa-HighestCTemp'].", ppa_LowestBicarbonate=".$_POST['ppa-LowestBicarbonate'].", ppa_HighestBicarbonate=".$_POST['ppa-HighestBicarbonate'].",
	ppa_LowestWhiteCellCount=".$_POST['ppa-LowestWhiteCellCount'].", ppa_HighestWhiteCellCount=".$_POST['ppa-HighestWhiteCellCount'].", ppa_LowestTemperature=".$_POST['ppa-LowestTemp'].", ppa_HighestTemperature=".$_POST['ppa-HighestTemp'].",
	ppa_LowestNa=".$_POST['ppa-LowestSodium'].", ppa_HighestNa=".$_POST['ppa-HighestSodium'].", ppa_LowestHaemocrit=".$_POST['ppa-LowestHaematocrit'].", ppa_HighestHaemocrit=".$_POST['ppa-HighestHaematocrit'].", ppa_LowestSystolic_BP=".$_POST['ppa-LowestSystolicBP'].",
	ppa_HighestSystolic_BP=".$_POST['ppa-HighestSystolicBP'].", ppa_LowestK=".$_POST['ppa-LowestPotassium'].", ppa_HighestK=".$_POST['ppa-HighestPotassium'].", ppa_LowestHb=".$_POST['ppa-LowestHaemoglobin'].", ppa_HighestHb=".$_POST['ppa-HighestHaemoglobin'].",
	ppa_LowestPairedDiasBP=".$_POST['ppa-LowestPairedDBP'].", ppa_HighestPairedDiasBP=".$_POST['ppa-HighestPairedDBP'].", ppa_LowestUrea=".$_POST['ppa-LowestUrea'].", ppa_HighestUrea=".$_POST['ppa-HighestUrea'].", ppa_LowestPlateletCount=".$_POST['ppa-LowestPlateletCount'].",
	ppa_HighestPlateletCount=".$_POST['ppa-HighestPlateletCount'].", ppa_LowestDiastolic_BP=".$_POST['ppa-LowestDiastolicBP'].", ppa_HighestDiastolic_BP=".$_POST['ppa-HighestDiastolicBP'].", ppa_LowestCreatinine=".$_POST['ppa-LowestCreatinine'].", ppa_HighestCreatinine=".$_POST['ppa-HighestCreatinine'].",
	ppa_LowestProthrombin=".$_POST['ppa-LowestProthrombin'].", ppa_HighestProthrombin=".$_POST['ppa-HighestProthrombin'].", ppa_LowestPairedSysBP=".$_POST['ppa-LowestPairedSBP'].", ppa_HighestPairedSysBP=".$_POST['ppa-HighestPairedSBP'].", ppa_LowestGlucose=".$_POST['ppa-LowestGlucose'].",
	ppa_HighestGlucose=".$_POST['ppa-HighestGlucose'].", ppa_LowestThromboPlastin=".$_POST['ppa-LowestThromboplastin'].", ppa_HighestThromboPlastin=".$_POST['ppa-HighestThromboplastin'].", ppa_LowestHeartRate=".$_POST['ppa-LowestHR'].", ppa_HighestHeartRate=".$_POST['ppa-HighestHR'].",
	ppa_LowestCalcium=".$_POST['ppa-LowestCalcium'].", ppa_HighestCalcium=".$_POST['ppa-HighestCalcium'].", ppa_LowestAST=".$_POST['ppa-LowestAST'].", ppa_HighestAST=".$_POST['ppa-HighestAST'].", ppa_LowestRespiratoryRate=".$_POST['ppa-LowestRespiratoryRate'].",
	ppa_HighestRespiratoryRate=".$_POST['ppa-HighestRespiratoryRate'].", ppa_LowestAlbumin=".$_POST['ppa-LowestAlbumin'].", ppa_HighestAlbumin=".$_POST['ppa-HighestAlbumin'].", ppa_LowestALT=".$_POST['ppa-LowestALT'].", ppa_HighestALT=".$_POST['ppa-HighestALT'].",
	ppa_LowestO2Saturation=".$_POST['ppa-LowestO2Saturation'].", ppa_HighestO2Saturation=".$_POST['ppa-HighestO2Saturation'].", ppa_CPAP='".$_POST['ppa-CPAP']."', ppa_LowestAmylase=".$_POST['ppa-LowestAmylase'].", ppa_HighestAmylase=".$_POST['ppa-HighestAmylase'].",
	ppa_LowestUrineOutput=".$_POST['ppa-LowestUrineOutput'].", ppa_WorstAVPU='".$_POST['ppa-WorstAVPU']."', ppa_LowestAlkaline=".$_POST['ppa-LowestAlkaline'].", ppa_HighestAlkaline=".$_POST['ppa-HighestAlkaline'].", ppa_Fluid_Input=".$_POST['ppa-FluidInput'].",
	ppa_Pain='".$_POST['ppa-worstPain']."', ppa_LowestBilirubin=".$_POST['ppa-LowestBilirubin'].", ppa_HighestBilirubun=".$_POST['ppa-HighestBilirubin'].", ppa_GCS_Eyes='".$_POST['ppa-GCSEyes']."', ppa_GCS_Motor='".$_POST['ppa-GCSMotor']."', ppa_GCS_Verbal='".$_POST['ppa-GCSVerbal']."',
	ppa_WorstGCS=".$_POST['ppa-WorstGCS'].", ppa_PaO2=".$_POST['ppa-WorstPAO2'].", ppa_LowestFIO2=".$_POST['ppa-AssociatedFIO2'].", ppa_LowestPaCO2=".$_POST['ppa-AssociatedPacO2'].", ppa_LowestPH=".$_POST['ppa-AssociatedPH'].", ppa_APACHEII=".$_POST['ppa-APACHEIIScore'].",
	ppa_APACHEII_Prob=".$_POST['ppa-APACHEIIProb'].", ppa_SAPSII=".$_POST['ppa-SAPSIIScore'].", ppa_SAPSII_Prob=".$_POST['ppa-SAPSIIProb']."
	WHERE ppa_ID=".$_POST['ppaDLK']."";
	try { 
	     $phys2_updResult = odbc_exec($connect,$phys2_updQuery); 
	    } 
	catch (RuntimeException $e) { 
	      print("Exception caught: $e");
	} //echo $phys2_updQuery;
	
	// Sepsis/infection
	$inf_updQuery = "UPDATE Infection_Source SET Infection_Source='".$_POST['sps-infectionSource']."'
	WHERE source_dlkID=".$_POST['ppaDLK']."";
	try { 
	     $inf_updResult = odbc_exec($connect,$inf_updQuery); 
	    } 
	catch (RuntimeException $e) { 
	      print("Exception caught: $e");
	} //echo $inf_updQuery;
	
	$inf2_updQuery = "UPDATE Outreach SET SepsisOnArival='".$_POST['sps-sepsisOnArrival']."', SepsisSource='".$_POST['sps-sepsisSource']."'
	WHERE otr_ID=".$_POST['patDLK']."";
	try { 
	     $inf2_updResult = odbc_exec($connect,$inf2_updQuery); 
	    } 
	catch (RuntimeException $e) { 
	      print("Exception caught: $e");
	} //echo $inf2_updQuery;
	
	// Visit Outcome
	// Adding assessment start time, end time and duration here because it saves another SQL call by adding it to a query with only one field prior anyway
	$assessmentDateSQL = "";
	if (strlen($_POST['assessmentHeaderDate']) != 0 && ($_POST['assessmentHeaderDate'] != '00/00/0')) {
	   $assessmentDateSQL = "dlk_AssessDate='".$_POST['assessmentHeaderDate']."',";
	}
	
	$vis_updQuery = "UPDATE DAILY_LINK SET GPLetter_Given='".$_POST['GPLetterGiven']."', $assessmentDateSQL dlk_AssessStartTime='".$_POST['assessmentHeaderStartTime']."',
	dlk_AssessEndTime='".$_POST['assessmentHeaderEndTime']."', dlk_AssessDuration='".$_POST['assessmentHeaderDuration']."'
	WHERE dlk_ID=".$_POST['patDLKID']."";
	try { 
	     $vis_updResult = odbc_exec($connect,$vis_updQuery); 
	    } 
	catch (RuntimeException $e) { 
	      print("Exception caught: $e");
	} //echo $vis_updQuery;
	
	// Visit outcome also includes groups/items, which are special too in that they have date/time fields
	if ((!empty($_POST['DOnotes'])) && (count($_POST['DOnotes'] > 0))) {
	      //echo "Daily Outcome count is ".count($_POST['DOnotes']);
	      foreach ($_POST['DOnotes'] AS $key => $val) {
		   //print "<b>Value</b>: $key as ".$val." also date is ".$_POST['DODate'][$key]." and time is ".$_POST['DOTime'][$key]."<br />";
		     if (strlen($_POST['DODate'][$key]) == 10) {	   
			    $domo_updQuery = "UPDATE DailyOutcome SET DailyOutcome_Notes='$val', DateOf='".$_POST['DODate'][$key]."', TimeOf='".$_POST['DOTime'][$key]."'
			    WHERE DailyOutcome_ID=$key AND DailyOutcome_LnkID=".$_POST['hiddenLNKID']." AND DailyOutcome_DLnkID=".$_POST['patDLKID']."";
			    try { 
				$domo_updResult = odbc_exec($connect,$domo_updQuery); 
			    } 
			    catch (RuntimeException $e) { 
				print("Exception caught: $e");
			    } //echo $domo_updQuery;
		     }
	       }
	}
	
	// chr_NextAppointment='".$_POST['do-NextAppointment']."' - pain in the backside date field
	$vis2_updQuery = "UPDATE Outreach SET otr_ActionTaken='".$_POST['do-actiontaken']."', otr_TeamReferral='".$_POST['do-actiontaken2']."', otr_SuggestedNextAssess='".$_POST['do-followup']."', Out_Level_Care='".$_POST['do-levelofcare']."'
	WHERE otr_ID=".$_POST['patDLK']."";
	try { 
	     $vis2_updResult = odbc_exec($connect,$vis2_updQuery); 
	    } 
	catch (RuntimeException $e) { 
	      print("Exception caught: $e");
	} //echo $vis2_updQuery;
	
       // Medications
       if (((!empty($_POST['MEnotes'])) && (count($_POST['MEnotes'] > 0))) || ((!empty($_POST['med-Dose'])) && (count($_POST['med-Dose'] > 0))) || ((!empty($_POST['med-doseUnits'])) && (count($_POST['med-doseUnits'] > 0))) || ((!empty($_POST['med-Frequency'])) && (count($_POST['med-Frequency'] > 0)))
	   || ((!empty($_POST['med-Route'])) && (count($_POST['med-Route'] > 0))) || ((!empty($_POST['med-Outcome'])) && (count($_POST['med-Outcome'] > 0))) || ((!empty($_POST['med-Discontinued'])) && (count($_POST['med-Discontinued'] > 0)))) {
	      //echo "Medication count is ".count($_POST['DOnotes']);
	      foreach ($_POST['MEnotes'] AS $key => $val) {
		     $sanitisedComments = filter_var($val, FILTER_SANITIZE_STRING);
		     $medDose = "";
		     $medDoseUnits = "";
		     $medFrequency = "";
		     $medRoute = "";
		     $medOutcome = "";
		     $medDiscontinued = "";
		     //echo "Med Dose val for $val is ".$_POST['med-Dose'][$key]."<br />";
		     if (isset($_POST['med-Dose'][$key])) $medDose = "med_Dose=".$_POST['med-Dose'][$key].", ";
		     if (isset($_POST['med-doseUnits'][$key])) $medDoseUnits = "Unit='".$_POST['med-doseUnits'][$key]."', ";
		     if (isset($_POST['med-Frequency'][$key])) $medFrequency = "med_Frequency='".$_POST['med-Frequency'][$key]."', ";
		     if (isset($_POST['med-Route'][$key])) $medRoute = "med_Route='".$_POST['med-Route'][$key]."', ";
		     if (isset($_POST['med-Outcome'][$key])) $medOutcome = "Outcome='".$_POST['med-Outcome'][$key]."', ";
		     if (isset($_POST['med-Discontinued'][$key])) $medDiscontinued = "End_Date='".$_POST['med-Discontinued'][$key]."', ";
		     //print "<b>Value</b>: $key as ".$val." also date is ".$_POST['DODate'][$key]." and time is ".$_POST['DOTime'][$key]."<br />";
		     //if (strlen($_POST['mednotes'][$key]) == 10) {	   
			    $medno_updQuery = "UPDATE Medication SET $medDose $medDoseUnits $medFrequency $medRoute $medOutcome $medDiscontinued med_Comments='$sanitisedComments'
			    WHERE itm_ID=$key AND med_lnkID=".$_POST['hiddenLNKID']." AND med_dlkID=".$_POST['patDLKID']."";
			    try { 
				$medno_updResult = odbc_exec($connect,$medno_updQuery); 
			    } 
			    catch (RuntimeException $e) { 
				print("Exception caught: $e");
			    } //echo $medno_updQuery;
		     //}
	       }
       }
       
       // Care Level
       if ($_POST['CLnotes']) {
	   foreach ($_POST['CLnotes'] AS $key => $val) {
		 //print "<b>Value</b>: $key as ".$val."<br />";
			
		 $cl_updQuery = "UPDATE CareLevel SET Notes='$val' WHERE CareLevelItem_ID=$key AND lnk_ID =".$_POST['hiddenLNKID']."";
		 try { 
		      $cl_updResult = odbc_exec($connect,$cl_updQuery); 
		     } 
		 catch (RuntimeException $e) { 
		       print("Exception caught: $e");
		 } //echo $cl_updQuery;
	      }
       }
       
       // Interventions
       if ($_POST['INnotes']) {
	   foreach ($_POST['INnotes'] AS $key => $val) {
		 //print "<b>Value</b>: $key as ".$val."<br />";
			
		 $inv_updQuery = "UPDATE Investigations SET inv_Comments='$val' WHERE inv_ID=$key AND inv_lnkID =".$_POST['hiddenLNKID']."";
		 try { 
		      $inv_updResult = odbc_exec($connect,$inv_updQuery); 
		     } 
		 catch (RuntimeException $e) { 
		       print("Exception caught: $e");
		 } //echo $inv_updQuery;
	      }
       }
       
	?>
	<div style="height:100%; width:100%;">
	      <div class="successbox" style="vertical-align: middle; text-align: center; margin-left: auto; margin-right: auto; border: 3px solid #66CD00; background-color: #CCFFCC; color: #596C56; height:25%; width:25%;">
		     <span style="vertical-align: middle; height: 100%;">
			    <h2>
				   Saved successfully
			    </h2>
			    <a href="patDmg.php?lnkID=<?php echo $_POST['hiddenLNKID']; ?>#page-8">Please click here to return if you are not automatically redirected within 5 seconds</a>
		     </span>
	      </div>
       </div>
	<?php
       }
       else {
	   echo "<div style='height:100%; width:100%;'>
		   <div class='failurebox' style='vertical-align: middle; text-align: center; margin-left: auto; margin-right: auto; border: 3px solid #A52A2A; background-color: #CD5C5C; color: #330000; height:25%; width:25%;'>
		       <span style='vertical-align: middle; height: 100%;'>
			   <h2>
			       Record Locking Error
			   </h2>
			   The selected record was not locked and therefore data were not safe to save. 
			   <br />
			   <a href='patListing.php'>Please click here to return to patient listing</a>
		       </span>
		   </div>
	      </div>";
       }
       ?>