<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['dlkpatid']) die("No DLK ID specified");
if (!$_REQUEST['field']) die("No field specified");
if (!$_REQUEST['value']) die("No value specified");

$dlkPatID = filter_var($_REQUEST['dlkpatid'], FILTER_SANITIZE_NUMBER_INT);
$field = filter_var($_REQUEST['field'], FILTER_SANITIZE_STRING);
$value = filter_var($_REQUEST['value'], FILTER_SANITIZE_NUMBER_INT);

switch($field) {
    case "sofa-pao2";
        $query = "UPDATE PhyAssess_AtTime SET pat_PaO2=$value WHERE pat_ID=$dlkPatID";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo 1;
            } 
            else { 
                throw new RuntimeException("Failed to connect."); 
            } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
    break;

    case "sofa-fio2";
        $query = "UPDATE PhyAssess_AtTime SET pat_FIO2=$value WHERE pat_ID=$dlkPatID";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo 1;
            } 
            else { 
                throw new RuntimeException("Failed to connect."); 
            } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
    break;

    case "sofa-systolicBP";
        $query = "UPDATE PhyAssess_AtTime SET pat_Systolic_BP=$value WHERE pat_ID=$dlkPatID";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo 1;
            } 
            else { 
                throw new RuntimeException("Failed to connect."); 
            } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
    break;

    case "sofa-diastolicBP";
        $query = "UPDATE PhyAssess_AtTime SET pat_Diastolic_BP=$value WHERE pat_ID=$dlkPatID";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo 1;
            } 
            else { 
                throw new RuntimeException("Failed to connect."); 
            } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
    break;

    case "sofa-creatinine";
        $query = "UPDATE PhyAssess_AtTime SET pat_Serum_Creatinine=$value WHERE pat_ID=$dlkPatID";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo 1;
            } 
            else { 
                throw new RuntimeException("Failed to connect."); 
            } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
    break;

    case "sofa-platelet";
        $query = "UPDATE PhyAssess_AtTime SET pat_Platelet=$value WHERE pat_ID=$dlkPatID";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo 1;
            } 
            else { 
                throw new RuntimeException("Failed to connect."); 
            } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        } //echo $query;
    break;

    case "sofa-bilirubin";
        $query = "UPDATE PhyAssess_AtTime SET pat_Serum_Bilirubin=$value WHERE pat_ID=$dlkPatID";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo 1;
            } 
            else { 
                throw new RuntimeException("Failed to connect."); 
            } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
    break;

    default:
        /* Should not update a field value if it doesn't match a case above as they
         * are hard-coded in so something's fishy if the value doesn't match a case above
         */
        return false;
    break;
}