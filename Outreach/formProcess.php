<meta http-equiv="refresh" content="5; URL=patListing.php">
<?php
error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/functions.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

/*echo "<h3>Variable dump for debugging purposes (easily hidden). Scroll below for success/failure check</h3>";
var_dump($_POST);
echo "<h4>If you don't see anything below this line it saved successfully</h4>";*/

if ($Mela_SQL->Exec4DSQL("SQLLock_IsLocked", $_POST['patLNK']) == 1) {

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
     function phoneNumberFilter($number) {
	// Only allow spaces and numbers
	if (preg_match('/^[0-9 ]+$/',$number)) {
	    return $number;
	} else return false;
     }
     
     function dateFilter($date) {
	// Only allow - and numbers
	if (preg_match('/^[0-9-]+$/',$date)) {
	    return $date;
	} else return false;
     }
     
     function timeFilter($time) {
	// Only allow : and numbers
	if (preg_match('/^[0-9:]+$/',$time)) {
	    return $time;
	} else return false;
     }
     
     function decimalFilter($number) {
	// Only allow . and numbers
	if (preg_match('/^[0-9.]+$/',$number)) {
	    return $number;
	} else return false;
     }
     
     // Custom filters for a few fields like phone number, dates etc
     $dmgPhoneFilter = array('dmg-phone' => FILTER_CALLBACK,'options' => 'phoneNumberFilter');
     $dmgHospitalAdmDate = array('dmg-hospitalAdmissionDate' => FILTER_CALLBACK,'options' => 'dateFilter');
     $dmgDOBFilter = array('dmg-DOB' => FILTER_CALLBACK,'options' => 'dateFilter');
     $dmgWeightFilter = array('dmg-weight' => FILTER_CALLBACK,'options' => 'decimalFilter');
     $dmgHeightFilter = array('dmg-height' => FILTER_CALLBACK,'options' => 'decimalFilter');
     
     $admHospitalAdmDate = array('adm-hospitalAdmissionDate' => FILTER_CALLBACK,'options' => 'dateFilter');
     $admReferralDate = array('adm-referralDate' => FILTER_CALLBACK,'options' => 'dateFilter');
     $admTimeOfCall = array('adm-timeOfCall' => FILTER_CALLBACK,'options' => 'timeFilter');
     $admTimeOfResponse = array('adm-timeOfResponse' => FILTER_CALLBACK,'options' => 'timeFilter');
     
     $sanitiseArgs = array(
	'dmg-hospitalNumber' => FILTER_SANITIZE_NUMBER_INT,
	'dmg-NHSNumber' => FILTER_SANITIZE_NUMBER_INT,
	'dmg-NHSVerification' => FILTER_SANITIZE_STRING,
	'dmg-hospitalAdmissionDate' => $dmgHospitalAdmDate,
	'dmg-firstName' => FILTER_SANITIZE_STRING,
	'dmg-middleName' => FILTER_SANITIZE_STRING,
	'dmg-surname' => FILTER_SANITIZE_STRING,
	'dmg-DOB' => $dmgDOBFilter,
	'dmg-sex' => FILTER_SANITIZE_STRING,
	'dmg-ethnicity' => FILTER_SANITIZE_STRING,
	'dmg-language' => FILTER_SANITIZE_STRING,
	'dmg-weight' => $dmgWeightFilter,
	'dmg-height' => $dmgHeightFilter,
	'dmg-eventNumber' => FILTER_SANITIZE_NUMBER_INT,
	'dmg-address' => FILTER_SANITIZE_STRING,
	'dmg-town' => FILTER_SANITIZE_STRING,
	'dmg-county' => FILTER_SANITIZE_STRING,
	'dmg-postCode' => FILTER_SANITIZE_STRING,
	'dmg-country' => FILTER_SANITIZE_STRING,
	'dmg-phone' => $dmgPhoneFilter,
	'dmg-NOK' => FILTER_SANITIZE_STRING,
	'dmg-NOKPhone' => FILTER_SANITIZE_NUMBER_INT,
	'dmg-NOKRelation' => FILTER_SANITIZE_STRING,
	'dmg-NOKAddress' => FILTER_SANITIZE_STRING,
	'dmg-NOKTown' => FILTER_SANITIZE_STRING,
	'dmg-NOKCounty' => FILTER_SANITIZE_STRING,
	'dmg-NOKPostCode' => FILTER_SANITIZE_STRING,
	'dmg-NOKCountry' => FILTER_SANITIZE_STRING,
	'adm-hospitalAdmissionDate' => $admHospitalAdmDate,
	'adm-referralDate' => $admReferralDate,
	'adm-referrer' => FILTER_SANITIZE_STRING,
	'adm-responder' => FILTER_SANITIZE_STRING,
	'adm-timeOfCall' => $admTimeOfCall,
	'adm-timeOfResponse' => $admTimeOfResponse,
	'adm-outreachNumber' => FILTER_SANITIZE_NUMBER_INT,
	'adm-location' => FILTER_SANITIZE_STRING,
	'adm-consultant' => FILTER_SANITIZE_STRING,
	'adm-locationPriorToSource' => FILTER_SANITIZE_STRING,
	'adm-hospital' => FILTER_SANITIZE_STRING,
	'adm-speciality' => FILTER_SANITIZE_STRING,
	'pdi-primaryDiagnosisNotes' => FILTER_SANITIZE_STRING,
	'pdi-Type' => FILTER_SANITIZE_STRING,
	'pdi-System' => FILTER_SANITIZE_STRING,
	'pdi-Site' => FILTER_SANITIZE_STRING,
	'pdi-Process' => FILTER_SANITIZE_STRING,
	'pdi-Condition' => FILTER_SANITIZE_STRING,
	'pdi-Code' => FILTER_SANITIZE_STRING,
	'sdi-secondaryDiagnosisNotes' => FILTER_SANITIZE_STRING,
	'sdi-Type' => FILTER_SANITIZE_STRING,
	'sdi-System' => FILTER_SANITIZE_STRING,
	'sdi-Site' => FILTER_SANITIZE_STRING,
	'sdi-Process' => FILTER_SANITIZE_STRING,
	'sdi-Condition' => FILTER_SANITIZE_STRING,
	'sdi-Code' => FILTER_SANITIZE_STRING,
	'otr-outreachDischargeOutcome' => FILTER_SANITIZE_STRING,
	'otr-summary' => FILTER_SANITIZE_STRING
     );
     
     $myinputs = filter_input_array(INPUT_POST, $sanitiseArgs);
     /*PRINT "TEST INPUT <BR />";
	var_dump($myinputs);*/
     
     /*
      * End data sanitisation
      */ 
    
     for ($i = 0; $i < count($formFields); $i++) {
	    $_POST[$formFields[$i]] = checkValues(soft_Clean($_POST[$formFields[$i]]));
	    //if ($sanitiseArgs[$formFields[$i]])
	    $sanitisedInput[$i] = ($myinputs[$formFields[$i]]) ? $myinputs[$formFields[$i]] : $_POST[$formFields[$i]];
	    //print "".$formFields[$i].": ".$_POST[$formFields[$i]]." = ".$sanitisedInput[$i]."<br />";
	    if ($sanitisedInput[$i]) $_POST[$formFields[$i]] = $sanitisedInput[$i];
     }
    
    $Mela_SQL->SQLLock_Unlock($_POST['lnk_ID']);
    
    
    //=======
     /*
      * Required fields
      *
      * If a field contained within this array is not present, an error will be thrown
      * This only checks the existence of the field and that it has a non-empty value
      */
     $requiredFields = array('adm-outreachNumber' => 'Admission - ID/Outreach Number');
     
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
				    <a href='patDmg.php?lnkID=".$_POST['patLNK']."'>Please click here to return</a>
				</span>
			    </div>
			</div>";
		  exit;
	   }
     }
     
     // Demographics
     // Hospital Admission Date, DATE OF BIRTH
     // Errors: Language='".$_POST['dmg-language']."',  (after dmg_Ethnic, LANGUAGE IS RESERVED SQL KEYWORD)
     
     // 4D hates empty date/time fields for some reason so we can't pass an empty DOB. Instead we'll have to do it like this
     $dmgDOB = "";
     //if ($_POST['dmg-DOB'] != "" OR strlen($_POST['dmg-DOB']) > 0 OR $_POST['dmg-DOB'] != "00/00/00" OR $_POST['dmg-DOB'] != "dd/mm/yyyy") {
     if (strlen($_POST['dmg-DOB']) != 0) {
	   $dmgDOB = "dmg_DateOfBirth='".$_POST['dmg-DOB']."',";
     }
     
     $dmgNormalBPSQL = "";
     if (strlen($_POST['dmg-normalBP']) != 0) {
	   $dmgNormalBPSQL = "dmg_Normal_BP=".$_POST['dmg-normalBP'].",";
     }
     
     // DATE OF BIRTH MUST BE SET OR GIVEN A DEFAULT VALUE ELSE IT WILL RESULT IN REJECTED QUERY!
     $dmg_updQuery = "UPDATE Demographic SET dmg_HospitalNumber='".$_POST['dmg-hospitalNumber']."', dmg_NHSNumber='".$_POST['dmg-NHSNumber']."', dmg_FirstName='".$_POST['dmg-firstName']."',
     dmg_MiddleName='".$_POST['dmg-middleName']."', dmg_Surname='".$_POST['dmg-surname']."', $dmgDOB dmg_Sex='".$_POST['dmg-sex']."', dmg_Ethnic='".$_POST['dmg-ethnicity']."',
     $dmgNormalBPSQL NHS_Verification='".$_POST['dmg-NHSVerification']."', dmg_Address='".$_POST['dmg-address']."', dmg_Town='".$_POST['dmg-town']."',
     dmg_County='".$_POST['dmg-county']."', dmg_PostCode='".$_POST['dmg-postCode']."', dmg_Country='".$_POST['dmg-country']."',
     dmg_Phone='".$_POST['dmg-phone']."', dmg_NOK='".$_POST['dmg-NOK']."', dmg_NOK_Phone='".$_POST['dmg-NOKPhone']."', dmg_NOK_Relation='".$_POST['dmg-NOKRelation']."',
     dmg_NOK_Address='".$_POST['dmg-NOKAddress']."', dmg_NOK_Town='".$_POST['dmg-NOKTown']."',
     dmg_NOK_County='".$_POST['dmg-NOKCounty']."', dmg_NOK_PostCode='".$_POST['dmg-NOKPostCode']."', dmg_NOK_Country='".$_POST['dmg-NOKCountry']."', Language='".$_POST['dmg-language']."'
     WHERE dmg_ID=".$_POST['dmg-ID']."";
     try { 
	  $dmg_updResult = odbc_exec($connect,$dmg_updQuery); 
	 } 
     catch (RuntimeException $e) { 
	   print("Exception caught: $e");
     } //echo $dmg_updQuery;
    
     // Medical Staff
     /*
      * Links up to Medstaff_LINK 
      *$medstaff_updQuery = "UPDATE ";
     try { 
	  $dmg_updResult = odbc_exec($connect,$dmg_updQuery); 
	 } 
     catch (RuntimeException $e) { 
	   print("Exception caught: $e");
     }
     */
     
     // Admission
     // To-do: call details-referrer, call details-time of call, call details-or responder, or-time of response, call details-scored by ward, call details-triggered by ward
     // call details-score on REF, consultant, planned admission, OR readmission, prior surgery undertaken, research tags, weight, height, BMI, event number
     
     // Turn pregnant into boolean value
     $pregnant = ($_POST['dmg-pregnant'] == 1) ? TRUE : FALSE;
     
     $admOriginalHospitalAdmission = str_replace('-','/',$_POST['adm-originalhospitalAdmission']);
     //$admOriginalHospitalAdmission = dateToString($_POST['adm-originalhospitalAdmission']);
     
     $originalHospitalAdmissionSQL = "";
     if (strlen($admOriginalHospitalAdmission) != 0) {
	   $originalHospitalAdmissionSQL = "adm_OriginalHospitalAdmission='".$admOriginalHospitalAdmission."',";      
     }
     
     $admICUAdmissionSQL = "";
     if (strlen($_POST['adm-ICUAdmission']) != 0) {
	   $admICUAdmissionSQL = "adm_ICUAdmission='".$_POST['adm-ICUAdmission']."',";
     }
     
     $admHospitalAdmissionSQL = "";
     if (strlen($_POST['dmg-hospitalAdmissionDate']) != 0) {
	   $admHospitalAdmissionSQL = "adm_HospitalAdmission='".$_POST['dmg-hospitalAdmissionDate']."',";
     }
     
     $formatICUAdminTime = new DateTime($_POST['adm-ICUAdmissionTime']);
     $ICUAdminTime = $formatICUAdminTime->format('H:i:s');
     $ICUAdminTimeSQL = "";
     if ($ICUAdminTime != '00:00:00') {
	   $ICUAdminTimeSQL = "adm_ICU_Admission_Time='".$ICUAdminTime."',";
     }
     
     $formatICUDischargeTime = new DateTime($_POST['adm-ICUDischargeTime']);
     $ICUDischargeTime = $formatICUDischargeTime->format('H:i:s');
     $ICUDischargeTimeSQL = "";
     if ($ICUDischargeTime != '00:00:00') {
	   $ICUDischargeTimeSQL = "adm_ICU_Discharge_Time='".$ICUDischargeTime."',";
     }
     
     $formatICUDischargeDelay = new DateTime($_POST['adm-ICUHDUDischargeDelay']);
     $ICUDischargeDelay = $formatICUDischargeDelay->format('H:i:s');
     $ICUDischargeDelaySQL = "";
     if ($ICUDischargeDelay != '00:00:00') {
	   $ICUDischargeDelaySQL = "adm_ICU_DischargeDelay='".$ICUDischargeDelay."',";
     }
     
     $formatHDUAdminTime = new DateTime($_POST['adm-HDUAdmissionTime']);
     $HDUAdminTime = $formatHDUAdminTime->format('H:i:s');
     $HDUAdminTimeSQL = "";
     if ($HDUAdminTime != '00:00:00') {
	   $HDUAdminTimeSQL = "adm_HDU_Admission_Time='".$HDUAdminTime."',";
     }
     
     $formatHDUDischargeTime = new DateTime($_POST['adm-HDUDischargeTime']);
     $HDUDischargeTime = $formatHDUDischargeTime->format('H:i:s');
     $HDUDischargeTimeSQL = "";
     if ($HDUDischargeTime != '00:00:00') {
	   $HDUDischargeTimeSQL = "adm_HDU_Discharge_Time='".$HDUDischargeTime."',";
     }
     
     $formatCCUAdminTime = new DateTime($_POST['adm-CCUAdmissionTime']);
     $CCUAdminTime = $formatCCUAdminTime->format('H:i:s');
     $CCUAdminTimeSQL = "";
     if ($CCUAdminTime != '00:00:00') {
	   $CCUAdminTimeSQL = "adm_CCU_Admission_Time='".$CCUAdminTime."',";
     }
     
     $formatCCUDischargeTime = new DateTime($_POST['adm-CCUDischargeTime']);
     $CCUDischargeTime = $formatCCUDischargeTime->format('H:i:s');
     $CCUDischargeTimeSQL = "";
     if ($CCUDischargeTime != '00:00:00') {
	   $CCUDischargeTimeSQL = "adm_CCU_Discharge_Time='$CCUDischargeTime',";
     }
     
     if (!isset($_POST['adm-ORReadmission'])) {
	   $_POST['adm-ORReadmission'] = 0;
     }
     $admReAdmission = ($_POST['adm-ORReadmission'] == 1) ? 'true' : 'false';
     
     foreach($_POST as $key => $value){
	   $exp_key = explode('_', $key);
	   if($exp_key[0] == 'adm-ResearchTag'){
		$admResearchTags[] = $value;
	   }
     }
     
     $admResearchTagsSQL = "";
     if ($admResearchTags) {
     $gluedAdmResearchTags = implode(',',$admResearchTags);
     $gluedAdmResearchTags .= ",";
     
     $admResearchTagsSQL = "adm_ResearchTag='".$gluedAdmResearchTags."',";
     }
     
     $admDischargeDateSQL = "";
     if (strlen($_POST['adm-ICUDischarge']) != 0) {
	   $admDischargeDateSQL = "adm_ICU_Discharge_Date='".$_POST['adm-ICUDischarge']."',";
     }
     
     $admReferralDateSQL = "";
     if (strlen($_POST['adm-referralDate']) != 0) {
	   $admReferralDateSQL = "adm_ReferralDate='".$_POST['adm-referralDate']."',";
     }
     
     $admHDUAdmissionSQL = "";
     if (strlen($_POST['adm-HDUAdmission']) != 0) {
	   $admHDUAdmissionSQL = "adm_HDU_Admission_Date='".$_POST['adm-HDUAdmission']."',";
     }
     
     $admHDUDischargeSQL = "";
     if (strlen($_POST['adm-HDUDischarge']) != 0) {
	   $admHDUDischargeSQL = "adm_HDU_Discharge_Date='".$_POST['adm-HDUDischarge']."',";
     }
     
     $admCCUAdmissionSQL = "";
     if (strlen($_POST['adm-CCUAdmission']) != 0) {
	   $admCCUAdmissionSQL = "adm_CCU_Admission_Date='".$_POST['adm-CCUAdmission']."',";
     }
     
     $admCCUDischargeSQL = "";
     if (strlen($_POST['adm-CCUDischarge']) != 0) {
	   $admCCUDischargeSQL = "adm_CCU_Discharge_Date='".$_POST['adm-CCUDischarge']."',";
     }
     
     $admHeightSQL = "";
     if (strlen($_POST['dmg-height']) != 0) {
	   $admHeightSQL = "adm_Height=".$_POST['dmg-height'].",";
     }
     
     $admWeightSQL = "";
     if (strlen($_POST['dmg-weight']) != 0) {
	   $admWeightSQL = "adm_Weight=".$_POST['dmg-weight'].",";
     }
     
     $admSurgeryClassification = "";
     if (strlen($_POST['adm-srgClassification']) != 0) {
	   $admWeightSQL = "adm_SurgeryClassification='".$_POST['adm-srgClassification']."',";
     }
     
     $admASAScoreSQL = "";
     if (strlen($_POST['adm-ASAScoreDD']) != 0) {
	   $admASAScoreSQL = "ASAScore='".$_POST['adm-ASAScoreDD']."',";
     }
     
     /* Consultant is passed by ID because it is used to get consultant speciality but
      * stored as first_Name Last_Name so fetch that and consultant speciality here from ID
      */
     
     if (!empty($_POST['adm-consultant'])) {
     $admConsultantQuery = "SELECT mds_FirstName, mds_Surname, mds_Speciality FROM Medstaff 
       WHERE mds_ID=".$_POST['adm-consultant']." AND Consultant=true";
     try { 
	  $adm_ConResult = odbc_exec($connect,$admConsultantQuery);
	  if ($adm_ConResult) {
		  $admConsultant = odbc_fetch_array($adm_ConResult);
	  }
	 } 
     catch (RuntimeException $e) { 
	   print("Exception caught: $e");
     }
     
     $consultantName = $admConsultant['MDS_FIRSTNAME']." ".$admConsultant['MDS_SURNAME'];
     } else {
	   $consultantName = "";
     }
     // AdmStatus='".$_POST['adm-status']."' - Disabled form elements don't get submitted. Could include a hidden textfield below it with same value but there is no option to change this value anyway so no point in updating atm
     // Pregnant='".$_POST['dmg-pregnant']."'
     $adm_updQuery = "UPDATE Admission SET $originalHospitalAdmissionSQL $admICUAdmissionSQL $ICUAdminTimeSQL
     $admHospitalAdmissionSQL $admDischargeDateSQL $ICUDischargeTimeSQL $admReferralDateSQL $admHDUAdmissionSQL
     $HDUAdminTimeSQL $admHDUDischargeSQL $HDUDischargeTimeSQL $ICUDischargeDelaySQL $admSurgeryClassification $admASAScoreSQL
     $admCCUAdmissionSQL $CCUAdminTimeSQL $admCCUDischargeSQL $CCUDischargeTimeSQL adm_ICU_DischargeDelay_Reason='".$_POST['adm-delayReason']."',
     adm_Number=".$_POST['adm-outreachNumber'].", adm_Ward='".$_POST['adm-location']."', adm_Consultant='$consultantName', Speciality_Entered='".$admConsultant['MDS_SPECIALITY']."', adm_HospitalAdmissionSource='".$_POST['adm-sourceOfAdmission']."',
     adm_LP_HospAdmSource='".$_POST['adm-locationPriorToSource']."', Hosp='".$_POST['adm-hospital']."', adm_PlannedAdmission='".$_POST['adm-plannedAdmission']."', adm_PriorSurgery='".$_POST['adm-priorSurgeryUndertaken']."',
     adm_ReAdmisson=".$admReAdmission.", $admResearchTagsSQL adm_Scored='".$_POST['adm-scoredByWard']."', adm_Triggered='".$_POST['adm-triggeredByWard']."', $admWeightSQL $admHeightSQL adm_BodyMassIndex=".$_POST['dmg-BMIHidden']."
     WHERE adm_ID=".$_POST['adm_ID']."";
     try { 
	  $adm_updResult = odbc_exec($connect,$adm_updQuery); 
	 } 
     catch (RuntimeException $e) { 
	   print("Exception caught: $e");
     } //echo $adm_updQuery;
     
     
     // Outreach Caller Detail - INCOMPLETE
     // Part of Admission page but uses different database table
     $formatOTCTOC = new DateTime($_POST['adm-timeOfCall']);
     $OTCTOCTime = $formatOTCTOC->format('H:i:s');
     
     $formatOTCTOR = new DateTime($_POST['adm-timeOfResponse']);
     $OTCTORTime = $formatOTCTOR->format('H:i:s');
     
     $formatOTCDelay = new DateTime($_POST['adm-hiddenDelay']);
     $OTCDelayTime = $formatOTCDelay->format('H:i:s');
     
     // TO-DO: OR Responder (after Caller) is medical staff, NEWS Score (Is this calculated or saved?), EWSS on referral/first trigger stuff
     $otrc_updQuery = "UPDATE OR_Call SET Caller='".$_POST['adm-referrer']."', Time_Of_Call='".$OTCTOCTime."', Time_Of_Response='".$OTCTORTime."', Delay='".$OTCDelayTime."' WHERE cal_ID=".$_POST['otc_calID']."";
     try { 
	  $otrc_updResult = odbc_exec($connect,$otrc_updQuery); 
	 } 
     catch (RuntimeException $e) { 
	   print("Exception caught: $e");
     } //echo $otrc_updQuery;
     
     
     // Discharge
     // Requires fields to be present, won't accept blank entries for some reason
     $otcDischargeDateSQL = "";
     if (strlen($_POST['otr-outreachDischargeDate']) != 0) {
	   $otcDischargeDateSQL = "otc_OTRDischargeDate='".$_POST['otr-outreachDischargeDate']."',";
     }
     
     $otcDischargeTimeSQL = "";
     if (strlen($_POST['otr-outreachDischargeTime']) != 0) {
	   $otcDischargeTimeSQL = "otc_OTRDischargeTime='".$_POST['otr-outreachDischargeTime']."',";
     }
     
     $otcLevel2DaysSQL = "";
     if (strlen($_POST['otr-level2Days']) != 0) {
	   $otcLevel2DaysSQL = "otc_Level_2_Days=".$_POST['otr-level2Days'].",";
     }
     
     $disc_updQuery = "UPDATE Outcome SET otc_Outcome='".$_POST['otr-outreachDischargeOutcome']."', otc_OTRDischargeStatus='".$_POST['otr-outreachDischargeStatusOutcome']."', 
     $otcDischargeTimeSQL otc_LOS=".$_POST['otr-lengthOfCareHidden'].", $otcLevel2DaysSQL otc_DNR='".$_POST['otc-DNR']."'
     WHERE otc_ID=".$_POST['lnk_otcID']."";
     try { 
	  $disc_updResult = odbc_exec($connect,$disc_updQuery); 
	 } 
     catch (RuntimeException $e) { 
	   print("Exception caught: $e");
     } //echo $disc_updQuery;
     
     
     // Diagnosis
     // Could be ICD10 diagnosis, in which case all of this is redundant so check here
     if ($_POST['pdi-primaryDiagnosisNotes']) {
	   // GET descriptions from passed POST IDs
	   if ($_POST['pdi-System'] != '') {
		 $sql = "SELECT Description FROM System WHERE Sys_ID =".$_POST['pdi-System']."";
		 try { 
		       $result = odbc_exec($connect,$sql); 
		       if($result){ 
			      $pdiSystem = odbc_fetch_array($result);
		       } 
		       else{ 
		       throw new RuntimeException("Failed to connect."); 
		       } 
			   } 
		       catch (RuntimeException $e) { 
			       print("Exception caught: $e");
		       }
	   }
	   
	   if ($_POST['pdi-Site'] != '') {      
		 $sql = "SELECT Description FROM Site WHERE Site_ID =".$_POST['pdi-Site']."";
		 try { 
		       $result = odbc_exec($connect,$sql); 
		       if($result){ 
			      $pdiSite = odbc_fetch_array($result);
		       } 
		       else{ 
		       throw new RuntimeException("Failed to connect."); 
		       } 
			   } 
		       catch (RuntimeException $e) { 
			       print("Exception caught: $e");
		       }
	   }
	   
	   if ($_POST['pdi-Process'] != '') {      
		 $sql = "SELECT Description FROM Process WHERE Proc_ID =".$_POST['pdi-Process']."";
		 try { 
		       $result = odbc_exec($connect,$sql); 
		       if($result){ 
			      $pdiProcess = odbc_fetch_array($result);
		       } 
		       else{ 
		       throw new RuntimeException("Failed to connect."); 
		       } 
			   } 
		       catch (RuntimeException $e) { 
			       print("Exception caught: $e");
		       }
	   }
	  
	   if ($_POST['pdi-Condition'] != '') {
		 $sql = "SELECT Description FROM Condition WHERE Cond_ID =".$_POST['pdi-Condition']."";
		 try { 
		       $result = odbc_exec($connect,$sql); 
		       if($result){ 
			      $pdiCondition = odbc_fetch_array($result);
		       } 
		       else{ 
		       throw new RuntimeException("Failed to connect."); 
		       } 
			   } 
		       catch (RuntimeException $e) { 
			       print("Exception caught: $e");
		       }
	   }
	   
	   $pdi_updQuery = "UPDATE Diagnosis SET dgn_AdmissionPrimaryReason='".$_POST['pdi-primaryDiagnosisNotes']."', dgn_Reason1_Type='".$_POST['pdi-Type']."', dgn_Reason1_System='".$pdiSystem['DESCRIPTION']."',
	   dgn_Reason1_Site='".$pdiSite['DESCRIPTION']."', dgn_Reason1_Process='".$pdiProcess['DESCRIPTION']."', dgn_Reason1_Condition='".$pdiCondition['DESCRIPTION']."', dgn_Reason1_Code='".$_POST['pdi-Code']."' 
	   WHERE dgn_ID=".$_POST['pdi-dgnLNK']."";
	   try { 
		$pdi_updResult = odbc_exec($connect,$pdi_updQuery); 
	       } 
	   catch (RuntimeException $e) { 
		 print("Exception caught: $e");
	   } //echo $pdi_updQuery;
     }
     
     
     // Other diagnosis
     // GET descriptions from passed POST IDs
     if (!empty($_POST['sdi-System'])) {
	   $sql = "SELECT Description FROM System WHERE Sys_ID =".$_POST['sdi-System']."";
	   try { 
		 $result = odbc_exec($connect,$sql); 
		 if($result){ 
			$sdiSystem = odbc_fetch_array($result);
		 } 
		 else{ 
		 throw new RuntimeException("Failed to connect."); 
		 } 
		     } 
		 catch (RuntimeException $e) { 
			 print("Exception caught: $e");
		 }
     }
     
     if (!empty($_POST['sdi-Site'])) {      
	   $sql = "SELECT Description FROM Site WHERE Site_ID =".$_POST['sdi-Site']."";
	   try { 
		 $result = odbc_exec($connect,$sql); 
		 if($result){ 
			$sdiSite = odbc_fetch_array($result);
		 } 
		 else{ 
		 throw new RuntimeException("Failed to connect."); 
		 } 
		     } 
		 catch (RuntimeException $e) { 
			 print("Exception caught: $e");
		 }
     }
     
     if (!empty($_POST['sdi-Process'])) {      
	   $sql = "SELECT Description FROM Process WHERE Proc_ID =".$_POST['sdi-Process']."";
	   try { 
		 $result = odbc_exec($connect,$sql); 
		 if($result){ 
			$sdiProcess = odbc_fetch_array($result);
		 } 
		 else{ 
		 throw new RuntimeException("Failed to connect."); 
		 } 
		     } 
		 catch (RuntimeException $e) { 
			 print("Exception caught: $e");
		 }
     }
    
     if (!empty($_POST['sdi-Condition'])) {
	   $sql = "SELECT Description FROM Condition WHERE Cond_ID =".$_POST['sdi-Condition']."";
	   try { 
		 $result = odbc_exec($connect,$sql); 
		 if($result){ 
			$sdiCondition = odbc_fetch_array($result);
		 } 
		 else{ 
		 throw new RuntimeException("Failed to connect."); 
		 } 
		     } 
		 catch (RuntimeException $e) { 
			 print("Exception caught: $e");
		 }
     }
     
     $sdi_updQuery = "UPDATE Diagnosis SET dgn_AdmissionSecondaryReason='".$_POST['sdi-secondaryDiagnosisNotes']."', dgn_Reason2_Type='".$_POST['sdi-Type']."', dgn_Reason2_System='".$sdiSystem['DESCRIPTION']."',
     dgn_Reason2_Site='".$sdiSite['DESCRIPTION']."', dgn_Reason2_Process='".$sdiProcess['DESCRIPTION']."', dgn_Reason2_Condition='".$sdiCondition['DESCRIPTION']."', dgn_Reason2_Code='".$_POST['sdi-Code']."' 
     WHERE dgn_ID=".$_POST['sdi-dgnLNK']."";
     try { 
	  $sdi_updResult = odbc_exec($connect,$sdi_updQuery); 
	 } 
     catch (RuntimeException $e) { 
	   print("Exception caught: $e");
     } //echo $sdi_updQuery;
     
     // Surgery
     
     
     // Co-morbidity 
     // Co-morbidity is groups/items so results will have to be looped through and each one added to the database
     if (!empty($_POST['COnotes'])) {
	   foreach ($_POST['COnotes'] AS $key => $val) {
		//print "<b>Value</b>: $key as ".$val."<br />";
			
		$como_updQuery = "UPDATE Co_Morbidity SET com_Notes='$val' WHERE com_ID=$key AND lnk_ID=".$_POST['patLNK']."";
		try { 
		    $como_updResult = odbc_exec($connect,$como_updQuery); 
		} 
		catch (RuntimeException $e) { 
		    print("Exception caught: $e");
		}
	    }
     }
     
     
    // PMH
    
    $pmh_updQuery = "UPDATE ICNARC_PMH SET icn_EPMH='".$_POST['pmh-evidenceAvailableToAssess']."', icn_PMHP='".$_POST['pmh-pastMedicalHistory']."', icn_BPC='".$_POST['pmh-biopsyProvenCirrhosis']."', icn_RADIOX='".$_POST['pmh-radiotherapy']."', icn_PH='".$_POST['pmh-portalHypertension']."',
    icn_CHEMOX='".$_POST['pmh-chemotherapy']."', icn_HE='".$_POST['pmh-hepaticEncephalopathy']."', icn_META='".$_POST['pmh-metastaticDisease']."', icn_VSCD='".$_POST['pmh-verySevereCardiovascularDisease']."',
    icn_AMLALLMM='".$_POST['pmh-acuteMyelogenousLeukaemia']."', icn_SRD='".$_POST['pmh-severeRespiratoryDisease']."', icn_CMLCLL='".$_POST['pmh-chronicMyelogenousLeukaemia']."',
    icn_HV='".$_POST['pmh-homeVentilation']."', icn_LYM='".$_POST['pmh-lymphoma']."', icn_CRRX='".$_POST['pmh-chronicRenalReplacementTherapy']."', icn_CICIDS='".$_POST['pmh-congenitalImmunohormonal']."',
    icn_AIDS='".$_POST['pmh-AIDS']."', icn_STERX='".$_POST['pmh-steroidTreatment']."'
    WHERE icn_ID=".$_POST['lnk_icnID']."";
    $pmh_update = odbc_prepare($connect, $pmh_updQuery);
    $pmh_updResult = odbc_execute($pmh_update) or die(odbc_errormsg());
     
     
     // Discharge
     /*
     $dis_updQuery = "UPDATE Outcome SET otc_Outcome='".$_POST['otr-outreachDischargeOutcome']."', otc_OTRDischargeStatus='".$_POST['otr-outreachDischargeStatusOutcome']."', otc_OTRDischargeDate='".$_POST['otr-outreachDischargeDate']."',
     otc_OTRDischargeTime='".$_POST['otr-outreachDischargeTime']."', otc_LOS='".$_POST['otr-lengthOfCare']."', otc_Level_2_Days='".$_POST['otr-level2Days']."', otc_OTRDischargeStatus='".$_POST['otr-hospitalDischargeStatus']."',
     otc_DeathDate='".$_POST['otr-hospitalDeathDate']."', otc_HospDischargeTime='".$_POST['otr-hospitalDischargeTime']."', otc_HospLOS='".$_POST['otr-hospitalLengthStay']."',
     otc_HospDischargeDestination='".$_POST['otr-destination']."', Summary='".$_POST['otr-summary']."' WHERE ???";*/
     
     // Modalities
     // Modalities is groups/items so results will have to be looped through and each one added to the database
     if ($_POST['MOnotes']) {
	   foreach ($_POST['MOnotes'] AS $key => $val) {
		 //print "<b>Value</b>: $key as ".$val."<br />";
			
		 $mo_updQuery = "UPDATE Modality SET mod_Comments='$val' WHERE ID=$key AND mod_lnkID = ".$_POST['patLNK']."";
		 try { 
		      $mo_updResult = odbc_exec($connect,$mo_updQuery); 
		     } 
		 catch (RuntimeException $e) { 
		       print("Exception caught: $e");
		 }
	      }
     }
     
    // Surgeries (G+I)
    if ($_POST['SUnotes']) {
	   foreach ($_POST['SUnotes'] AS $key => $val) {
		 //print "<b>Value</b>: $key as ".$val."<br />";
			
		 $mo_updQuery = "UPDATE Surgery SET srg_Notes='$val' WHERE srg_ID=$key AND srg_lnkID = ".$_POST['patLNK']."";
		 try { 
		      $mo_updResult = odbc_exec($connect,$mo_updQuery); 
		     } 
		 catch (RuntimeException $e) { 
		       print("Exception caught: $e");
		 }
	      }
     }
     
    // CCMDS
    /*
     * Data passed is a text string from Table_Lists_Items['Long_name'] but needs to be saved as ['short_name']
     */
    $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TLI.tbi_TBLID=TL.TBL_ID AND TLI.Long_Name='".$_POST['ccmds-unitFunction']."'";
    try { 
	$result = odbc_exec($connect,$sql); 
	if($result){ 
	    $ccmdsUnitFunction = odbc_fetch_array($result);
	} 
	else { 
	    throw new RuntimeException("Failed to connect."); 
	} 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    }
    
    $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TLI.tbi_TBLID=TL.TBL_ID AND TLI.Long_Name='".$_POST['ccmds-unitBedConfiguration']."'";
    try { 
	$result = odbc_exec($connect,$sql); 
	if($result){ 
	    $ccmdsUnitBedConfiguration = odbc_fetch_array($result);
	} 
	else { 
	    throw new RuntimeException("Failed to connect."); 
	} 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    }
    
    $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TLI.tbi_TBLID=TL.TBL_ID AND TLI.Long_Name='".$_POST['ccmds-admissionSource']."'";
    try { 
	$result = odbc_exec($connect,$sql); 
	if($result){ 
	    $ccmdsAdmissionSource = odbc_fetch_array($result);
	} 
	else { 
	    throw new RuntimeException("Failed to connect."); 
	} 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    }
    
    $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TLI.tbi_TBLID=TL.TBL_ID AND TLI.Long_Name='".$_POST['ccmds-sourceLocation']."'";
    try { 
	$result = odbc_exec($connect,$sql); 
	if($result){ 
	    $ccmdsSourceLocation = odbc_fetch_array($result);
	} 
	else { 
	    throw new RuntimeException("Failed to connect."); 
	} 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    }
    
    $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TLI.tbi_TBLID=TL.TBL_ID AND TLI.Long_Name='".$_POST['ccmds-admissionType']."'";
    try { 
	$result = odbc_exec($connect,$sql); 
	if($result){ 
	    $ccmdsAdmissionType = odbc_fetch_array($result);
	} 
	else { 
	    throw new RuntimeException("Failed to connect."); 
	} 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    }
    
    $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TLI.tbi_TBLID=TL.TBL_ID AND TLI.Long_Name='".$_POST['ccmds-dischargeStatus']."'";
    try { 
	$result = odbc_exec($connect,$sql); 
	if($result){ 
	    $ccmdsDischargeStatus = odbc_fetch_array($result);
	} 
	else { 
	    throw new RuntimeException("Failed to connect."); 
	} 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    }
    
    $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TLI.tbi_TBLID=TL.TBL_ID AND TLI.Long_Name='".$_POST['ccmds-dischargeDestination']."'";
    try { 
	$result = odbc_exec($connect,$sql); 
	if($result){ 
	    $ccmdsDischargeDestination = odbc_fetch_array($result);
	} 
	else { 
	    throw new RuntimeException("Failed to connect."); 
	} 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    }
    
    $sql = "SELECT TLI.Short_Name
	    FROM Table_Lists TL, Table_List_Items TLI
	    WHERE TLI.tbi_TBLID=TL.TBL_ID AND TLI.Long_Name='".$_POST['ccmds-dischargeLocation']."'";
    try { 
	$result = odbc_exec($connect,$sql); 
	if($result){ 
	    $ccmdsDischargeLocation = odbc_fetch_array($result);
	} 
	else { 
	    throw new RuntimeException("Failed to connect."); 
	} 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    }
    
    $ccmdsUnitFunctionSQL = "";
    if (strlen($ccmdsUnitFunction['SHORT_NAME']) > 0) {
	$ccmdsUnitFunctionSQL = "UnitFunction=".$ccmdsUnitFunction['SHORT_NAME'].",";	
    }
    
    $ccmdsBedConfigSQL = "";
    if (strlen($ccmdsUnitBedConfiguration['SHORT_NAME']) > 0) {
	$ccmdsBedConfigSQL = "BedConfig=".$ccmdsUnitBedConfiguration['SHORT_NAME'].",";	
    }
    
    $ccmdsAdmSrcSQL = "";
    if (strlen($ccmdsAdmissionSource['SHORT_NAME']) > 0) {
	$ccmdsAdmSrcSQL = "AdmSrc=".$ccmdsAdmissionSource['SHORT_NAME'].",";	
    }
    
    $ccmdsSrcLocationSQL = "";
    if (strlen($ccmdsSourceLocation['SHORT_NAME']) > 0) {
	$ccmdsSrcLocationSQL = "SrcLocation=".$ccmdsSourceLocation['SHORT_NAME'].",";	
    }
    
    $ccmdsAdmTypeSQL = "";
    if (strlen($ccmdsAdmissionType['SHORT_NAME']) > 0) {
	$ccmdsAdmTypeSQL = "AdmType=".$ccmdsAdmissionType['SHORT_NAME'].",";	
    }
    
    $ccmdsDischStatusSQL = "";
    if (strlen($ccmdsDischargeStatus['SHORT_NAME']) > 0) {
	$ccmdsDischStatusSQL = "DischStatus=".$ccmdsDischargeStatus['SHORT_NAME'].",";	
    }
    
    $ccmdsDischDestSQL = "";
    if (strlen($ccmdsDischargeDestination['SHORT_NAME']) > 0) {
	$ccmdsDischDestSQL = "DischDest=".$ccmdsDischargeDestination['SHORT_NAME'].",";	
    }
    
    $ccmdsDischLocationSQL = "";
    if (strlen($ccmdsDischargeLocation['SHORT_NAME']) > 0) {
	$ccmdsDischLocationSQL = "DischLocation=".$ccmdsDischargeLocation['SHORT_NAME'].",";	
    }
    
    $ccmds_updQuery = "UPDATE CCMDS SET $ccmdsUnitFunctionSQL
		       $ccmdsBedConfigSQL $ccmdsAdmSrcSQL $ccmdsSrcLocationSQL
		       $ccmdsAdmTypeSQL $ccmdsDischStatusSQL $ccmdsDischDestSQL
		       TrtSpecialityCode='".$_POST['ccmds-treatmentFunction']."'		       
		       WHERE dmg_ID=".$_POST['dmg-ID']."";
    try { 
	$ccmds_updResult = odbc_exec($connect,$ccmds_updQuery); 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    } //echo $ccmds_updQuery;
     
    ?>
    <div style="height:100%; width:100%;">
	   <div class="successbox" style="vertical-align: middle; text-align: center; margin-left: auto; margin-right: auto; border: 3px solid #66CD00; background-color: #CCFFCC; color: #596C56; height:25%; width:25%;">
		  <span style="vertical-align: middle; height: 100%;">
			 <h2>
				Saved successfully
			 </h2>
			 <a href="patListing.php">Please click here if you are not automatically redirected within 5 seconds</a>
		  </span>
	   </div>
    </div>
    <?php
    $Mela_SQL->Exec4DSQL("SQLLock_Unlock", $_POST['patLNK']);
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