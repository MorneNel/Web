<?php

/*//$$$ Problems with relative paths $$$

//include ('inc/authInitScript.php');

// Must do manually / cannot incl authInitScipt.php, due to the path level differences (another reason to have them in 1 inc folder)
include('/../db.php');
include("../inc/class/auth.class.php");  
include('../class/Mela_SQL.php');

$auth = new cuonic\PHPAuth2\Auth;
$auth->fillUserKeys($_COOKIE['auth_session']);
$Mela_SQL = new Mela_SQL($auth->UsrKeys);
//$hash = $_COOKIE['auth_session'];

$auth->logout($_COOKIE['auth_session']);

$Mela_SQL->SQLLock_UnlockByUser();

header("Location: ../patListing.php");
exit();
*/

////////////////////////////////////////////

include 'db.php';
include 'Mela_SQL.php';
include 'auth.class.php';  
$auth = new Auth ($connect);
$auth->logout($_COOKIE['auth_session']);
$Mela_SQL = new Mela_SQL($auth->UsrKeys, $connect);

$Mela_SQL->SQLLock_UnlockByUser();

header("Location: ../patListing.php");
exit();

?>