<script src="media/js/jquery-1.10.0.min.js"></script>
<script src="media/js/date.js"></script>
<script src="media/js/datesDifference.js"></script>
<script src="media/js/closeEditPages.js"></script>

<link type="text/css" rel="stylesheet" href="media/css/normalize.css"/>
<link type="text/css" rel="stylesheet" href="media/css/style.css"/>

<link type="text/css" rel="stylesheet" href="media/css/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="media/css/jquery%20css.css"/>
<link type="text/css" rel="stylesheet" href="media/css/tablesorterStyle.css"/>
<link type="text/css" rel="stylesheet" href="media/css/surgery.css"/>
<link type="text/css" rel="stylesheet" href="media/css/GI_Style_real.css"/>

<link type="text/css" rel="stylesheet" href="media/css/Header_style.css">

<script language="JavaScript" type="text/javascript">    
    function calculateDuration(startDate, startTime, endDate, endTime) {
	/*console.log(startDate);
	console.log(startTime);
	console.log(endDate);
	console.log(endTime);*/
	
	var differenceDays = getDaysDifference(startDate, endDate);
	var differenceHoursMins = getHoursMinsDifference(startTime, endTime);
	
	var duration = differenceDays + differenceHoursMins;
	
	$('#inv-duration').val(duration);
	
    }	
    
    $(document).ready(function() {
	$('#inv-startDate, #inv-startTime, #inv-endDate, #inv-endTime').change(function() {
	    var startDate = $('#inv-startDate').val();
	    var startTime = $('#inv-startTime').val();
	    var endDate = $('#inv-endDate').val();
	    var endTime = $('#inv-endTime').val();
	    
	    if ((startDate !== '') && (endDate !== '')) {
		calculateDuration(startDate,startTime,endDate,endTime);
	    }
	});
    });
</script>

<?php
error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/functions.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$Form = new Mela_Forms('editInterventions','','POST','interventions_form');

if (!$_REQUEST['dlk'] || !$_REQUEST['lnk'] || !$_REQUEST['row']) die("Necessary data is missing");

$row = filter_var($_REQUEST['row'], FILTER_SANITIZE_NUMBER_INT);
$dlkID = filter_var($_REQUEST['dlk'], FILTER_SANITIZE_NUMBER_INT);
$lnkID = filter_var($_REQUEST['lnk'], FILTER_SANITIZE_NUMBER_INT);

$query_PAT = "SELECT dmg.dmg_FirstName, dmg.dmg_Surname, dmg.dmg_DateOfBirth, dmg.dmg_Sex, dmg.dmg_NHSNumber, dmg.dmg_HospitalNumber, adm.adm_Number
			FROM Demographic dmg
			LEFT OUTER JOIN LINK lnk ON lnk.lnk_dmgID = dmg.dmg_ID
			LEFT OUTER JOIN Admission adm ON adm.adm_ID = lnk.lnk_admID
			WHERE lnk.lnk_ID = $lnkID";
try { 
    $result_PAT = odbc_exec($connect,$query_PAT); 
    if($result_PAT){ 
	$HeaderData = odbc_fetch_array($result_PAT);
    } 
    else{ 
    throw new RuntimeException("Failed to connect."); 
    } 
	} 
    catch (RuntimeException $e) { 
	    print("Exception caught: $e");
    }

/*
 * The fields used in this differ in AcutePain and elsewhere
 */
if ($appName == "Outreach") {
    //print "<h1>HELLO</h1>";
}

