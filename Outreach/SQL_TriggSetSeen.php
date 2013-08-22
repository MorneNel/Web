<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['lnkid']) die("No ID specified");
if (!$_REQUEST['user']) die("No user specified");

$ID = filter_var($_REQUEST['lnkid'], FILTER_SANITIZE_NUMBER_INT);
$user = filter_var($_REQUEST['user'], FILTER_SANITIZE_STRING);

echo $Mela_SQL->Exec4DSQL("SQL_TriggSetSeen", "$ID, '$user'"); 