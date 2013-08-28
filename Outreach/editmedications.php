<script src="media/js/jquery-1.10.0.min.js"></script>
<script src="media/js/date.js"></script>
<script src="media/js/datesDifference.js"></script>
<script src="media/js/closeEditPages.js"></script>

<link type="text/css" rel="stylesheet" href="media/css/normalize.css"/>
<link type="text/css" rel="stylesheet" href="media/css/style.css"/>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        
        function changeDropDown(select, options) {
            var dropdown = $("select#" + select + "");
            var val = $('#' + options + '').val();
            var optionID = $('#' + options + ' option').filter(function() {
                return this.value == val;
            }).data('id');
            console.debug("Option is: " + options + " and ID is " + optionID + " and val is " + val);
            dropdown.empty();    
            dropdown.load("changeDropdown.php?dd=" + select + "&id=" + $('#' + options + '').val());
	}
	
	function calculateDuration(startDate, startTime, endDate, endTime) {
	    var differenceDays = getDaysDifference(startDate, endDate);
	    var differenceHoursMins = getHoursMinsDifference(startTime, endTime);	    
	    var duration = differenceDays + differenceHoursMins;
	    
	    $('#med-Duration').val(duration);	    
	}
            
        $('#crit-identifiedRole').change(function() {
            $('#crit-identifiedName').val('');
            changeDropDown('crit-identifiedName','crit-identifiedRole');
        });	
	
	$('#med-StartDate, #med-StartTime, #med-EndDate, #med-EndTime').change(function() {
	    var startDate = $('#med-StartDate').val();
	    var startTime = $('#med-StartTime').val();
	    var endDate = $('#med-EndDate').val();
	    var endTime = $('#med-EndTime').val();
	    
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

$Form = new Mela_Forms('editMedications','','POST','medications_form');

if (!$_REQUEST['dlk'] || !$_REQUEST['lnk'] || !$_REQUEST['row']) die("Necessary data is missing");

$row = filter_var($_REQUEST['row'], FILTER_SANITIZE_NUMBER_INT);
$dlkID = filter_var($_REQUEST['dlk'], FILTER_SANITIZE_NUMBER_INT);
$lnkID = filter_var($_REQUEST['lnk'], FILTER_SANITIZE_NUMBER_INT);

// Get relevant data to fill out form
$query = "SELECT med.itm_ID, DATE_TO_CHAR(med.med_AssignedDate,'yyyy-Mm-Dd') AS MED_ASSIGNEDDATE, med.med_Time, DATE_TO_CHAR(med.End_Date,'yyyy-Mm-Dd') AS END_DATE, med.End_Time,
	  med.med_Comments, med.med_PrescribedBy, med.med_Dose, med.med_Strength, med.med_NextRefill,
	  med.Pump_No, med.No_Of_Tries, med.No_Of_Goods, med.med_Frequency, med.med_Route, med.`Duration`,
	  med.Unit AS Medication_Unit,
	  itm.Description, itm.Invisible, itm.Dose, itm.Pump, itm.PrescribedBy, itm.Unit, itm.Dose_Value,
	  itm.Frequency, itm.Strength, itm.`Time`, itm.Route, itm.PUlcer_Scr, itm.Self_Med
	  FROM Medication med
	  LEFT OUTER JOIN Items_Med itm ON med.itm_ID = itm.ID
	  WHERE med.itm_ID=$row AND med.med_dlkID=$dlkID AND med.med_lnkID=$lnkID AND med.itm_ID=itm.ID";
try { 
    $result = odbc_exec($connect,$query); 
    if($result){ 
	$medicationsData = odbc_fetch_array($result);
    } else { 
        throw new RuntimeException("Failed to connect."); 
    } 
} 
catch (RuntimeException $e) { 
    print("Exception caught: $e");
}






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







$hiddenRow = $Form->hiddenField('row',$row);
$hiddenDLK = $Form->hiddenField('dlk',$dlkID);
$hiddenLNK = $Form->hiddenField('lnk',$lnkID);

echo $hiddenRow;
echo $hiddenDLK;
echo $hiddenLNK;

if ($_POST) {
    
    if (!$_POST['itmID']) die("No ID set for selected row.");
    $itmID = filter_var($_REQUEST['itmID'], FILTER_SANITIZE_NUMBER_INT);
    
    foreach($_POST as $k => $v) {
	$formKey[$k] = $k;
	$formVal[$k] = checkValues($v);
	//echo "<b>". $formKey[$k] ."</b> - ". $formVal[$k] ."<br />";
    }

    $medAssignedDateSQL = "";
    if (strlen($formVal['med-StartDate']) > 0) {
	$medAssignedDateSQL = "med_AssignedDate='".$formVal['med-StartDate']."', ";
    }
    
    $medAssignedTimeSQL = "";
    if (strlen($formVal['med-StartTime']) > 0) {
	$medAssignedTimeSQL = "med_Time='".$formVal['med-StartTime']."', ";
    }
    
    $medEndDateSQL = "";
    if (strlen($formVal['med-EndDate']) > 0) {
	$medEndDateSQL = "End_Date='".$formVal['med-EndDate']."', ";
    }
    
    $medEndTimeSQL = "";
    if (strlen($formVal['med-EndTime']) > 0) {
	$medEndTimeSQL = "End_Time='".$formVal['med-EndTime']."', ";
    }
    
    $medNextRefillSQL = "";
    if (strlen($formVal['med-NextRefill']) > 0) {
	$medNextRefillSQL = "med_NextRefill='".$formVal['med-NextRefill']."', ";
    }
    
    $medPrescribedBySQL = "";
    if (strlen($formVal['med-prescribedBy']) > 0) {
	$medPrescribedBySQL = "med_PrescribedBy='".$formVal['med-prescribedBy']."', ";
    }
    
    $medDoseSQL = "";
    if (strlen($formVal['med-Dose']) > 0) {
	$medDoseSQL = "med_Dose=".$formVal['med-Dose'].", ";
    }
    
    $medStrengthSQL = "";
    if (strlen($formVal['med-Strength']) > 0) {
	$medStrengthSQL = "med_Strength='".$formVal['med-Strength']."', ";
    }
    
    $medPumpSQL = "";
    if (strlen($formVal['med-PumpNo']) > 0) {
	$medPumpSQL = "Pump_No='".$formVal['med-PumpNo']."', ";
    }
    
    $medFrequencySQL = "";
    if (strlen($formVal['med-Frequency']) > 0) {
	$medFrequencySQL = "med_Frequency='".$formVal['med-Frequency']."', ";
    }
    
    $medRouteSQL = "";
    if (strlen($formVal['med-Route']) > 0) {
	$medRouteSQL = "med_Route='".$formVal['med-Route']."', ";
    }
    
    $hiddenComments = $Form->hiddenField('hiddenComments',$formVal['med-Comments']);
    echo $hiddenComments;
    
    // Need to check that the record is properly locked first of all
    if ($Mela_SQL->Exec4DSQL("SQLLock_IsLocked", $lnkID) == 1) { 
	$query = "UPDATE Medication SET $medAssignedDateSQL $medAssignedTimeSQL $medEndDateSQL $medEndTimeSQL med_Comments='".$formVal['med-Comments']."',
	$medPrescribedBySQL $medDoseSQL $medStrengthSQL $medNextRefillSQL
	$medPumpSQL $medFrequencySQL $medRouteSQL No_Of_Tries=".$formVal['med-NoOfTries'].", No_Of_Goods=".$formVal['med-NoOfGoods'].",
	`Duration`='".$formVal['med-Duration']."', Unit='".$formVal['med-Units']."'
	WHERE itm_ID=$row AND med_dlkID=$dlkID AND med_lnkID=$lnkID";
	try { 
	    $result = odbc_exec($connect,$query); 
	    if($result){ 
    ?>
    
		<script type="text/javascript">
		    CloseAndRefresh('row','hiddenComments','mednotes');
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
    $itmID = $Form->hiddenField('itmID',$medicationsData['ITM_ID']);
    echo $itmID;
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
                    <tr><td class="Table_Right iwashere" color="#ffffff">NHS No&nbsp;</td><td color="#ffffff" class="Table_Right"><?php echo $HeaderData['DMG_NHSNUMBER']; ?></td></tr>
                    <tr><td class="Table_Right" color="#ffffff">Hospital No&nbsp;</td><td color="#ffffff" class="Table_Right"><?php echo $HeaderData['DMG_HOSPITALNUMBER']; ?></td></tr>
                    <tr><td class="Table_Right" color="#ffffff">Referral No&nbsp;</td><td color="#ffffff" class="Table_Right"><?php echo $HeaderData['ADM_NUMBER']; ?></td></tr>
                </table>
            </li>
        </ul>
    </div>



        <div id="tabs2" class="btn_bar">
            <button style="font-size:small;color:red" type="button"  value="Cancel" onclick="CloseAndRefresh()" href=>Cancel</button>
            <button style="font-size:small;color:green" type="submit" value="Save" onclick="submitButton()">Save</button>
            <!-- <input type="submit" value="Save"> -->
            <!-- Form submission success -->
            <div id="success" style="display: none;">
                Success
            </div>
        </div>


 <!--    <?php
        $medSubmit = $Form->submitButton();
        echo $medSubmit;
    ?> -->




<div class="medi_div">
    <form action="" method="POST">
    <table class="temp medi_tab">
	<tr>
	    <td>Description</td>
	    <td colspan='8'>
		<?php $medDescription = $Form->textBox('med-Description',$medicationsData['DESCRIPTION']); echo $medDescription; ?></td>
	</tr>
	<tr>
	    <td>Start Date/Time</td>
	    <td colspan='2'>
		    <?php $myDclass = array("medDate");
		    $medStartDate = $Form->dateField('med-StartDate',stringToDateTime($medicationsData['MED_ASSIGNEDDATE']),$myDclass); echo $medStartDate; ?>
		    <?php $myTclass = array("medTime");
		    $medStartTime = $Form->timeField('med-StartTime',convert4DTime($medicationsData['MED_TIME']),$myTclass); echo $medStartTime; ?>
	    </td>
	    
	    <td>End Date/Time</td>
	    <td colspan='2'>
			<?php $myDclass = array("medDate");
			$medEndDate = $Form->dateField('med-EndDate',stringToDateTime($medicationsData['END_DATE']),$myDclass); echo $medEndDate; ?>
		    <?php $myTclass = array("medTime");
		    $medEndTime = $Form->timeField('med-EndTime',convert4DTime($medicationsData['END_TIME']),$myTclass); echo $medEndTime; ?>
	    </td>
	    
	    <td>Duration</td>
	    <td colspan='2'><?php $myStrclass = array("medStrDate");
	    $medDuration = $Form->textBox('med-Duration',$medicationsData['DURATION'],'','',$myStrclass); echo $medDuration; ?></td>
	</tr>
    <tr>
	    <td>Comments</td>
		<td colspan='7'><?php $myMedText = array("medText");
		$medComments = $Form->textArea('med-Comments',$medicationsData['MED_COMMENTS'],'','','',$myMedText); echo $medComments; ?></td>
	</tr>


	<?php if ($medicationsData['PRESCRIBEDBY'] == 'true') { ?>
		<tr>	    
		    <td>Prescribed by</td>
		    <td colspan='7'>
				<?php
	                $medPrescribedByDDSQL = $Mela_SQL->getMedicalStaff(1,0,0,0,1);
	                $medPrescribedByDDArray = array();
	                for ($i = 1; $i < (count($medPrescribedByDDSQL)); $i++) {
	                    array_push($medPrescribedByDDArray,$medPrescribedByDDSQL[$i]['mds_Name']);
	                }
	    
	                $medPrescribedByDD = $Form->dropDown('med-prescribedBy',$medPrescribedByDDArray,$medPrescribedByDDArray,$medicationsData['MED_PRESCRIBEDBY']);
	                echo $medPrescribedByDD;
	                ?>
		    </td>
		</tr>
	<?php } ?>



	<?php if ($medicationsData['DOSE'] == 'true') { ?>
	    <tr>
		<td>Dose</td>
		<td colspan='7'><?php $medDose = $Form->textBox('med-Dose',$medicationsData['MED_DOSE']); echo $medDose; ?></td>
	    </tr>
	<?php } ?>


	<!--<tr>
	    <td>Units</td>
	    <td colspan='2'>
		<?php
		    $medUnitsDDSQL = $Mela_SQL->tbl_LoadItems('Dose Units');
		    $medUnitsDDArray = array();
		    for ($i = 1; $i < (count($medUnitsDDSQL)+1); $i++) {
			array_push($medUnitsDDArray,$medUnitsDDSQL[$i]['Long_Name']);
		    }

		    $medUnitsDD = $Form->dropDown('med-Units',$medUnitsDDArray,$medUnitsDDArray,$medicationsData['Medication_Unit']);
		    echo $medUnitsDD;
		    //var_dump($medicationsData);
		?>
	    </td>
	    <td>Units</td>
	    <td colspan='2'>
		<?php
		    $medUnitsDDSQL = $Mela_SQL->tbl_LoadItems('Dose Units');
		    $medUnitsDDArray = array();
		    for ($i = 1; $i < (count($medUnitsDDSQL)+1); $i++) {
			array_push($medUnitsDDArray,$medUnitsDDSQL[$i]['Long_Name']);
		    }

		    $medUnitsDD = $Form->dropDown('med-Units',$medUnitsDDArray,$medUnitsDDArray,$medicationsData['Medication_Unit']);
		    echo $medUnitsDD;
		    //var_dump($medicationsData);
		?>
	    </td>
	    <td>Units</td>
	    <td colspan='2'>
		<?php
		    $medUnitsDDSQL = $Mela_SQL->tbl_LoadItems('Dose Units');
		    $medUnitsDDArray = array();
		    for ($i = 1; $i < (count($medUnitsDDSQL)+1); $i++) {
			array_push($medUnitsDDArray,$medUnitsDDSQL[$i]['Long_Name']);
		    }

		    $medUnitsDD = $Form->dropDown('med-Units',$medUnitsDDArray,$medUnitsDDArray,$medicationsData['Medication_Unit']);
		    echo $medUnitsDD;
		    //var_dump($medicationsData);
		?>
	    </td>
	</tr>-->
	<?php if ($medicationsData['STRENGTH'] == 'true') { ?>
		<tr>
		    <td>Strength</td>
		    <td colspan='7'><?php $medStrength = $Form->textBox('med-Strength',$medicationsData['MED_STRENGTH']); echo $medStrength; ?></td>
		</tr>
	<?php } ?>

	<?php if ($medicationsData['PUMP'] == 'true') { ?>
	<tr>
	    <td>Next Refill</td>
	    <td colspan='7'><?php $medNextRefill = $Form->dateField('med-NextRefill',stringToDateTime($medicationsData['MED_NEXTREFILL'],2)); echo $medNextRefill; ?></td>
	</tr>

        <tr>
	    	<td>Pump No.</td>
	    	<td colspan='7'><?php $medPumpNo = $Form->textBox('med-PumpNo',$medicationsData['PUMP_NO']); echo $medPumpNo;?></td>
		</tr>
	<?php } ?>

	<?php if ($medicationsData['SELF_MED'] == 'true') { ?>
	<tr>
	    <td>No. Of Tries</td>
	    <td colspan='7'><?php $medNoOfTries = $Form->textBox('med-NoOfTries',$medicationsData['NO_OF_TRIES']); echo $medNoOfTries; ?></td>
	</tr>


	<tr>
	    <td>No. Of Goods</td>
	    <td colspan='7'><?php $medNoOfGoods = $Form->textBox('med-NoOfGoods',$medicationsData['NO_OF_GOODS']); echo $medNoOfGoods; ?></td>
	</tr>
	<?php } ?>

	<?php if ($medicationsData['FREQUENCY'] == 'true') { ?>
	    <tr>
		<td>Frequency</td>
		<td colspan='7'>
		    <?php
			$medFrequencyDDSQL = $Mela_SQL->tbl_LoadItems('Frequency');
			$medFrequencyDDArray = array();
			for ($i = 1; $i < (count($medFrequencyDDSQL)+1); $i++) {
			    array_push($medFrequencyDDArray,$medFrequencyDDSQL[$i]['Long_Name']);
			}

			$medFrequencyDD = $Form->dropDown('med-Frequency',$medFrequencyDDArray,$medFrequencyDDArray,$medicationsData['MED_FREQUENCY']);
			echo $medFrequencyDD;
		    ?>
		</td>
	    </tr>
	<?php } ?>



	<?php if ($medicationsData['ROUTE'] == 'true') { ?>
        <tr>
		    <td>Route</td>
		    <td colspan='7'>
		    	<?php
				    $medRouteDDSQL = $Mela_SQL->tbl_LoadItems('Route');
				    $medRouteDDArray = array();
				    for ($i = 1; $i < (count($medRouteDDSQL)+1); $i++) {
					array_push($medRouteDDArray,$medRouteDDSQL[$i]['Long_Name']);
				    }

				    $medRouteDD = $Form->dropDown('med-Route',$medRouteDDArray,$medRouteDDArray,$medicationsData['MED_ROUTE']);
				    echo $medRouteDD;
				?>
		    </td>
		</tr>
	<?php } ?>
    </table>
       
<br />


</div>
</div>



<?php
}
?>