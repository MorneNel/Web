<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['dd']) die("No dropdown list specified");

switch ($_REQUEST['dd']) {
    case "pdi-System":
        $rows = array();
        $query = "SELECT Sys_ID, Description, Value FROM System";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['SYS_ID']."'>".$systems['DESCRIPTION']."</option>";
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

    case "pdi-Site":
        $rows = array();
        $query = "SELECT Site_ID, Description, Value FROM Site";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['SITE_ID']."'>".$systems['DESCRIPTION']."</option>";
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
        $query = "SELECT Site_ID, Proc_ID, Description, Value FROM Process WHERE".$Mela_SQL->sqlHUMinMax("Proc_ID");
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['PROC_ID']."'>".$systems['DESCRIPTION']."</option>";
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
        $query = "SELECT Cond_ID, Proc_ID, Description, Value, Code FROM Condition WHERE".$Mela_SQL->sqlHUMinMax("Cond_ID");
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['COND_ID']."'>".$systems['DESCRIPTION']."</option>";
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

    case "sdi-System":
        $rows = array();
        $query = "SELECT Sys_ID, Description, Value FROM System WHERE".$Mela_SQL->sqlHUMinMax("Sys_ID");
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['SYS_ID']."'>".$systems['DESCRIPTION']."</option>";
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
        $query = "SELECT Site_ID, Description, Value FROM Site WHERE".$Mela_SQL->sqlHUMinMax("Site_ID");
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['SITE_ID']."'>".$systems['DESCRIPTION']."</option>";
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
        $query = "SELECT Site_ID, Proc_ID, Description, Value FROM Process WHERE".$Mela_SQL->sqlHUMinMax("Proc_ID");
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['PROC_ID']."'>".$systems['DESCRIPTION']."</option>";
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
        $query = "SELECT Cond_ID, Proc_ID, Description, Value, Code FROM Condition WHERE".$Mela_SQL->sqlHUMinMax("Cond_ID");
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($systems = odbc_fetch_array($result)) {
                            echo "<option value='".$systems['COND_ID']."'>".$systems['DESCRIPTION']."</option>";
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
}