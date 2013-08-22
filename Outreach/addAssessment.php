<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

// Capture and sanitise values sent by jQuery
//$hospID = filter_var($_REQUEST['hospID'], FILTER_SANITIZE_NUMBER_INT);
$hospID = $auth->UsrKeys->HospID;
$lnkID = filter_var($_REQUEST['lnkID'], FILTER_SANITIZE_NUMBER_INT);
//$currentDateTime = date('d-m-Y H:i:s');
$correctDateForm = date("d-m-Y", strtotime($_REQUEST['date']));
$dateTime = $correctDateForm." ".$_REQUEST['time'];

// Add ass, default medications (subject to prefs, no worry here) and return string as per below
$ret = $Mela_SQL->Exec4DSQL ("SQL_dlk_CreateDaily", "$hospID,$lnkID,'$dateTime'");
$AssID = strtok ($ret, chr(9));
if ($AssID > 100) // any meaninfgul AssID (note: above strtok can also return False, etc, hence numerical comparison better)
{
	$Mela_SQL->Exec4DSQL ("SQL_dlk_CondDfltMedis", "$hospID,$AssID");
}
echo $ret;  // for JQUery - echo AssID + TAB + Optional Message of just addedd rec (AssID=0 means not added)

