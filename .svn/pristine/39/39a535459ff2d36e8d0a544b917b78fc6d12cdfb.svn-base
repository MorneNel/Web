<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['lnkID']) die("No ID specified");

$lnkID = filter_var($_REQUEST['lnkID'], FILTER_SANITIZE_NUMBER_INT);

echo $Mela_SQL->Exec4DSQL("SQLLock_Unlock", $lnkID); 