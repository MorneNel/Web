<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

// Capture hospital number value sent by jQuery
$hospNum = filter_var($_REQUEST['hospNum'], FILTER_SANITIZE_STRING);
$HospID = $auth->UsrKeys->HospID;
echo $Mela_SQL->Exec4DSQL ("SQL_lnk_Add_Record", "$HospID,'Admitted','$hospNum',''"); 
// Above for JQUery - echo LnkID + TAB + Optional Message of just addedd rec (LnkID=0 means not added)