// Get relevant data to fill out form
$query = "SELECT inv.inv_ID, DATE_TO_CHAR(inv.StartDate,'yyyy-Mm-Dd') AS STARTDATE, inv.inv_Time, inv.Duration_Time, DATE_TO_CHAR(inv.EndDate,'yyyy-Mm-Dd') AS ENDDATE, inv.EndTime, inv.inv_Comments, inv.inv_Bolus, inv.inv_Dose, inv.inv_Probes,
	  inv.inv_TubeLength, inv.inv_Time_Volts, inv.inv_TubeSize, inv.inv_Test, inv.inv_Result, inv.inv_Treatment, inv.inv_Type, inv.inv_Infusion,
	  inv.inv_NextRefill, inv.Pump_No, inv.No_Of_Tries, inv.No_Of_Goods, inv.inv_PerformedBy, inv.inv_Program, inv.inv_Reason, inv.inv_Sensation,
	  inv.inv_Volts, inv.inv_Time_Volts, inv.inv_LineType, inv.inv_TubeSize, inv.inv_Frequency, inv.inv_LineSite, inv.inv_ChoiceOfLA,
	  inv.inv_InsertionLevel, inv.inv_ChoiceOfOpioid, inv.inv_BlockLevel, inv.inv_Rate, inv.BlockLevelRight1, inv.inv_DensityOfBlock,
	  inv.inv_BromageScore, inv.inv_SiteCheck, inv.`Duration`, inv.Suggested,
	  itm.Description, itm.Frequency, itm.Advance_Resp, itm.Basic_Resp, itm.Infusion, itm.Dose, itm.Renal, itm.Neurological, itm.Unit, itm.Test,
	  itm.Circulatory, itm.`Time`, itm.Reason, itm.IsLine, itm.IsTube, itm.PerformedBy, itm.Treatment, itm.Pump, itm.LA, itm.Opioid, itm.InsertionLevel,
	  itm.Rate, itm.BlockLevel, itm.DensityOfBlock, itm.BromageScore, itm.SiteCheck, itm.Type, itm.Bolus, itm.Probes, itm.Sensation, itm.Program, itm.Volts,
	  itm.Time_Volts, itm.Self_Med, itm.SkinPrep, itm.EpiTestDose, itm.EpiInitDose, itm.EpiMaintainDose, itm.Epi2HrLimit, itm.Background_Inf, itm.SkinEpiDistance,
	  itm.CatInSpace, itm.PatPosition, itm.AttemptsToSite, itm.FailToSite, itm.ReasonForFailToSite, itm.PerformedByPerson
	  FROM Investigations inv
	  LEFT OUTER JOIN Items_Inv itm ON inv.inv_ID=itm.ID
	  WHERE inv.inv_ID=$row AND inv.inv_dlkID=$dlkID AND inv.inv_lnkID=$lnkID AND itm.ID=inv.inv_ID";
try { 
    $result = odbc_exec($connect,$query); 
    if($result){ 
	$interventionsData = odbc_fetch_array($result);
    } 
    else { 
	throw new RuntimeException("Failed to connect."); 
    } 
} 
catch (RuntimeException $e) { 
    print("Exception caught: $e");
} //echo $query;
//var_dump($interventionsData);
    
$hiddenRow = $Form->hiddenField('row',$row);
$hiddenDLK = $Form->hiddenField('dlk',$dlkID);
$hiddenLNK = $Form->hiddenField('lnk',$lnkID);

echo $hiddenRow;
echo $hiddenDLK;
echo $hiddenLNK;
	
