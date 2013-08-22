<?php
include('./MelaClass/db.php');
include('./MelaClass/authInitScript.php');

if (!$_REQUEST['lnk_ID'] || !$_REQUEST['ICD_ID']) die("Missing vital parameters");

$lnk_ID = filter_var($_REQUEST['lnk_ID'], FILTER_SANITIZE_NUMBER_INT);
$ICD10_ID = filter_var($_REQUEST['ICD_ID'], FILTER_SANITIZE_NUMBER_INT);

$query = "DELETE FROM PatICD10 WHERE Link_ID=$lnk_ID AND ICD10_ID=$ICD10_ID";
    try { 
            $result = odbc_exec($connect,$query); 
            if($result) {
              echo 1;
            } else {
              throw new RuntimeException("Failed to connect."); 
            } 
    } 
    catch (RuntimeException $e) { 
        print("Exception caught: $e");
    }