<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['page']) die("No page specified");
if (!$_REQUEST['id']) die("No ID specified");
if (!$_REQUEST['user']) die("No user specified");

$page = filter_var($_REQUEST['page'], FILTER_SANITIZE_STRING);
$ID = filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
$user = filter_var($_REQUEST['user'], FILTER_SANITIZE_STRING);

if ($page != "PHYS" && $page != "ADM") die("Unrecognised page value");

echo $Mela_SQL->Exec4DSQL("SQL_NEWS_Calc", "'$page', $ID, '$user'"); 