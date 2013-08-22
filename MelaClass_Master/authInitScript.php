<?php

/*
Script to be executed at the beginning of each form / action.
Creates objects: Auth, Mela_SQL, preferences, appName.
Checks if the user is logged-in and if not, goes to the login page
*/

include 'auth.class.php';
include 'Mela_SQL.php';
//include 'db.php'; <- would already be done before (here was behaving funny in some cases...)

global $auth;
global $Mela_SQL;
global $preferences;
global $appName;

$auth = new Auth ($connect); 

$loggedin = $auth->isLoggedIn($_COOKIE['auth_session']);
if ($loggedin == FALSE) {
	include 'loginPage.php';
	exit;
} else {
	$auth->updateSessionExpiry($_COOKIE['auth_session']);
	$auth->fillUserKeys($_COOKIE['auth_session']);
}

$Mela_SQL = new Mela_SQL($auth->UsrKeys, $connect);

$preferences = $Mela_SQL->getPreferences();
$appName = $auth->UsrKeys->AppName; // $Mela_SQL->getAppName();
$HospID = $auth->UsrKeys->HospID;
//var_dump($preferences);
?>