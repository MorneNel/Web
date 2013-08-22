<?php
include('./MelaClass/db.php');
include('./MelaClass/authInitScript.php');

if (!$_REQUEST['dlkID']) die("No page specified!");

$DLKID = filter_var($_REQUEST['dlkID'], FILTER_SANITIZE_NUMBER_INT);

echo @$Mela_SQL->Exec4DSQL(SQL_dlk_DelRec,$DLKID);
    /*try {
        Exec4DSQL(SQL_dlk_DelRec,$DLKID);
        $result = odbc_exec($connect,$query); 
        if(!$result) { 
            throw new RuntimeException("Failed to connect."); 
        } 
    } 
    catch (RuntimeException $e) { 
        print("Exception caught: $e");
    }*/
