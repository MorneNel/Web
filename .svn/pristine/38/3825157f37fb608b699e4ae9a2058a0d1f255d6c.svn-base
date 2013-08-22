<script src="media/js/jquery-1.10.0.min.js"></script>
<script src="media/js/closeEditPages.js"></script>
<script language="JavaScript" type="text/javascript">    
    $(document).ready(function() {
        
        function changeDropDown(select, options) {
            var dropdown = $("select#" + select + "");
            var val = $('#' + options + '').val();
            var optionID = $('#' + options + ' option').filter(function() {
                return this.value == val;
            }).data('id');
            dropdown.empty();    
            dropdown.load("changeDropdown.php?dd=" + select + "&id=" + $('#' + options + '').val());
	    console.debug(optionID);
	}
        
	/*$('#crit-identifiedRole[value!=""]').ready(function() {
	    changeDropDown('crit-identifiedName','crit-identifiedRole');
	});*/
	
	$('#crit-identifiedName').one("click", function() {
            changeDropDown('crit-identifiedName','crit-identifiedRole');
        });
	    
        $('#crit-identifiedRole').change(function() {
            $('#crit-identifiedName').val('');
            changeDropDown('crit-identifiedName','crit-identifiedRole');
        });
    });
</script>

<?php
error_reporting(E_ALL ^ E_NOTICE);

include './MelaClass/functions.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$Form = new Mela_Forms('editCriticalIncidents','','POST','criticalincidents_form');

if (!$_REQUEST['dlk'] || !$_REQUEST['lnk'] || !$_REQUEST['row']) die("Necessary data is missing");

$row = filter_var($_REQUEST['row'], FILTER_SANITIZE_NUMBER_INT);
$dlkID = filter_var($_REQUEST['dlk'], FILTER_SANITIZE_NUMBER_INT);
$lnkID = filter_var($_REQUEST['lnk'], FILTER_SANITIZE_NUMBER_INT);

// Get relevant data to fill out form

$query = "SELECT cc_ID, Itm_ID, cc_ListItem, Comments, Date_Assigned, Time_Assigned, Location, mds_Role, mds_Name,
          How_Identified, Issues, Tagged, Suggested_Causes, Detail, Notified_to, Outcome, Contributing_factor,
          Resuscitation
	  FROM Critical_Inc
	  WHERE Itm_ID=$row AND cc_dlkID=$dlkID AND cc_lnkID=$lnkID";
