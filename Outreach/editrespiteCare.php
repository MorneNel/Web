<script src="media/js/closeEditPages.js"></script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/functions.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$Form = new Mela_Forms('editRespiteCare','','POST','respiteCare_form');

if (!$_REQUEST['lnkID']) die("Necessary data is missing");
if (!$_REQUEST['respCareID']) die("Necessary data is missing");

$lnkID = filter_var($_REQUEST['lnkID'], FILTER_SANITIZE_NUMBER_INT);
$respiteCareID = filter_var($_REQUEST['respCareID'], FILTER_SANITIZE_NUMBER_INT);

if ($_POST) {
    
    foreach($_POST as $k => $v) {
	$formKey[$k] = $k;
	$formVal[$k] = checkValues($v);
	//echo "<b>". $formKey[$k] ."</b> - ". $formVal[$k] ."<br />";
    }
    
    // Get the mds_ID for the care staff
    $query = "SELECT mds_ID FROM MedStaff WHERE mds_Name='".$formVal['resp-careStaff']."'";
    try { 
        $result = odbc_exec($connect,$query); 
        if($result){ 
            $careStaff = odbc_fetch_array($result);
        } 
        else { 
            throw new RuntimeException("Failed to connect."); 
        } 
    } 
    catch (RuntimeException $e) { 
        print("Exception caught: $e");
    }
    
    //echo "<br />ID is: ".$careStaff['MDS_ID'];
    
    $dateFromSQL = "";
    if (strlen($formVal['resp-dateFrom']) > 0) {
	$dateFromSQL = "DateFrom='".$formVal['resp-dateFrom']."', ";
    }
    
    $dateToSQL = "";
    if (strlen($formVal['resp-dateTo']) > 0) {
	$dateToSQL = "DateTo='".$formVal['resp-dateTo']."', ";
    }
    
    $timeFromSQL = "";
    if (strlen($formVal['resp-timeFrom']) > 0) {
	$timeFromSQL = "TimeFrom='".$formVal['resp-timeFrom']."', ";
    }
    
    $timeToSQL = "";
    if (strlen($formVal['resp-timeTo']) > 0) {
	$timeToSQL = "TimeTo='".$formVal['resp-timeTo']."', ";
    }
    
    // Need to check that the record is properly locked first of all
    if ($Mela_SQL->Exec4DSQL("SQLLock_IsLocked", $lnkID) == 1) { 
	$query = "UPDATE RespiteCare SET Location='".$formVal['resp-Location']."', Shift='".$formVal['resp-Shift']."', $dateFromSQL $dateToSQL
	$timeFromSQL $timeToSQL Comments='".$formVal['resp-Comments']."', CareStaff=".$careStaff['MDS_ID']."
	WHERE Respite_Care_ID=".$formVal['resp-CareID']." AND Link_ID=$lnkID";
	try { 
	    $result = odbc_exec($connect,$query); 
	    if($result){ 
		?>
		<script type="text/javascript">
		    CloseAndRefresh();
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

// Get relevant data to fill out form
$query = "SELECT resp.Respite_Care_ID, resp.Location, resp.Shift, resp.DateFrom, resp.DateTo, resp.TimeFrom, resp.TimeTo, resp.Comments, resp.CareStaff,
          med.mds_Name  
	  FROM RespiteCare resp
          LEFT OUTER JOIN MedStaff med ON resp.CareStaff = med.mds_ID
	  WHERE resp.Link_ID=$lnkID AND Respite_Care_ID=$respiteCareID";
try { 
    $result = odbc_exec($connect,$query); 
    if($result){ 
	$respiteData = odbc_fetch_array($result);
    } 
    else{ 
    throw new RuntimeException("Failed to connect."); 
    } 
	} 
    catch (RuntimeException $e) { 
	    print("Exception caught: $e");
    }

$hiddenLNK = $Form->hiddenField('lnk',$lnkID);
$hiddenRespCareID = $Form->hiddenField('resp-CareID', $respiteData['RESPITE_CARE_ID']);

echo $hiddenLNK;
echo $hiddenRespCareID;
?>
<table class="temp">
    <tr>
        <td>
            Location
        </td>
        <td>
            <?php
                $locationDDSQL = $Mela_SQL->tbl_LoadItems('Wards');
                $locationDDArray = array();
                for ($i = 1; $i < (count($locationDDSQL)+1); $i++) {
                    array_push($locationDDArray,$locationDDSQL[$i]['Long_Name']);
                }

                $locationDD = $Form->dropDown('resp-Location',$locationDDArray,$locationDDArray,$respiteData['LOCATION']);
                echo $locationDD;
            ?>
        </td>
        <td>
            Shift
        </td>
        <td>
            <?php
                $shiftDDSQL = $Mela_SQL->tbl_LoadItems('Respite Care Shift');
                $shiftDDArray = array();
                for ($i = 1; $i < (count($shiftDDSQL)+1); $i++) {
                    array_push($shiftDDArray,$shiftDDSQL[$i]['Long_Name']);
                }

                $shiftDD = $Form->dropDown('resp-Shift',$shiftDDArray,$shiftDDArray,$respiteData['SHIFT']);
                echo $shiftDD;
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Date from
        </td>
        <td>
            <?php		    
                $dateFrom = $Form->dateField('resp-dateFrom',stringToDateTime($respiteData['DATEFROM'],2));
                echo $dateFrom;
            ?>
        </td>
        <td>
            Date to
        </td>
        <td>
            <?php		    
                $dateTo = $Form->dateField('resp-dateTo',stringToDateTime($respiteData['DATETO'],2));
                echo $dateTo;
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Time from
        </td>
        <td>
            <?php
                $timeFrom = $Form->timeField('resp-timeFrom',convert4DTime($respiteData['TIMEFROM']));
                echo $timeFrom;
            ?>
        </td>
        <td>
            Time to
        </td>
        <td>
            <?php
                $timeTo = $Form->timeField('resp-timeTo',convert4DTime($respiteData['TIMETO']));
                echo $timeTo;
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Comments
        </td>
        <td colspan='3'>
            <?php
                $comments = $Form->textArea('resp-Comments',$respiteData['COMMENTS']);
                echo $comments;
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Care Staff
        </td>
        <td colspan='3'>
            <?php                
                $careStaffDDSQL = $Mela_SQL->getMedicalStaff(1,0,0,0,0,1);
                $careStaffDDArray = array();
                for ($i = 1; $i < (count($careStaffDDSQL)+1); $i++) {
                    array_push($careStaffDDArray,$careStaffDDSQL[$i]['mds_Name']);
                }
    
                $careStaffDD = $Form->dropDown('resp-careStaff',$careStaffDDArray,$careStaffDDArray,$respiteData['MDS_NAME']);
                echo $careStaffDD;
            ?>
        </td>
    </tr>
    <tr>
        <td colspan='2'>
            <?php
            $submitButton = $Form->submitButton('Save');
            echo $submitButton;
            ?>
        </td>
    </tr>
</table>
<?php } ?>