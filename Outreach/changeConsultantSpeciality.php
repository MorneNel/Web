<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';
include './MelaClass/Mela_Forms.php';

if (!$_REQUEST['consultant']) die("No consultant specified!");

$consultant = filter_var($_REQUEST['consultant'], FILTER_SANITIZE_NUMBER_INT);

$rows = array();
$query = "SELECT mds_Speciality FROM MedStaff WHERE mds_ID=$consultant AND Consultant=true AND".$Mela_SQL->sqlHUMinMax("mds_ID");
    try { 
        $result = odbc_exec($connect,$query); 
        if($result){ 
                $speciality = odbc_fetch_array($result);
        } 
        else { 
            throw new RuntimeException("Failed to connect."); 
        } 
    } 
    catch (RuntimeException $e) { 
        print("Exception caught: $e");
    }

//$Form = new Mela_Forms('consultant','formProcessAss.php','POST','save_form');
echo "<select class='FormDropDown ' id='adm-speciality' name='adm-speciality' >";

$specialityDDSQL = $Mela_SQL->tbl_LoadItems('Specialities');
$specialityDDArray = array();
for ($i = 1; $i < (count($specialityDDSQL)+1); $i++) {
    array_push($specialityDDArray,$specialityDDSQL[$i]['Long_Name']);
}

//var_dump($specialityDDArray);
foreach($specialityDDArray as $key => $val) {
    $selected = ($speciality['MDS_SPECIALITY'] == $val) ? "selected" : "";
    echo "<option value='".$val."' $selected>".$val."</option>";
}
echo "</select>";

//$consultantDD = $Form->dropDown('adm-speciality',$specialityDDArray,$specialityDDArray,$speciality['MDS_SPECIALITY']);
//echo $consultantDD;