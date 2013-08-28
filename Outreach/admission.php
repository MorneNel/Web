<?php
// Get OR_Call table in this page because it's only used here
$or_query ="SELECT * FROM OR_Call WHERE cal_ID=".$patient['ADM_CALID']."";
$or_result = odbc_exec($connect,$or_query);
$or_patient = odbc_fetch_array($or_result);

$adm_ID = $Form->hiddenField('adm_ID',$patient['ADM_ID']);
echo $adm_ID;

$otc_calID = $Form->hiddenField('otc_calID',$patient['ADM_CALID']);
echo $otc_calID;

//var_dump($preferences);
?>
<div class="Row1">
        <table>

            <tr><td colspan='2' class='linebreak_top'>Admission Detail</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>


            <tr>
            <td class="form_labels">Status</td>
            <td>
                <?php
                    $admStatus = $Form->textBox('adm-status',$patient['ADMSTATUS'],'',1);
                    echo $admStatus;                         
                ?>
            </td>
             </tr>

            <?php if ($preferences['prf_ShowOrigHospAdmDate'] == 'true') { ?> 
            <tr>
                <td class="form_labels">Original hospital admission</td>
                <td>
                    <?php
                        $originalHospitalAdmission = $Form->dateField('adm-originalhospitalAdmission',$patient['ADM_ORIGINALHOSPITALADMISSION']);
                        echo $originalHospitalAdmission;
                    ?>
                </td>
            </tr>            
            <?php } ?>
            <?php if ($preferences['prf_ShowHospAdmDates'] == 'true') { ?>
            <tr>
                <td class="form_labels">Hospital admission date</td>
                <td>
                    <?php
                        $hospitalAdmissionDate = $Form->dateField('adm-hospitalAdmissionDate',stringToDateTime($patient['ADM_HOSPITALADMISSION'],2));
                        echo $hospitalAdmissionDate;
                    ?>
                </td>
            </tr>
            <?php } ?>
            


            <tr>
                <td class="form_labels">
                    Referral Date
                </td>
                <td>
                    <?php
                        $admReferralDate = $Form->dateField('adm-referralDate',stringToDateTime($patient['ADM_REFERRALDATE'],2));
                        echo $admReferralDate;
                    ?>
                </td>
            </tr>
            <?php if ($appName == "Outreach") { ?>
            <?php if ($preferences['prf_ShowICUDischDetails'] == 'true') { ?>
            <tr>
                <td class="form_labels">ICU/HDU Discharge Delay</td>
                <td><input type="time" class="FormField" name="adm-ICUHDUDischargeDelay" value="<?php echo convert4DTime($patient['ADM_ICU_DISCHARGEDELAY']); ?>"></td>
            </tr>
            <tr>
                <td class="form_labels">Delay reason</td>
                <td>
                        <?php
                                $dischargeDelayDDSQL = $Mela_SQL->tbl_LoadItems('ICU/HDU Discharge Delay Reasons');
                                $dischargeDelayDDArray = array();
                                for ($i = 1; $i < (count($dischargeDelayDDSQL)+1); $i++) {
                                    array_push($dischargeDelayDDArray,$dischargeDelayDDSQL[$i]['Long_Name']);
                                }
        
                                $dischargeDelayDD = $Form->dropDown('adm-delayReason',$dischargeDelayDDArray,$dischargeDelayDDArray,$patient['ADM_ICU_DISCHARGEDELAY_REASON']);
                                echo $dischargeDelayDD;                          
                        ?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
            
        </table>
    </div>


    <div class="Row2">
        <?php if ($appName == "Outreach") { ?>
        <table>
            <tr><td colspan='2' class='linebreak_top'>Previous Critical Care Admission Details</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>

            <?php if ($preferences['prf_Show_ICU_Dates'] == 'true') { ?>    
            <tr id="ICUAdmission">
                <td class="form_labels">ICU Admission</td>
                <td>
                    <?php
                        $formDTDateClass = array('FormDTDate');
                        $admICUAdmissionDate = $Form->dateField('adm-ICUAdmission',stringToDateTime($patient['ADM_ICUADMISSION'],2),$formDTDateClass);
                        echo $admICUAdmissionDate;

                        $formDTTimeClass = array('FormDTTime');
			$admICUAdmissionTime = $Form->timeField('adm-ICUAdmissionTime',convert4DTime($patient['ADM_ICU_ADMISSION_TIME']),$formDTTimeClass);
			echo $admICUAdmissionTime;
		    ?>
                </td>
            </tr>

            <tr id="ICUDischarge">
                <td class="form_labels">ICU Discharge</td>
                <td>
                    <?php
                        $admICUDischargeDate = $Form->dateField('adm-ICUDischarge',$patient['ADM_ICU_DISCHARGE_DATE'],$formDTDateClass);
                        echo $admICUDischargeDate;

			$admICUDischargeTime = $Form->timeField('adm-ICUDischargeTime',convert4DTime($patient['ADM_ICU_DISCHARGE_TIME']),$formDTTimeClass);
			echo $admICUDischargeTime;
		    ?>
                </td>
            </tr>
            <?php } ?>
            <?php if ($appName == "Outreach") { ?>
            <?php if ($preferences['prf_Show_HDU_Dates'] == 'true') { ?>
            <tr>
                <td class="form_labels">HDU Admission</td>
                <td>
                    <!--<input type="date" class="FormDTDate" name="adm-HDUAdmission" value="<?php echo stringToDateTime($patient['ADM_HDU_ADMISSION_DATE'],2); ?>">-->
                    <?php
                        $HDUAdmissionDate = $Form->dateField('adm-HDUAdmission',stringToDateTime($patient['ADM_HDU_ADMISSION_DATE'],2),$formDTDateClass);
                        echo $HDUAdmissionDate;
                    ?>
                    <!--<input type="time" class="FormDTTime" name="adm-HDUAdmissionTime" size="4" value="<?php echo convert4DTime($patient['ADM_HDU_ADMISSION_TIME']); ?>">-->
                    <?php
			$HDUAdmissionTime = $Form->timeField('adm-HDUAdmissionTime',convert4DTime($patient['ADM_HDU_ADMISSION_TIME']),$formDTTimeClass);
			echo $HDUAdmissionTime;
		    ?>
                </td>
            </tr>

            <tr>
                <td class="form_labels">HDU Discharge</td>
                <td>
                    <!--<input type="date" class="FormDTDate" name="adm-HDUDischarge" value="<?php echo stringToDateTime($patient['ADM_HDU_DISCHARGE_DATE'],2); ?>">-->
                    <?php
                        $HDUDischargeDate = $Form->dateField('adm-HDUDischarge',stringToDateTime($patient['ADM_HDU_DISCHARGE_DATE'],2),$formDTDateClass);
                        echo $HDUDischargeDate;
                    ?>
                    <!--<input type="time" class="FormDTTime" name="adm-HDUDischargeTime" size="4" value="<?php echo convert4DTime($patient['ADM_HDU_DISCHARGE_TIME']); ?>">-->
                    <?php
			$HDUDischargeTime = $Form->timeField('adm-HDUDischargeTime',convert4DTime($patient['ADM_HDU_DISCHARGE_TIME']),$formDTTimeClass);
			echo $HDUDischargeTime;
		    ?>
                </td>
            </tr>
            <?php } ?>    

            <?php if ($preferences['CCU_Date_Time'] == 'true') { ?>
            <tr>
                <td class="form_labels">CCU Admission</td>
                <td>
                    <!--<input type="date" class="FormDTDate" name="adm-CCUAdmission" value="<?php echo stringToDateTime($patient['ADM_CCU_ADMISSION_DATE'],2); ?>">-->
                    <?php
                        $CCUAdmissionDate = $Form->dateField('adm-CCUAdmission',stringToDateTime($patient['ADM_CCU_ADMISSION_DATE'],2),$formDTDateClass);
                        echo $CCUAdmissionDate;
                    ?>
                    <!--<input type="time" class="FormDTTime" name="adm-CCUAdmissionTime" size="4" value="<?php echo convert4DTime($patient['ADM_CCU_ADMISSION_TIME']); ?>">-->
                    <?php
			$CCUAdmissionTime = $Form->timeField('adm-CCUAdmissionTime',convert4DTime($patient['ADM_CCU_ADMISSION_TIME']),$formDTTimeClass);
			echo $CCUAdmissionTime;
		    ?>
                </td>
            </tr>


            <tr>
                <td class="form_labels">CCU Discharge</td>
                <td>
                    <!--<input type="date" class="FormDTDate" name="adm-CCUDischarge" value="<?php echo stringToDateTime($patient['ADM_CCU_DISCHARGE_DATE'],2); ?>">-->
                    <?php
                        $CCUDischargeDate = $Form->dateField('adm-CCUDischarge',stringToDateTime($patient['ADM_CCU_DISCHARGE_DATE'],2),$formDTDateClass);
                        echo $CCUDischargeDate;
                    ?>
                    <!--<input type="time" class="FormDTTime" name="adm-CCUDischargeTime" size="4" value="<?php echo convert4DTime($patient['ADM_CCU_DISCHARGE_TIME']); ?>">-->
                    <?php
			$CCUDischargeTime = $Form->timeField('adm-CCUDischargeTime',convert4DTime($patient['ADM_CCU_DISCHARGE_TIME']),$formDTTimeClass);
			echo $CCUDischargeTime;
		    ?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>

        </table>
        <?php } ?>
    </div>




    <div class="caller_detail">
        <table>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
            <tr><td class='linebreak_top_call_detail'>Caller Detail</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
        </table>
    </div>


    <div class="Row1">
        <table>
        <?php if ($preferences['Show_Ref_Resp'] == 'true') { ?>
            <tr>
                <td class="form_labels">Referrer</td>
                <td>
                    <?php
                        $reffererDDSQL = $Mela_SQL->tbl_LoadItems('Referral Source');
                        $reffererDDArray = array();
                        for ($i = 1; $i < (count($reffererDDSQL)+1); $i++) {
                            array_push($reffererDDArray,$reffererDDSQL[$i]['Long_Name']);
                        }
    
                        $reffererDD = $Form->dropDown('adm-referrer',$reffererDDArray,$reffererDDArray,$or_patient['Caller']);
                        echo $reffererDD;                         
                    ?>
                </td>
            </tr>
        <?php if ($appName == "AcutePain") { ?>
            <tr>
                <td class="form_labels">Responder</td>
                <td>
                    <?php
                    // Get responder options and values from database
                    // Special case where medical staff database must be accessed and array populated with results
                    $responderFields = array();
                    $responderValues = array();
                    $responderQuery = "SELECT mds_ID, mds_Name FROM MedStaff WHERE Outreach_Team=TRUE and Active=TRUE AND".$Mela_SQL->sqlHUMinMax("mds_ID");
                    try { 
                        $responderResult = odbc_exec($connect,$responderQuery); 
                            if($responderResult){ 
                                    while ($responderpatient = odbc_fetch_array($responderResult)) {
                                        array_push($responderFields, $responderpatient['MDS_NAME']);
                                        array_push($responderValues, $responderpatient['MDS_ID']);                                                
                                    }
                            } 
                            else{ 
                            throw new RuntimeException("Failed to connect."); 
                            } 
                        } 
                        catch (RuntimeException $e) { 
                                print("Exception caught: $e");
                        }
                    $responderDD = $Form->dropDown('adm-responder',$responderFields,$responderValues,$or_patient['OR_Responder'],'');
                    echo $responderDD;
                    ?>    
                </td>                
            </tr>
        <?php } ?>
            
        <?php if ($appName == "Outreach") { ?>
            <tr>
                <td class="form_labels">OR Responder</td>
                <td>
                    <?php
                    // Get responder options and values from database
                    // Special case where medical staff database must be accessed and array populated with results
                    $responderFields = array();
                    $responderValues = array();
                    $responderQuery = "SELECT mds_ID, mds_Name FROM MedStaff WHERE Outreach_Team=TRUE and Active=TRUE AND".$Mela_SQL->sqlHUMinMax("mds_ID");
                    try { 
                        $responderResult = odbc_exec($connect,$responderQuery); 
                            if($responderResult){ 
                                    while ($responderpatient = odbc_fetch_array($responderResult)) {
                                        array_push($responderFields, $responderpatient['MDS_NAME']);
                                        array_push($responderValues, $responderpatient['MDS_ID']);                                                
                                    }
                            } 
                            else{ 
                            throw new RuntimeException("Failed to connect."); 
                            } 
                        } 
                        catch (RuntimeException $e) { 
                                print("Exception caught: $e");
                        }
                    $responderDD = $Form->dropDown('adm-responder',$responderFields,$responderValues,$or_patient['OR_Responder'],'');
                    echo $responderDD;
                    ?>    
                </td>                
            </tr>
        <?php } ?>
        <?php } ?>
        <?php if ($appName == "Outreach") { ?>
        <?php if ($preferences['score_trig'] == 'true') { ?>
            <tr>
                <td class="form_labels">Scored by ward</td>
                <td>
                    <?php
                        $scoredByWardOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $scoredByWard = $Form->radioBox('adm-scoredByWard',$scoredByWardOptions,''.$patient['ADM_SCORED'].'','');
                        print $scoredByWard;
                    ?>
                </td>
            </tr>

            <tr>
                <td class="form_labels">Triggered by ward</td>
                <td>
                    <?php
                        $triggeredByWardOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $triggeredByWard = $Form->radioBox('adm-triggeredByWard',$triggeredByWardOptions,''.$patient['ADM_TRIGGERED'].'','');
                        print $triggeredByWard;
                    ?>
                </td>
            </tr>

            <tr>
                <td class="form_labels">NEWS Score</td>
                <td>
                    <?php
                        $NEWSScore= $Form->textBox('adm-NEWS',$patient['NEWS_SCORE']);
                        echo $NEWSScore;
                        echo "<button type='button' id='admNEWSScore' data-dlkid='".$patient['DLK_ID']."' data-dlkpatid='".$patient['DLK_PATID']."' data-lnkid='".$lnkID."'>NEWS Trigger</button>";
                        //var_dump($preferences);
                    ?>
                </td>
            </tr>
        <?php } ?>
        <?php } ?>

        </table>
    </div>

    <div class="Row2">
        <table>
             <?php if (($appName == "AcutePain") AND ($preferences['prf_Time_of_Call'] == 'true')) { ?>
            <tr>
                <td class="form_labels">Time of Call</td>
                <td>
                    <?php
                        $timeofCall = $Form->timeField('adm-timeOfCall',convert4DTime($or_patient['Time_Of_Call']));
                        echo $timeofCall;
                    ?>
            </tr>            

            <tr>
                <td class="form_labels">Time of Response</td>
                <td>
                    <?php
                        $timeofResponse = $Form->timeField('adm-timeOfResponse',convert4DTime($or_patient['Time_Of_Response']));
                        echo $timeofResponse;
                    ?>
                </td>
            </tr>


            <tr>
                <td class="form_labels">Delay</td>
                <td>
                    <input type="time" class="FormTime" name="adm-delay" id="adm-delay" size="4" value='<?php echo convert4DTime($or_patient['Delay']); ?>' disabled>
                    <?php
                        $hiddenORDelayTime = $Form->hiddenField('adm-hiddenDelay',convert4DTime($or_patient['Delay']));
                        echo $hiddenORDelayTime;
                    ?>
                </td>
            </tr>
            <?php } ?>
            
            <?php if ($appName == "Outreach") { ?>
            <tr>
                <td class="form_labels"><?php echo $preferences['prf_EWSS_Name']; ?> on Referral</td>
                <td>
                    <?php
                        $myScoreOnREF = $Form->textBox('adm-myScoreOnREF',$patient['ADM_MEWS'],'',1,'MyScoreLabel');
                        echo $myScoreOnREF;
                        // Wrap this in preference
                        if ($preferences['prf_ShowInitialTrigger'] == 'true') {
                            echo "<button type='button' id='firstTrigger' data-lnkid='".$lnkID."'>First Trigger</button>";
                        }
                    ?>
                </td>
            </tr>
            
            <!--<tr>
                <td class="form_labels"><button type='button'>EWSS on ref</button></td>
                <td>
                    <?php
                        $EWSSOnREF = $Form->textBox('adm-EWSSOnREF',$patient['REFERRAL_CARELEVEL']);
                        echo $EWSSOnREF;
                    ?>
                </td>
            </tr>-->
        <?php } ?>

        </table>
    </div>


    <div class="caller_detail">
        <table>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
            <tr><td class='linebreak_top_call_detail'>Other Detail</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
        </table>
    </div>

    <div class="Row1">
        <table>

            <tr>
                <td class="form_labels">
                        <span id="IDOutreachText">
                                <?php if ($appName == "Outreach") { ?>
                                    Outreach number
                                <?php } elseif ($appName == "AcutePain") { ?>
                                    ID Number
                                <?php } ?>
                        </span>
                </td>
                <td>
                    <?php
                        $outreachNumber = $Form->textBox('adm-outreachNumber',$patient['ADM_NUMBER']);
                        echo $outreachNumber;
                    ?>
                </td>
            </tr>  

            <?php if ($preferences['Show_location'] == 'true') { ?>
            <tr>
                <td class="form_labels">Location</td>
                <td>
                        <?php
                                $wardsDDSQL = $Mela_SQL->tbl_LoadItems('Wards');
                                $wardsDDArray = array();
                                for ($i = 1; $i < (count($wardsDDSQL)+1); $i++) {
                                    array_push($wardsDDArray,$wardsDDSQL[$i]['Long_Name']);
                                }
        
                                $wardsDD = $Form->dropDown('adm-location',$wardsDDArray,$wardsDDArray,$patient['ADM_WARD']);
                                echo $wardsDD;                         
                        ?>        
                </td>
            </tr>
            <?php } ?>

                <tr>
                <td class="form_labels">Consultant</td>
                <td>
                    <?php
                    $medStaffList = array();
                    $consultantID = array();
                    $sql = "SELECT mds_ID, mds_Name, mds_Title, mds_FirstName, mds_Surname FROM MedStaff WHERE Consultant=true AND".$Mela_SQL->sqlHUMinMax("mds_ID");
                    try { 
                        $result = odbc_exec($connect,$sql); 
                            if($result){ 
                                    while ($medStaffResult = odbc_fetch_array($result)) {
                                        array_push($consultantID,$medStaffResult['MDS_ID']);
                                        $consultantRow = "".$medStaffResult['MDS_FIRSTNAME']." ".$medStaffResult['MDS_SURNAME'];
                                        array_push($medStaffList,$consultantRow);
                                    }
                            } 
                            else { 
                            throw new RuntimeException("Failed to connect."); 
                            } 
                        } 
                        catch (RuntimeException $e) { 
                                print("Exception caught: $e");
                        }

                    $consultantDD = $Form->dropDown('adm-consultant',$medStaffList,$consultantID,$patient['ADM_CONSULTANT']);
                    echo $consultantDD;
                    ?>
                </td>
                </tr>

            <?php if ($preferences['prf_ShowSource'] == 'true') { ?>
            <tr>
                <td class="form_labels">Source of admission</td>
                <td>
                        <?php
                            $admiSourceDDSQL = $Mela_SQL->tbl_LoadItems('Source Of Admission');
                            $admiSourceDDArray = array();
                            for ($i = 1; $i < (count($admiSourceDDSQL)+1); $i++) {
                                array_push($admiSourceDDArray,$admiSourceDDSQL[$i]['Long_Name']);
                            }
    
                            $admiSourceDD = $Form->dropDown('adm-sourceOfAdmission',$admiSourceDDArray,$admiSourceDDArray,$patient['ADM_HOSPITALADMISSIONSOURCE']);
                            echo $admiSourceDD;                        
                        ?>    
                </td>
            </tr>
            <?php } ?>
            
            <?php if ($appName == "Outreach" && $preferences['Show_Loc_Prior_source'] == 'true') { ?>
            <tr>
                <td class="form_labels">Location prior to source</td>
                <td>
                        <?php
                                $priorLocationDDSQL = $Mela_SQL->tbl_LoadItems('Source Of Admission');
                                $priorLocationDDArray = array();
                                for ($i = 1; $i < (count($priorLocationDDSQL)+1); $i++) {
                                    array_push($priorLocationDDArray,$priorLocationDDSQL[$i]['Long_Name']);
                                }
        
                                $priorLocationDD = $Form->dropDown('adm-locationPriorToSource',$priorLocationDDArray,$priorLocationDDArray,$patient['ADM_LP_HOSPADMSOURCE']);
                                echo $priorLocationDD;                       
                        ?>      
                </td>
            </tr>
            <?php } ?>    

            <?php if ($preferences['Show_planned_adm'] == 'true') { ?>
            <tr>
                <td class="form_labels">Planned admission</td>
                <td>
                    <?php
                        $plannedAdmissionOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $plannedAdmission = $Form->radioBox('adm-plannedAdmission',$plannedAdmissionOptions,''.$patient['ADM_PLANNEDADMISSION'].'','');
                        print $plannedAdmission;
                    ?>
                </td>
            </tr>
            <?php } ?>    
            
            <?php if ($preferences['Show_prior_surg_undrtkn'] == 'true') { ?>
            <tr>
                <td class="form_labels"><?php $customSurgery = ($preferences['CustomSurgeryName_Field']) ? $preferences['CustomSurgeryName_Field'] : "Prior surgery undertaken" ; echo $customSurgery; ?></td>
                <td>
                    <?php
                        $priorSurgeryOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $priorSurgery = $Form->radioBox('adm-priorSurgeryUndertaken',$priorSurgeryOptions,''.$patient['ADM_PRIORSURGERY'].'','');
                        print $priorSurgery;
                    // The form element below seems out of place but it makes the assessment tag modal window JSON work
                    ?>                    
                    <form id="admResearchTagsForm">
                        </form>
                </td>
            </tr>
            <?php } ?>

            <tr>
                <td class="form_labels">Research Tags</td>
                <td>
                    <button type='button' style='font-size:small;' id='adm-researchTags'>Set Tags</button>
                    <div id='adm-ResearchTagsForm' data-page='secondary' title='Set Assessment Research Tags'>                       
                        <fieldset>
                            <div class="textBox">
                                    <form id="admResearchTagsForm">
                                    <input type="hidden" name="hiddenADMID" value="<?php echo $patient['LNK_ADMID']; ?>">
                                    <?php 
                                    /* This is not pretty but it works
                                    * Fetches both short_name and long_name from Tags
                                    * to print then checks against adm_ResearchTag and
                                    * checks any matching rows
                                    */
                                   //$admResearchtags = array('admResearchTags');
                                   $researchTagsShortSQL = $Mela_SQL->tbl_LoadItems('Tags');
                                   $researchTagsShortArray = array();
                                   for ($i = 1; $i < (count($researchTagsShortSQL)+1); $i++) {
                                       array_push($researchTagsShortArray,$researchTagsShortSQL[$i]['Short_Name']);
                                   }
                                   
                                   $researchTagsLongSQL = $Mela_SQL->tbl_LoadItems('Tags');
                                   $researchTagsLongArray = array();
                                   for ($i = 1; $i < (count($researchTagsLongSQL)+1); $i++) {
                                       array_push($researchTagsLongArray,$researchTagsLongSQL[$i]['Long_Name']);
                                   }
                                   
                                   $patientTags = explode(',',$patient['ADM_RESEARCHTAG']);
                                   $patientTags = array_map('trim',$patientTags);
                                   $researchTagsFull = array_intersect($researchTagsShortArray,$patientTags);
                                   
                                   foreach ($researchTagsShortArray as $key => $val) {
                                       $checked = ($researchTagsFull[$key]) ? "checked" : "";
                                       $name = ($researchTagsLongArray[$key]) ? $researchTagsLongArray[$key] : "None";
                                       $name = str_replace('>','&gt;',$name);
                                       $name = str_replace('<','&lt;',$name);
                                       echo "<input type='checkbox' name='adm-ResearchTag_".$key."' id='adm-Tag-$key' value='".$val."' $checked><label for='adm-Tag-$key'>$name</label><br />"; 
                                   }
                                   ?>
                                    </form>
                                        
                                    <div id="admResearchTagsResults">                        
                                    </div>
                            </div>
                        </fieldset>                         
                    </div>
                </td>
            </tr>
            <?php if ($preferences['ShowHosp'] == 'true') { ?>
            <tr>
                <td class="form_labels">Hospital</td>
                <td>
                    <?php
                        $hospitalsDDSQL = $Mela_SQL->tbl_LoadItems('Hospitals');
                        $hospitalsDDArray = array();
                        for ($i = 1; $i < (count($hospitalsDDSQL)+1); $i++) {
                            array_push($hospitalsDDArray,$hospitalsDDSQL[$i]['Long_Name']);
                        }

                        $hospitalsDD = $Form->dropDown('adm-hospital',$hospitalsDDArray,$hospitalsDDArray,$patient['HOSP']);
                        echo $hospitalsDD;
                    ?> 
                </td>
            </tr>
            <?php } ?>



        </table>
    </div>

    <div class="Row2">
        <table>

            <tr>
                <td class="form_labels"></td>
                <td>&nbsp;</td>
            </tr>   
            <tr>
                <td class="form_labels"></td>
                <td>&nbsp;</td>
            </tr>          

            <tr>
                <td class="form_labels">Speciality</td>
                <td>
                    <?php                
                    $specialityDDSQL = $Mela_SQL->tbl_LoadItems('Specialities');
                    $specialityDDArray = array();
                    for ($i = 1; $i < (count($specialityDDSQL)+1); $i++) {
                        array_push($specialityDDArray,$specialityDDSQL[$i]['Long_Name']);
                    }
                    
                    if ($preferences['Speciality_Enterable'] == 'true') {
                        $specialityDD = $Form->dropDown('adm-speciality',$specialityDDArray,$specialityDDArray,$patient['SPECIALITY_ENTERED']);                    
                    } else {                        
                        $specialityDD = $Form->dropDown('adm-speciality',$specialityDDArray,$specialityDDArray,$patient['SPECIALITY_ENTERED'],'',1);                        
                    }
                    
                    echo $specialityDD;
                    ?>
                </td>
            </tr>

            <tr>
                <td class="form_labels"></td>
                <td>&nbsp;</td>
            </tr> 

            <tr>
                <td class="form_labels">
                    <?php
                        $readmissionTitle = ($appName == "Outreach") ? "OR Readmission" : "Readmission";
                        echo $readmissionTitle;
                    ?>
                </td>
                <td>
                    <?php
                        $readmissionCheckBox = $Form->checkBox('adm-readmission','adm-readmission','',$patient['ADM_READMISSON']);
                        echo $readmissionCheckBox;
                    ?>
                </td>
                </td>
            </tr> 
            <?php /*
            <?php if ($appName == "AcutePain") { ?>
            <tr>
                <td class="form_labels">Readmission</td>
                <td>
                    <?php
                        $admORChecked = ($patient['ADM_READMISSON'] == 'true') ? 'checked' : '';
                        $ORReadmission = $Form->checkBox('adm-ORReadmission','1','',$admORChecked);
                        echo $ORReadmission;
                        
                    ?>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td class="form_labels">Surgery classification</td>
                <td>
                    <?php
                    $surgeryClassificationDDSQL = $Mela_SQL->tbl_LoadItems('Surgery Classification');
                    $surgeryClassificationDDArray = array();
                    for ($i = 1; $i < (count($surgeryClassificationDDSQL)+1); $i++) {
                        array_push($surgeryClassificationDDArray,$surgeryClassificationDDSQL[$i]['Long_Name']);
                    }

                    $surgeryClassificationDD = $Form->dropDown('adm-surgeryClassification',$surgeryClassificationDDArray,$surgeryClassificationDDArray,$patient['ADM_SURGERYCLASSIFICATION']);
                    echo $surgeryClassificationDD;
                    ?>
                </td>
            </tr>
            */ ?>

            <tr class="adm-priorSurgeryHide">
                <td class="form_labels">Surgery Classification</td>
                <td>
                        <?php
                        $srgClassificationDDSQL = $Mela_SQL->tbl_LoadItems('Surgery Classification');
                        $srgClassificationDDArray = array();
                        for ($i = 1; $i < (count($srgClassificationDDSQL)+1); $i++) {
                            array_push($srgClassificationDDArray,$srgClassificationDDSQL[$i]['Long_Name']);
                        }
                    
                        $srgClassificationDD = $Form->dropDown('adm-srgClassification',$srgClassificationDDArray,$srgClassificationDDArray,$patient['ADM_SURGERYCLASSIFICATION']);
                        echo $srgClassificationDD;                           
                        ?>  
                </td>
            </tr>
            
            <!--<tr class="adm-priorSurgeryHide">
                <td class="form_labels">Operation Date</td>
                <td><input type="text" class="HiddenField"></td>
            </tr>--> 

            <tr class="adm-priorSurgeryHide">
                <td class="form_labels">ASA Score</td>
                <td>
                    <?php
                    $ASAScores = array("I", "II", "III", "IV", "V", "E", "N");
                    
                    $ASAScoreDD = $Form->dropDown('adm-ASAScoreDD',$ASAScores,$ASAScores,$patient['ASASCORE']);
                    echo $ASAScoreDD;
                    
                    $ASAScoreTextArea = $Form->textArea('adm-ASAScoreTextBox','','','','','','adm-ASAScoreTextBox');
                    echo $ASAScoreTextArea;
                    ?>
                </td>
            </tr> 

        </table>
    </div>