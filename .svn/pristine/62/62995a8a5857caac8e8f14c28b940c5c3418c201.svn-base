<?php

//$dbh = @new PDO("mysql:dbname=authexample;host=localhost", "root", "");
//$dbh = odbc_connect('DRIVER={4D v11 ODBC Driver};SSL=false;SERVER='.$host.';PORT='.$port.';UID='.$user.';PWD='.$pass.'',"","");
//$auth = new cuonic\PHPAuth2\Auth($dbh);


//#########TST
//include 'loginAction.php';

//echo "action.php: ".getcwd();

include 'db.php';
include 'functions.php';
include 'auth.class.php';
$auth = new Auth ($connect);

//--- NOT set here, pointless check anyway as not set 
// if(isset($_COOKIE['auth_session']))
// {
// 	$hash = $_COOKIE['auth_session'];

// 	if($auth->checkSession($hash))
// 	{
// 		$loggedin = 1;
// 	}
// 	else
// 	{
// 		$loggedin = 0;
// 	}
// }
// else
// {
// 	$loggedin = 0;
// }

if(isset($_GET['a']))
{
	$action = strtolower($_GET['a']);
	
	switch($action)
	{
		case 'login':
			//if($loggedin == 1) { exit(); }
			include 'loginAction.php';
			break;

		// $$$ To be used or not ?
		case 'register':
			if($loggedin == 1) { exit(); }
			//include("actions/register.php");
			break;
		case 'activate':
			if($loggedin == 1) { exit(); }
			//include("actions/activate.php");
			break;
		case 'reset1':
			if($loggedin == 1) { exit(); }
			//include("actions/reset1.php");
			break;
		case 'reset2':
			if($loggedin == 1) { exit(); }
			//include("actions/reset2.php");
			break;
		case 'reset3':
			if($loggedin == 1) { exit(); }
			//include("actions/reset3.php");
			break;
		case 'activation-resend':
			if($loggedin == 1) { exit(); }
			//include("actions/activation-resend.php");
			break;
		case 'change-password':
			if($loggedin == 0) { exit(); }
			//include("actions/change-password.php");
			break;
		case 'change-email':
			if($loggedin == 0) { exit(); }
			//include("actions/change-email.php");
			break;

		default:
			exit();
	}
}
else
{
	exit();
}