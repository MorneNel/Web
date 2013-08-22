<?php

//$root = $_SERVER['DOCUMENT_ROOT'].'/Web Folder/';
//include $root.'MelaClass/functions.php'; <- would be already declared
//include getProgFolder().'config.php';  // get the right config for the right program

//echo "db.php: ".__DIR__;

//--- FAILS from loginAction.php --- include './config.php'; 
//include 'C:\xampp\htdocs\Web Folder - NEW\Outreach\config.php'; // ############################################ 

include __DIR__.'\..\config.php'; 
$connect = odbc_connect('DRIVER={4D v12 ODBC Driver};SSL=false;SERVER='.$host.';PORT='.$port.';UID='.$user.';PWD='.$pass.'',"","");
//echo var_dump($connect);

if (odbc_error($connect)) {
    echo odbc_errormsg($connect);
}


?>