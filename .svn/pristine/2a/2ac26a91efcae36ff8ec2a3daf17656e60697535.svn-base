<?php

//include('/../inc/class/auth.class.php'); // not needed as this will get called before normally, complains othweriwse for re-declaration of classess

class Mela_SQL {
    
    protected $_connection;
    private $connect;
    public $fields;
    public $table;
    public $items = array();
    public $UsrKeys;
    
    /****************************************/
    function __construct(UserKeys $parUsrKeys, $connect) {
    //function __construct($parUsrKeys) {  // UserKeys type

        //include 'db.php';
        
        $this->_connection = $connect;
        unset($connect);

        $this->UsrKeys = $parUsrKeys;
    }

    /*********************************************************
    Creates a primary key.
       $PKName : key name (based on table name but may differ, see 4D)
       $IfRaw : True = raw key, False = normal
       Ret: the key
    *********************************************************/
    function GetPK ($PKName, $IfRaw)
    {
        if ($IfRaw)
            $method = 'SQL_pke_GetRawKey';
        else
            $method = 'SQL_pke_GetKey';
        $HospID = $this->UsrKeys->HospID;
        $str = $this->Exec4DSQL ($method,"'$PKName',$HospID");
        $ID = strtok ($str, chr(9));
        if ($ID === false)
            throw new RuntimeException("Failed to retrieve a PK from 4D SQL for ".$PKName);
        else
            return ($ID);
    }

    /*********************************************************
    Executes a 4D SQL stored procedure
      $procName = name of the procedure in 4D
      $paramString = list of comma delimited parameters
      Ret: tab delimited txt message, usually Code+TAB+TestMessage (flexible, depending on method)
    *********************************************************/
    function Exec4DSQL($procName, $paramString)
    {
       $query = "SELECT {fn $procName($paramString) AS Varchar} as RetVal FROM Preferences
                 WHERE prf_Hospital_ID=".$this->UsrKeys->HospID;
       try { 
            $result = odbc_exec($this->_connection,$query); 
            if($result){ 
                $arr1 = odbc_fetch_array($result);
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
        }    
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        } 
        return $arr1['RetVal'];       
    }

    
    /*********************************************************
    Generic - runs an SQL statemnt ($query) and returns an odbc result
    *********************************************************/
    function SQLExec($query)
    {    
        try 
        { 
            $result = odbc_exec($this->_connection,$query); 
            if(!$result) 
            { 
                throw new RuntimeException("Failed to execute sql."); 
            }  
        }   
        catch (RuntimeException $e) 
        { 
                print("Exception caught: $e");
        }
        return $result;
    }

