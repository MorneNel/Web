<?php
include('./MelaClass/db.php');
include('./MelaClass/Mela_Forms.php');
include('./MelaClass/authInitScript.php');
//$Form = new Mela_Forms('patDmg','formProcess.php','POST','save_form');
$rowID = filter_var($_REQUEST['id'],FILTER_SANITIZE_NUMBER_INT);
// Get arrays necessary for the dose/units/frequency etc dropdown menus
$medUnitsDDSQL = $Mela_SQL->tbl_LoadItems('Dose Units');
$medUnitsDDArray = array();
for ($i = 1; $i < (count($medUnitsDDSQL)+1); $i++) {
    array_push($medUnitsDDArray,$medUnitsDDSQL[$i]['Long_Name']);
}
//$medUnitsDD = $Form->dropDown('med1',$medUnitsDDArray,$medUnitsDDArray,'','physiologyDropDown');
//echo $medUnitsDD;
echo "<select id='med-doseUnits[$rowID]' name='med-doseUnits[$rowID]'>";
foreach ($medUnitsDDArray as $key => $val) {      
    echo "<option value='".trim($val)."' id='med-doseUnits[$rowID]' name='med-doseUnits[$rowID]'>".trim($val)."</option>";    
}
echo "</select>";
echo "|";

$medFrequencyDDSQL = $Mela_SQL->tbl_LoadItems('Frequency');
$medFrequencyDDArray = array();
for ($i = 1; $i < (count($medFrequencyDDSQL)+1); $i++) {
    array_push($medFrequencyDDArray,$medFrequencyDDSQL[$i]['Long_Name']);
}
//$medFrequencyDD = $Form->dropDown('med2',$medFrequencyDDArray,$medFrequencyDDArray,'','physiologyDropDown');
//echo $medFrequencyDD;
echo "<select id='med-Frequency[$rowID]' name='med-Frequency[$rowID]'>";
foreach ($medFrequencyDDArray as $key => $val) {        
    echo "<option value='".trim($val)."' id='med-Frequency[$rowID]' name='med-Frequency[$rowID]'>".trim($val)."</option>";    
}
echo "</select>";
echo "|";

$medRouteDDSQL = $Mela_SQL->tbl_LoadItems('Route');
$medRouteDDArray = array();
for ($i = 1; $i < (count($medRouteDDSQL)+1); $i++) {
    array_push($medRouteDDArray,$medRouteDDSQL[$i]['Long_Name']);
}
//$medRouteDD = $Form->dropDown('med3',$medRouteDDArray,$medRouteDDArray,'','physiologyDropDown');
//echo $medRouteDD;
echo "<select id='med-Route[$rowID]' name='med-Route[$rowID]'>";
foreach ($medRouteDDArray as $key => $val) {        
    echo "<option value='".trim($val)."' id='med-Route[$rowID]' name='med-Route[$rowID]'>".trim($val)."</option>";    
}
echo "</select>";
echo "|";

$medOutcomeDDSQL = $Mela_SQL->tbl_LoadItems('Medicine Outcome');
$medOutcomeDDArray = array();
for ($i = 1; $i < (count($medOutcomeDDSQL)+1); $i++) {
    array_push($medOutcomeDDArray,$medOutcomeDDSQL[$i]['Long_Name']);
}
//$medOutcomeDD = $Form->dropDown('med4',$medOutcomeDDArray,$medOutcomeDDArray,'','physiologyDropDown');
//echo $medOutcomeDD;
echo "<select id='med-Outcome[$rowID]' name='med-Outcome[$rowID]'>";
foreach ($medOutcomeDDArray as $key => $val) {        
    echo "<option value='".trim($val)."' id='med-Outcome[$rowID]' name='med-Outcome[$rowID]'>".trim($val)."</option>";    
}
echo "</select>";
echo "|";
?>