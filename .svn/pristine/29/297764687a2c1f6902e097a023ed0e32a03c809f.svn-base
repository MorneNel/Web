<?php
include './MelaClass/db.php';

$test = $_POST;
//var_dump($test);
//var_dump(json_decode($test['admResearchTags']));

$obj = get_object_vars(json_decode($test['assTags']));
//var_dump($obj);

foreach($obj as $key => $value){
       $exp_key = explode('_', $key);
       if($exp_key[0] == 'ass-Tag'){
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

$sql = "UPDATE Outreach SET ResearchTag='$gluedAdmResearchTags' WHERE otr_ID=".$obj['hiddenOTRID']."";
try { 
      $result = odbc_exec($connect,$sql); 
    } 
    catch (RuntimeException $e) { 
       print("Exception caught: $e");
    } //echo $sql;
    
echo "<Br />Tags saved";
?>