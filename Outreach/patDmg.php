<?php

error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/functions.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

// include('class/Mela_SQL.php');
// include('inc/class/auth.class.php');
// $auth = new cuonic\PHPAuth2\Auth; 

// $loggedin = $auth->isLoggedIn($_COOKIE['auth_session']);
// if ($loggedin == FALSE) {
// 	include("pages/login.php");
// 	exit;
// } else {
// 	$auth->updateSessionExpiry($_COOKIE['auth_session']);
// 	$auth->fillUserKeys($_COOKIE['auth_session']);
// }

// $Mela_SQL = new Mela_SQL($auth->UsrKeys);

// $preferences = $Mela_SQL->getPreferences();
// $appName = $auth->UsrKeys->AppName; // $Mela_SQL->getAppName();

/* Patient ID must have been passed else take them to patient listing screen */
if (!$_REQUEST['lnkID'] && !$_POST['lnkID']) {
	//$$$ Error here
	$lnkID=0;
} else {
	$lnkID = filter_var($_REQUEST['lnkID'], FILTER_SANITIZE_NUMBER_INT);
}

if (!$_REQUEST['lnkID']) {
	header('Location: patListing.php');
	}
	else {
		$lnkID = filter_var($_REQUEST['lnkID'], FILTER_SANITIZE_NUMBER_INT);
		//$msg = $Mela_SQL->SQLLock_CondLockMsg($lnkID);
		if ($msg != "")
		{
			//$$$ Proper dialog showing the message
			//$$$ Back to listing (OR check at the listing level)
			echo $msg;
			exit;
			//header('Location: patListing.php');
		}
	}

/* Since all tabs are technically on one page and PHP only
 * runs on each 'proper' page refresh, we need to grab the
 * SQL data for all tabs at once right now
 */
