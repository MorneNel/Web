<?php
include('db.php');

$patientID = 145100007;
$patient['ADM_CALID'] = 145100007;
/*
//$adm_query = "SELECT a.*, d.dmg_ID, l.lnk_dmgID, l.lnk_admID FROM Admission a, Demographic d, LINK l WHERE l.lnk_admID = a.adm_ID AND l.lnk_dmgID = '$patientID'";
/*$adm_query = "SELECT d.dmg_FirstName, d.dmg_MiddleName, d.dmg_Surname, d.dmg_DateOfBirth, d.dmg_AgeYears, d.dmg_AgeMonths, d.dmg_AgeDays, d.dmg_Sex, a.adm_Number, a.adm_ReferralDate
            FROM Demographic d
            LEFT OUTER JOIN LINK l ON d.dmg_ID = l.lnk_dmgID
            LEFT OUTER JOIN Admission a ON a.adm_ID = l.lnk_admID
            WHERE d.dmg_ID=$patientID";
$adm_query = "SELECT d.dmg_FirstName, d.dmg_MiddleName, d.dmg_Surname, d.dmg_DateOfBirth, d.dmg_AgeYears, d.dmg_AgeMonths, d.dmg_AgeDays, d.dmg_Sex, d.dmg_NHSNumber, d.dmg_HospitalNumber,
		d.dmg_PostCode,	d.dmg_Normal_BP, d.dmg_Address, d.dmg_Phone, d.dmg_NOK, d.dmg_NOK_Phone, d.dmg_NOK_Address, d.dmg_NOK_PostCode,
		a.adm_Number, a.adm_OriginalHospitalAdmission, a.adm_HospitalAdmission, a.adm_ReferralDate, a.adm_height, a.adm_weight, a.adm_BodyMassIndex, a.Pregnant, a.adm_ReferralDate, a.adm_ICU_DischargeDelay,
		a.adm_ICUAdmission, a.adm_ICU_Admission_Time,
		dia.dgn_ID, dia.dgn_AdmissionPrimaryReason, dia.dgn_Reason1_Type, dia.dgn_Reason1_System, dia.dgn_Reason1_Site, dia.dgn_Reason1_Process, dia.dgn_Reason1_Condition, dia.dgn_Reason1_Code,
		dia.dgn_AdmissionSecondaryReason, dia.dgn_Reason2_Type, dia.dgn_Reason2_System, dia.dgn_Reason2_Site, dia.dgn_Reason2_Process, dia.dgn_Reason2_Condition, dia.dgn_Reason2_Code
		FROM Demographic d
		LEFT OUTER JOIN LINK l ON d.dmg_ID = l.lnk_dmgID
		LEFT OUTER JOIN Admission a ON a.adm_ID = l.lnk_admID
		LEFT OUTER JOIN Diagnosis dia ON dia.dgn_ID = l.lnk_dgnID
		WHERE d.dmg_ID=$patientID";
$adm_result = odbc_exec($connect,$adm_query);
$adm_patient = odbc_fetch_array($adm_result);

print_r($adm_patient);
//echo $adm_patient['ADM_NUMBER'];
*/

$or_query ="SELECT * FROM OR_Call WHERE cal_ID=".$patient['ADM_CALID']."";
$or_result = odbc_exec($connect,$or_query);
$or_patient = odbc_fetch_array($or_result);
print_r($or_patient);
?>