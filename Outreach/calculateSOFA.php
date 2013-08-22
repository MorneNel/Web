<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['dlkid']) die("No DLK ID specified");

$dlkID = filter_var($_REQUEST['dlkid'], FILTER_SANITIZE_NUMBER_INT);

echo $Mela_SQL->Exec4DSQL ("SQL_SOFA_Calc", $dlkID); 