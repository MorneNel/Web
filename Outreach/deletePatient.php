<?php
include('./MelaClass/db.php');
include('./MelaClass/authInitScript.php');

if (!$_REQUEST['lnkID']) die("No lnk ID specified!");
$lnkID = filter_var($_REQUEST['lnkID'], FILTER_SANITIZE_NUMBER_INT);

if ($Mela_SQL->Exec4DSQL("SQL_lnk_DelRec", "$lnkID")) {
    return 1;
} else return false;