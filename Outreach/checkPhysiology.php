<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['dlkid']) die("No Daily Link ID specified");
if (!$_REQUEST['code']) die("No field code specified");
if (!$_REQUEST['type']) die("No field type specified");
if (!$_REQUEST['value']) die("No physiology value specified");
if (!$_REQUEST['label']) die("No field label specified");

$dlkID = filter_var($_REQUEST['dlkid'], FILTER_SANITIZE_NUMBER_INT);
$code = filter_var($_REQUEST['code'], FILTER_SANITIZE_STRING);
$type = filter_var($_REQUEST['type'], FILTER_SANITIZE_STRING);
$value = $_REQUEST['value'];//filter_var($_REQUEST['value'], FILTER_SANITIZE_NUMBER_FLOAT); // Thought FLOAT sanitisation would be fine but it removes periods for some reason
$label = filter_var($_REQUEST['label'], FILTER_SANITIZE_STRING);

echo $Mela_SQL->Exec4DSQL("SQL_PhysioValid", "$dlkID,'$code','$type',$value,'$label'"); 