try { 
    $result = odbc_exec($connect,$query); 
    if($result){ 
	$criticalIncData = odbc_fetch_array($result);
    } else { 
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
    
    if (!$_POST['critID']) die("No ID set for selected row.");
    $critID = filter_var($_REQUEST['critID'], FILTER_SANITIZE_NUMBER_INT);
    
    foreach($_POST as $k => $v) {
	$formKey[$k] = $k;
	$formVal[$k] = checkValues($v);
	//echo "<b>". $formKey[$k] ."</b> - ". $formVal[$k] ."<br />";
    }

    $dateAssignedSQL = "";
    if (strlen($formVal['crit-Date']) > 0) {
	$dateAssignedSQL = "Date_Assigned='".$formVal['crit-Date']."', ";
    }
    
    $timeAssignedSQL = "";
    if (strlen($formVal['crit-Time']) > 0) {
	$timeAssignedSQL = "Time_Assigned='".$formVal['crit-Time']."', ";
    }
    
    $critTagged = "";
    if ((empty($formVal['crit-review'])) AND (empty($formVal['crit-research']))) {
        $critTagged = "";
    } elseif ((empty($formVal['crit-review'])) AND (!empty($formVal['crit-research']))) {
        $critTagged = "Tagged='Research', ";
    } elseif ((!empty($formVal['crit-review'])) AND (empty($formVal['crit-research']))) {
        $critTagged = "Tagged='Review', ";
    } elseif ((!empty($formVal['crit-review'])) AND (!empty($formVal['crit-research']))) {
        $critTagged = "Tagged='Review and Research', ";
    }
    
    $critSuggestedCauses = "";
    if ((empty($formVal['crit-humanFactor'])) AND (empty($formVal['crit-patientFactor'])) AND (empty($formVal['crit-systemFactor']))) {
        $critSuggestedCauses = "";
    } elseif ((!empty($formVal['crit-humanFactor'])) AND (empty($formVal['crit-patientFactor'])) AND (empty($formVal['crit-systemFactor']))) {
        $critSuggestedCauses = "Suggested_Causes='Human factor', ";
    } elseif ((empty($formVal['crit-humanFactor'])) AND (!empty($formVal['crit-patientFactor'])) AND (empty($formVal['crit-systemFactor']))) {
        $critSuggestedCauses = "Suggested_Causes='Patient factor', ";
    } elseif ((empty($formVal['crit-humanFactor'])) AND (empty($formVal['crit-patientFactor'])) AND (!empty($formVal['crit-systemFactor']))) {
        $critSuggestedCauses = "Suggested_Causes='System factor', ";
    } elseif ((!empty($formVal['crit-humanFactor'])) AND (!empty($formVal['crit-patientFactor'])) AND (empty($formVal['crit-systemFactor']))) {
        $critSuggestedCauses = "Suggested_Causes='Human and Patient factor', ";
    } elseif ((!empty($formVal['crit-humanFactor'])) AND (empty($formVal['crit-patientFactor'])) AND (!empty($formVal['crit-systemFactor']))) {
        $critSuggestedCauses = "Suggested_Causes='Human and System factor', ";
    } elseif ((empty($formVal['crit-humanFactor'])) AND (!empty($formVal['crit-patientFactor'])) AND (!empty($formVal['crit-systemFactor']))) {
        $critSuggestedCauses = "Suggested_Causes='Patient and System factor', ";
    } elseif ((!empty($formVal['crit-humanFactor'])) AND (!empty($formVal['crit-patientFactor'])) AND (!empty($formVal['crit-systemFactor']))) {
        $critSuggestedCauses = "Suggested_Causes='Human, Patient and System factor', ";
    }
    
    $hiddenComments = $Form->hiddenField('hiddenComments',$formVal['crit-Comments']);
    echo $hiddenComments;
    
    // Need to check that the record is properly locked first of all
    if ($Mela_SQL->Exec4DSQL("SQLLock_IsLocked", $lnkID) == 1) {
    
	// Need to add mds_Role, mds_Name, Tagged, Suggested_Causes
	$query = "UPDATE Critical_Inc SET Comments='".$formVal['crit-Comments']."', $dateAssignedSQL $timeAssignedSQL Location='".$formVal['crit-Location']."', mds_Role='".$formVal['crit-identifiedRole']."',
	mds_Name='".$formVal['crit-identifiedName']."', How_Identified='".$formVal['crit-howIdentified']."', Issues='".$formVal['crit-issues']."', $critTagged $critSuggestedCauses Detail='".$formVal['crit-Detail']."',
	Notified_to='".$formVal['crit-NotifiedTo']."', Outcome='".$formVal['crit-Outcome']."', Contributing_factor='".$formVal['crit-ContributingFactors']."', Resuscitation='".$formVal['crit-Resuscitation']."'
	WHERE Itm_ID=$row AND cc_dlkID=$dlkID AND cc_lnkID=$lnkID";
	try { 
	    $result = odbc_exec($connect,$query); 
	    if($result){ 
		?>
		<script type="text/javascript">
		    CloseAndRefresh('row','hiddenComments','cinotes');
		</script>
		<?php
	    } else {
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
    $critID = $Form->hiddenField('critID',$criticalIncData['ITM_ID']);
    echo $critID;
?>
<fieldset style="width:95%;">
    <legend>
        Selected record
    </legend>
    <form action="" method="POST">
    <table class="temp" cellpadding="5">
	<tr>
	    <td>
		Description
	    </td>
	    <td colspan='3'>
		<?php
		    $critDescription = $Form->textBox('crit-Description',$criticalIncData['CC_LISTITEM'],'',1);
		    echo $critDescription;
		?>
	    </td>
	</tr>
        <tr>
            <td>
		Comments
            </td>
	    <td colspan='3'>
		<?php		
		    $startDate = $Form->textArea('crit-Comments',$criticalIncData['COMMENTS']);
		    echo $startDate;
		?>
	    </td>
	    
	    <td>
		Date
	    </td>
	    <td>
		<?php
		    $critDate = $Form->dateField('crit-Date',stringToDateTime($criticalIncData['DATE_ASSIGNED'],2));
		    echo $critDate;
		?>
	    </td>
	</tr>
	<tr>	    
	    <td>
		Time
	    </td>
	    <td>
		<?php
		    $critTime = $Form->timeField('crit-Time',convert4DTime($criticalIncData['TIME_ASSIGNED']));
		    echo $critTime;
		?>
	    </td>
	</tr>
	<tr>
	    <td>
		Location
	    </td>
	    <td colspan='3'>
		<?php
                    $locationDDSQL = $Mela_SQL->tbl_LoadItems('Wards');
		    $locationDDArray = array();
		    for ($i = 1; $i < (count($locationDDSQL)+1); $i++) {
			array_push($locationDDArray,$locationDDSQL[$i]['Long_Name']);
		    }

		    $locationDD = $Form->dropDown('crit-Location',$locationDDArray,$locationDDArray,$criticalIncData['LOCATION']);
		    
		    echo $locationDD;
                ?>
	    </td>
        </tr>
        <tr>
	    <td>
		Identified by role
	    </td>
	    <td colspan='3'>
		<?php
                    $identifiedRoleDDSQL = $Mela_SQL->tbl_LoadItems('Roles');
		    $identifiedRoleDDArray = array();
		    for ($i = 1; $i < (count($identifiedRoleDDSQL)+1); $i++) {
			array_push($identifiedRoleDDArray,$identifiedRoleDDSQL[$i]['Long_Name']);
		    }

		    $identifiedRoleDD = $Form->dropDown('crit-identifiedRole',$identifiedRoleDDArray,$identifiedRoleDDArray,$criticalIncData['MDS_ROLE']);
		    
		    echo $identifiedRoleDD;
                ?>
	    </td>
	</tr>
	<tr>
	    <td>
		Identified by name
	    </td>
	    <td colspan='3'>
		<?php
                    //$identifiedNameDDSQL = $Mela_SQL->getMedicalStaff(1,0,0,0);
		    $identifiedNameDDSQL = $Mela_SQL->getMedicalStaff();
                    $identifiedNameDDArray = array();
                    for ($i = 1; $i < (count($identifiedNameDDSQL)); $i++) {
                        array_push($identifiedNameDDArray,$identifiedNameDDSQL[$i]['mds_Name']);
                    }
        
                    $identifiedNameDD = $Form->dropDown('crit-identifiedName',$identifiedNameDDArray,$identifiedNameDDArray,$criticalIncData['MDS_NAME']);
                    echo $identifiedNameDD;
                ?>
	    </td>
        </tr>
        <tr>
	    <td>
		How identified
	    </td>
	    <td>
		<?php
                    $howIdentifiedDDSQL = $Mela_SQL->tbl_LoadItems('Critical Incident How Identified');
		    $howIdentifiedDDArray = array();
		    for ($i = 1; $i < (count($howIdentifiedDDSQL)+1); $i++) {
			array_push($howIdentifiedDDArray,$howIdentifiedDDSQL[$i]['Long_Name']);
		    }

		    $howIdentifiedDD = $Form->dropDown('crit-howIdentified',$howIdentifiedDDArray,$howIdentifiedDDArray,$criticalIncData['HOW_IDENTIFIED']);
		    
		    echo $howIdentifiedDD;
                ?>
	    </td>
	</tr>
	<tr>
	    <td>
		Issues
	    </td>
	    <td colspan='3'>
		<?php
                    $issuesDDSQL = $Mela_SQL->tbl_LoadItems('Critical Incident Issues');
		    $issuesDDArray = array();
		    for ($i = 1; $i < (count($issuesDDSQL)+1); $i++) {
			array_push($issuesDDArray,$issuesDDSQL[$i]['Long_Name']);
		    }

		    $issuesDD = $Form->dropDown('crit-issues',$issuesDDArray,$issuesDDArray,$criticalIncData['ISSUES']);
		    
		    echo $issuesDD;
                ?>
	    </td>
        </tr>
        <tr>
	    <td>
		Tagged
	    </td>
	    <td colspan='3'>
		<?php		    
                    switch ($criticalIncData['TAGGED']) {
                        case "Review":
                            $critTaggedData = array(0 => array('crit-review','1','Review','checked'),
                                                    1 => array('crit-research','1','Research',''));
                        break;
                    
                        case "Research":
                            $critTaggedData = array(0 => array('crit-review','1','Review',''),
                                                    1 => array('crit-research','1','Research','checked'));    
                        break;
                    
                        case "Review and Research":
                            $critTaggedData = array(0 => array('crit-review','1','Review','checked'),
                                                    1 => array('crit-research','1','Research','checked'));    
                        break;
                    
                        default:
                            $critTaggedData = array(0 => array('crit-review','1','Review',''),
                                                    1 => array('crit-research','1','Research',''));    
                        break;
                    }
                    
                    $checkBoxGroup = $Form->checkBoxGroup('crit-Tagged',$critTaggedData,'','');
                    echo $checkBoxGroup;
		?>
	    </td>
	</tr>
	<tr>
	    <td>
		Suggested Causes
	    </td>
	    <td colspan='3'>
		<?php		    
                    switch ($criticalIncData['SUGGESTED_CAUSES']) {
                        case "Human factor":
                            $suggestedCausesData = array(0 => array('crit-humanFactor','1','Human factor','checked'),
                                                    1 => array('crit-patientFactor','1','Patient factor',''),
                                                    2 => array('crit-systemFactor','1','System factor',''));
                        break;
                    
                        case "Patient factor":
                            $suggestedCausesData = array(0 => array('crit-humanFactor','1','Human factor',''),
                                                    1 => array('crit-patientFactor','1','Patient factor','checked'),
                                                    2 => array('crit-systemFactor','1','System factor',''));    
                        break;
                    
                        case "System factor":
                            $suggestedCausesData = array(0 => array('crit-humanFactor','1','Human factor',''),
                                                    1 => array('crit-patientFactor','1','Patient factor',''),
                                                    2 => array('crit-systemFactor','1','System factor','checked'));    
                        break;
                    
                        case "Human and Patient factor":
                            $suggestedCausesData = array(0 => array('crit-humanFactor','1','Human factor','checked'),
                                                    1 => array('crit-patientFactor','1','Patient factor','checked'),
                                                    2 => array('crit-systemFactor','1','System factor',''));
                        break;
                    
                        case "Human and System factor":
                            $suggestedCausesData = array(0 => array('crit-humanFactor','1','Human factor','checked'),
                                                    1 => array('crit-patientFactor','1','Patient factor',''),
                                                    2 => array('crit-systemFactor','1','System factor','checked'));
                        break;
                    
                        case "Patient and System factor":
                            $suggestedCausesData = array(0 => array('crit-humanFactor','1','Human factor',''),
                                                    1 => array('crit-patientFactor','1','Patient factor','checked'),
                                                    2 => array('crit-systemFactor','1','System factor','checked'));
                        break;
                    
                        case "Human, Patient and System factor":
                            $suggestedCausesData = array(0 => array('crit-humanFactor','1','Human factor','checked'),
                                                    1 => array('crit-patientFactor','1','Patient factor','checked'),
                                                    2 => array('crit-systemFactor','1','System factor','checked'));
                        break;
                    
                        default:
                            $suggestedCausesData = array(0 => array('crit-humanFactor','1','Human factor',''),
                                                    1 => array('crit-patientFactor','1','Patient factor',''),
                                                    2 => array('crit-systemFactor','1','System factor',''));    
                        break;
                    }
                    
                    $suggestedCausesCheckBoxGroup = $Form->checkBoxGroup('crit-SuggestedCauses',$suggestedCausesData,'','');
                    echo $suggestedCausesCheckBoxGroup;
		?>
	    </td>
        </tr>
        <tr>
	    <td>
		CI Detail
	    </td>
	    <td colspan='3'>
		<?php
		    $critDetailDDSQL = $Mela_SQL->tbl_LoadItems('Critical Incident Detail');
		    $critDetailDDArray = array();
		    for ($i = 1; $i < (count($critDetailDDSQL)+1); $i++) {
			array_push($critDetailDDArray,$critDetailDDSQL[$i]['Long_Name']);
		    }

		    $critDetailDD = $Form->dropDown('crit-Detail',$critDetailDDArray,$critDetailDDArray,$criticalIncData['DETAIL']);
		    echo $critDetailDD;
		?>
	    </td>
	</tr>
	<tr>
	    <td>
		Notified to
	    </td>
	    <td colspan='3'>
		<?php
		    $critNotifiedToDDSQL = $Mela_SQL->tbl_LoadItems('Critical Incident Notified To');
		    $critNotifiedToDDArray = array();
		    for ($i = 1; $i < (count($critNotifiedToDDSQL)+1); $i++) {
			array_push($critNotifiedToDDArray,$critNotifiedToDDSQL[$i]['Long_Name']);
		    }

		    $critNotifiedToDD = $Form->dropDown('crit-NotifiedTo',$critNotifiedToDDArray,$critNotifiedToDDArray,$criticalIncData['NOTIFIED_TO']);
		    echo $critNotifiedToDD;
		?>	
	    </td>
        </tr>
        <tr>
	    <td>
		Outcome 
	    </td>
	    <td colspan='3'>
		<?php
		    $critOutcomeDDSQL = $Mela_SQL->tbl_LoadItems('Critical Incident Outcome');
		    $critOutcomeDDArray = array();
		    for ($i = 1; $i < (count($critOutcomeDDSQL)+1); $i++) {
			array_push($critOutcomeDDArray,$critOutcomeDDSQL[$i]['Long_Name']);
		    }

		    $critOutcomeDD = $Form->dropDown('crit-Outcome',$critOutcomeDDArray,$critOutcomeDDArray,$criticalIncData['OUTCOME']);
		    echo $critOutcomeDD;
		?>
	    </td>
	</tr>
	<tr>
	    <td>
		Contributing Factors
	    </td>
	    <td colspan='3'>
		<?php
		    $critContributingFactorsDDSQL = $Mela_SQL->tbl_LoadItems('Critical Incident Contributing Factor');
		    $critContributingFactorsDDArray = array();
		    for ($i = 1; $i < (count($critContributingFactorsDDSQL)+1); $i++) {
			array_push($critContributingFactorsDDArray,$critContributingFactorsDDSQL[$i]['Long_Name']);
		    }

		    $critContributingFactorsDD = $Form->dropDown('crit-ContributingFactors',$critContributingFactorsDDArray,$critContributingFactorsDDArray,$criticalIncData['CONTRIBUTING_FACTOR']);
		    echo $critContributingFactorsDD;
		?>
	    </td>
        </tr>
        <tr>
	    <td>
		Resuscitation
	    </td>
	    <td colspan='3'>
		<?php
		    $critResuscitationDDSQL = $Mela_SQL->tbl_LoadItems('Critical Incident Resuscitation');
		    $critResuscitationDDArray = array();
		    for ($i = 1; $i < (count($critResuscitationDDSQL)+1); $i++) {
			array_push($critResuscitationDDArray,$critResuscitationDDSQL[$i]['Long_Name']);
		    }

		    $critResuscitationDD = $Form->dropDown('crit-Resuscitation',$critResuscitationDDArray,$critResuscitationDDArray,$criticalIncData['RESUSCITATION']);
		    echo $critResuscitationDD;
		?>	
	    </td>
	</tr>
    </table>
       
    <?php
        $critSubmit = $Form->submitButton();
        echo $critSubmit;
    ?>
</fieldset>
<?php
}
?>