<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['lnkid']) die("No ID specified");

$lnkID = filter_var($_REQUEST['lnkid'], FILTER_SANITIZE_NUMBER_INT);

echo $Mela_SQL->Exec4DSQL("SQL_AdmSco_CondAdd", $lnkID); 