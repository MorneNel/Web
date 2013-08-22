<?php
include './MelaClass/db.php';

$test = $_POST;
//var_dump(json_decode($test['admResearchTags']));

$obj = get_object_vars(json_decode($test['admResearchTags']));
//var_dump($obj);

foreach($obj as $key => $value){
       $exp_key = explode('_', $key);
       if($exp_key[0] == 'adm-ResearchTag'){
	    $admResearchTags[] = $value;
            //echo "<b>$key</b> is $value<br />";
       }
 }
 
if ($admResearchTags) {
    $gluedAdmResearchTags = implode(',',$admResearchTags);
    $gluedAdmResearchTags .= ",";
    //echo $gluedAdmResearchTags;
    //echo "<br />".$obj['hiddenADMID']."";
}

$sql = "UPDATE Admission SET adm_ResearchTag='$gluedAdmResearchTags' WHERE adm_ID=".$obj['hiddenADMID']."";
try { 
      $result = odbc_exec($connect,$sql); 
    } 
    catch (RuntimeException $e) { 
       print("Exception caught: $e");
    } //echo $sql;
    
echo "<Br />";
?>