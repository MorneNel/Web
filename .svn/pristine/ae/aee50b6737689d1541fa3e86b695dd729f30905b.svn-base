<table class="temp">
    <tr>
        <td>
            <fieldset>
                <legend>
                    Prior to arrest - MEWS
                </legend>
                <table class="temp">
                    <tr>
                        <td>
                            Documented
                        </td>
                        <td>
                            <?php
                                $resDocumentedRadioArray = array('Yes' => ' Yes ', 'No' => ' No ');
                                $resDocumentedRadio = $Form->radioBox('res-Documented',$resDocumentedRadioArray,$patient['MEWS_NotDocumented'],'');
                                echo $resDocumentedRadio; 
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            MEWS Score
                        </td>
                        <td>
                            <?php
                                $resMEWSScore = $Form->textBox('res-MEWSScore',$patient['MEWSPRIORARREST']);
                                echo $resMEWSScore;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Date
                        </td>
                        <td>
                            <?php
                                $resDate = $Form->dateField('res-Date',stringToDateTime($patient['MEWS_DATE'],2));
                                echo $resDate;
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Time
                        </td>
                        <td>
                            <?php
                                $resTime = $Form->timeField('res-Time',convert4DTime($patient['MEWS_TIME']));
                                $resTimeNotDoc = $Form->checkBox('res-TimeNotDoc','res-TimeNotDoc','Not documented',$patient['MEWS_SEENBY_NOTDOC']);
                                echo $resTime;
                                echo $resTimeNotDoc;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Triggered in past 12h
                        </td>
                        <td>
                            <?php
                                $resTriggeredPast12HArray = array('Yes' => ' Yes ', 'No' => ' No ');
                                $resTriggeredPast12H = $Form->radioBox('res-TriggeredPast12H',$resTriggeredPast12HArray,$patient['TriggPast12H'],'');
                                echo $resTriggeredPast12H; 
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Reviewed by outreach
                        </td>
                        <td>
                            <?php
                                $rsReviewedOutreachDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation reviewed by outreach');
                                $rsReviewedOutreachDDArray = array();
                                for ($i = 1; $i < (count($rsReviewedOutreachDDSQL)+1); $i++) {
                                    array_push($rsReviewedOutreachDDArray,$rsReviewedOutreachDDSQL[$i]['Long_Name']);
                                }
                    
                                $rsReviewedOutreachDD = $Form->dropDown('res-ReviewedByOutreach',$rsReviewedOutreachArray,$rsReviewedOutreachDDArray,$patient['ReviewByORPriorArrest']);
                                echo $rsReviewedOutreachDD;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Concerned about care
                        </td>
                        <td>
                            <?php
                                $resConcernedAboutCareArray = array('Yes' => ' Yes ', 'No' => ' No ');
                                $resConcernedAboutCare = $Form->radioBox('res-ConcernedAboutCare',$resConcernedAboutCareArray,$patient['PriorArrestCareConcernYN'],'');
                                echo $resConcernedAboutCare; 
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Concern details
                        </td>
                        <td>
                            <?php
                                $rsConcernDetailsDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation concerns about pre-arrest care');
                                $rsConcernDetailsDDArray = array();
                                for ($i = 1; $i < (count($rsConcernDetailsDDSQL)+1); $i++) {
                                    array_push($rsConcernDetailsDDArray,$rsConcernDetailsDDSQL[$i]['Long_Name']);
                                }
                    
                                $rsConcernDetailsDD = $Form->dropDown('res-ConcernDetails',$rsConcernDetailsArray,$rsConcernDetailsDDArray,$patient['PriorArrestCareConcerns']);
                                echo $rsConcernDetailsDD;
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Seen by Consultant/SpR
                        </td>
                        <td>
                            <?php
                                $resSeenByConsultantArray = array('Yes' => ' Yes ', 'No' => ' No ');
                                $resSeenByConsultant = $Form->radioBox('res-SeenByConsultant',$resSeenByConsultantArray,$patient['MEWS_SEENBY'],'');
                                echo $resSeenByConsultant; 
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Date
                        </td>
                        <td>
                            <?php
                                $resDate2 = $Form->dateField('res-Date2',stringToDateTime($patient['MEWS_SEENBY_DATE'],2));
                                echo $resDate2;
                                echo "<input type=text value='Day of Week'>";
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Time
                        </td>
                        <td>
                            <?php
                                $resTime2 = $Form->timeField('res-Time2',convert4DTime($patient['MEWS_SEENBY_TIME']));
                                $resTimeNotDoc2 = $Form->checkBox('res-TimeNotDoc2','res-TimeNotDoc2','Not documented',$patient['MEWS_SEENBY_NOTDOC']);
                                echo $resTime2;
                                echo $resTimeNotDoc2;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Action 1
                        </td>
                        <td>
                            <?php
                                $rsAction1DDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Action');
                                $rsAction1DDArray = array();
                                for ($i = 1; $i < (count($rsAction1DDSQL)+1); $i++) {
                                    array_push($rsAction1DDArray,$rsAction1DDSQL[$i]['Long_Name']);
                                }
                    
                                $rsAction1DD = $Form->dropDown('res-Action1',$rsAction1Array,$rsAction1DDArray,$patient['MEWS_ACTION1']);
                                echo $rsAction1DD;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Action 2
                        </td>
                        <td>
                            <?php
                                $rsAction2DDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Action');
                                $rsAction2DDArray = array();
                                for ($i = 1; $i < (count($rsAction2DDSQL)+1); $i++) {
                                    array_push($rsAction2DDArray,$rsAction2DDSQL[$i]['Long_Name']);
                                }
                    
                                $rsAction2DD = $Form->dropDown('res-Action2',$rsAction2Array,$rsAction2DDArray,$patient['MEWS_ACTION2']);
                                echo $rsAction2DD;
                            ?> 
                        </td>
                    </tr>
                </table>
            </fieldset>
        </td>
        <td rowspan='2'>
            <table class="temp">
                <tr>
                    <td>
                        Temperature
                    </td>
                    <td>
                        <?php
                            $resTemperature = $Form->textBox('res-Temperature',$patient['TEMP']);
                            echo $resTemperature;
                        ?>    
                    </td>
                </tr>
                <tr>
                    <td>
                        Heart rate
                    </td>
                    <td>
                        <?php
                            $resHR = $Form->textBox('res-HR',$patient['HR']);
                            echo $resHR;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Respiratory rate
                    </td>
                    <td>
                        <?php
                            $resRespiratoryRate = $Form->textBox('res-RespiratoryRate',$patient['RR']);
                            echo $resRespiratoryRate;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Systolic BP
                    </td>
                    <td>
                        <?php
                            $resSystolicBP = $Form->textBox('res-SystolicBP',$patient['SYSTOLICBP']);
                            echo $resSystolicBP;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Diastolic BP
                    </td>
                    <td>
                        <?php
                            $resDiastolicBP = $Form->textBox('res-DiastolicBP',$patient['DIASTOLICBP']);
                            echo $resDiastolicBP;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Capillary Refill Time
                    </td>
                    <td>
                        <?php
                            $resCapillaryRefillTime = $Form->textBox('res-CapillaryRefillTime',$patient['CAPREFILLTIME']);
                            echo $resCapillaryRefillTime;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Oxygen
                    </td>
                    <td>
                        <?php
                            $resOxygen = $Form->textBox('res-Oxygen',$patient['O2']);
                            echo $resOxygen;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Oxygen Saturation
                    </td>
                    <td>
                        <?php
                            $resOxygenSaturation = $Form->textBox('res-OxygenSaturation',$patient['O2SAT']);
                            echo $resOxygenSaturation;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Potassium
                    </td>
                    <td>
                        <?php
                            $resPotassium = $Form->textBox('res-Potassium',$patient['POTASSIUM']);
                            echo $resPotassium;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        PaO2
                    </td>
                    <td>
                        <?php
                            $resPaO2 = $Form->textBox('res-PaO2',$patient['PAO2']);
                            echo $resPaO2;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        PaCO2
                    </td>
                    <td>
                        <?php
                            $resPaCO2 = $Form->textBox('res-PaCO2',$patient['PACO2']);
                            echo $resPaCO2;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Blood sugar
                    </td>
                    <td>
                        <?php
                            $resBloodSugar = $Form->textBox('res-BloodSugar',$patient['BLOODSUGAR']);
                            echo $resBloodSugar;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Base Excess
                    </td>
                    <td>
                        <?php
                            $resBaseExcess = $Form->textBox('res-BaseExcess',$patient['BASEEXCESS']);
                            echo $resBaseExcess;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Bicarbonate
                    </td>
                    <td>
                        <?php
                            $resBicarbonate = $Form->textBox('res-Bicarbonate',$patient['BICARB']);
                            echo $resBicarbonate;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Lactate
                    </td>
                    <td>
                        <?php
                            $resLactate = $Form->textBox('res-Lactate',$patient['LACTATE']);
                            echo $resLactate;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        SaO2
                    </td>
                    <td>
                        <?php
                            $resSaO2 = $Form->textBox('res-SaO2',$patient['SAO2']);
                            echo $resSaO2;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Pupils
                    </td>
                    <td>
                        <?php
                            $resPupilsLDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Pupils');
                            $resPupilsLDDArray = array();
                            for ($i = 1; $i < (count($resPupilsLDDSQL)+1); $i++) {
                                array_push($resPupilsLDDArray,$resPupilsLDDSQL[$i]['Long_Name']);
                            }
                
                            $resPupilsLDD = $Form->dropDown('res-PupilsL',$resPupilsLArray,$resPupilsLDDArray,$patient['PUPILSL']);
                            echo "L " + $resPupilsLDD;
                            
                            $resPupilsRDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Pupils');
                            $resPupilsRDDArray = array();
                            for ($i = 1; $i < (count($resPupilsRDDSQL)+1); $i++) {
                                array_push($resPupilsRDDArray,$resPupilsRDDSQL[$i]['Long_Name']);
                            }
                
                            $resPupilsRDD = $Form->dropDown('res-PupilsR',$resPupilsRArray,$resPupilsRDDArray,$patient['PUPILSR']);
                            echo "R " + $resPupilsRDD;
                        ?>    
                    </td>
                </tr>
                <tr>
                    <td>
                        AVPU
                    </td>
                    <td>
                        <?php
                            $rsAVPUDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation neurological statu');
                            $rsAVPUDDArray = array();
                            for ($i = 1; $i < (count($rsAVPUDDSQL)+1); $i++) {
                                array_push($rsAVPUDDArray,$rsAVPUDDSQL[$i]['Long_Name']);
                            }
                
                            $rsAVPUDD = $Form->dropDown('res-AVPU',$rsAVPUArray,$rsAVPUDDArray,$patient['AVPU']);
                            echo $rsAVPUDD;
                        ?>     
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <fieldset>
                <legend>
                    GCS
                </legend>
                <table class="temp">
                    <tr>
                        <td>
                            Eye
                        </td>
                        <td>
                            <?php
                                $resGCSEye = $Form->textBox('res-GCSEye',$patient['GCS_EYE']);
                                echo $resGCSEye;
                                
                                $resGCSEyesDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation GCS EYE');
                                $resGCSEyesDDArray = array();
                                for ($i = 1; $i < (count($resGCSEyesDDSQL)+1); $i++) {
                                    array_push($resGCSEyesDDArray,$resGCSEyesDDSQL[$i]['Long_Name']);
                                }
                    
                                $resGCSEyesDD = $Form->dropDown('res-GCSEyes',$resGCSEyesArray,$resGCSEyesDDArray,$patient['PUPILSR']);
                                echo $resGCSEyesDD;
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Motor
                        </td>
                        <td>
                            <?php
                                $resGCSMotor = $Form->textBox('res-GCSMotor',$patient['GCS_MOTOR']);
                                echo $resGCSMotor;
                                
                                $resGCSMotorDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation GCS Motor');
                                $resGCSMotorDDArray = array();
                                for ($i = 1; $i < (count($resGCSMotorDDSQL)+1); $i++) {
                                    array_push($resGCSMotorDDArray,$resGCSMotorDDSQL[$i]['Long_Name']);
                                }
                    
                                $resGCSMotorDD = $Form->dropDown('res-GCSMotor',$resGCSMotorArray,$resGCSMotorDDArray,$patient['PUPILSR']);
                                echo $resGCSMotorDD;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Verbal
                        </td>
                        <td>
                            <?php
                                $resGCSVerbal = $Form->textBox('res-GCSMotor',$patient['GCS_VERBAL']);
                                echo $resGCSVerbal;
                                
                                $resGCSVerbalDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation GCS Verbal');
                                $resGCSVerbalDDArray = array();
                                for ($i = 1; $i < (count($resGCSVerbalDDSQL)+1); $i++) {
                                    array_push($resGCSVerbalDDArray,$resGCSVerbalDDSQL[$i]['Long_Name']);
                                }
                    
                                $resGCSVerbalDD = $Form->dropDown('res-GCSVerbal',$resGCSVerbalArray,$resGCSVerbalDDArray,$patient['PUPILSR']);
                                echo $resGCSVerbalDD;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Total GCS
                        </td>
                        <td>
                            <?php
                                $resTotalGCS = $Form->textBox('res-TotalGCS',$patient['GCS_TOTAL']);
                                echo $resTotalGCS;
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </td>
    </tr>
</table>