$query = "SELECT d.dmg_ID, d.dmg_FirstName, d.dmg_MiddleName, d.dmg_Surname, DATE_TO_CHAR(d.dmg_DateOfBirth,'yyyy-Mm-Dd') AS DMG_DATEOFBIRTH, d.dmg_AgeYears, d.dmg_AgeMonths, d.dmg_AgeDays, d.dmg_Sex, d.dmg_Ethnic, d.dmg_NHSNumber, d.dmg_HospitalNumber,
		d.dmg_PostCode, d.dmg_Town, d.dmg_Country, d.dmg_County, d.dmg_Normal_BP, d.dmg_Address, d.dmg_Phone, d.dmg_NOK, d.dmg_NOK_Phone, d.dmg_NOK_Address, d.dmg_NOK_PostCode, d.dmg_NOK_Town, d.dmg_NOK_Relation, d.dmg_NOK_County, d.dmg_NOK_Country, d.Language, d.NHS_Verification,
		a.adm_ID, a.adm_Number, DATE_TO_CHAR(a.adm_OriginalHospitalAdmission,'yyyy-Mm-Dd') AS ADM_ORIGINALHOSPITALADMISSION, DATE_TO_CHAR(a.adm_HospitalAdmission,'yyyy-Mm-Dd') AS ADM_HOSPITALADMISSION, a.adm_HospitalAdmissionSource, DATE_TO_CHAR(a.adm_ReferralDate,'yyyy-Mm-Dd') AS ADM_REFERRALDATE,
		a.adm_calID, a.adm_height, a.adm_weight, a.adm_BodyMassIndex, a.Pregnant, a.adm_ICU_DischargeDelay,
		DATE_TO_CHAR(a.adm_ICUAdmission,'yyyy-Mm-Dd') AS ADM_ICUADMISSION, a.adm_ICU_Admission_Time, DATE_TO_CHAR(a.adm_ICU_Discharge_Date,'yyyy-Mm-Dd') AS ADM_ICU_DISCHARGE_DATE, a.adm_ICU_Discharge_Time, DATE_TO_CHAR(a.adm_HDU_Admission_Date,'yyyy-Mm-Dd') AS ADM_HDU_ADMISSION_DATE, a.adm_HDU_Admission_Time,
		DATE_TO_CHAR(a.adm_HDU_Discharge_Date,'yyyy-Mm-Dd') AS ADM_HDU_DISCHARGE_DATE, a.adm_HDU_Discharge_Time, a.AdmStatus, a.Speciality_Entered,
		DATE_TO_CHAR(a.adm_CCU_Admission_Date,'yyyy-Mm-Dd') AS ADM_CCU_ADMISSION_DATE, a.adm_CCU_Admission_Time, DATE_TO_CHAR(a.adm_CCU_Discharge_Date,'yyyy-Mm-Dd') AS ADM_CCU_DISCHARGE_DATE, a.adm_CCU_Discharge_Time, a.Referral_Person, a.adm_Number, a.adm_ICU_DischargeDelay_Reason, a.adm_LP_HospAdmSource, a.adm_Ward, a.NEWS_Score, a.adm_ReAdmisson,
		a.adm_Scored, a.adm_Consultant, a.adm_Triggered, a.ASAScore,
		a.Speciality_Entered, a.adm_SurgeryClassification, a.Hosp, a.Pregnant, a.adm_Triggered, a.adm_ID, a.adm_PlannedAdmission, a.adm_PriorSurgery, a.adm_MEWS, a.adm_ResearchTag,
		dia.dgn_ID, dia.dgn_AdmissionPrimaryReason, dia.dgn_Reason1_Type, dia.dgn_Reason1_System, dia.dgn_Reason1_Site, dia.dgn_Reason1_Process, dia.dgn_Reason1_Condition, dia.dgn_Reason1_Code,
		dia.dgn_AdmissionSecondaryReason, dia.dgn_Reason2_Type, dia.dgn_Reason2_System, dia.dgn_Reason2_Site, dia.dgn_Reason2_Process, dia.dgn_Reason2_Condition, dia.dgn_Reason2_Code, dia.dgn_NonICNARC_Reason,
		DATE_TO_CHAR(otc.otc_OTRDischargeDate,'yyyy-Mm-Dd') AS OTC_OTRDISCHARGEDATE, otc.otc_OTRDischargeTime, otc.otc_OTRDischargeStatus, otc.otc_LOS, otc.otc_Level_2_Days, DATE_TO_CHAR(otc.otc_DeathDate,'yyyy-Mm-Dd') AS OTC_DEATHDATE, otc.otc_DeathTime, otc.otc_HospDischargeTime, otc.otc_HospLOS, otc.otc_Outcome,
		otc.otc_HospDischargeDestination, DATE_TO_CHAR(otc.Dr2Scr_Arive_Date,'yyyy-Mm-Dd') AS DR2SCR_ARIVE_DATE, otc.Dr2Scr_Arive_Time, otc.Dr2Scr_Total_Time, otc.otc_DNR,
		icn.icn_ID, icn.icn_EPMH, icn.icn_PMHP, icn.icn_AIDS, icn.icn_BPC, icn.icn_RADIOX, icn.icn_PH, icn.icn_CHEMOX, icn.icn_HE, icn.icn_META, icn.icn_VSCD, icn.icn_AMLALLMM, icn.icn_SRD, icn.icn_CMLCLL, icn.icn_HV,
		icn.icn_LYM, icn.icn_CRRX, icn.icn_CICIDS, icn.icn_STERX,
		l.lnk_ID, l.lnk_dmgID, l.lnk_dgnID, l.lnk_icnID, l.lnk_otcID, l.lnk_admID, l.TriggStat,
		dlk.dlk_ID, dlk.dlk_patID,
		DATE_TO_CHAR(adms.Score_Date,'yyyy-Mm-Dd') AS SCORE_DATE, adms.Score_Time,
		ccmd.UnitFunction, ccmd.TrtSpecialityCode, ccmd.BedConfig, ccmd.AdmSrc, ccmd.SrcLocation, ccmd.AdmType, ccmd.DischStatus, ccmd.DischDest, ccmd.DischLocation,
		ccmd.AdvRespSupp, ccmd.BasicRespSupp, ccmd.AdvCardioSupp, ccmd.BasicCardioSupp, ccmd.RenalSupp, ccmd.NeuroSupp, ccmd.DermaSupp, ccmd.LiverSupp, ccmd.GISupport,
		ccmd.MaxOrganSupp, ccmd.Level3, ccmd.Level2, ccmd.Level1, ccmd.Level0
		FROM Demographic d
		LEFT OUTER JOIN LINK l ON d.dmg_ID = l.lnk_dmgID
		LEFT OUTER JOIN DAILY_LINK dlk ON l.lnk_ID = dlk.dlk_lnkID
		LEFT OUTER JOIN Admission a ON a.adm_ID = l.lnk_admID
		LEFT OUTER JOIN Diagnosis dia ON dia.dgn_ID = l.lnk_dgnID
		LEFT OUTER JOIN Outcome otc ON otc.otc_ID = l.lnk_otcID
		LEFT OUTER JOIN ICNARC_PMH icn ON icn.icn_ID = l.lnk_icnID
		LEFT OUTER JOIN Admission_Score adms ON adms.AScore_ID = a.adm_ScoreID
		LEFT OUTER JOIN CCMDS ccmd ON ccmd.dmg_ID = l.lnk_dmgID
		WHERE l.lnk_ID=$lnkID";

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
	//exit;
}


