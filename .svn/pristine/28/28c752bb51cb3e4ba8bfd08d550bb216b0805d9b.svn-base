<?php

if(isset($_POST['username'])) { $username = $_POST['username']; } else { echo 1; exit(); }
if(isset($_POST['password'])) { $password = $_POST['password']; } else { echo 1; exit(); }
//print "<h1>$username & $password</h1>";
$login = $auth->login($username, $password);

$return = array();

switch($login['code'])
{
                case 0:
                                $return['error'] = 1;
                                $return['message'] = "You are temporarily locked out of the system. Please try again in 30 minutes.";
                                break;
                case 1:
                                $return['error'] = 1;
                                $return['message'] = "Username / Password is invalid";
                                break;
                case 2:
                                $return['error'] = 1;
                                $return['message'] = "Username / Password is incorrect";
                                break;
                case 3:
                                $return['error'] = 1;
                                $return['message'] = "Account is not active";
                                break;
                case 4:
                                $return['error'] = 0;
                                $return['message'] = "Logged in successfully, please wait...";
                                $return['session_hash'] = $login['session_hash'];
                                // Clear any poss pat locks by this user (of use after a disconnect / crash)
                                //$$$$$$ 'auth_session' is not set YET so cannot work, only in loginPage.php, should be in PHP / auth
                                // include 'Mela_SQL.php';
                                // $auth->fillUserKeys($_COOKIE['auth_session']); 
                                // $Mela_SQL = new Mela_SQL($auth->UsrKeys, $connect);
                                // $Mela_SQL->SQLLock_UnlockByUser();
                                break;
                case 5:
                                $return['error'] = 1;
                                $return['message'] = "You are attempting to login with more active users than your licence allows.";
                                break;
                case 6:
                                $return['error'] = 1;
                                $return['message'] = "Username not found.";
                                break;
                case 7:
                                $return['error'] = 1;
                                $return['message'] = "Another active session for this user already exists.";
                                break;
                default:
                                $return['error'] = 1;
                                $return['message'] = "System error encountered: ".$login['code'];
                                break;
}


$return = json_encode($return);
echo $return;

