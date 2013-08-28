<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';
//include './MelaClass/Mela_SQL.php';

//if (!$_REQUEST['ID']) die("ID must be specified!");


/*
 * This script will auto-populate a specified dropdown list
 *
 * You can specify which dropdown list to populate with $_REQUEST['dd'] and
 * the ID to search by with $_REQUEST['id']
 */

if(isset($_REQUEST['id'])) {
    echo "<option value='0'></option>";

switch ($_REQUEST['dd']) {
    case "pdi-Site":
        $rows = array();
        $query = "SELECT Site_ID, Sys_ID, Description, Value FROM Site WHERE Sys_ID=".$_REQUEST['id']."";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['SITE_ID']."' data-id='".$systems['SITE_ID']."'>".$systems['DESCRIPTION']."</option>";
                        }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }    
    break;

    case "pdi-Process":
        $rows = array();
        $query = "SELECT Site_ID, Proc_ID, Description, Value FROM Process WHERE Site_ID=".$_REQUEST['id']."";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['PROC_ID']."' data-id='".$systems['PROC_ID']."'>".$systems['DESCRIPTION']."</option>";
                        }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }    
    break;

    case "pdi-Condition":
        $rows = array();
        $query = "SELECT Cond_ID, Proc_ID, Description, Value, Code FROM Condition WHERE Proc_ID=".$_REQUEST['id']."";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['COND_ID']."' data-id='".$systems['COND_ID']."'>".$systems['DESCRIPTION']."</option>";
                        }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }    
    break;

    case "sdi-Site":
        $rows = array();
        $query = "SELECT Site_ID, Sys_ID, Description, Value FROM Site WHERE Sys_ID=".$_REQUEST['id']."";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['SITE_ID']."' data-id='".$systems['SITE_ID']."'>".$systems['DESCRIPTION']."</option>";
                        }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }    
    break;

    case "sdi-Process":
        $rows = array();
        $query = "SELECT Site_ID, Proc_ID, Description, Value FROM Process WHERE Site_ID=".$_REQUEST['id']."";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['PROC_ID']."' data-id='".$systems['PROC_ID']."'>".$systems['DESCRIPTION']."</option>";
                        }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }    
    break;

    case "sdi-Condition":
        $rows = array();
        $query = "SELECT Cond_ID, Proc_ID, Description, Value, Code FROM Condition WHERE Proc_ID=".$_REQUEST['id']."";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['COND_ID']."' data-id='".$systems['COND_ID']."'>".$systems['DESCRIPTION']."</option>";
                        }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }    
    break;

    case "ass-seenByName":
    case "ass-seenByName1":
    case "ass-seenByName2":
        /*$rows = array();
        $query = "SELECT mds_ID, mds_Name, mds_Role, mds_Speciality FROM MedStaff WHERE Active=true AND Outreach_Team=true AND mds_Role='".$_REQUEST['id']."' AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['MDS_NAME']."'>".$systems['MDS_NAME']." - ".$systems['MDS_SPECIALITY']."</option>";
                        }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                    print("Exception caught: $e");
                }*/
            //$seenByNameDDSQL = $Mela_SQL->getMedicalStaff();
            $seenByNameDDSQL = array();
            $i = 0;
            $sql = "SELECT * FROM MedStaff WHERE Active = true AND mds_Role='".$_REQUEST['id']."' AND ".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
            $result = odbc_exec($connect,$sql);
                if($result){
                        while ($row = odbc_fetch_array($result,$i)) {
                            /* BREAK APART THE KEYS FROM THE VALUES */ 
                            foreach($row AS $key=>$value) {                    
                                /* ADD TO THE ARRAY */ 
                                    $seenByNameDDSQL[$i][$key]=$row[$key];                     
                            } 
                            $i++;     
                        }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                    print("Exception caught: $e");
                }
            $seenByNameDDArray = array();
            for ($i = 1; $i < (count($seenByNameDDSQL)+1); $i++) {
                array_push($seenByNameDDArray,$seenByNameDDSQL[$i]['mds_Name']);
            }
            //var_dump($seenByNameDDSQL);
            //$seenByNameDD = $Form->dropDown('ass-seenByName',$seenByNameDDArray,$seenByNameDDArray,$patient['OTR_SEENBY_NAME']);
            $seenByNameDD = "";
            if (!empty($seenByNameDDArray)) {
                foreach ($seenByNameDDArray as $key => $val) {
                    $opValue = $key;
                    $opValue = trim($opValue);
                    
                    $seenByNameDD .= "<option value='".trim($val)."'>".trim($val)."</option>";    
                }
                echo $seenByNameDD;
            }
        
    break;

    case "crit-identifiedName":
        $rows = array();
        $query = "SELECT mds_ID, mds_Name, mds_Role, mds_Speciality FROM MedStaff WHERE mds_Role='".$_REQUEST['id']."' AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['MDS_NAME']."'>".$systems['MDS_NAME']."</option>";
                        }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                    print("Exception caught: $e");
                }
    break;

    case "do-actiontaken2":
        if ($_REQUEST['specifier'] == "specialist") {
            $DOActionTaken2DDSQL = $Mela_SQL->tbl_LoadItems('Specialities');
            $DOActionTaken2DDArray = array();
            for ($i = 1; $i < (count($DOActionTaken2DDSQL)+1); $i++) {
                echo "<option value='".$DOActionTaken2DDSQL[$i]['Long_Name']."'>".$DOActionTaken2DDSQL[$i]['Long_Name']."</option>";
            }
        } elseif ($_REQUEST['specifier'] == "transfer") {
            $DOActionTaken2DDSQL = $Mela_SQL->tbl_LoadItems('Transfer Location');
            $DOActionTaken2DDArray = array();
            for ($i = 1; $i < (count($DOActionTaken2DDSQL)+1); $i++) {
                echo "<option value='".$DOActionTaken2DDSQL[$i]['Long_Name']."'>".$DOActionTaken2DDSQL[$i]['Long_Name']."</option>";
            }   
        }
    break;

    case "ass-detail":
        if ($_REQUEST['specifier']) {
            $tblID = $_REQUEST['specifier'];
            $query = "SELECT List_Name FROM Table_Lists WHERE TBL_ID=$tblID";
            try { 
                $result = odbc_exec($connect,$query); 
                if ($result) { 
                    $tableName = odbc_fetch_array($result);
                } 
                else { 
                    throw new RuntimeException("Failed to connect."); 
                } 
            } 
            catch (RuntimeException $e) { 
                print("Exception caught: $e");
            }
            
            if ($tableName) {
                $identifier = $tableName['LIST_NAME'];
                $detailDDSQL = $Mela_SQL->tbl_LoadItems($identifier);
                $detailDDArray = array();
                $selected = "";
                for ($i = 1; $i < (count($detailDDSQL)+1); $i++) {
                    if (isset($_REQUEST['defaultVal']) && $_REQUEST['defaultVal'] == preg_replace('/\s+/', '', $detailDDSQL[$i]['Long_Name'])) $selected = "selected";
                    echo "<option value='".$detailDDSQL[$i]['Long_Name']."' $selected>".$detailDDSQL[$i]['Long_Name']."</option>";
                }    
            }
        }
    break;

    // ---- Same as above 
    // case "crit-identifiedName":
    //     $rows = array();
    //     $query = "SELECT mds_ID, mds_Title, mds_FirstName, mds_Surname, mds_Role, mds_Speciality FROM MedStaff WHERE mds_Role='".$_REQUEST['id']."'";
    //         try { 
    //             $result = odbc_exec($connect,$query); 
    //             if($result){ 
    //                     while ($systems = odbc_fetch_array($result)) {
    //                         echo "<option value='".$systems['MDS_ID']."'>".$systems['MDS_TITLE']." ".$systems['MDS_FIRSTNAME']." ".$systems['MDS_SURNAME']." - ".$systems['MDS_SPECIALITY']."</option>";
    //                     }
    //             } 
    //             else{ 
    //             throw new RuntimeException("Failed to connect."); 
    //             } 
    //                 } 
    //             catch (RuntimeException $e) { 
    //                     print("Exception caught: $e");
    //                     //exit;
    //             }
    // break;
}

    
}