    /*
     * Selects all records, columns and fields from Table_List_Items
     * in a numbered array
     * Result looks like this:
     * $containerVariable[rowNumber][fieldName]
     * @param string $tableName The name of the table to look at from Table_Lists
     */ 
    function tbl_LoadItems($tableName) {
        // Get TBL_ID from Table_Lists from table name
        $i = 1;
        $sql = "SELECT TBL_ID FROM Table_Lists WHERE lower(List_Name)=lower('$tableName') AND".$this->sqlHUMinMax("TBL_ID");
        try { 
            $result = odbc_exec($this->_connection,$sql); 
                if($result){ 
                        $table = odbc_fetch_array($result);
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }
        if (!$table) return;
                
        $sql = "SELECT * FROM Table_List_Items WHERE tbi_TBLID=".$table['TBL_ID']."";
        try { 
            $result = odbc_exec($this->_connection,$sql); 
                if($result){
                        while ($row = odbc_fetch_array($result,$i)) {
                            /* BREAK APART THE KEYS FROM THE VALUES */ 
                            foreach($row AS $key=>$value) {                    
                                /* ADD TO THE ARRAY */ 
                                    $items[$i][$key]=$row[$key];                     
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
                        //exit;
                }
    
        return $items;    
    }
    
    /*
     * Takes the name of a medical staff member
     * and returns their speciality
     * @param string $name Name of staff member ([MedStaff] mds_Name)
     * @return string The speciality of the staff member
     */
    function mds_ShowSpeciality($name) {
        $sql = "SELECT mds_Speciality FROM MedStaff WHERE mds_Name='$name' AND".$this->sqlHUMinMax("mds_ID");
        try { 
            $result = odbc_exec($this->_connection,$sql); 
                if($result){ 
                        $role = odbc_fetch_array($result);
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }    
    
        $speciality = $role['mds_Speciality'];
        return $speciality;
    }
    
    /*
     * Get all active anaesthetists, mainly for surgery dropdowns
     *
     * @param string $name Name attribute of the dropdown list
     * @param string $id Optional, ID attribute of the dropdown list. Defaults to $name
     * @param int $selected Optional, specify the value of an mds_ID field to pre-select a specific row
     * @return HTML Dropdown containing all active anaesthetists
     */
    function getAnaesthetistDropdown($name, $id = '', $selected = '') {
        if ($id == '') $id = $name;
        $output = "<select class='FormDropDown' name='$name' id='$id'>";
        $output .= "<option value=''></option>";
        $sql = "SELECT * FROM MedStaff WHERE Active=True AND Anaesthetist=True AND".$this->sqlHUMinMax("mds_ID");
        try { 
            $result = odbc_exec($this->_connection,$sql); 
                if($result){ 
                        while ($anaesthetists = odbc_fetch_array($result)) {
                            $preselect = (is_numeric($selected) && $anaesthetists['mds_ID'] == $selected) ? 'selected' : '';
                            $output .="<option value='".$anaesthetists['mds_ID']."' $preselect>".$anaesthetists['mds_Title']." ".$anaesthetists['mds_FirstName']." ".$anaesthetists['mds_Surname']."</option>";    
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
        $output .= "</select>";
        
        return $output;
    }
    
    /*
     * Get list of all medical staff by specified parameters. All parameters are optional
     * 1 = true, 0 = false
     * @param bool $active Active
     * @param bool $consultant Consultant
     * @param bool $ana Anaesthetist
     * @param bool $outreach Outreach team
     * @param bool $prescribedBy Prescribed by
     * @param bool $respiteCare Respite Care
     * @return array Array of medical staff containing specified elements
     */ 
    
    function getMedicalStaff($active = 1, $consultant = 0, $ana = 0, $outreach = 0, $prescribedBy = 0, $respiteCare = 0) {        
        $argumentQuant = func_num_args();
        $i = 0;
        
        if ($argumentQuant == 0) {
            $sql = "SELECT * FROM MedStaff WHERE Active = true AND".$this->sqlHUMinMax("mds_ID");
        } else {
                    // Build query                        
                    $wheres = array();
                    if ($active == 1) {
                        $wheres[] = 'Active = true';
                    }
                    if ($consultant == 1) {
                        $wheres[] = 'Consultant = true';
                    }
                    if ($ana == 1) {
                        $wheres[] = 'Anaesthetist = true';
                    }
                    if ($outreach == 1) {
                        $wheres[] = 'Outreach_Team = true';
                    }
                    if ($prescribedBy == 1) {
                        $wheres[] = 'mds_PrescribedBy = true';
                    }
                    if ($respiteCare == 1) {
                        $wheres[] = 'mds_RespiteCare = true';
                    }
                    
                    $where_string = implode(' AND ', $wheres);
                    $sql = "SELECT * FROM MedStaff";
                    if ($where_string) {
                        $sql .= " WHERE " . $where_string;
                    }
                    $sql .= " AND".$this->sqlHUMinMax("mds_ID");
        }

        try { 
            $result = odbc_exec($this->_connection,$sql);
                if($result){
                        while ($row = odbc_fetch_array($result,$i)) {
                            /* BREAK APART THE KEYS FROM THE VALUES */ 
                            foreach($row AS $key=>$value) {                    
                                /* ADD TO THE ARRAY */ 
                                    $staff[$i][$key]=$row[$key];                     
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
                        //exit;
                }
    
        return $staff; 
    }


    // ------- NOW integerated in Auth->getUserKeys 
    /*
     * Get app Name
     * @return string Name code, either: Outreach, AcutePain
     */
    // function getAppName() {
    //     $sql = "SELECT prf_ApplicationName FROM Preferences";
    //     try { 
    //         $result = odbc_exec($this->_connection,$sql); 
    //             if($result){ 
    //                     $app = odbc_fetch_array($result);
    //             } 
    //             else{ 
    //             throw new RuntimeException("Failed to connect."); 
    //             } 
    //                 } 
    //             catch (RuntimeException $e) { 
    //                     print("Exception caught: $e");
    //                     //exit;
    //             }
        
    //     switch ($app['PRF_APPLICATIONNAME']) {
    //         case "MedICUs Outreach":
    //             $appVersion = "Outreach";
    //         break;
        
    //         case "Pain Management Acute":
    //             $appVersion = "AcutePain";
    //         break;
        
    //         case "Acute Pain Services":
    //             $appVersion = "AcutePain";
    //         break;
        
    //         default:
    //             $appVersion = "AcutePain";
    //         break;
    //     }

    //     return $appVersion;
    // }
    
    /*
     * Get Preferences
     * Simply pulls all data from Preferences table
     * @return array An associative array of Preferences fields and values
     */
    function getPreferences() {
        $sql = "SELECT * FROM Preferences WHERE prf_Hospital_ID=".$this->UsrKeys->HospID;
        //echo $sql;
        try { 
            $result = odbc_exec($this->_connection,$sql); 
                if($result){ 
                        $preferences = odbc_fetch_array($result);
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }    

        return $preferences;    
    }
    
    /*
     * Check preference
     * Specify a preference in Preferences table and get true/false returned
     * NOT CURRENTLY WORKING
     * @param string $preference Specified preference from Preferences table to check
     * @return bool True/False
     
    function checkPreference($preference) {
        $sql = "SELECT $preference FROM Preferences";
        try { 
            $result = odbc_exec($this->_connection,$sql); 
                if($result){ 
                        $prfSQL = odbc_fetch_array($result);
                        
                        // Preference field is converted to upper case for some stupid reason
                        $upperCasePref = strtoupper($preference);
                        return $prfSQL[$upperCasePref];
                        if ($prfSQL[$upperCasePref] == 'true' || $prfSQL[$upperCasePref] == TRUE) {
                            return TRUE;
                        } else return FALSE;
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }
        return FALSE;
    }
    */
    
    /*
     * Get tabs
     *
     * Generates the tabs used to navigate between pages
     * @param array $preferences Array of preferences from Preferences table, can be value returned by getPreferences()
     * @param string $tabSection Specify which tabs to generate, choices are currently either 'Demographics' or 'Assessments'
     * @return array multi-dimensional array of tabs sorted by order and then with name and href attributes
     */
    function getTabs(array $preferences,$tabSection) {
        $tabsArray = array();
        
        switch (strtolower($tabSection)) {
            case "demographics":
                /*
                 * These tabs always appear
                 */ 
                // Demographics
                $arrDemographics = array('name' => 'Demographics', 'href' => '1');
                array_push($tabsArray,$arrDemographics);
                // Admission
                $arrAdmission = array('name' => 'Admission', 'href' => '2');
                array_push($tabsArray,$arrAdmission);
                
                /*
                 * Other tabs
                 */ 
                // Primary diagnosis
                // This doesn't appear to be the correct preference field
                //if ($preferences['prf_ShowCustomDiagnosis'] == 'true') {
                    $arrpDiagnosis = array('name' => 'Diagnosis', 'href' => '3');
                    array_push($tabsArray,$arrpDiagnosis);
                //}
                // Secondary diagnosis
                if ($preferences['prf_showSecondReason'] == 'true') {
                    $arrsDiagnosis = array('name' => 'Other Diagnosis', 'href' => '4');
                    array_push($tabsArray,$arrsDiagnosis);
                }
                // Surgery
                if ($preferences['prf_ShowSurgery'] == 'true') {
                    $tabNameSurgery = ($preferences['CustomSurgeryName_Name']) ? $preferences['CustomSurgeryName_Name'] : "Surgery";
                    $arrSurgery = array('name' => $tabNameSurgery, 'href' => '5');
                    array_push($tabsArray,$arrSurgery);
                }
                // Co-morbidity
                if ($preferences['prf_ShowComorbidity'] == 'true') {
                    $tabNameComo = ($preferences['ComorbName']) ? $preferences['ComorbName'] : "Co-Morbidity";
                    $arrComo = array('name' => $tabNameComo, 'href' => '6');
                    array_push($tabsArray,$arrComo);    
                }
                // PMH
                if ($preferences['prf_PMH'] == 'true') {
                    $arrPMH = array('name' => 'PMH', 'href' => '7');
                    array_push($tabsArray,$arrPMH);
                }
                // Assessments
                $arrAssessments = array('name' => 'Assessments', 'href' => '8');
                array_push($tabsArray,$arrAssessments);
                // Pain Assessment Tool
                $arrPAT = array('name' => 'Pain Assessment Tool', 'href' => '9');
                array_push($tabsArray,$arrPAT);
                // Modalities
                $arrModalities = array('name' => 'Modalities', 'href' => '10');
                array_push($tabsArray,$arrModalities);
                // Discharge
                if ($preferences['prf_ShowDischarge'] == 'true') {
                    $arrDischarge = array('name' => 'Discharge', 'href' => '11');
                    array_push($tabsArray,$arrDischarge);    
                }
                // Medical staff
                $arrMedicalStaff = array('name' => 'Medical Staff', 'href' => '12');
                array_push($tabsArray,$arrMedicalStaff);
            break;
        
            case "assessments":
                // Assess Details
                $arrAssessDetails = array('name' => 'Assess Details', 'href' => '1');
                array_push($tabsArray,$arrAssessDetails);
                // Pain Assessment
                $arrPainAssessment = array('name' => 'Pain Assessment', 'href' => '2');
                array_push($tabsArray,$arrPainAssessment);
                // Physical Examination
                $arrPhysicalExamination = array('name' => 'Physical Examination', 'href' => '3');
                array_push($tabsArray,$arrPhysicalExamination);
                // Medications
                $arrMedications = array('name' => 'Medications', 'href' => '4');
                array_push($tabsArray,$arrMedications);
                // Interventions
                $arrInterventions = array('name' => 'Interventions', 'href' => '5');
                array_push($tabsArray,$arrInterventions);
                // Critical Incidents
                if ($preferences['ShowCritIncidents'] == 'true') {
                    $tabCritInc = ($preferences['CritInc_Title']) ? $preferences['CritInc_Title'] : "Critical Incidents";
                    $arrCritInc = array('name' => $tabCritInc, 'href' => '6');
                    array_push($tabsArray,$arrCritInc);
                }
                // Visit Outcome
                $arrVisitOutcome = array('name' => 'Visit Outcome', 'href' => '7');
                array_push($tabsArray,$arrVisitOutcome);
                // Tasks
                $arrTasks = array('name' => 'Tasks', 'href' => '8');
                array_push($tabsArray,$arrTasks);
            break;
        
            default:
                // Error
            break;
        }
        
        return $tabsArray;
    }    


    //-------------------------------------------------------------------------------------------------------------

    /* As below but rets the full message if pat locked (unless by itself). */
    /* $LnkID = LnkID of a patient to check and try to lock
       @ret: "" if not locked before (OK, locked now), else the message
    */
    function SQLLock_CondLockMsg($LnkID)
    {
        $lockingUserID = $this->SQLLock_CondLock($LnkID);
        if (($lockingUserID != 0) && ($lockingUserID != $this->UsrKeys->UserID))
        {
            $sql = "SELECT UserName FROM Users WHERE UserID=".$lockingUserID;
            $result = odbc_exec($this->_connection, $sql);
            $row = odbc_fetch_array($result);  
            if ($row)          
                return "This patient is being edited by another user: ".$row['USERNAME'];
            else // in case errorous user ID or another reason
                return "This patient is being edited by another user: ".$lockingUserID;
        }
        return "";
    }

    /* $LnkID = LnkID of a patient to check and try to lock
       @ret: 0 if not locked before (OK, locked now), else UserID that's locking
    */
    function SQLLock_CondLock($LnkID)
    {
        return $this->Exec4DSQL ("SQLLock_CondLock", "$LnkID,".$this->UsrKeys->UserID);
    }

    /* As per 4D SQLLock_Unlock - unlocks a specifc pat */
    function SQLLock_Unlock($LnkID)
    {
        $this->Exec4DSQL ("SQLLock_Unlock", "$LnkID");
    }

    /* As per 4D SQLLock_IsLocked - checks if locked.
       To be used before saving data to prevent when users goes back to page and saves even though pat is not locked . 
       @ret:  1 = locked, 0 = not */
    function SQLLock_IsLocked($LnkID)
    {
        return $this->Exec4DSQL ("SQLLock_IsLocked", "$LnkID");
    }

    /* As per 4D SQLLock_Unlock - unlocks anything by the current user (on logout / re-login, of use after a disconnect / crash or logout from inside pat) */
    function SQLLock_UnlockByUser()
    {
        //echo $this->UsrKeys->UserID;
        $this->Exec4DSQL ("SQLLock_UnlockByUser", $this->UsrKeys->UserID);
    }

    /* As per 4D SQLLock_ClearAll - clears al locks (on server shutdown/startup) */
    function SQLLock_ClearAll()
    {
        $this->Exec4DSQL ("SQLLock_ClearAll", "");
    }

    //-------------------------------------------------------------------------------------------------------------

    /* Generates SQL 'appendix' string for WHERE, to apply min/max HospID
    @param int - PK ID to apply min/max to
    @return string - SQL
    */
    public function sqlHUMinMax($PKStr)
    {
        return " (".$PKStr.">=".$this->UsrKeys->HUMin." AND ".$PKStr."<=".$this->UsrKeys->HUMax.")";
    }

}