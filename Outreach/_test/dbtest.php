<?php
include('db.php');
include('Class/Mela_SQL.php');
if ($connect)
{ 

    $Mela_SQL = new Mela_SQL();

    //$query="SELECT {fn SQL_lnk_Add_Record(145,'Admitted','abc123','') AS Numeric} as C1 FROM Preferences";
    //$result = $Mela_SQL->SQLExec($query);
    //$ID = odbc_fetch_array($result)['C1'];

    /*$query="SELECT {fn SQL_dlk_CreateDaily(145,145100378,'2013-05-31 07:45') AS Numeric} as C1 FROM Preferences";
    $result = $Mela_SQL->SQLExec($query);
    $ID = odbc_fetch_array($result)['C1'];    
    echo $ID;*/

$HospID = 145;
$hospNum = "abc876";
$Mela_SQL = new Mela_SQL();
$result = $Mela_SQL->SQLExec("SELECT {fn SQL_lnk_Add_Record($HospID,'Admitted','$hospNum','') AS Numeric} as LnkID FROM Preferences");
$arr1 = odbc_fetch_array($result);
echo $arr1['LnkID'];  // for JQUery - echo LnkID of just addedd rec (0 if error, later to replace with text messages as returned by 4D...)



/*  //--------------------------------------
    try 
    { 
         $result = odbc_exec($connect,$query); 
         if(!$result) 
         { 
            throw new RuntimeException("Failed to connect."); 
         } 
    } 
    catch (RuntimeException $e) 
    { 
            print("Exception caught: $e");
    }

    //--------------------------------------
    $arr1 = odbc_fetch_array($result);
    echo $arr1['C1'];
*/
    //echo "done";
}

//echo __DIR__;
//echo __DIR__ . 'db.php';
?>