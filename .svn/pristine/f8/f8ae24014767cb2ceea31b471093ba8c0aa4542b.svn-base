<?php
// Get OR_Call table in this page because it's only used here
$or_query ="SELECT * FROM OR_Call WHERE cal_ID=".$patient['ADM_CALID']."";
$or_result = odbc_exec($connect,$or_query);
$or_patient = odbc_fetch_array($or_result);
?>
<td>



    <!--<table class="temp" cellpadding="5">-->
    <table>
        <tr>
            <td>Status</td>
            <td>
                <select class="FormDropDown" name="adm-status">
                    <?php
                    // Get admission status options and values from database
                    $admissionStatusQuery = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145109123";
                    try { 
                        $admissionStatusResult = odbc_exec($connect,$admissionStatusQuery); 
                            if($admissionStatusResult){ 
                                    while ($admissionStatuspatient = odbc_fetch_array($admissionStatusResult)) {
                                            if ($patient['ADMSTATUS'] == $admissionStatuspatient['LONG_NAME']) {
                                                print '<option value="'.$admissionStatuspatient['LONG_NAME'].'" selected>'.$admissionStatuspatient['LONG_NAME'].'</option>';    
                                            } else {
                                                print '<option value="'.$admissionStatuspatient['LONG_NAME'].'">'.$admissionStatuspatient['LONG_NAME'].'</option>';
                                            }
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
                    ?>
                </select>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Original hospital admission</td>
            <td><input type="datetime-local" class="FormDate" name="adm-originalhospitalAdmission" value="<?php echo stringToDateTime($patient['ADM_ORIGINALHOSPITALADMISSION']); ?>"></td>
            <td>ICU Admission</td>
            <td><input type="date" class="FormDTDate" name="adm-ICUAdmission" value="<?php echo $patient['ADM_ICUADMISSION']; ?>"> <input type="text" class="FormDTTime" name="ICUAdmissionTime" size="4" value="<?php echo $patient['ADM_ICU_ADMISSION_TIME']; ?>"></td>
        </tr>
        <tr>
            <td>Hospital admission date</td>
            <td><input type="datetime-local" class="FormDate" name="adm-hospitalAdmissionDate" value="<?php echo stringToDateTime($patient['ADM_HOSPITALADMISSION']); ?>"></td>
            <td>ICU Discharge</td>
            <td><input type="date" class="FormDate" name="adm-ICUDischarge" value="<?php echo $patient['ADM_ICU_DISCHARGE_DATE']; ?>"> <input type="text" class="FormField" name="ICUDischargeTime" size="4"  value="<?php echo $patient['ADM_ICU_DISCHARGE_TIME']; ?>"></td>
        </tr>
        <tr>
            <td>Referral Date</td>
            <td><input type="datetime-local" class="FormDate" name="adm-referralDate" value="<?php echo stringToDateTime($patient['ADM_REFERRALDATE']); ?>"></td>
            <td>HDU Admission</td>
            <td><input type="date" class="FormDate" name="adm-HDUAdmission" value="<?php echo $patient['ADM_HDU_ADMISSION_DATE']; ?>"> <input type="text" class="FormField" name="HDUAdmissionTime" size="4" value="<?php echo $patient['ADM_HDU_ADMISSION_TIME']; ?>"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>HDU Discharge</td>
            <td><input type="date" class="FormDate" name="adm-HDUDischarge" value="<?php echo $patient['ADM_HDU_DISCHARGE_DATE']; ?>"> <input type="text" class="FormField" name="HDUDischargeTime" size="4" value="<?php echo $patient['ADM_HDU_DISCHARGE_TIME']; ?>"></td>
        </tr>
        <tr>
            <td>ICU/HDU Discharge Delay</td>
            <td><input type="datetime-local" class="FormField" name="adm-ICUHDUDischargeDelay" value="<?php echo stringToDateTime($patient['ADM_ICU_DISCHARGE_DELAY']); ?>"></td>
            <td>CCU Admission</td>
            <td><input type="date" class="FormDate" name="adm-CCUAdmission" value="<?php echo $patient['ADM_CCU_ADMISSION_DATE']; ?>"> <input type="text" class="FormField" name="CCUAdmission" size="4" value="<?php echo $patient['ADM_CCU_ADMISSION_TIME']; ?>"></td>
        </tr>
        <tr>
            <td>Delay reason</td>
            <td>
                <select form="FormDropDown" name="adm-delayReason">
                    <?php
                    // Get discharge delay options and values from database
                    $dischargeDelayQuery = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145100092";
                    try { 
                        $dischargeDelayResult = odbc_exec($connect,$dischargeDelayQuery); 
                            if($dischargeDelayResult){ 
                                    while ($dischargeDelaypatient = odbc_fetch_array($dischargeDelayResult)) {
                                            if ($patient['ADM_ICU_DISCHARGEDELAY_REASON'] == $dischargeDelaypatient['LONG_NAME']) {
                                                print '<option value="'.$dischargeDelaypatient['LONG_NAME'].'" selected>'.$dischargeDelaypatient['LONG_NAME'].'</option>';    
                                            } else {
                                                print '<option value="'.$dischargeDelaypatient['LONG_NAME'].'">'.$dischargeDelaypatient['LONG_NAME'].'</option>';
                                            }
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
                    ?>
                </select>
            </td>
            <td>CCU Disharge</td>
            <td><input type="date" class="FormDate" name="adm-CCUDischarge" value="<?php echo $patient['ADM_CCU_DISCHARGE_DATE']; ?>"> <input type="text" class="FormField" name="CCUDischarge" size="4" value="<?php echo $patient['ADM_CCU_DISCHARGE_TIME']; ?>"></td>
        </tr>
    </table>
    <!--<fieldset style="width:100%;">
        <legend>
            Call Details
        </legend>-->

        <table class="temp" cellpadding="5">
            <tr><tr colspan='2' class='linebreak_top'>This is my break</td></tr>
            <tr>
                <td>>Referrer</td>
                <td>
                    <select class="FormDropDown" name="adm-referrer">
                        <?php
                        // Get referrer options and values from database
                        $referrerQuery = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145100018";
                        try { 
                            $referrerResult = odbc_exec($connect,$referrerQuery); 
                                if($referrerResult){ 
                                        while ($referrerpatient = odbc_fetch_array($referrerResult)) {
                                                if ($or_patientpatient['CALLER'] == $referrerpatient['LONG_NAME']) {
                                                    print '<option value="'.$referrerpatient['LONG_NAME'].'" selected>'.$referrerpatient['LONG_NAME'].'</option>';    
                                                } else {
                                                    print '<option value="'.$referrerpatient['LONG_NAME'].'">'.$referrerpatient['LONG_NAME'].'</option>';
                                                }
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
                        ?>
                    </select>
                </td>
                <td>Time of Call</td>
                <td><input type="time" class="FormField" name="adm-timeOfCall" size="4" value="".stringToDateTime($or_patient['Time_Of_Call'],3).""></td>
            </tr>
            <tr>
                <td>OR Responder</td>
                <td>
                    <select class="FormDropDown" name="adm-responder">
                        <?php
                        // Get responder options and values from database
                        // Special case where medical staff database must be accessed and array populated with results
                        $responderQuery = "SELECT mds_ID, mds_Name FROM MedStaff WHERE Outreach_Team=TRUE and Active=TRUE";
                        try { 
                            $responderResult = odbc_exec($connect,$responderQuery); 
                                if($responderResult){ 
                                        while ($responderpatient = odbc_fetch_array($responderResult)) {
                                                    print '<option value="'.$responderpatient['MDS_IS'].'">'.$responderpatient['MDS_NAME'].'</option>';                                                
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
                        ?>    
                    </select> 
                </td>
                <td>Time of Response</td>
                <td><input type="time" class="FormField" name="adm-timeOfResponse" size="4" value="".stringToDateTime($or_patient['Time_Of_Response'],3).""></td>
            </tr>
            <tr>
                <td>Scored by ward</td>
                <td><input type="radio" class="RadioTic" name="adm-scoredByWard" value="1">Yes <input type="radio" class="RadioTic" name="scoredByWard" value="2">No</td>
                <td>Delay</td>
                <td><input type="time" class="FormField" name="adm-delay" size="4" disabled></td>
            </tr>
            <tr>
                <td>Triggered by ward</td>
                <td>
                    <?php
                    // Convert triggered by ward into selected value
                    switch ($_POST['adm_Triggered']) {
                    case "Yes":
                        $triggeredByWardOptionOneSelected = "checked=checked";
                        $triggeredByWardOptionTwoSelected = "";
                    break;
                
                    default:
                        $triggeredByWardOptionOneSelected = "";
                        $triggeredByWardOptionTwoSelected = "checked=checked";
                    break;
                    }
                    ?>
                    <input type="radio" class="RadioTic" name="adm-triggeredByWard" value="1" <?php echo $triggeredByWardOptionOneSelected; ?>>Yes <input type="radio" class="RadioTic" name="triggeredByWard" value="2" <?php echo $triggeredByWardOptionTwoSelected; ?>>No
                </td>
                <td>My score on REF</td>
                <td><input type="text" class="FormField" name="adm-myScoreOnREF"></td>
            </tr>
        </table>
  <!--  </fieldset>-->
    <table class="temp" cellpadding="5">
        <tr>
            <td>Outreach number</td>
            <td><input type="text" class="FormField" name="adm-outreachNumber" value="<?php echo $patient['ADM_NUMBER']; ?>"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Location</td>
            <td>
                <select class="FormDropDown" name="adm-location">
                    <?php
                        // Get wards options and values from database
                        $wardsQuery = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145100002";
                        try { 
                            $wardsResult = odbc_exec($connect,$wardsQuery); 
                                if($wardsResult){ 
                                        while ($wardspatient = odbc_fetch_array($wardsResult)) {
                                                if ($patient['ADM_WARD'] == $wardspatient['LONG_NAME']) {
                                                    print '<option value="'.$wardspatient['LONG_NAME'].'" selected>'.$wardspatient['LONG_NAME'].'</option>';    
                                                } else {
                                                    print '<option value="'.$wardspatient['LONG_NAME'].'">'.$wardspatient['LONG_NAME'].'</option>';
                                                }
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
                    ?>        
                </select>
            </td>
        </tr>
        <tr>
            <td>Consultant</td>
            <td>
                <select class="FormDropDown" name="adm-consultant">
                        
                </select>
            </td>
            <td>Speciality</td>
            <td>
                <select class="FormDropDown" name="adm-speciality">
                    <?php
                    // Get speciality options and values from database
                    $specialityQuery = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145100028";
                    try { 
                        $specialityResult = odbc_exec($connect,$specialityQuery); 
                            if($specialityResult){ 
                                    while ($specialitypatient = odbc_fetch_array($specialityResult)) {
                                            if ($patient['ADMSTATUS'] == $specialitypatient['LONG_NAME']) {
                                                print '<option value="'.$specialitypatient['LONG_NAME'].'" selected>'.$specialitypatient['LONG_NAME'].'</option>';    
                                            } else {
                                                print '<option value="'.$specialitypatient['LONG_NAME'].'">'.$specialitypatient['LONG_NAME'].'</option>';
                                            }
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
                    ?>        
                </select>
            </td>
        </tr>
        <tr>
            <td>Source of admission</td>
            <td>
                <select class="FormDropDown" name="adm-sourceOfAdmission">
                    <?php
                        // Get admission source options and values from database
                        $admissionSourceQuery = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145100015";
                        try { 
                            $admissionSourceResult = odbc_exec($connect,$admissionSourceQuery); 
                                if($admissionSourceResult){ 
                                        while ($admissionSourcepatient = odbc_fetch_array($admissionSourceResult)) {
                                                if ($patient['ADM_HOSPITALADMISSIONSOURCE'] == $admissionSourcepatient['LONG_NAME']) {
                                                    print '<option value="'.$admissionSourcepatient['LONG_NAME'].'" selected>'.$admissionSourcepatient['LONG_NAME'].'</option>';    
                                                } else {
                                                    print '<option value="'.$admissionSourcepatient['LONG_NAME'].'">'.$admissionSourcepatient['LONG_NAME'].'</option>';
                                                }
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
                    ?>    
                </select>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Location prior to source</td>
            <td>
                <select class="FormDropDown" name="adm-locationPriorToSource">
                    <?php
                        // Get prior source location and values from database
                        $priorSourceLocationQuery = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145100021";
                        try { 
                            $priorSourceLocationResult = odbc_exec($connect,$priorSourceLocationQuery); 
                                if($priorSourceLocationResult){ 
                                        while ($priorSourceLocationpatient = odbc_fetch_array($priorSourceLocationResult)) {
                                                if ($patient['ADM_LP_HOSPADMSOURCE'] == $priorSourceLocationpatient['LONG_NAME']) {
                                                    print '<option value="'.$priorSourceLocationpatient['LONG_NAME'].'" selected>'.$priorSourceLocationpatient['LONG_NAME'].'</option>';    
                                                } else {
                                                    print '<option value="'.$priorSourceLocationpatient['LONG_NAME'].'">'.$priorSourceLocationpatient['LONG_NAME'].'</option>';
                                                }
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
                    ?>      
                </select>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Planned admission</td>
            <td><input type="checkbox" class="RadioTic plannedAdmission" name="adm-plannedAdmission">Yes &nbsp; <input type="checkbox" class="RadioTic plannedAdmission" name="plannedAdmission">No</td>
            <td>OR readmission</td>
            <td><input type="checkbox" class="RadioTic" name="adm-ORReaddmission"></td>
        </tr>
        <tr>
            <td>Prior surgery undertaken</td>
            <td><input type="checkbox" class="RadioTic" name="adm-priorSurgeryUndertaken">Yes &nbsp; <input type="checkbox" class="RadioTic" name="priorSurgeryUndertaken">No</td>
            <td>Surgery classification</td>
            <td>
                <select class="FormDropDown" name="adm-surgeryClassification">
                    <?php
                        // Get surgery classification and values from database
                        $surgeryClassificationQuery = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145103121";
                        try { 
                            $surgeryClassificationResult = odbc_exec($connect,$surgeryClassificationQuery); 
                                if($surgeryClassificationResult){ 
                                        while ($surgeryClassificationpatient = odbc_fetch_array($surgeryClassificationResult)) {
                                                if ($patient['ADM_SURGERYCLASSIFICATION'] == $surgeryClassificationpatient['LONG_NAME']) {
                                                    print '<option value="'.$surgeryClassificationpatient['LONG_NAME'].'" selected>'.$surgeryClassificationpatient['LONG_NAME'].'</option>';    
                                                } else {
                                                    print '<option value="'.$surgeryClassificationpatient['LONG_NAME'].'">'.$surgeryClassificationpatient['LONG_NAME'].'</option>';
                                                }
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
                    ?>     
                </select>
            </td>
        </tr>
        <tr>
            <td>Research Tag</td>
            <td><input type="text" id="researchTags" name="adm-researchTags" style="width:150px" value=""/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Hospital</td>
            <td>
                <select class="FormDropDown" name="adm-hospital">
                    <?php
                        // Get Hospital and values from database
                        $hospitalQuery = "SELECT Short_Name, Long_Name FROM Table_List_Items WHERE tbi_TBLID=145100044";
                        try { 
                            $hospitalResult = odbc_exec($connect,$hospitalQuery); 
                                if($hospitalResult){ 
                                        while ($hospitalpatient = odbc_fetch_array($hospitalResult)) {
                                                if ($patient['HOSP'] == $hospitalpatient['LONG_NAME']) {
                                                    print '<option value="'.$hospitalpatient['LONG_NAME'].'" selected>'.$hospitalpatient['LONG_NAME'].'</option>';    
                                                } else {
                                                    print '<option value="'.$hospitalpatient['LONG_NAME'].'">'.$hospitalpatient['LONG_NAME'].'</option>';
                                                }
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
                    ?>     
                </select>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
</td>
