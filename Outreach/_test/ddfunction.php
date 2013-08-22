<?php
//include('db.php');
include('functions.php');

$names = array(1 => 'Bill', 2 => 'Bob',3 => 'Bert',4 => 'Biff');

generateDropdown($names,'ID', 145100009, 1);

/*$names = array(1 => 'Bill', 2 => 'Bob',3 => 'Bert',4 => 'Biff');
$formname = "names";

$ddlist = dropDown($names,$formname);

echo $ddlist;*/

/*
for ($i = 0; $i < count($names); $i++) {
            $fieldnames .= $names[$i].", ";
        }
        
        //$query = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145109142";
        $fieldnames2 = rtrim($fieldnames,', ');
        echo $fieldnames2;
*/
?>