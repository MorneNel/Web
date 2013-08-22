<script src="media/js/jquery-1.10.0.min.js"></script>
<script>
    function addRespiteRow(lnkID, respCareID, dateFrom, dateTo, shift, staffName) 
    {
	var tr = $('<tr data-lnkid=' + lnkID + ' data-respcareid=' + respCareID + '>'
		    + '<td data-lnkid=' + lnkID + ' data-respcareid=' + respCareID + '>' + dateFrom + '</td>' 
		    + '<td data-lnkid=' + lnkID + ' data-respcareid=' + respCareID + '>' + dateTo + '</td>'
		    + '<td data-lnkid=' + lnkID + ' data-respcareid=' + respCareID + '>' + shift + '</td>'
		    + '<td data-lnkid=' + lnkID + ' data-respcareid=' + respCareID + '>' + staffName + '</td>'
		    + '<td id="Button_cell"><button id="' + respCareID + '" type="button" class="deleteRow" data-page="respiteCare"><img src="Media/img/bin.gif" alt="Delete"/></button></td>'
		    + '</tr>');
	
	window.opener.$('#respiteCare > tbody:last').one().append(tr);
	self.close();
    }
</script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/functions.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$Form = new Mela_Forms('addRespiteCare','','POST','respiteCare_form');

if (!$_REQUEST['lnkID']) die("Necessary data is missing");

$lnkID = filter_var($_REQUEST['lnkID'], FILTER_SANITIZE_NUMBER_INT);

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
	$dateFromSQL = "'".$formVal['resp-dateFrom']."', ";
    }
    
    $dateToSQL = "";
    if (strlen($formVal['resp-dateTo']) > 0) {
	$dateToSQL = "'".$formVal['resp-dateTo']."', ";
    }
    
    $timeFromSQL = "";
    if (strlen($formVal['resp-timeFrom']) > 0) {
	$timeFromSQL = "'".$formVal['resp-timeFrom']."', ";
    }
    
    $timeToSQL = "";
    if (strlen($formVal['resp-timeTo']) > 0) {
	$timeToSQL = "'".$formVal['resp-timeTo']."', ";
    }    
    
    $query = "INSERT INTO RespiteCare
	      (Link_ID, Location, Shift, DateFrom, DateTo, TimeFrom, TimeTo, Comments, CareStaff)
	      VALUES
	      ($lnkID, '".$formVal['resp-Location']."', '".$formVal['resp-Shift']."',  $dateFromSQL $dateToSQL $timeFromSQL $timeToSQL '".$formVal['resp-Comments']."', ".$careStaff['MDS_ID'].")";
    try { 
	$result = odbc_exec($connect,$query);
	if($result){ 
	    // Query was inserted successfully so get Respite_Care_ID of it and med staff name to pass to addRespiteRow
	    $sql = "SELECT resp.Respite_Care_ID, med.mds_Name
		    FROM RespiteCare resp
		    LEFT OUTER JOIN MedStaff med ON resp.CareStaff = med.mds_ID
		    WHERE Link_ID=$lnkID
		    ORDER BY Respite_Care_ID DESC
		    LIMIT 1";
	    try { 
		$result = odbc_exec($connect,$sql); 
		if($result){ 
		    $newRespiteRow = odbc_fetch_array($result);
		} 
		else { 
		    throw new RuntimeException("Failed to connect."); 
		} 
	    } 
	    catch (RuntimeException $e) { 
		print("Exception caught: $e");
	    }
	    
	    print "<div style='display: none;' id='respiteRowData' data-lnkid='$lnkID' data-respitecareid='".$newRespiteRow['RESPITE_CARE_ID']."' data-datefrom='".$formVal['resp-dateFrom']."' data-dateto='".$formVal['resp-dateTo']."' data-shift='".$formVal['resp-Shift']."' data-staff='".$newRespiteRow['MDS_NAME']."'></div>";
	    ?>
            <script type="text/javascript">
		// Get hidden DIV with all relevant data 
		$(document).ready(function() {		    
		    var data = $("#respiteRowData").data();
		    //console.debug(data);
		    addRespiteRow(data['lnkid'], data['respitecareid'], data['datefrom'], data['dateto'], data['shift'], data['staff']);
		});
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

$hiddenLNK = $Form->hiddenField('lnk',$lnkID);
echo $hiddenLNK;
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

                $locationDD = $Form->dropDown('resp-Location',$locationDDArray,$locationDDArray);
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

                $shiftDD = $Form->dropDown('resp-Shift',$shiftDDArray,$shiftDDArray);
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
                $dateFrom = $Form->dateField('resp-dateFrom','',2);
                echo $dateFrom;
            ?>
        </td>
        <td>
            Date to
        </td>
        <td>
            <?php		    
                $dateTo = $Form->dateField('resp-dateTo');
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
                $timeFrom = $Form->timeField('resp-timeFrom');
                echo $timeFrom;
            ?>
        </td>
        <td>
            Time to
        </td>
        <td>
            <?php
                $timeTo = $Form->timeField('resp-timeTo');
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
                $comments = $Form->textArea('resp-Comments');
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
    
                $careStaffDD = $Form->dropDown('resp-careStaff',$careStaffDDArray,$careStaffDDArray);
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