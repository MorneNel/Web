<?php
include('db.php');

$sexQuery = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145109142";
/*$patientID = 145100007;
$sexQuery = "SELECT d.dmg_ID, d.dmg_FirstName, d.dmg_MiddleName, d.dmg_Surname, d.dmg_DateOfBirth, d.dmg_AgeYears, d.dmg_AgeMonths, d.dmg_AgeDays, d.dmg_Sex, d.dmg_NHSNumber, d.dmg_HospitalNumber,
		d.dmg_PostCode,	d.dmg_Normal_BP, d.dmg_Address, d.dmg_Phone, d.dmg_NOK, d.dmg_NOK_Phone, d.dmg_NOK_Address, d.dmg_NOK_PostCode,
		a.adm_Number, a.adm_OriginalHospitalAdmission, a.adm_HospitalAdmission, a.adm_ReferralDate, a.adm_calID, a.adm_height, a.adm_weight, a.adm_BodyMassIndex, a.Pregnant, a.adm_ReferralDate, a.adm_ICU_DischargeDelay,
		a.adm_ICUAdmission, a.adm_ICU_Admission_Time, a.adm_ICU_Discharge_Date, a.adm_ICU_Discharge_Time, a.adm_HDU_Admission_Date, a.adm_HDU_Admission_Time, a.adm_HDU_Discharge_Date, a.adm_HDU_Discharge_Time,
		a.adm_CCU_Admission_Date, a.adm_CCU_Admission_Time, a.adm_CCU_Discharge_Date, a.adm_CCU_Discharge_Time, a.Referral_Person, a.adm_Number,
		dia.dgn_ID, dia.dgn_AdmissionPrimaryReason, dia.dgn_Reason1_Type, dia.dgn_Reason1_System, dia.dgn_Reason1_Site, dia.dgn_Reason1_Process, dia.dgn_Reason1_Condition, dia.dgn_Reason1_Code,
		dia.dgn_AdmissionSecondaryReason, dia.dgn_Reason2_Type, dia.dgn_Reason2_System, dia.dgn_Reason2_Site, dia.dgn_Reason2_Process, dia.dgn_Reason2_Condition, dia.dgn_Reason2_Code,
		otc.otc_OTRDischargeDate, otc.otc_OTRDischargeTime, otc.otc_LOS, otc.otc_Level_2_Days, otc.otc_DeathDate, otc.otc_HospDischargeTime, otc.otc_HospLOS
		FROM Demographic d
		LEFT OUTER JOIN LINK l ON d.dmg_ID = l.lnk_dmgID
		LEFT OUTER JOIN Admission a ON a.adm_ID = l.lnk_admID
		LEFT OUTER JOIN Diagnosis dia ON dia.dgn_ID = l.lnk_dgnID
		LEFT OUTER JOIN Outcome otc ON otc.otc_ID = l.lnk_otcID
		WHERE d.dmg_ID=$patientID";*/
                        try { 
                            $sexResult = odbc_exec($connect,$sexQuery); 
                                if($sexResult){ 
                                        while ($sexpatient = odbc_fetch_array($sexResult)) {
                                                print 'ln: '.$sexpatient['LONG_NAME'].' - sn: '.$sexpatient['SHORT_NAME'].'';
                                        }
                                } 
                                else{ 
                                throw new RuntimeException("Failed to connect."); 
                                } 
                                    } 
                                catch (RuntimeException $e) { 
                                        print("Exception caught: $e");
                                        //exit;
                                }
?>