<?php

/*
 * Get Follow up
 *
 * This is for the detail dropdown list which changes depending on assessment reason
 *
 * Basic code is:
 * $_REQUEST['followup'] = [Table_List_Items]Long_Name get [Table_List_Items]SubList_ID
 * [Table_List_Items]SubList_ID = [Table_Lists]TBL_ID
 */

include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['followup']) die("No page specified"); 

$followUp = filter_var($_REQUEST['followup'], FILTER_SANITIZE_STRING);
// Remove any underscores it may have and replace with whitespace
$followUp = str_replace('_',' ',$followUp);

$query = "SELECT Sublist_ID FROM Table_List_Items WHERE Long_Name='$followUp'";
    try { 
        $result = odbc_exec($connect,$query); 
        if ($result) { 
            $TBLID = odbc_fetch_array($result);
            echo $TBLID['SUBLIST_ID'];
        } 
        else { 
            throw new RuntimeException("Failed to connect."); 
        } 
    } 
    catch (RuntimeException $e) { 
        print("Exception caught: $e");
    }