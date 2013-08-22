<?php
include './MelaClass/db.php';

$test = $_POST;
var_dump($_POST);
var_dump(json_decode($test['result']));

$obj = get_object_vars(json_decode($test['result']));
var_dump($obj);
/*
foreach($obj as $key => $value){
       $exp_key = explode('_', $key);
       if($exp_key[0] == 'adm-ResearchTag'){
	    $admResearchTags[] = $value;
            echo "<b>$key</b> is $value<br />";
       }
 }
 
if ($admResearchTags) {
    $gluedAdmResearchTags = implode(',',$admResearchTags);
    $gluedAdmResearchTags .= ",";
    echo $gluedAdmResearchTags;
    echo "<br />".$obj['hiddenADMID']."";
}*/

/*
 * Late on Friday and I wrote an update statement when I meant to write an insert statement. Refactor Monday
 * RD_Number, RD_Defibrillator_shock
 *$sql = "UPDATE Resus_detail SET RD_Time='".$obj['int-Event']."', RD_Rhythm='".$obj['int-Rhythm']."', RD_Adrenaline='".$obj['int-Adrenaline']."', RD_Drugs='".$obj['int-Drugs']."', RD_Fluids='".$obj['int-Fluids']."',
 	  RD_Route='".$obj['int-Route']."', RD_Number='', RD_Defibrillator_type='".$obj['int-Defibrillator']."', RD_Defibrillator_shock='', RD_Cardio='".$obj['int-Cardiovascular']."',
 	  RD_Respiratory='".$obj['int-Respiratory']."', RD_Neurological='".$obj['int-Neurological']."', RD_Airway='".$obj['int-Airway']."'
	  WHERE Lnk_ID=".$obj['hiddenIntLNKID']."";*/
$sql = "INSERT INTO Resus_detail (Lnk_ID, RD_Time, RD_Rhythm, RD_Adrenaline, RD_Drugs, RD_Fluids, RD_Route,
				  RD_Defibrillator_type, RD_Cardio, RD_Respiratory, RD_Neurological, RD_Airway)
				  VALUES
				  (".$obj['hiddenIntLNKID'].",'".$obj['int-Time']."','".$obj['int-Rhythm']."', '".$obj['int-Adrenaline']."', '".$obj['int-Drugs']."',
				  '".$obj['int-Fluids']."','".$obj['int-Route']."','".$obj['int-Defibrillator']."','".$obj['int-Cardiovascular']."',
				  '".$obj['int-Respiratory']."','".$obj['int-Neurological']."','".$obj['int-Airway']."')";
try { 
      $result = odbc_exec($connect,$sql); 
    } 
    catch (RuntimeException $e) { 
       print("Exception caught: $e");
    } echo $sql;
    
//echo 1;
?>