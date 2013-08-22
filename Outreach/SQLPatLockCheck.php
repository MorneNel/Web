<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['lnkID']) die("No ID specified");
//if (!$_REQUEST['user']) die("No user specified");

$lnkID = filter_var($_REQUEST['lnkID'], FILTER_SANITIZE_NUMBER_INT);
//$user = filter_var($_REQUEST['user'], FILTER_SANITIZE_NUMBER_INT);

//echo $Mela_SQL->Exec4DSQL("SQLLock_CondLock", "$lnkID, $user");
echo $Mela_SQL->SQLLock_CondLockMsg($lnkID);