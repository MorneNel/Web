<?php
error_reporting(E_ALL ^ E_NOTICE);

include './MelaClass/functions.php';
include './MelaClass/db.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/authInitScript.php';

/*
 * Since all tabs are technically on one page and PHP only
 * runs once, we need to grab the
 * SQL data for all tabs at once right now
 */
if (!$_REQUEST['lnkID'] && !$_POST['lnkID']) {
	//$$$ Error here
	$lnkID=0;
} else {
	$lnkID = filter_var($_REQUEST['lnkID'], FILTER_SANITIZE_NUMBER_INT);
}

// Assessment must also be set
if (!$_REQUEST['assessment'] && !$_POST['assessment']) {
	//$$$ Error here
	$assessmentID=0;
} else {
	$assessmentID = filter_var($_REQUEST['assessment'], FILTER_SANITIZE_NUMBER_INT);
}

$query = "SELECT d.dmg_ID, d.dmg_FirstName, d.dmg_MiddleName, d.dmg_Surname, d.dmg_NHSNumber, DATE_TO_CHAR(d.dmg_DateOfBirth,'yyyy-Mm-Dd') AS DMG_DATEOFBIRTH, d.dmg_PostCode, d.dmg_HospitalNumber, d.dmg_Sex,
		lnk.lnk_dmgID, lnk.lnk_dgnID, lnk.lnk_ID, lnk.TriggStat,
		dlk.dlk_otrID, DATE_TO_CHAR(dlk.dlk_AssessDate,'yyyy-Mm-Dd') AS DLK_ASSESSDATE, dlk.dlk_AssessStartTime, dlk.dlk_AssessEndTime, dlk.dlk_AssessDuration, dlk.dlk_days_past_Op, dlk.dlk_ID, dlk.GPLetter_Given,
		dlk.dlk_patID, dlk.dlk_ppaID, dlk.dlk_SourceID,
		otr.otr_ID, otr.otr_ScoringSystem, otr.otr_ActionTaken, otr.otr_LastSeenBy_Grade, DATE_TO_CHAR(otr.otr_LastSeenBy_Date,'yyyy-Mm-Dd') AS OTR_LASTSEENBY_DATE, otr.otr_LastSeenBy_Time, DATE_TO_CHAR(otr.otr_PreviousContactDate,'yyyy-Mm-Dd') AS OTR_PREVIOUSCONTACTDATE, otr.otr_PreviousContactTime, otr.Out_Level_Care,
		otr.otr_Ward, otr.otr_AssessmentReason, otr.otr_FollowUp, otr.otr_SeenBy, otr.otr_SeenBy_Name, otr.chr_VisitType, otr.chr_AppointmentType, otr.otr_CLScore, otr.chr_NextAppointment,
		otr.chr_Attended, otr.chr_WhyNotAttended, otr.otr_SuggestedNextAssess, otr.Location_bay, otr.Location_bed, otr.Timeliness_Hours, otr.Timeliness_Minutes, otr.otr_TeamReferral,
		otr.InapReason, otr.otr_Accompanied_By, otr.Weight, otr.Hight, otr.BMI, otr.ResearchTag, otr.otr_CareLevel,
		otr.otr_PainAtRest, otr.otr_PainAtActivity, otr.otr_PainScoreWard, otr.otr_Sedation, otr.otr_Nausea, otr.otr_Pruritus, otr.SepsisOnArival, otr.SepsisSource, otr.Timeliness_visit,
		otr.otr_SeenBy1, otr.otr_SeenBy2, otr.otr_SeenBy_Name1, otr.otr_SeenBy_Name2,
		pat.pat_PhysExam, pat.pat_Serum_Bicarbonate, DATE_TO_CHAR(pat.pat_Blood_Test_Date,'yyyy-Mm-Dd') AS PAT_BLOOD_TEST_DATE, pat.pat_Blood_Test_Time, pat.pat_Serum_Na, pat.pat_Serum_K, pat.pat_Serum_Urea,
		pat.pat_Serum_Creatinine, pat.pat_Serum_Glucose, pat.pat_Serum_Ca, pat.pat_InorganicPhosphate, pat.pat_TotalProtein, pat.pat_Serum_Albumin, pat.pat_Serum_Mg,
		pat.pat_Blood_Lactate, pat.pat_White_Cell_Count, pat.pat_Serum_Haematocrit, pat.pat_Serum_Hb, pat.pat_Platelet, pat.pat_Prothrombin, pat.pat_Thromboplastin,
		pat.pat_Amylase, pat.pat_AlkalinePO4, pat.pat_AST, pat.pat_ALT, pat.pat_INR, pat.pat_Serum_Bilirubin, pat.pat_GGT, pat.pat_Temperature, pat.pat_Weight, pat.pat_PsycoExam, pat.pat_PhyioExam,
		pat.pat_Systolic_BP, pat.pat_Diastolic_BP, pat.pat_Mean_arterial_bp, pat.pat_HeartRate, pat.pat_RespiratoryRate, pat.pat_O2Saturation, pat.pat_O2Rec_Unit, pat.pat_O2deliv_by,
		pat.pat_UrineDD, pat.Urine_in_last_hrs, pat.pat_AVPU, pat.pat_Pain, pat.ABG_type, pat.pat_PaO2, pat.pat_FIO2, pat.pat_PaCO2, pat.pat_pH, pat.pat_Base_Excess, pat.pat_SaO2,
		pat.pat_HCO3, DATE_TO_CHAR(pat.pat_ABG_Test_Date,'yyyy-Mm-Dd') AS PAT_ABG_TEST_DATE, pat.pat_ABG_Test_Time, pat.pat_Mean_arterial_bp, pat.pat_CRP, pat.pat_DDimers, pat.pat_Troponin_Level, pat.pat_Cardiac_Kinase, pat.pat_ESR,
		pat.pat_RAP, pat.pat_Rhythm, pat.pat_Paced, pat.pat_GCS_Eyes, pat.pat_GCS_Motor, pat.pat_GCS_Verbal, pat.pat_GCS_Grimace, pat_GCS, pat.Limb_LeftArm, pat.Limb_LeftLeg, pat.Limb_RightArm, pat.Limb_RightLeg,
		pat.LimbTotal, pat.Seizure_Type, pat.Seizure_Desc, pat.PupilReact_Left, pat.PupilReact_Right, pat.PupilDilation_Left, pat.PupilDilation_Right, pat.SOFA, pat.NEWS_Score,
		pat.pat_EWSSFDDCI, pat.pat_PsycoExam, pat.pat_PhyioExam, pat.pat_UrineOutput, pat.pat_O2Received,
		ppa.ppa_LowestTemperature, ppa.ppa_HighestTemperature, ppa.ppa_LowestBicarbonate, ppa.ppa_HighestBicarbonate, ppa.ppa_LowestWhiteCellCount, ppa.ppa_HighestWhiteCellCount,
		ppa.ppa_LowestCTemperature, ppa.ppa_HighestCTemperature, ppa.ppa_LowestTemperature, ppa.ppa_HighestTemperature, ppa.ppa_LowestBicarbonate, ppa.ppa_HighestBicarbonate, ppa.ppa_LowestWhiteCellCount, ppa.ppa_HighestWhiteCellCount,
		ppa.ppa_LowestNa, ppa.ppa_HighestNa, ppa.ppa_LowestHaemocrit, ppa.ppa_HighestHaemocrit, ppa.ppa_LowestSystolic_BP, ppa.ppa_HighestSystolic_BP, ppa.ppa_LowestK, ppa.ppa_HighestK,
		ppa.ppa_LowestHb, ppa.ppa_HighestHb, ppa.ppa_LowestUrea, ppa.ppa_HighestUrea, ppa.ppa_LowestPlateletCount, ppa.ppa_HighestPlateletCount, ppa.ppa_LowestDiastolic_BP, ppa.ppa_HighestDiastolic_BP,
		ppa.ppa_LowestPairedDiasBP, ppa.ppa_HighestPairedDiasBP, ppa.ppa_LowestCreatinine, ppa.ppa_HighestCreatinine, ppa.ppa_LowestPairedSysBP, ppa.ppa_HighestPairedSysBP, ppa.ppa_LowestProthrombin, ppa.ppa_HighestProthrombin,
		ppa.ppa_LowestGlucose, ppa.ppa_HighestGlucose, ppa.ppa_LowestThromboPlastin, ppa.ppa_HighestThromboPlastin, ppa.ppa_LowestHeartRate, ppa.ppa_HighestHeartRate, ppa.ppa_LowestCalcium, ppa.ppa_HighestCalcium,
		ppa.ppa_LowestRespiratoryRate, ppa.ppa_HighestRespiratoryRate, ppa.ppa_LowestAlbumin, ppa.ppa_HighestAlbumin, ppa.ppa_LowestAST, ppa.ppa_HighestAST, ppa.ppa_HighestALT, ppa.ppa_LowestALT,
		ppa.ppa_LowestO2Saturation, ppa.ppa_HighestO2Saturation, ppa.ppa_CPAP, ppa.ppa_LowestUrineOutput, ppa.ppa_WorstAVPU, ppa.ppa_LowestAlkaline, ppa.ppa_HighestAlkaline, ppa.ppa_LowestAmylase, ppa.ppa_HighestAmylase,
		ppa.ppa_Fluid_Input, ppa.ppa_Pain, ppa.ppa_LowestBilirubin, ppa.ppa_HighestBilirubun, ppa.ppa_GCS_Eyes, ppa.ppa_GCS_Motor, ppa.ppa_GCS_Verbal, ppa.ppa_WorstGCS, ppa.ppa_PaO2, ppa.ppa_LowestFIO2, ppa.ppa_LowestPaCO2, ppa.ppa_LowestPH,
		ppa.ppa_APACHEII, ppa.ppa_APACHEII_Prob, ppa.ppa_SAPSII, ppa.ppa_SAPSII_Prob,
		sca.Pigmentation, sca.Vascularity, sca.Pliability, sca.Height,
		infs.Infection_Source,
		orc.Caller, orc.OR_Responder, orc.Time_Of_Response,
		adm.adm_calID, DATE_TO_CHAR(adm.adm_ReferralDate,'yyyy-Mm-Dd') AS ADM_REFERRALDATE, adm.adm_Number, adm.adm_Consultant, adm.NonAdmOutcome, adm.Non_ADM_sorted, adm.adm_ResearchTag, adm.NEWS_Score, adm.Referral_CareLevel,
		DATE_TO_CHAR(cds.R4Disch_Date,'yyyy-Mm-Dd') AS R4DISCH_DATE, cds.AdvRespSupp, cds.BasicRespSupp, cds.AdvCardioSupp, cds.BasicCardioSupp, cds.RenalSupp, cds.NeuroSupp, cds.DermaSupp, cds.LiverSupp, cds.GISupport,
		cds.MaxOrganSupp, cds.Level3, cds.Level2, cds.Level1, cds.Level0,
		DATE_TO_CHAR(otc.otc_OTRDischargeDate,'yyyy-Mm-Dd') AS OCT_OTRDISCHARGEDATE,
		DATE_TO_CHAR(rse.AdmDate,'yyyy-Mm-Dd') AS ADMDATE, rse.Reason_For_Adm, rse.Resus_Post_Arrest_dest, rse.Resus_LongPost_Arrest_dest, rse.SurvivalToDisch, DATE_TO_CHAR(rse.HospDischDate,'yyyy-Mm-Dd') AS HOSPDISCHDATE, rse.SedationAtDisch, rse.Outcome_StatusHosp, rse.HLOS, rse.Dest, rse.NeuroStatAtDischCPC,
		rse.CompletedBy, rse.Call_222Call, DATE_TO_CHAR(rse.Resus_Date,'yyyy-Mm-Dd') AS RESUS_DATE, rse.Resus_Confirmed, rse.Resus_In_Hosp, rse.Resus_Location, rse.Ambulance_Called, rse.Resus_Monitored, rse.Resus_Cause, rse.Ambulance_Arrival,
		rse.Resus_Witnessed, rse.WitnessedBy, rse.Arrival_At_AE, rse.IncidentType, rse.Resus_Time_collapse, rse.TCollapse_NotDoc, rse.Resus_Time_team_called, rse.TTeamColled_NotDoc, rse.Resus_Time_team_arival,
		rse.TTeamArrived_NotDoc, rse.Status_On_Team_Arrival, rse.Outlier, rse.FormCompleted, rse.Init_Rhythm, rse.Resus_NotAttemt_Why, rse.Resus_Attempted, rse.Resus_Attempted_type, rse.CPRStarted, rse.Resus_Time_CPR_Started,
		rse.Resus_CPR_Provider, rse.Resus_Time_Adv_Airway, rse.Resus_Airway_Control, rse.FirstDefibShock, rse.Resus_Defib_Provider, rse.CPRStopped, rse.Defib_used, rse.Time_DefAirway, rse.Resus_CPR_Stoped_Reason, rse.END_Time,
		rse.Def_Airway_used, rse.MEWS_NotDocumented, rse.MEWSPriorArrest, DATE_TO_CHAR(rse.MEWS_Date,'yyyy-Mm-Dd') AS MEWS_DATE, rse.MEWS_Time, rse.MEWS_SeenBy_Time, rse.MEWS_SeenBy_NotDoc, rse.TriggPast12H, rse.ReviewByORPriorArrest, rse.PriorArrestCareConcernYN,
		rse.MEWS_SeenBy, rse.MEWS_Action1, rse.MEWS_Action2, rse.Temp, rse.HR, rse.SystolicBP, rse.DiastolicBP, rse.CapRefillTime, rse.O2, rse.O2Sat, rse.Potassium, rse.PaO2, rse.PaCO2, rse.BloodSugar, rse.Bicarb, rse.Lactate, rse.SaO2,
		rse.PupilsL, rse.PupilsR, rse.AVPU, rse.GCS_Eye, rse.GCS_Motor, rse.GCS_Verbal, rse.GCS_Total, rse.Resus_Recovery, rse.Resus_Remained_For, rse.Resus_Hypothermia_protocol, rse.NeuroStat, rse.VentStat, rse.TrtPlanAfterROSC,
		rse.DNARAfterROSC, rse.DNAR, rse.Guildlines, rse.Outcome_Status, DATE_TO_CHAR(rse.DeathDate,'yyyy-Mm-Dd') AS DEATHDATE, rse.DeathTime, rse.TOD_NotDocumented, rse.Disch_CritIncFormComp, rse.Incident_Form_No, rse.OutcomeComments
		FROM Demographic d
		LEFT OUTER JOIN LINK lnk ON d.dmg_ID = lnk.lnk_dmgID
		LEFT OUTER JOIN DAILY_LINK dlk ON lnk.lnk_ID = dlk.dlk_lnkID
		LEFT OUTER JOIN Outreach otr ON dlk.dlk_otrID = otr.otr_ID
		LEFT OUTER JOIN PhyAssess_AtTime pat ON pat.pat_ID = dlk.dlk_patID
		LEFT OUTER JOIN PhyAssess_PrevTime ppa ON ppa.ppa_ID = dlk.dlk_ppaID
		LEFT OUTER JOIN Scars_Outcome sca ON sca.ScarOutcome_dlkID = dlk.dlk_ScarOutcomeID
		LEFT OUTER JOIN Infection_Source infs ON infs.source_dlkID = dlk.dlk_SourceID
		LEFT OUTER JOIN Admission adm ON adm.adm_ID = lnk.lnk_admID
		LEFT OUTER JOIN OR_Call orc ON orc.cal_ID = adm.adm_calID
		LEFT OUTER JOIN CCMDS cds ON cds.dmg_ID = lnk.lnk_dmgID
		LEFT OUTER JOIN Outcome otc ON otc.otc_ID = lnk.lnk_otcID
		LEFT OUTER JOIN Resus_event rse ON rse.Resuscitation_ID = lnk.lnk_Resus_ID
		WHERE dlk.dlk_ID=$assessmentID"; // rse.Duration for resuscitation causes an error and I have no idea why at the moment - 23/05

