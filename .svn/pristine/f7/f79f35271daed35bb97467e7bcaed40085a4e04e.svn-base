<?php
error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/functions.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

//$Form = new Mela_Forms('deleteInterventions','','POST','interventions_form');

// Check if any post data has been submitted (specifically Resus_Detail_ID for record deletion)
if ($_REQUEST['rowID']) {
    $rowID = filter_var($_REQUEST['rowID'], FILTER_SANITIZE_NUMBER_INT);
    // Check such a row exists for the current patient
    $sql = "SELECT Lnk_ID FROM Resus_detail WHERE Resus_Detail_ID=$rowID";
    try { 
	$result = odbc_exec($connect,$sql); 
	if($result){ 
	    $row = odbc_fetch_array($result);
	} 
	else { 
	    throw new RuntimeException("Failed to connect."); 
	} 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    } //echo $sql;
    
    if ($row) {
	// Row exists, so delete row
	$query = "DELETE FROM Resus_detail WHERE Resus_Detail_ID=$rowID AND Lnk_ID=".$row['LNK_ID']."";
        try { 
            $result = odbc_exec($connect,$query); 
	    if(!$result) { 
		throw new RuntimeException("Failed to connect."); 
            } 
	} 
	catch (RuntimeException $e) { 
	    print("Exception caught: $e");
	}
    }
}
?>
<hr />
<table class="temp">
    <thead>
	<tr>
	    <th>
		Event
	    </th>
	    <th>
		Time
	    </th>
	    <th>
		Rhythm
	    </th>
	    <th>
		Adrenaline
	    </th>
	    <th>
		DC Shock
	    </th>
	    <th>
		Type
	    </th>
	    <th>
		Drugs
	    </th>
	    <th>
		Fluids
	    </th>
	    <th>
		Route
	    </th>
	    <th>
		Cardiovascular
	    </th>
	    <th>
		Respiratory
	    </th>
	    <th>
		Neurological
	    </th>
	    <th>
		Airway
	    </th>
	</tr>
    </thead>
    <tbody>
        <?php
            $query = "SELECT RD_Time, RD_Rhythm, RD_Adrenaline, RD_Drugs, RD_Fluids, RD_Route,
	    RD_Number, RD_Defibrillator_type, RD_Defibrillator_shock, RD_Cardio, RD_Respiratory,
	    RD_Neurological, RD_Airway, Resus_Detail_ID, Lnk_ID
            FROM Resus_detail
            WHERE Lnk_ID=145100355";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result) { 
		    while ($existingRows = odbc_fetch_array($result)) {
			//$hiddenResusDetailID = $Form->hiddenField('hiddenResusDetailID',$existingRows['RESUS_DETAIL_ID']);
			$intID = $existingRows['RESUS_DETAIL_ID'];
			print "<tr>
				<td>
				    ".$hiddenResusDetailID."    
				</td>
				<td>
				    ".$existingRows['RD_TIME']."    
				</td>
				<td>
				    ".$existingRows['RD_RHYTHM']."    
				</td>
				<td>
				    ".$existingRows['RD_ADRENALINE']."    
				</td>
				<td>
				    ---    
				</td>
				<td>
				    ".$existingRows['RD_DEFIBRILLATOR_TYPE']."    
				</td>
				<td>
				    ".$existingRows['RD_DRUGS']."    
				</td>
				<td>
				    ".$existingRows['RD_FLUIDS']."    
				</td>
				<td>
				    ".$existingRows['RD_ROUTE']."    
				</td>
				<td>
				    ".$existingRows['RD_CARDIO']."    
				</td>
				<td>
				    ".$existingRows['RD_RESPIRATORY']."    
				</td>
				<td>
				    ".$existingRows['RD_NEUROLOGICAL']."    
				</td>
				<td>
				    ".$existingRows['RD_AIRWAY']."    
				</td>
				<td>
				    <!--<button type='submit' class='deleteintRow' data-icdid='".$intID."' data-lnk='".$existingRows['LNK_ID']."' id='".$intID."'>
					Remove
				    </button>-->
				    <a href='?rowID=$intID'>Remove</a>
				</td>
			       </tr>";
		    }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                }	
	?>
    </tbody>
</table>