<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['field'] || !$_REQUEST['val'] || !$_REQUEST['ascoreid']) die("Missing field name and/or value");

$field = filter_var($_REQUEST['field'], FILTER_SANITIZE_STRING);
$val = (is_numeric($_REQUEST['val'])) ? filter_var($_REQUEST['val'], FILTER_SANITIZE_NUMBER_INT) : filter_var($_REQUEST['val'], FILTER_SANITIZE_STRING);
$aScoreID = filter_var($_REQUEST['ascoreid'], FILTER_SANITIZE_NUMBER_INT);

$fieldQuery = (is_numeric($val)) ? "$field=$val" : "$field='$val'";

$query = "UPDATE Admission_Score SET $fieldQuery WHERE AScore_ID=$aScoreID";
    try { 
        $result = odbc_exec($connect,$query); //echo $query;
        if ($result) {
            echo 1;
        } 
        else { 
            throw new RuntimeException("Failed to connect."); 
        } 
    } 
    catch (RuntimeException $e) { 
        print("Exception caught: $e");
    }