try { 
      $result = odbc_exec($connect,$query); 
if($result){ 
	$patient = odbc_fetch_array($result);
	global $patient;
} 
else{ 
throw new RuntimeException("Failed to connect."); 
} 
    } 
catch (RuntimeException $e) { 
    print("Exception caught: $e");
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <?php include('header.php'); ?>
    <title>
	<?php echo $preferences['prf_HospitalName']; ?>
    </title>
    </head>



<!--     <div id="top_of_page">
	<a href='patListing.php'>Click here for Patient Listing</a> - <a href='MelaClass/logoutAction.php'>Click here to logout</a>
    </div> -->
    <?php
	// This supposedly speeds up rendering time - see http://developer.yahoo.com/performance/rules.html#etags
	flush();
    ?>
    <body>
	<div class="container clearfix">
	    <div class="Header_List_Ass">
		    <table class="head_table">
			    <tr class="head_pat_info_row">
				    <td class="head_left">
					    <?php echo $patient['DMG_FIRSTNAME'].'&nbsp;'.$patient['DMG_SURNAME']; ?>

				    </td>
				    <td class="head_cell_middle">
					    <table class="head_middle">
						    <tr><td>Sex&nbsp;</td><td><?php echo $patient['DMG_SEX']; ?></td></tr>
						    <tr><td>DOB&nbsp;</td><td>
							<?php 
								$splitDOB = explode(' ',$patient['DMG_DATEOFBIRTH']);
								$splittmpDOB = explode('-',$splitDOB[0]);
								$tmpDOB = array_reverse($splittmpDOB);
								echo join('-',$tmpDOB);
							?>
						</td></tr>
					    </table>
				    </td>
				    <td class="head_cell_right">
					    <table class="head_right">
						    <tr><td>NHS No&nbsp;</td><td><?php echo $patient['DMG_NHSNUMBER']; ?></td></tr>
						    <tr><td>Hospital No&nbsp;</td><td><?php echo $patient['DMG_HOSPITALNUMBER']; ?></td></tr>
						    <tr><td>Referral No&nbsp;</td><td><?php echo $patient['ADM_NUMBER']; ?></td></tr>
					    </table>
				    </td>
			    </tr>
			    <tr class="head_cron_info_row">
				    <td colspan="3" class="head_cron_info_cell">
					    <span class="cron_bold">Assessment Date: </span>
						<?php
						$splitAssessDate = explode (' ', $patient['DLK_ASSESSDATE']);
						echo getDayFromDate($patient['DLK_ASSESSDATE']).'&nbsp;'.'&ndash;'.'&nbsp;';
							
							$splitAssessDate = explode(' ',$patient['DLK_ASSESSDATE']);
							$splittmpAssessDate = explode('-',$splitAssessDate[0]);
							$tmpAssessDate = array_reverse($splittmpAssessDate);
							echo join('-',$tmpAssessDate);
						?>
					    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="cron_bold">Start: </span><?php echo convert4DTime($patient['DLK_ASSESSSTARTTIME']); ?>&emsp;&emsp;
					    <?php if ($preferences['prf_EndtimeDuration'] == 'true') { ?><span class="cron_bold">End: </span><?php echo convert4DTime($patient['DLK_ASSESSENDTIME']); ?>&emsp;&emsp;<span class="cron_bold">Duration: </span><?php echo convert4DTime($patient['DLK_ASSESSDURATION']); } ?>
					    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="cron_bold">Post Op: </span><?php echo $patient['DLK_DAYS_PAST_OP']; ?>
				    </td>
			    </tr>
		    </table>
	    </div>
	    <?php $Form = new Mela_Forms('patAss','formProcessAss.php','POST','save_form'); ?>
	    <?php
		$hiddenDLK = $Form->hiddenField('patDLK',$patient['DLK_OTRID']);
		echo $hiddenDLK;    
		
		$hiddenDLKID = $Form->hiddenField('patDLKID',$patient['DLK_ID']);
		echo $hiddenDLKID;
		
		$hiddenPPADLKID = $Form->hiddenField('ppaDLK',$patient['DLK_PPAID']);
		echo $hiddenPPADLKID;
		
		$hiddenSourceDLKID = $Form->hiddenField('sourceDLK',$patient['DLK_SOURCEID']);
		echo $hiddenSourceDLKID;
		
		$hiddenLNKID = $Form->hiddenField('hiddenLNKID',$lnkID);
		echo $hiddenLNKID;
		
		$hiddenAssessmentID = $Form->hiddenField('hiddenAssessmentID',$assessmentID);
		echo $hiddenAssessmentID;
		
		$hiddenUsername = $Form->hiddenField('hiddenUsername',$auth->UsrKeys->Username);
		echo $hiddenUsername;
	    ?>
	    <div id="tabs2" class="btn_bar">
	    	<button style="font-size:small;color:green" type="button"  name="vsHTMLogoutButt" value="Logout" onclick="logOutConfirm(<?php echo $patient['LNK_ID']; ?>)">Logout</button>
		    <!--<button style="font-size:small;color:black" type="button" name="vsHTMDemographicsButt" value="Back" onclick="toDemographics(<?php echo $patient['LNK_ID']; ?>)">Go back</button>
		    <button style="font-size:small;color:red" type="button" name="vsHTMCancelButt" value="Cancel" id="cancelButton" data-lnkid="<?php echo $patient['LNK_ID']; ?>">Cancel</button>-->
		    <button style="font-size:small;color:red" type="button" name="vsHTMDemographicsButt" value="Back" onclick="toDemographics(<?php echo $patient['LNK_ID']; ?>)">Cancel</button>
		    <button style="font-size:small;color:green" type="submit"  name="vsHTMSaveButt" value="Save" onclick="return OnSave(Ass)">Save</button>
		    <?php if ($auth->UsrKeys->UserGrpName == "Admin Group") { ?><button style="font-size:small;color:red" type="button" name="vsHTMDeleteButt" id="deletePatient" data-lnkid="<?php echo $patient['LNK_ID']; ?>" value="Delete">Delete</button><?php } ?>
		    <?php if ($appName == "Outreach" && $patient['TRIGGSTAT'] == "TRIG") { ?> <button style="font-size:small;color:gray" type="button" name="vsHTMSeenButt" id="patientSeen" data-lnkid="<?php echo $patient['LNK_ID']; ?>" data-user="<?php echo $auth->UsrKeys->Username; ?>" value="Patient Seen">Patient Seen</button> <?php } ?>
		    <!-- Form submission success -->
		    <div id="success" style="display: none;">
			    Success
		    </div>
	    </div>
	    <div class="validationErrorBox" style="display:none;">
		<!-- Necessary for displaying any form validation errors - leave blank, jQuery fills this in -->
	    </div>
	    <div id="tabs">
		<ul style="display:none;">
		    <li><a href="#page-1"><span>Assess Details</span></a></li>
		    <li><a href="#page-2"><span>Pain Assessment</span></a></li>
		    <li><a href="#page-3"><span>Physical Examination2</span></a></li>
		    <li><a href="#page-4"><span>Physiology 1A</span></a></li>
		    <li><a href="#page-5"><span>Physiology 1B</span></a></li>
		    <li><a href="#page-6"><span>Physiology 2</span></a></li>
		    <li><a href="#page-7"><span>Sepsis/Infections</span></a></li>
		    <li><a href="#page-8"><span>Medications</span></a></li>
		    <li><a href="#page-9"><span>Interventions</span></a></li>
		    <li><a href="#page-10"><span><?php if ($preferences['CRITINC_TITLE'] != '') echo $preferences['CRITINC_TITLE']; else echo "Critical Incidents"; ?></span></a></li>
		    <li><a href="#page-11"><span>Surgery</span></a></li>
		    <li><a href="#page-12"><span>Visit Outcome</span></a></li>
		    <li><a href="#page-13"><span>Tasks</span></a></li>
		    <li><a href="#page-14"><span>Modalities</span></a></li>
		    <li><a href="#page-15"><span>Co-morbidity</span></a></li>
		    <li><a href="#page-16"><span>Scar Outcome</span></a></li>
		    <li><a href="#page-17"><span>Care Level</span></a></li>
		</ul>
		    


	    <div class="cssmenu">	
		<ul>
		    <li class='tabs_item' id='tabAssessDetails'><a href='#page-1' class='active_pat_tab'><span>Assess Details</span></a></li>
		    <?php if ($appName == "AcutePain" && $preferences['ShowPainAss'] == 'true') { ?><li class='tabs_item' id='tabPainAssessment'><a href='#page-2'><span>Pain Assessment</span></a></li><?php } ?>



			<?php if ($appName == "Outreach") { ?>
				<?php if ($preferences['prf_Physical_Examination'] == 'true') { ?>
					<li class='has-sub tabs_item'><a href='#page-2'><span>Observation</span></a>
					    <ul>
					    	<li class='tabsub' id='tabCareLevel'><a href='#page-17'><span>Care Level</span></a></li>
							<li class='tabsub' id='tabPhysicalExamination'><a href='#page-3'><span>Physical examination</span></a></li>
					    </ul>
					</li>
				 <?php } else { ?>
					<li class='tabs_item' id='tabCareLevel'><a href='#page-17'><span>Care Level</span></a></li>
				 <?php } ?>
		    <?php } else { ?>
				<li class='tabs_item' id='tabCareLevel'><a href='#page-17'><span>Care Level</span></a></li>
			<?php } ?>


		    <?php if ($appName == "Outreach") { ?>
				<li class='has-sub tabs_item'><a href='#page-2'><span>Investigation</span></a>
				    <ul>
						<?php if ($preferences['prf_ShowPhys1'] == 'true') { ?><li class='tabsub' id='tabPhysiology1A'><a href='#page-4'><span>Physiology 1A</span></a></li><?php } ?>
						<?php if ($preferences['prf_ShowPhys1'] == 'true') { ?><li class='tabsub' id='tabPhysiology1B'><a href='#page-5'><span>Physiology 1B</span></a></li><?php } ?>
						<?php if ($preferences['Physiology2'] == 'true') { ?><li class='tabsub' id='tabPhysiology2'><a href='#page-6'><span>Physiology 2</span></a></li><?php } ?>
				    </ul>
				</li>
		    <?php } ?>	

				<li class='has-sub tabs_item'><a href='#page-2'><span>Management</span></a>
				    <ul>
						<?php if ($preferences['prf_Show_Interventions'] == 'true') { ?><li class='tabsub' id='tabInterventions'><a href='#page-9'><span>Interventions</span></a></li><?php } ?>
					    <?php if ($preferences['prf_Show_Medication'] == 'true') { ?><li class='tabsub' id='tabMedications'><a href='#page-8'><span>Medications</span></a></li><?php } ?>
					    <?php if ($appName == "Outreach") { ?>
							<?php if ($preferences['prf_Infection'] == 'true') { ?><li class='tabsub' id='tabSepsis'><a href='#page-7'><span>Sepsis/Infections</span></a></li><?php } ?>
					    <?php } ?>
				    </ul>
				</li>

		    <?php if ($preferences['ShowCritIncidents'] == 'true') { ?><li class='tabs_item' id='tabCriticalIncidents'><a href='#page-10'><span><?php if ($preferences['CritInc_Title'] != '') { echo $preferences['CritInc_Title']; } else { echo "Critical Incidents"; } ?></span></a></li><?php } ?>
		    <?php if ($preferences['prf_ShowSurgery_Ass'] == 'true') { ?><li class='tabs_item' id='tabSurgery'><a href='#page-11'><span>Surgery</span></a></li><?php } ?>
		    <?php if ($preferences['show_daily_outcome'] == 'true') { ?><li class='tabs_item' id='tabVisitOutcome'><a href='#page-12'><span>Visit Outcome</span></a></li><?php } ?>
		    <?php if ($preferences['Show_Tasks'] == 'true') { ?><li class='tabs_item' id='tabTasks'><a href='#page-13'><span>Tasks</span></a></li><?php } ?>
		    <?php if ($preferences['ModalityInAss'] == 'true') { ?><li class='tabs_item' id='tabModalities'><a href='#page-14'><span>Modalities</span></a></li><?php } ?>
		</ul>
	    </div>
	    <div style="clear: both;"></div>

	    <!-- Assess -->
	    <div id="page-1"> 
		    <table>
			<tr>
			    <td>
			    <?php
			    include('assessmentDetails.php');
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- Assess -->


	    <!-- Pain -->
	    <div id="page-2"> 
		    <table>
			<tr>
			    <td>
			    <?php
				if ($appName == "AcutePain" && $preferences['ShowPainAss'] == 'true') include('painAssessment.php');
			    ?>
			    </td>
			</tr>
		    </table>      
	    </div>  <!-- Pain -->


	    <div id="page-3">  <!-- PhysEx -->
		    <table>
			<tr>
			    <td>
			    <?php
				if ($appName == "Outreach" && $preferences['prf_Physical_Examination'] == 'true') include('physicalexamination.php');
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- PhysEx -->


	    <div id="page-4">  <!-- Phys1A -->
		    <table>
			<tr>
			    <td>
			    <?php
				if ($preferences['prf_ShowPhys1'] == 'true') include('physiology1A.php');
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- Phys1A -->
	    
	    <div id="page-5">  <!-- Phys1B -->
		    <table>
			<tr>
			    <td>
			    <?php
				if ($preferences['prf_ShowPhys1'] == 'true') include('physiology1B.php');
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- Phys1B -->
	    
	    <div id="page-6">  <!-- Phys2 -->
		    <table>
			<tr>
			    <td>
			    <?php
				if ($preferences['Physiology2'] == 'true') include('physiology2.php');
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- Phys2 -->
	    
	    <div id="page-7">  <!-- Sepsis -->
		    <table>
			<tr>
			    <td>
			    <?php
			    if ($preferences['prf_Infection'] == 'true') include('sepsis.php');
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- Sepsis -->
	    
	    <div id="page-8">  <!-- Meds -->
		    <table>
			<tr>
			    <td>
			    <?php
			    if ($preferences['prf_Show_Medication'] == 'true') {
				if ($appName == "Outreach") {
				    include('medicationsOR.php');
				}
				else {
				    include('medications.php');
				}
			    }
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- Meds -->


	    <div id="page-9">  <!-- Int -->
		    <table>
			<tr>
			    <td>
			    <?php
				if ($preferences['prf_Show_Interventions'] == 'true') include('interventions.php');
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- Int -->


	    <div id="page-10">  <!-- Adv -->
		    <table>
			<tr>
			    <td>
			    <?php
			    //include('painRatingScale.php');
			    //include('examination.php');
			    //include('referralDetails.php');
			    //include('CCMDS.php');
			    //include('outcome.php');
			    //include('resuscitationOutcome.php');
			    //include('resuscitationOutcome2.php');
			    //include('resuscitationPhysiology.php');
			    //include('resuscitationInterventions.php');
			    //include('resuscitation.php'); // Incomplete, medical staff/team leader need filling in but don't know how it selects from resus_tables
			    //include('painAssessment.php');
			    //include('careLevel.php');
				if ($preferences['ShowCritIncidents'] == 'true') include('criticalIncidents.php');
			    //include('respiteCare.php');
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- Adv -->
	    
	    <div id="page-11">  <!-- Surg -->
		    <table>
			<tr>
			    <td>
			    <?php
			    if ($preferences['prf_ShowSurgery_Ass'] == 'true') {
				if ($preferences['prf_UseOPCSCodes'] == 'true') {
					include('surgeryOPCS.php');	
				} else {
					include('surgery.php');
				}
			    }
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- Surg -->


	    <div id="page-12">  <!-- Vis -->
		    <table>
			<tr>
			    <td>
			    <?php
			    //<!--#4DSCRIPT/htm_PatDmg_PMH/XXX-->
				if ($preferences['show_daily_outcome'] == 'true') include('dailyOutcome.php');
			    ?>
			    </td>
			</tr>
		    </table>
	    </div>  <!-- Vis -->


	    <div id="page-13">  <!-- Task -->
		    <table>
			<tr>
			    <td>
			    <?php
				if ($preferences['Show_Tasks'] == 'true') include('tasks.php');
			    ?>
			    </td>
			</tr>
		    </table>						
	    </div>  <!-- Task -->
	    
	    <div id="page-14">  <!-- Modalities -->
		    <table>
			<tr>
			    <td>
			    <?php
				if ($preferences['ModalityInAss'] == 'true') include('modalities.php');
			    ?>
			    </td>
			</tr>
		    </table>						
	    </div>  <!-- Modalities -->
	    
	    <div id="page-15">  <!-- Co-morbidity -->
		    <table>
			<tr>
			    <td>
			    <?php
				// Don't know why this is here - can't see an option for it on the menus at all
				//include('comorbidity.php');
			    ?>
			    </td>
			</tr>
		    </table>						
	    </div>  <!-- Co-morbidity -->
	    
	    <div id="page-16">  <!-- Scar outcome -->
		    <table>
			<tr>
			    <td>
			    <?php
				// Don't know why this is here - can't see an option for it on the menus at all
				//include('scarOutcome.php');
			    ?>
			    </td>
			</tr>
		    </table>						
	    </div>  <!-- Scar outcome -->
	    
	    <div id="page-17">  <!-- Care level -->
		    <table>
			<tr>
			    <td>
			    <?php
			    include('careLevel.php');
			    ?>
			    </td>
			</tr>
		    </table>						
	    </div>  <!-- Care level-->
	    

	    </div> <!--  <div id="tabs">  -->
	    </form>
	</div> <!--  <div class="container clearfix">  -->
    </body>
</html>
<?php
include('javascriptCommon.php');
include('javascriptAssessments.php');
include('footer.php');
?>