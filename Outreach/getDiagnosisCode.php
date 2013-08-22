<?php
include './MelaClass/db.php';

if(isset($_REQUEST['procID']) && isset($_REQUEST['description'])) {
    $id = filter_var($_REQUEST['procID'], FILTER_SANITIZE_NUMBER_INT);
    $description = filter_var($_REQUEST['description'], FILTER_SANITIZE_STRING);

$query = "SELECT Code, Cond_ID FROM Condition WHERE Cond_ID=$id AND Description='".$description."'";
    try { 
        $result = odbc_exec($connect,$query); 
        if($result){ 
                while ($systems = odbc_fetch_array($result)) {
                    echo $systems['CODE'];
                }
        } 
        else{ 
        throw new RuntimeException("Failed to connect."); 
        } 
            } 
        catch (RuntimeException $e) { 
                print("Exception caught: $e");
        }   
}