if ($_POST) {
    
    if (!$_POST['invID']) die("No ID set for selected row.");
    $invID = filter_var($_REQUEST['invID'], FILTER_SANITIZE_NUMBER_INT);
    
    foreach($_POST as $k => $v) {
	$formKey[$k] = $k;
	$formVal[$k] = checkValues($v);
	//echo "<b>". $formKey[$k] ."</b> - ". $formVal[$k] ."<br />";
    }
    
    $bolusSQL = "";
    if (isset($formVal['inv-Bolus'])) {
	$bolusBool = ($formVal['inv-Bolus'] == 1) ? 'true' : 'false';
	$bolusSQL = "inv_Bolus=".$bolusBool.", ";
    }
    
    $startDateSQL = "";
    if (strlen($formVal['inv-startDate']) > 0) {
	$startDateSQL = "StartDate='".$formVal['inv-startDate']."', ";
    }
    
    $startTimeSQL = "";
    if (strlen($formVal['inv-startTime']) > 0) {
	$startTimeSQL = "inv_Time='".$formVal['inv-startTime']."', ";
    }
    
    $endDateSQL = "";
    if (strlen($formVal['inv-endDate']) > 0) {
	$endDateSQL = "EndDate='".$formVal['inv-endDate']."', ";
    }
    
    $endTimeSQL = "";
    if (strlen($formVal['inv-endTime']) > 0) {
	$endTimeSQL = "EndTime='".$formVal['inv-endTime']."', ";
    }
    
    $nextRefillSQL = "";
    if (strlen($formVal['inv-NextRefill']) > 0) {
	$nextRefillSQL = "inv_NextRefill='".$formVal['inv-NextRefill']."', ";
    }
    
    $hiddenComments = $Form->hiddenField('hiddenComments',$formVal['inv-Comments']);
    echo $hiddenComments;
    
    $probesSQL = "";
    if (strlen($formVal['inv-Probes']) > 0) {
	$nextRefillSQL = "inv_Probes='".$formVal['inv-Probes']."', ";
    }
    
    $doseSQL = "";
    if (strlen($formVal['inv-Dose']) > 0) {
	$doseSQL = "inv_Dose='".$formVal['inv-Dose']."', ";
    }
    
    $tubeLengthSQL = "";
    if (strlen($formVal['inv-TubeLength']) > 0) {
	$tubeLengthSQL = "inv_TubeLength='".$formVal['inv-TubeLength']."', ";
    }
    
    $timeVoltsSQL = "";
    if (strlen($formVal['inv-TimeVolts']) > 0) {
	$timeVoltsSQL = "inv_Time_Volts='".$formVal['inv-TimeVolts']."', ";
    }
    
    $tubeSizeSQL = "";
    if (strlen($formVal['inv-TubeSize']) > 0) {
	$timeVoltsSQL = "inv_TubeSize='".$formVal['inv-TubeSize']."', ";
    }
    
    $infusionSQL = "";
    if (strlen($formVal['inv-Infusion']) > 0) {
	$infusionSQL = "inv_Infusion='".$formVal['inv-Infusion']."', ";
    }
    
    $suggestedSQL = "";
    if (strlen($formVal['inv-suggested']) > 0) {
	$suggestedSQL = "Suggested=true, ";
    } else {
	$suggestedSQL = "Suggested=false, ";
    }
    
    // Need to check that the record is properly locked first of all
    if ($Mela_SQL->Exec4DSQL("SQLLock_IsLocked", $lnkID) == 1) {  
	$query = "UPDATE Investigations SET $startDateSQL $startTimeSQL
	$endDateSQL $endTimeSQL inv_Comments='".$formVal['inv-Comments']."', $bolusSQL inv_PerformedBy='".$formVal['inv-PerformedBy']."', $suggestedSQL
	$probesSQL $doseSQL inv_Program='".$formVal['inv-Program']."', inv_Reason='".$formVal['inv-Reason']."', inv_Sensation='".$formVal['inv-Sensation']."',
	$tubeLengthSQL inv_Volts='".$formVal['inv-Volts']."', $timeVoltsSQL inv_LineType='".$formVal['inv-LineType']."',
	$tubeSizeSQL inv_Frequency='".$formVal['inv-Frequency']."', inv_LineSite='".$formVal['inv-lineSite']."', inv_Test='".$formVal['inv-Test']."', inv_Result='".$formVal['inv-Result']."', inv_Treatment='".$formVal['inv-Treatment']."',
	inv_ChoiceOfLA='".$formVal['inv-ChoiceOfLA']."', inv_Type='".$formVal['inv-Type']."', inv_InsertionLevel='".$formVal['inv-InsertionLevel']."', inv_ChoiceOfOpioid='".$formVal['inv-ChoiceOfOpioid']."',
	inv_BlockLevel='".$formVal['inv-BlockLevelLeft']."', inv_Rate='".$formVal['inv-Rate']."', BlockLevelRight1='".$formVal['inv-BlockLevelRight']."', inv_DensityOfBlock='".$formVal['inv-DensityOfBlock']."',
	inv_BromageScore='".$formVal['inv-BromageScore']."', inv_SiteCheck='".$formVal['inv-SiteCheck']."', $infusionSQL $nextRefillSQL
	Pump_No='".$formVal['inv-PumpNo']."', No_Of_Tries='".$formVal['inv-NoOfTries']."', No_Of_Goods='".$formVal['inv-NoOfGoods']."', `Duration`='".$formVal['inv-duration']."'
	WHERE inv_ID=$row AND inv_dlkID=$dlkID AND inv_lnkID=$lnkID";
	try { 
	    $result = odbc_exec($connect,$query); 
	    if($result){ 
		?>
		<script type="text/javascript">
		    CloseAndRefresh('row','hiddenComments','INnotes');
		</script>	    
		<?php 			 
	    }
	    else {
		throw new RuntimeException("Failed to connect.");
	    }
	}
	catch (RuntimeException $e) { 
		print("Exception caught: $e");
	} //echo $query;
    } else {
        echo '<div style="height:100%; width:100%;">
		<div class="failurebox" style="vertical-align: middle; text-align: center; margin-left: auto; margin-right: auto; border: 3px solid #A52A2A; background-color: #CD5C5C; color: #330000; height:50%; width:50%;">
		    <span style="vertical-align: middle; height: 100%;">
			<h2>
			    Record Locking Error
			</h2>
			The selected record was not locked and therefore data were not safe to save. 
			<br />
			<button type="button" style="font-size:small;color:red" onclick="failedRecordLock()">Please click here to return to patient listing</button>
		    </span>
		</div>
	    </div>';
    }

} else {
    $invID = $Form->hiddenField('invID',$interventionsData['INV_ID']);
    echo $invID;
?>



        <div class="container clearfix">

            <div class="Header_List">
                <ul id="Head_Left" class="grid_3 alpha">
                    <li><?php echo $HeaderData['DMG_FIRSTNAME']; ?></li> 
                    <li><?php echo $HeaderData['DMG_SURNAME']; ?></li>
                </ul>
                <ul id="Head_Mid" class="grid_3">
                    <li>
                        <table class="Tab_Mid">
                            <tr><td class="Table_Mid">Sex&nbsp;</td><td class="Table_Mid"><?php echo $HeaderData['DMG_SEX']; ?></td></tr>
                            <tr><td class="Table_Mid">DOB&nbsp;</td><td class="Table_Mid"><?php $splitDOB = explode(' ',$HeaderData['DMG_DATEOFBIRTH']); echo $splitDOB[0]; ?></td></tr>
                        </table>
                    </li>
                </ul>
                <ul id="Head_Right" class="grid_3 omega">
                    <li>
                        <table>
                            <tr><td class="Table_Right">NHS No&nbsp;</td><td class="Table_Right"><?php echo $HeaderData['DMG_NHSNUMBER']; ?></td></tr>
                            <tr><td class="Table_Right">Hospital No&nbsp;</td><td class="Table_Right"><?php echo $HeaderData['DMG_HOSPITALNUMBER']; ?></td></tr>
                            <tr><td class="Table_Right">Referral No&nbsp;</td><td class="Table_Right"><?php echo $HeaderData['ADM_NUMBER']; ?></td></tr>
                        </table>
                    </li>
                </ul>
            </div>



                <div id="tabs2" class="btn_bar">
                    <button style="font-size:small;color:red" type="button"  value="Cancel" onclick="CloseAndRefresh()" href=>Cancel</button>
                    <button style="font-size:small;color:green" type="submit" value="Save" onclick="submitButton()">Save</button>
                    <?php echo $Form->checkBox('inv-suggested','inv-suggested','Suggested',$interventionsData['SUGGESTED']); ?>
                </div>


  


<div class='mod_Form'>

    <form action="" method="POST">

<div class='div_modDetail intDiv'>

    <table class="temp table_intDetail">
	<tr>
	    <td colspan="1">Description</td>
		<td colspan='4'><?php $invDescription = $Form->textBox('inv-Description',$interventionsData['DESCRIPTION'],'',1,'','FormText_Inter'); echo $invDescription; ?></td>
	</tr>
    <tr>
        <td colspan="1">Start Date/Time</td>
        <td colspan="1">
	        <?php $myDclass = array("medDate");
	            $startDate =$Form->dateField('inv-startDate',stringToDateTime($interventionsData['STARTDATE'],2),$myDclass); echo $startDate;
	        ?>
	        <?php $myTclass = array("medTime");
	            $startTime = $Form->timeField('inv-startTime',convert4DTime($interventionsData['INV_TIME']),$myTclass); echo $startTime;
	        ?>
    	</td>

        <td colspan="1">End Date/Time</td>
        <td colspan="1">
            <?php $myDclass = array("medDate");
	            $endDate = $Form->dateField('inv-endDate',stringToDateTime($interventionsData['ENDDATE'],2),$myDclass); echo $endDate;
	        ?>
	        <?php $myTclass = array("medTime");
	            $endTime = $Form->timeField('inv-endTime',convert4DTime($interventionsData['ENDTIME']),$myTclass); echo $endTime;
	        ?>
        </td>

	    <td colspan="1">Duration
	    	<?php $myStrclass = array("medStrDate"); $duration = $Form->textBox('inv-duration',$interventionsData['DURATION'],'','',$myStrclass); print $duration; ?>
		</td>
    </tr>


    
	<tr>
	    <td colspan="1">Comments</td>
	    <td colspan="4"><?php $invComments = $Form->textArea('inv-Comments',$interventionsData['INV_COMMENTS'],0,0,'','FormText_Inter'); echo $invComments; ?></td>
    </tr>


	<tr>
	    <?php if ($interventionsData['PERFORMEDBY'] == 'true') { ?>
	    <td colspan="1">Performed by</td>
	    <td colspan="1"><?php
	            $performedByDDSQL = $Mela_SQL->tbl_LoadItems('Performed By');
			    $performedByDDArray = array();
			    for ($i = 1; $i < (count($performedByDDSQL)+1); $i++) {
					array_push($performedByDDArray,$performedByDDSQL[$i]['Long_Name']);
			    }
			    $performedByDD = $Form->dropDown('inv-PerformedBy',$performedByDDArray,$performedByDDArray,$interventionsData['INV_PERFORMEDBY']);
			    echo $performedByDD; 
		    ?>
	    </td>
	    <?php } ?>
	    
	    <?php if ($interventionsData['BOLUS'] == 'true') { ?>
	    <td colspan="1">Bolus</td>
	    <td colspan="2"><?php 
	    		$invBolusChecked = ($interventionsData['INV_BOLUS'] == 'true') ? 'checked' : '';
                $invBolus = $Form->checkBox('inv-Bolus','1','',$invBolusChecked);
                echo $invBolus;
			?>
	    </td>
	    <?php } ?>
	</tr>

	<tr>
	    <?php if ($interventionsData['DOSE'] == 'true') { ?>
	    <td colspan="1">Total Amount</td>
	    <td colspan="1"><?php
                $sql = "SELECT adm_Weight FROM Admission WHERE adm_ID=$lnkID";
			    try { 
					$result2 = odbc_exec($connect,$sql); 
					if($result2){ 
				    	$admission = odbc_fetch_array($result2);
					} 
			    	else{ 
			    		throw new RuntimeException("Failed to connect."); 
			    	} 
				} 
			    catch (RuntimeException $e) { 
				    print("Exception caught: $e");
			    }
	                    
			    $totalAmount = $admission['ADM_WEIGHT']*$interventionsData['INV_DOSE'];
			    $invtotalAmount = $Form->textBox('inv-totalAmount',$totalAmount);
			    echo $invtotalAmount;
            ?>
	    </td>
	    <?php } ?>
	    
	    <?php if ($interventionsData['PROBES'] == 'true') { ?>
	    <td colspan="1">Probes</td>
	    <td colspan="2"><?php
		    	$invProbes = $Form->textBox('inv-Probes',$interventionsData['INV_PROBES']);
		    	echo $invProbes;
			?>
	    </td>
	    <?php } ?>
	</tr>


	<tr>
	    <?php if ($interventionsData['DOSE'] == 'true') { ?>
	    <td colspan="1">Dose</td>
	    <td colspan="1"><?php $invDose = $Form->textBox('inv-Dose',$interventionsData['INV_DOSE']); echo $invDose; ?></td>
	    <?php } ?>
	    <?php if ($interventionsData['PROGRAM'] == 'true') { ?>
	    <td colspan="1">Program</td>
	    <td colspan="2"><?php		    
		    	$invProgramDDSQL = $Mela_SQL->tbl_LoadItems('Program');
		    	$invProgramDDArray = array();
		    	for ($i = 1; $i < (count($invProgramDDSQL)+1); $i++) {
					array_push($invProgramDDArray,$invProgramDDSQL[$i]['Long_Name']);
		    	}

		    	$invProgramDD = $Form->dropDown('inv-Program',$invProgramDDArray,$invProgramDDArray,$interventionsData['INV_PROGRAM']);
		    	echo $invProgramDD;
			?>
	    </td>
	    <?php } ?>
	</tr>


	<tr>
	    <?php if ($interventionsData['REASON'] == 'true') { ?>
	    <td colspan="1">Reason</td>
	    <td colspan="1"><?php
		    	$invReasonDDSQL = $Mela_SQL->tbl_LoadItems('Intervention Reason');
		    	$invReasonDDArray = array();
		    	for ($i = 1; $i < (count($invReasonDDSQL)+1); $i++) {
					array_push($invReasonDDArray,$invReasonDDSQL[$i]['Long_Name']);
		    	}

		    	$invReasonDD = $Form->dropDown('inv-Reason',$invReasonDDArray,$invReasonDDArray,$interventionsData['INV_REASON']);
		    	echo $invReasonDD;
			?>
	    </td>
	    <?php } ?>
	    <?php if ($interventionsData['SENSATION'] == 'true') { ?>
	    <td colspan="1">Sensation</td>
	    <td colspan="2"><?php
		    	$invSensationDDSQL = $Mela_SQL->tbl_LoadItems('Sensation');
		    	$invSensationDDArray = array();
		    	for ($i = 1; $i < (count($invSensationDDSQL)+1); $i++) {
					array_push($invSensationDDArray,$invSensationDDSQL[$i]['Long_Name']);
		    	}

		    	$invSensationDD = $Form->dropDown('inv-Sensation',$invSensationDDArray,$invSensationDDArray,$interventionsData['INV_SENSATION']);
		    	echo $invSensationDD;
			?>
	    </td>
	    <?php } ?>
	</tr>


	<tr>
	    <?php if ($interventionsData['ISTUBE'] == 'true') { ?>
	    <td colspan="1">Tube Length</td>
	    <td colspan="1"><?php $invTubeLength = $Form->textBox('inv-TubeLength',$interventionsData['INV_TUBELENGTH']); echo $invTubeLength; ?></td>
	    <?php } ?>
	    <?php if ($interventionsData['VOLTS'] == 'true') { ?>
	    <td colspan="1">Volts</td>
	    <td colspan="2"><?php
		    	$invVoltsDDSQL = $Mela_SQL->tbl_LoadItems('Volts');
		    	$invVoltsDDArray = array();
		    	for ($i = 1; $i < (count($invVoltsDDSQL)+1); $i++) {
					array_push($invVoltsDDArray,$invVoltsDDSQL[$i]['Long_Name']);
		    	}

		    	$invVoltsDD = $Form->dropDown('inv-Volts',$invVoltsDDArray,$invVoltsDDArray,$interventionsData['INV_VOLTS']);
		    	echo $invVoltsDD;
		    
		    	echo " Time ";
		    
		    	$invTimeVolts = $Form->textBox('inv-TimeVolts',$interventionsData['INV_TIME_VOLTS'],2);
		    	echo $invTimeVolts ." sec";
			?>
	    </td>
	    <?php } ?>
	</tr>



	<tr>
	    <?php if ($interventionsData['ISLINE'] == 'true') { ?>
	    <td colspan="1">Line Type</td>
	    <td colspan="1"><?php
		    	$invLineTypeDDSQL = $Mela_SQL->tbl_LoadItems('Line Type');
		    	$invLineTypeDDArray = array();
		    	for ($i = 1; $i < (count($invLineTypeDDSQL)+1); $i++) {
					array_push($invLineTypeDDArray,$invLineTypeDDSQL[$i]['Long_Name']);
		    	}

		    	$invLineTypeDD = $Form->dropDown('inv-LineType',$invLineTypeDDArray,$invLineTypeDDArray,$interventionsData['INV_LINETYPE']);
		    	echo $invLineTypeDD;
			?>
	    </td>
	    <?php } ?>
	    <?php if ($interventionsData['ISTUBE'] == 'true') { ?>
	    <td colspan="1">Tube Size</td>
	    <td colspan="2"><?php $invTubeSize = $Form->textBox('inv-TubeSize',$interventionsData['INV_TUBESIZE']); echo $invTubeSize; ?></td>
	    <?php } ?>
	</tr>





	<tr>
	    <?php if ($interventionsData['FREQUENCY'] == 'true') { ?>
	    <td colspan="1">Frequency</td>
	    <td colspan="1"><?php
		    	$invFrequencyDDSQL = $Mela_SQL->tbl_LoadItems('Frequency');
		    	$invFrequencyDDArray = array();
		    	for ($i = 1; $i < (count($invFrequencyDDSQL)+1); $i++) {
					array_push($invFrequencyDDArray,$invFrequencyDDSQL[$i]['Long_Name']);
		    	}

		    	$invFrequencyDD = $Form->dropDown('inv-Frequency',$invFrequencyDDArray,$invFrequencyDDArray,$interventionsData['INV_FREQUENCY']);
		    	echo $invFrequencyDD;
			?>
	    </td>
	    <?php } ?>
	    <?php if ($interventionsData['ISLINE'] == 'true') { ?>
	    <td colspan="1">Line Site</td>
	    <td colspan="2">
			<?php
		    	$invLineSiteDDSQL = $Mela_SQL->tbl_LoadItems('Line Site');
		    	$invLineSiteDDArray = array();
		    	for ($i = 1; $i < (count($invLineSiteDDSQL)+1); $i++) {
					array_push($invLineSiteDDArray,$invLineSiteDDSQL[$i]['Long_Name']);
		    	}

		    	$invLineSiteDD = $Form->dropDown('inv-lineSite',$invLineSiteDDArray,$invLineSiteDDArray,$interventionsData['INV_LINESITE']);
		    	echo $invLineSiteDD;
			?>
	    </td>
	    <?php } ?>
	</tr>


	<tr>
	    <?php if ($interventionsData['EPITESTDOSE'] == 'true') { ?>
	    <td colspan="1">Test</td>
	    <td colspan="4"><?php $invTest = $Form->textBox('inv-Test',$interventionsData['INV_TEST'],50); echo $invTest; ?></td>
	    <?php } ?>
	</tr>

	<tr>
	    <?php if ($interventionsData['TEST'] == 'true') { ?>
	    <td colspan="1">Result</td>
	    <td colspan="4"><?php $invResult = $Form->textBox('inv-Result',$interventionsData['INV_RESULT'],50); echo $invResult; ?></td>
	    <?php } ?>
	</tr>

	<tr>
	    <?php if ($interventionsData['TREATMENT'] == 'true') { ?>
	    <td colspan="1">Treatment</td>
	    <td colspan="4"><?php $invTreatment = $Form->textBox('inv-Treatment',$interventionsData['INV_TREATMENT'],50); echo $invTreatment; ?></td>
	    <?php } ?>
	</tr>

	<tr>
	    <?php if ($interventionsData['LA'] == 'true') { ?>
	    <td colspan="1">Choice of LA</td>
	    <td colspan="1"><?php
		    	$invChoiceOfLADDSQL = $Mela_SQL->tbl_LoadItems('Choice Of LA');
		    	$invChoiceOfLADDArray = array();
		    	for ($i = 1; $i < (count($invChoiceOfLADDSQL)+1); $i++) {
					array_push($invChoiceOfLADDArray,$invChoiceOfLADDSQL[$i]['Long_Name']);
		    	}
		    	$invChoiceOfLADD = $Form->dropDown('inv-ChoiceOfLA',$invChoiceOfLADDArray,$invChoiceOfLADDArray,$interventionsData['INV_CHOICEOFLA']);
		    	echo $invChoiceOfLADD;
			?>
	    </td>
	    <?php } ?>
	    <?php if ($interventionsData['TYPE'] == 'true') { ?>
	    <td colspan="1">Type</td>
	    <td colspan="2"><?php $invType = $Form->textBox('inv-Type',$interventionsData['INV_TYPE']); echo $invType; ?></td>
	    <?php } ?>
	</tr>



	<tr>
	    <?php if ($interventionsData['INSERTIONLEVEL'] == 'true') { ?>
	    <td colspan="1">Insertion Level</td>
	    <td colspan="1"><?php
		    	$invInsertionLevelDDSQL = $Mela_SQL->tbl_LoadItems('Insertion Level');
		    	$invInsertionLevelDDArray = array();
		    	for ($i = 1; $i < (count($invInsertionLevelDDSQL)+1); $i++) {
					array_push($invInsertionLevelDDArray,$invInsertionLevelDDSQL[$i]['Long_Name']);
		    	}

		    	$invInsertionLevelDD = $Form->dropDown('inv-InsertionLevel',$invInsertionLevelDDArray,$invInsertionLevelDDArray,$interventionsData['INV_INSERTIONLEVEL']);
		    	echo $invInsertionLevelDD;
			?>	
	    </td>
	    <?php } ?>
	    <?php if ($interventionsData['OPIOID'] == 'true') { ?>
	    <td colspan="1">Choice of Opioid</td>
	    <td colspan="2"><?php
		    	$invChoiceOfOpioidDDSQL = $Mela_SQL->tbl_LoadItems('Choice Of Opioid');
		    	$invChoiceOfOpioidDDArray = array();
		    	for ($i = 1; $i < (count($invChoiceOfOpioidDDSQL)+1); $i++) {
					array_push($invChoiceOfOpioidDDArray,$invChoiceOfOpioidDDSQL[$i]['Long_Name']);
		    	}

		    	$invChoiceOfOpioidDD = $Form->dropDown('inv-ChoiceOfOpioid',$invChoiceOfOpioidDDArray,$invChoiceOfOpioidDDArray,$interventionsData['INV_CHOICEOFOPIOID']);
		    	echo $invChoiceOfOpioidDD;
			?>
	    </td>
	    <?php } ?>
	</tr>
	<tr>
	    <?php if ($interventionsData['BLOCKLEVEL'] == 'true') { ?>
	    <td colspan="1">Block Level left</td>
	    <td colspan="1"><?php
		    	$invBlockLevelLeftDDSQL = $Mela_SQL->tbl_LoadItems('Block Level');
		    	$invBlockLevelLeftDDArray = array();
		    	for ($i = 1; $i < (count($invBlockLevelLeftDDSQL)+1); $i++) {
					array_push($invBlockLevelLeftDDArray,$invBlockLevelLeftDDSQL[$i]['Long_Name']);
		    	}

		    	$invBlockLevelLeftDD = $Form->dropDown('inv-BlockLevelLeft',$invBlockLevelLeftDDArray,$invBlockLevelLeftDDArray,$interventionsData['INV_BLOCKLEVEL']);
		    	echo $invBlockLevelLeftDD;
			?>	
	    </td>
	    <?php } ?>
	    <?php if ($interventionsData['RATE'] == 'true') { ?>
	    <td colspan="1">Rate</td>
	    <td colspan="2"><?php
		    	$invRateDDSQL = $Mela_SQL->tbl_LoadItems('Rate');
		    	$invRateDDArray = array();
		    	for ($i = 1; $i < (count($invRateDDSQL)+1); $i++) {
					array_push($invRateDDArray,$invRateDDSQL[$i]['Long_Name']);
		    	}

		    	$invRateDD = $Form->dropDown('inv-Rate',$invRateDDArray,$invRateDDArray,$interventionsData['INV_RATE']);
		    	echo $invRateDD;
			?>
	    </td>
	    <?php } ?>
	</tr>


	<tr>
	    <?php if ($interventionsData['BLOCKLEVEL'] == 'true') { ?>
	    <td colspan="1">Block Level right</td>
	    <td colspan="1"><?php
		    	$invBlockLevelRightDDSQL = $Mela_SQL->tbl_LoadItems('Block Level');
		    	$invBlockLevelRightDDArray = array();
		    	for ($i = 1; $i < (count($invBlockLevelRightDDSQL)+1); $i++) {
					array_push($invBlockLevelRightDDArray,$invBlockLevelRightDDSQL[$i]['Long_Name']);
		    	}

		    	$invBlockLevelRightDD = $Form->dropDown('inv-BlockLevelRight',$invBlockLevelRightDDArray,$invBlockLevelRightDDArray,$interventionsData['BLOCKLEVELRIGHT1']);
		    	echo $invBlockLevelRightDD;
			?>
	    </td>
	    <?php } ?>
	    <?php if ($interventionsData['DENSITYOFBLOCK'] == 'true') { ?>
	    <td colspan="1">Density of Block</td>
	    <td colspan="2"><?php
		    	$invDensityOfBlockDDSQL = $Mela_SQL->tbl_LoadItems('Density of Block');
		    	$invDensityOfBlockDDArray = array();
		    	for ($i = 1; $i < (count($invDensityOfBlockDDSQL)+1); $i++) {
					array_push($invDensityOfBlockDDArray,$invDensityOfBlockDDSQL[$i]['Long_Name']);
		    	}

		    	$invDensityOfBlockDD = $Form->dropDown('inv-DensityOfBlock',$invDensityOfBlockDDArray,$invDensityOfBlockDDArray,$interventionsData['INV_DENSITYOFBLOCK']);
		    	echo $invDensityOfBlockDD;
			?>
	    </td>
	    <?php } ?>
	</tr>



	<tr>
	    <?php if ($interventionsData['BROMAGESCORE'] == 'true') { ?>
	    <td colspan="1">Bromage Score</td>
	    <td colspan="1"><?php
		    	$invBromageScoreDDSQL = $Mela_SQL->tbl_LoadItems('Bromage Score');
		    	$invBromageScoreDDArray = array();
		    	for ($i = 1; $i < (count($invBromageScoreDDSQL)+1); $i++) {
					array_push($invBromageScoreDDArray,$invBromageScoreDDSQL[$i]['Long_Name']);
		    	}

		    	$invBromageScoreDD = $Form->dropDown('inv-BromageScore',$invBromageScoreDDArray,$invBromageScoreDDArray,$interventionsData['INV_BROMAGESCORE']);
		    	echo $invBromageScoreDD;
			?>
	    </td>
	    <?php } ?>
	    <?php if ($interventionsData['SITECHECK'] == 'true') { ?>
	    <td colspan="1">Site Check</td>
	    <td colspan="2"><?php
		    	$invSiteCheckDDSQL = $Mela_SQL->tbl_LoadItems('Site Check');
		    	$invSiteCheckDDArray = array();
		    	for ($i = 1; $i < (count($invSiteCheckDDSQL)+1); $i++) {
					array_push($invSiteCheckDDArray,$invSiteCheckDDSQL[$i]['Long_Name']);
		    	}

		    	$invSiteCheckDD = $Form->dropDown('inv-SiteCheck',$invSiteCheckDDArray,$invSiteCheckDDArray,$interventionsData['INV_SITECHECK']);
		    	echo $invSiteCheckDD;
			?>
	    </td>
	    <?php } ?>
	</tr>



	<tr>
	    <?php if ($interventionsData['INFUSION'] == 'true') { ?>
	    <td colspan="1">Infusion</td>
	    <td colspan="1"><?php $invInfusion = $Form->textBox('inv-Infusion',$interventionsData['INV_INFUSION']); echo $invInfusion; ?></td>
	    <td colspan="1">Next Refill</td>
	    <td colspan="2"><?php $invNextRefill = $Form->dateField('inv-NextRefill',stringToDateTime($interventionsData['INV_NEXTREFILL'],2)); echo $invNextRefill; ?></td>
	    <?php } ?>
	</tr>
	<?php if ($interventionsData['PUMP'] == 'true') { ?>
	<tr>
	    <td colspan="1">Pump No.</td>
	    <td colspan="1"><?php $invPumpNo = $Form->textBox('inv-PumpNo',$interventionsData['PUMP_NO']); echo $invPumpNo; ?></td>
	    <td colspan="1">No. of tries</td>
	    <td colspan="2"><?php $invNoOfTries = $Form->textBox('inv-NoOfTries',$interventionsData['NO_OF_TRIES']); echo $invNoOfTries; ?></td>   
	</tr>

	<tr>
	    <td colspan="1">No. of goods</td>
	    <td colspan="4"><?php $invNoOfGoods = $Form->textBox('inv-NoOfGoods',$interventionsData['NO_OF_GOODS']); echo $invNoOfGoods; ?></td>
	   
	</tr>
	<?php } ?>
    </table>
       



</div>
    </form>
</div>
</div>

<?php
}
?>