/*
 * If patient has just been created then they will not have a daily link
 * Some features require a daily link like groups/items however
 * In this case inserting a value of 0 for daily link is acceptable
 */
if (!isset($patient['DLK_ID'])) $patient['DLK_ID'] = 0;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<?php include('header.php'); ?>
	<title>
	    <?php echo $preferences['prf_HospitalName']; ?>
	</title>
	</head>
	<?php
	// This supposedly speeds up rendering time - see http://developer.yahoo.com/performance/rules.html#etags
	flush();
	?>
	<body>
<!-- 	    <div id="top_of_page">
		<a href='patListing.php'>Click here for Patient Listing</a> - <a "href=MelaClass/logoutAction.php">Click here to logout</a>
	    </div> -->
		<!--<script> FocusTop(); </script>-->
		<div class="container clearfix">
			<div class="Header_List">
				<ul id="Head_Left" class="grid_3 alpha">
					<li><?php echo $patient['DMG_FIRSTNAME']; ?></li> 
					<li><?php echo $patient['DMG_SURNAME']; ?></li>
				</ul>
				<ul id="Head_Mid" class="grid_3">
					<li>
						<table class="Tab_Mid">
							<tr><td class="Table_Mid">Sex&nbsp;</td><td class="Table_Mid"><?php echo $patient['DMG_SEX']; ?></td></tr>
							<tr><td class="Table_Mid">DOB&nbsp;</td><td class="Table_Mid">
							<?php
								$splitDOB = explode(' ',$patient['DMG_DATEOFBIRTH']);
								$splittmpDOB = explode('-',$splitDOB[0]);
								$tmpDOB = array_reverse($splittmpDOB);
								echo join('-',$tmpDOB);
							?>
							</td></tr>
						</table>
					</li>
				</ul>
				<ul id="Head_Right" class="grid_3 omega">
					<li>
						<table>
							<tr><td class="Table_Right">NHS No&nbsp;</td><td class="Table_Right"><?php echo $patient['DMG_NHSNUMBER']; ?></td></tr>
							<tr><td class="Table_Right">Hospital No&nbsp;</td><td class="Table_Right"><?php echo $patient['DMG_HOSPITALNUMBER']; ?></td></tr>
							<tr><td class="Table_Right">Referral No&nbsp;</td><td class="Table_Right"><?php echo $patient['ADM_NUMBER']; ?></td></tr>
						</table>
					</li>
				</ul>
			</div>

			<?php $Form = new Mela_Forms('patDmg','formProcess.php','POST','save_form'); ?>
			<?php
			    $hiddenLNK = $Form->hiddenField('patLNK',$patient['LNK_ID']);
			    echo $hiddenLNK;    
			?>				
				<div id="tabs2" class="btn_bar">
					<button style="font-size:small;color:green" type="button" name="vsHTMLogoutButt" value="Logout" onclick="logOutConfirm(<?php echo $patient['LNK_ID']; ?>)">Logout</button>
					<button style="font-size:small;color:red" type="button" name="vsHTMCancelButt" value="Cancel" id="cancelButton" onclick="cancelConfirm(<?php echo $patient['LNK_ID']; ?>)">Cancel</button>
					<button style="font-size:small;color:green" type="submit" name="vsHTMSaveButt" value="Save" onclick="return OnSave(PatDmg)">Save</button>
					<?php if ($auth->UsrKeys->UserGrpName == "Admin Group") { ?><button style="font-size:small;color:red" type="button" name="vsHTMDeleteButt" id="deletePatient" data-lnkid="<?php echo $patient['LNK_ID']; ?>" value="Delete">Delete</button><?php } ?>
					<?php if ($appName == "Outreach" && $patient['TRIGGSTAT'] == "TRIG") { ?> <button style="font-size:small;color:gray" type="button" name="vsHTMSeenButt" id="patientSeen" data-lnkid="<?php echo $patient['LNK_ID']; ?>" data-user="<?php echo $auth->UsrKeys->Username; ?>" value="Patient Seen">Patient Seen</button> <?php } ?>
				</div>
				
				<div class="validationErrorBox" style="display:none;">
				    <!-- Necessary for displaying any form validation errors - leave blank, jQuery fills this in -->
				</div>
				
				<!-- This is hidden but necessary for the functionality of the tabs below it. If you add a tab, you do need to update this list -->
				<div id="tabs">
					<ul style="display:none;">
						<li class="tabs_item"><a href="#page-1"><span>Demographics</span></a></li>
						<li class="tabs_item"><a href="#page-2"><span>Admission</span></a></li>
						<li class="tabs_item"><a href="#page-3"><span>Diagnosis</span></a></li>
						<li class="tabs_item"><a href="#page-4"><span>Other Diagnosis</span></a></li>
						<li class="tabs_item"><a href="#page-5"><span>Surgery</span></a></li>
						<li class="tabs_item"><a href="#page-6"><span>Co-morbity</span></a></li>
						<li class="tabs_item"><a href="#page-7"><span>PMH</span></a></li>
						<li class="tabs_item"><a href="#page-8"><span>Assessments</span></a></li>
						<li class="tabs_item"><a href="#page-9"><span>Pain Assessment Tool</span></a></li>
						<li class="tabs_item"><a href="#page-10"><span>Modalities</span></a></li>
						<li class="tabs_item"><a href="#page-11"><span>Discharge</span></a></li>
						<li class="tabs_item"><a href="#page-12"><span>Medical Staff</span></a></li>
						<li class="tabs_item"><a href="#page-13"><span>ICD10 Diagnosis</span></a></li>
						<li class="tabs_item"><a href="#page-14"><span>CCMDS</span></a></li>
						<li class="tabs_item"><a href="#page-15"><span>Respite Care</span></a></li>
					</ul>
				<?php
				// In acute pain there is a post op usergroup which
				// displays only a very cut down menu. Rather than mess about
				// adding more conditionals to the regular CSS menu it's just easier
				// to swap it out with another CSS menu
				if (($appName == "AcutePain") && ($auth->UsrKeys->UserGrpName == "Post Op")) { ?>
					    <div class="cssmenu">	
						<ul>
						<!-- =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   -->
							<li class='tabs_item' id='tabDemographic'><a href='#page-1' class='active_pat_tab'><span>Demographics</span></a></li>
							<li class='tabs_item' id='tabSurgery2'><a href='#page-5'><span><?php if ($preferences['CustomSurgeryName_Name'] !='') echo $preferences['CustomSurgeryName_Name']; else echo "Surgery"; ?></span></a></li>
							<li class='tabs_item' id='tabModalities'><a href='#page-10'><span>Modalities</span></a></li>
						<!-- =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   -->
						</ul>
					    </div>

					<?php } else { ?>


						<div class="cssmenu">	
							<ul>
							<!-- =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   -->
								<li class='tabs_item' id='tabDemographic'><a href='#page-1' class='active_pat_tab'><span>Demographics</span></a></li>
							<!-- =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   -->
						<?php if ($preferences['prf_ShowMedicalStaff'] == 'false') { ?>
								<li class='tabs_item' id='tabAdmission'><a href='#page-2'><span>Admission</span></a></li>
						<?php } else { ?>
								<li class='has-sub tabs_item'><a href='#page-2'><span>Admission</span></a>
								    <ul>
										<li id='tabAdmission' class='tabsub'><a href='#page-2'><span>Admission detail</span></a></li>
										<li id='tabMedicalStaff' class='tabsub last_sub' ><a href='#page-12'><span>Medical Staff</span></a></li>
								    </ul>
								</li>
						<?php } ?>
					<!-- =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   -->
					   <li class='has-sub tabs_item'><a href='#'><span>Diagnosis</span></a>
						<ul>
						    <?php if ($preferences['prf_ShowICD10'] == 'true') { echo "<li class='tabsub' id='tabICD10Diagnosis'><a href='#page-13'><span>ICD10 Diagnosis</span></a></li>"; } ?>
						    <?php if (($appName == "Outreach") && ($preferences['HideICNARCDgn'] != 'true')) { ?>
							<li class='tabsub' id='tabDiagnosis'><a href='#page-3'><span>First Reason</span></a></li>
							<li class='tabsub last_sub' id='tabOtherDiagnosis'><a href='#page-4'><span>Second Reason</span></a></li>
						    <?php } ?>
						    <?php if (($appName == "AcutePain") && ($preferences['show_diag'] == 'true')) { ?>
							<li class='tabsub' id='tabDiagnosis'><a href='#page-3'><span>Diagnosis</span></a></li>
						    <?php } ?>
						</ul>
					   </li>
					   <?php if ($preferences['prf_ShowSurgery'] == 'true') { ?><li class='tabs_item' id='tabSurgery2'><a href='#page-5'><span><?php if ($preferences['CustomSurgeryName_Name'] !='') echo $preferences['CustomSurgeryName_Name']; else echo "Surgery"; ?></span></a></li><?php } ?>
					<!-- =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   -->
					    <li class='has-sub tabs_item'><a href='#'><span>History</span></a>
						<ul>
						    <?php if ($preferences['prf_ShowComorbidity'] == 'true') { ?><li class='tabsub' id='tabComorbidity'><a href='#page-6'><span><?php if ($preferences['COMORBNAME'] !='') echo $preferences['COMORBNAME']; else echo "Co-Morbidity"; ?></span></a></li><?php } ?>
						    <?php if ($appName == "Outreach" && $preferences['prf_PMH'] == 'true') { ?><li class='tabsub last_sub' id='tabPMH'><a href='#page-7'><span>PMH</span></a></li><?php } ?>
						    <!--<li class='tabsub last_sub' id='tabPainAssessmentTool'><a href='#page-9'><span>Pain Assessment Tool</span></a></li>-->
						</ul>
					    </li>
					<!-- =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   -->
					    <?php if ($appName == "Outreach") { ?><li class='tabs_item' id='tabCCMDS'><a href='#page-14' class='tabsub'><span>CCMDS</span></a></li><?php } ?>
					<!-- =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   =   -->    
					   <?php if (($appName == "AcutePain") && ($preferences['ModalityInPat'] == 'true')) { ?><li class='tabs_item' id='tabModalities'><a href='#page-10'><span>Modalities</span></a></li><?php } ?>
					   <li class='tabs_item' id='tabAssessments'><a href='#page-8'><span>Assessments</span></a></li>
					   <?php if ($preferences['prf_ShowDischarge'] == 'true') { ?><li class='last tabs_item' id='tabDischarge'><a href='#page-11'><span>Discharge</span></a></li><?php } ?>
					   <?php if ($preferences['Show_RespiteCare'] == 'true') { ?><li class='last tabs_item' id='tabRespiteCare'><a href='#page-15'><span>Respite Care</span></a></li><?php } ?>
					</ul>
				</div>
				<?php } ?>
				<div style="clear: both;"></div>


					<!-- Dmg -->
					<div id="page-1"> 
						<table>
						    <tr>
							<td>
							<?php
							include('demographics.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- Dmg -->


					<!-- Adm -->
					<div id="page-2"> 
						<table>
						    <tr>
							<td>
							<?php
							include('admission.php');
							?>
							</td>
						    </tr>
						</table>      
					</div>  <!-- Adm -->


					<div id="page-3">  <!-- Diag -->
						<table width="100%">
						    <tr>
							<td>
							<?php
							    include('diagnosis.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- Diag -->


					<div id="page-4">  <!-- OtherDiag -->
						<table>
						    <tr>
							<td>
							<?php
							include('otherDiagnosis.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- OtherDiag -->


					<div id="page-5">  <!-- Surgery -->
						<table>
						    <tr>
							<td>
							<?php
							if ($preferences['prf_ShowSurgery'] == 'true') {
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
					</div>  <!-- Surgery -->


			 		<div id="page-6">  <!-- CoMorb -->
						<table>
						    <tr>
							<td>
							<?php
								if ($preferences['prf_ShowComorbidity'] == 'true') include('comorbidity.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- CoMorb -->


			 		<div id="page-7">  <!-- PMH -->
						<table>
						    <tr>
							<td>
							<?php
								if ($appName == "Outreach" && $preferences['prf_PMH'] == 'true') include('pmh.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- PMH -->


			 		<div id="page-8">  <!-- Assessments -->
						<table id="assContainTable">
						    <tr>
							<td>
							<?php
							include('assessments.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- Assessments -->
					
					<div id="page-9">  <!-- Pain Assessment Tool -->
						<table>
						    <tr>
							<td>
							<?php
							include('painassessmenttool.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- Pain Assessment Tool -->
					
					<div id="page-10">  <!-- Modalities -->
						<table>
						    <tr>
							<td>
							<?php
							include('modalities.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- Modalities -->


					<div id="page-11">  <!-- Disch -->
						<table>
						    <tr>
							<td>
							<?php
								if ($preferences['prf_ShowDischarge'] == 'true') include('discharge.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- Disch -->
					
					<div id="page-12">  <!-- Medical Staff -->
						<table>
						    <tr>
							<td>
							<?php
							include('medicalstaff.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- Medical Staff -->
					
					<div id="page-13">  <!-- ICD10 Diag -->
						<table width="100%">
						    <tr>
							<td>
							<?php
							    if ($preferences['prf_ShowICD10'] == 'true') include('ICD10.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- ICD10 Diag -->
					
					<div id="page-14">  <!-- CCMDS -->
						<table width="100%">
						    <tr>
							<td>
							<?php
							    if ($appName == "Outreach") include('CCMDS.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- CCMDS -->
					
					<div id="page-15">  <!-- Respite Care -->
						<table width="100%">
						    <tr>
							<td>
							<?php
							    if ($preferences['Show_RespiteCare'] == 'true') include('respiteCare.php');
							?>
							</td>
						    </tr>
						</table>
					</div>  <!-- Respite Care -->

				</div> <!--  <div id="tabs">  -->
			</form>
		</div> <!--  <div class="container clearfix">  -->
	</body>
</html>
<?php
include('javascriptCommon.php');
include('javascriptDemographics.php');
include('footer.php');
?>
