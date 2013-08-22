<?php $unitsArray = array(" &deg;C", " mmHg", " beats/min", " /min", " %", " mmol / l", " mmHG", " mg/l", " ng/ml", " &micro;g/l", " mm / hr");
// This class is for identifying fields that need NEWS values calculating when their value is changed
$NEWSCSS = array('calculateNEWS','checkPhysiology');
// Purely for physiology checking
$PhysCSS = array('checkPhysiology');
?>
<!-- <fieldset> -->

    <table class='temp'>
        <tbody>
            <tr>
                <!-- Begin first column -->
                <td valign="top" align="right">
                    <table class='temp Phys1TopLeftTable'>
                        <tr><td colspan='100' class='linebreak_top'>Observations</td></tr>
                        <tr style='line-height:4px;'><td>&nbsp;</td></tr>
                        <tr>
                            <td>Temperature</td>
                            <td>
                                <?php
                                    $tempDataTags = array('code' => 'temp', 'type' => 'T', 'label' => 'Temperature');
                                    $physTemperature = $Form->textBoxPhysiology('phys-temperature',$patient['PAT_TEMPERATURE'],'',0,$NEWSCSS, $tempDataTags);
                                    echo $physTemperature . $unitsArray[0];
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td>Systolic BP</td>
                            <td>
                                <?php
                                    $sysDataTags = array('code' => 'sys', 'type' => 'T', 'label' => 'Systolic BP');
                                    $physSystolicBP = $Form->textBoxPhysiology('phys-systolicBP',$patient['PAT_SYSTOLIC_BP'],'',0,$NEWSCSS, $sysDataTags);
                                    echo $physSystolicBP . $unitsArray[1];
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td>Diastolic BP</td>
                            <td>
                                <?php
                                    $diasDataTags = array('code' => 'dias', 'type' => 'T', 'label' => 'Diastolic BP');
                                    $physDiastolicBP = $Form->textBoxPhysiology('phys-diastolicBP',$patient['PAT_DIASTOLIC_BP'],'',0,$PhysCSS,$diasDataTags);
                                    echo $physDiastolicBP . $unitsArray[1];
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td>Mean BP</td>
                            <td>
                                <?php
                                    $physMeanBP = $Form->textBoxPhysiology('phys-meanBP',$patient['PAT_MEAN_ARTERIAL_BP']);
                                    echo $physMeanBP . $unitsArray[1];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Heart Rate</td>
                            <td>
                                <?php
                                    $hrDataTags = array('code' => 'hr', 'type' => 'T', 'label' => 'Heart Rate');
                                    $physHeartRate = $Form->textBoxPhysiology('phys-heartRate1',$patient['PAT_HEARTRATE'],'',0,$PhysCSS,$hrDataTags);
                                    echo $physHeartRate . $unitsArray[2];
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td>Resp Rate</td>
                            <td>
                                <?php
                                    $rrDataTags = array('code' => 'rr', 'type' => 'T', 'label' => 'Respiratory Rate');
                                    $physRespRate = $Form->textBoxPhysiology('phys-respRate',$patient['PAT_RESPIRATORYRATE'],'',0,$NEWSCSS,$rrDataTags);
                                    echo $physRespRate . $unitsArray[3];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>SpO2</td>
                            <td>
                                <?php
                                    $spo2DataTags = array('code' => 'SpO2', 'type' => 'T', 'label' => 'SpO2');
                                    $physSpO2 = $Form->textBoxPhysiology('phys-SpO2',$patient['PAT_O2SATURATION'],'',0,$NEWSCSS,$spo2DataTags);
                                    echo $physSpO2 . $unitsArray[4];
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td>O2 Received</td>
                            <td>
                                <?php
                                    $o2DataTags = array('code' => 'o2Rec', 'type' => 'T', 'label' => 'O2 Received');
                                    $physO2 = $Form->textBoxPhysiology('phys-O2',$patient['PAT_O2RECEIVED'],'',0,$NEWSCSS,$o2DataTags);
                                    echo $physO2 ."<br />";
                                
                                    if ($preferences['prf_Use_O2RecUnit_List'] == 'true') {
                                    $O2ReceivedDDSQL = $Mela_SQL->tbl_LoadItems('O2 Received Units');
                                    $O2ReceivedDDArray = array();
                                    for ($i = 1; $i < (count($O2ReceivedDDSQL)+1); $i++) {
                                        array_push($O2ReceivedDDArray,$O2ReceivedDDSQL[$i]['Long_Name']);
                                    }
                        
                                    $O2ReceivedDD = $Form->dropDown('phys-O2Received',$O2ReceivedDDArray,$O2ReceivedDDArray,$patient['PAT_O2REC_UNIT'],'physiologyDropDown');
                                    echo $O2ReceivedDD ."<br />";
                                    }
                                    
                                    $O2Received2DDSQL = $Mela_SQL->tbl_LoadItems('O2 delivered by');
                                    $O2Received2DDArray = array();
                                    for ($i = 1; $i < (count($O2Received2DDSQL)+1); $i++) {
                                        array_push($O2Received2DDArray,$O2Received2DDSQL[$i]['Long_Name']);
                                    }
                        
                                    $O2Received2DD = $Form->dropDown('phys-O2Received2',$O2Received2DDArray,$O2Received2DDArray,$patient['PAT_O2DELIV_BY'],'physiologyDropDown');
                                    echo $O2Received2DD;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Urine</td>
                            <td>
                                <?php
                                    if ($preferences['prf_UseUrineList'] == 'true') {
                                    $physUrineDDSQL = $Mela_SQL->tbl_LoadItems('Urine');
                                    $physUrineDDArray = array();
                                    for ($i = 1; $i < (count($physUrineDDSQL)+1); $i++) {
                                        array_push($physUrineDDArray,$physUrineDDSQL[$i]['Long_Name']);
                                    }
                        
                                    $physUrineDD = $Form->dropDown('phys-Urine',$physUrineDDArray,$physUrineDDArray,$patient['PAT_URINEDD'],'physiologyDropDown');
                                    echo $physUrineDD ."<br />";
                                    
                                    } else {
                                    
                                    $physUrine2DDSQL = $Mela_SQL->tbl_LoadItems('Urine in past hours');
                                    $physUrine2DDArray = array();
                                    for ($i = 1; $i < (count($physUrine2DDSQL)+1); $i++) {
                                        array_push($physUrine2DDArray,$physUrine2DDSQL[$i]['Long_Name']);
                                    }
                                    
                                    $physUrineQuantDD = $Form->textBoxPhysiology('phys-UrineQuant',$patient['PAT_URINEOUTPUT']);
                                    $physUrine2DD = $Form->dropDown('phys-Urine2',$physUrine2DDArray,$physUrine2DDArray,$patient['URINE_IN_LAST_HRS'],'physiologyDropDown');
                                    
                                    echo $physUrineQuantDD;
                                    echo $physUrine2DD;
                                    
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>AVPU</td>
                            <td>
                                <?php
                                    $physAVPUDDSQL = $Mela_SQL->tbl_LoadItems('AVPU');
                                    $physAVPUDDArray = array();
                                    for ($i = 1; $i < (count($physAVPUDDSQL)+1); $i++) {
                                        array_push($physAVPUDDArray,$physAVPUDDSQL[$i]['Long_Name']);
                                    }
                        
                                    $physAVPUDD = $Form->dropDown('phys-AVPU',$physAVPUDDArray,$physAVPUDDArray,$patient['PAT_AVPU'],'physiologyDropDown calculateNEWS');
                                    echo $physAVPUDD;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Pain</td>
                            <td>
                                <?php
                                    $physPainDDSQL = $Mela_SQL->tbl_LoadItems('PAIN');
                                    $physPainDDArray = array();
                                    for ($i = 1; $i < (count($physPainDDSQL)+1); $i++) {
                                        array_push($physPainDDArray,$physPainDDSQL[$i]['Long_Name']);
                                    }
                        
                                    $physPainDD = $Form->dropDown('phys-Pain',$physPainDDArray,$physPainDDArray,$patient['PAT_PAIN'],'physiologyDropDown');
                                    echo $physPainDD;
                                ?>    
                            </td>
                        </tr>
                    </table>
                </td>
                <!-- End First column -->


                <!-- Begin second column -->
                <td valign="top" align="right">
                        <table class='temp Phys1TopCenterTable'>
                            <tr>
                                <td colspan='100' class='linebreak_top'>
                                    <?php $ABGName = $preferences['Show_ABG_CustNAme'] ? $preferences['Phys1GB_Name'] : "Blood Gasses";
                                        if(strlen($ABGName)>=1) {
                                            echo $ABGName;
                                        }
                                        else{
                                            echo 'Blood Gasses';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
                            <tr>
                                <td>Type</td>
                                <td>
                                    <?php
                                        $physTypeDDArray = array("Arterial", "Capillary", "Venous");                            
                                        $physTypeDD = $Form->dropDown('phys-Type',$physTypeDDArray,$physTypeDDArray,$patient['ABG_TYPE']);
                                        echo $physTypeDD;
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>PaO2</td>
                                <td>
                                    <?php
                                        $pao2DataTags = array('code' => 'pao2', 'type' => 'T', 'label' => 'PaO2');
                                        $physPAO2 = $Form->textBoxPhysiology('phys-heartRate',$patient['PAT_PAO2'],'',0,$PhysCSS,$pao2DataTags);
                                        echo $physPAO2 . $preferences['PRF_PAO2'];
                                    ?>     
                                </td>
                            </tr>
                            <tr>
                                <td>Associated FIO2</td>
                                <td>
                                    <?php
                                        $fioDataTags = array('code' => 'fio', 'type' => 'T', 'label' => 'Associated FIO2');
                                        $physAssociatedFIO2 = $Form->textBoxPhysiology('phys-AssociatedFIO2',$patient['PAT_FIO2'],'',0,$PhysCSS,$fioDataTags);
                                        echo $physAssociatedFIO2;
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Associated PaCO2</td>
                                <td>
                                    <?php
                                        $paco2DataTags = array('code' => 'pac', 'type' => 'T', 'label' => 'Associated PaCO2');
                                        $physAssociatedPACO2 = $Form->textBoxPhysiology('phys-AssociatedPACO2',$patient['PAT_PACO2'],'',0,$PhysCSS,$paco2DataTags);
                                        echo $physAssociatedPACO2 . $preferences['PRF_PACO2'];
                                        echo $Form->hiddenField('prf_PACO2',$preferences['PRF_PACO2']);
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Associated pH/H+</td>
                                <td>
                                    <?php
                                        $phDataTags = array('code' => 'ph', 'type' => 'T', 'label' => 'Associated pH/H+');
                                        $physAssociatedPHH = $Form->textBoxPhysiology('phys-AssociatedPHH',$patient['PAT_PH'],'',0,$PhysCSS,$phDataTags);
                                        echo $physAssociatedPHH . $preferences['PRF_PH'];
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Base Excess</td>
                                <td>
                                    <?php
                                        $physBaseExcess = $Form->textBoxPhysiology('phys-BaseExcess',$patient['PAT_BASE_EXCESS']);
                                        echo $physBaseExcess;
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>SaO2</td>
                                <td>
                                    <?php
                                        $sao2DataTags = array('code' => 'SaO2', 'type' => 'T', 'label' => 'SaO2');
                                        $physSAO2 = $Form->textBoxPhysiology('phys-SaO2',$patient['PAT_SAO2'],'',0,$PhysCSS,$sao2DataTags);
                                        echo $physSAO2 . $unitsArray[4];
                                    ?>     
                                </td>
                            </tr>
                            <tr>
                                <td>HCO3</td>
                                <td>
                                    <?php
                                        $hco3DataTags = array('code' => 'HCO3', 'type' => 'T', 'label' => 'HCO3');
                                        $physHCO3 = $Form->textBoxPhysiology('phys-HCO3',$patient['PAT_HCO3'],'',0,$PhysCSS,$hco3DataTags);
                                        echo $physHCO3 . $unitsArray[5];
                                    ?>     
                                </td>
                            </tr>
                            <?php if ($preferences['prf_Show_Test_DateTime'] == 'true') { ?>
                            <tr>
                                <td>ABG Date & Time</td>
                                <td>
                                    <?php
                                        $ABGDateSplit = explode(' ',$patient['PAT_ABG_TEST_DATE']);
                                        $physABGDate = $Form->textBoxPhysiology('phys-ABGDate',$ABGDateSplit[0]);
                                        echo $physABGDate;
                                        
                                        $physABGTime = $Form->textBoxPhysiology('phys-ABGTime',convert4DTime($patient['PAT_ABG_TEST_TIME']));
                                        echo $physABGTime;
                                    ?>    
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>Mean arterial bp</td>
                                <td>
                                    <?php
                                        $physMeanArterialBP = $Form->textBoxPhysiology('phys-MeanArterialBP',$patient['PAT_MEAN_ARTERIAL_BP']);
                                        echo $physMeanArterialBP . $unitsArray[6];
                                    ?>    
                                </td>
                            </tr>
                        </table>  
                </td>
                <!-- End second column -->


                <!-- Begin third column -->
                <?php if ($preferences['prf_Cardiac'] == 'true') { ?>
                <td valign="top" align="right">
                    <table class='temp Phys1TopRightTable'>
                        <tr><td colspan='100' class='linebreak_top'>Cardiac</td></tr>
                        <tr style='line-height:4px;'><td>&nbsp;</td></tr>
                            <tr>
                                <td>CRP</td>
                                <td>
                                    <?php
                                        $crpDataTags = array('code' => 'crp', 'type' => 'T', 'label' => 'CRP');
                                        $physCRP = $Form->textBoxPhysiology('phys-CRP',$patient['PAT_CRP'],'',0,$PhysCSS,$crpDataTags);
                                        echo $physCRP . $unitsArray[7];
                                    ?>        
                                </td>
                            </tr>
                            <tr>
                                <td>D-Dimers</td>
                                <td>
                                    <?php
                                        $ddimDataTags = array('code' => 'DDim', 'type' => 'T', 'label' => 'D-Dimers');
                                        $physDDimers = $Form->textBoxPhysiology('phys-DDimers',$patient['PAT_DDIMERS'],'',0,$PhysCSS,$ddimDataTags);
                                        echo $physDDimers . $unitsArray[8];
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Troponin Level</td>
                                <td>
                                    <?php
                                        $calcDataTags = array('code' => 'calc', 'type' => 'T', 'label' => 'Troponin Level');
                                        $physTroponinLevel = $Form->textBoxPhysiology('phys-TroponinLevel',$patient['PAT_TROPONIN_LEVEL'],'',0,$PhysCSS,$calcDataTags);
                                        echo $physTroponinLevel . $unitsArray[9];
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Cardiac Kinase</td>
                                <td>
                                    <?php
                                        $kinaseDataTags = array('code' => 'kinase', 'type' => 'T', 'label' => 'Cardiac Kinase');
                                        $physCardiacKinase = $Form->textBoxPhysiology('phys-CardiacKinase',$patient['PAT_CARDIAC_KINASE'],'',0,$PhysCSS,$kinaseDataTags);
                                        echo $physCardiacKinase;
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>ESR</td>
                                <td>
                                    <?php
                                        $esrDataTags = array('code' => 'esr', 'type' => 'T', 'label' => 'ESR');
                                        $physESR = $Form->textBoxPhysiology('phys-ESR',$patient['PAT_ESR'],'',0,$PhysCSS,$esrDataTags);
                                        echo $physESR . $unitsArray[10];
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>RAP</td>
                                <td>
                                    <?php
                                        $physRAP = $Form->textBoxPhysiology('phys-RAP',$patient['PAT_RAP']);
                                        echo $physRAP . $unitsArray[6];
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Rhythm</td>
                                <td>
                                    <?php
                                        $physRhythmDDSQL = $Mela_SQL->tbl_LoadItems('Rhythm');
                                        $physRhythmDDArray = array();
                                        for ($i = 1; $i < (count($physRhythmDDSQL)+1); $i++) {
                                            array_push($physRhythmDDArray,$physRhythmDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $physRhythmDD = $Form->dropDown('phys-Rhythm',$physRhythmDDArray,$physRhythmDDArray,$patient['PAT_RHYTHM'],'physiologyDropDown');
                                        echo $physRhythmDD;
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Paced</td>
                                <td>
                                    <?php
                                        $physPacedDDSQL = $Mela_SQL->tbl_LoadItems('Paced');
                                        $physPacedDDArray = array();
                                        for ($i = 1; $i < (count($physPacedDDSQL)+1); $i++) {
                                            array_push($physPacedDDArray,$physPacedDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $physPacedDD = $Form->dropDown('phys-Paced',$physPacedDDArray,$physPacedDDArray,$patient['PAT_PACED'],'physiologyDropDown');
                                        echo $physPacedDD;
                                    ?>     
                                </td>
                            </tr>
                        </table>
                </td>
                <!-- End third column -->
                <?php } ?>
            </tr>
        </tbody>
    </table>
    
<br/>

    <table class='temp middleEarth'>
        <tr>
            <?php if ($preferences['prf_ShowGCS'] == 'true') { ?> 
            <td class='middleEarth_leftShire' valign="top" align="right">
                    <table class='temp leftShire'>
                        <tr><td colspan='100' class='linebreak_top'>GSC</td></tr>
                        <tr style='line-height:4px;'><td>&nbsp;</td></tr>
                        <tr>
                            <td>
                                Eyes
                            </td>
                            <td>
                                <?php
                                    $physEyesDDSQL = $Mela_SQL->tbl_LoadItems('GCS Eyes');
                                    $physEyesDDArray = array();
                                    for ($i = 1; $i < (count($physEyesDDSQL)+1); $i++) {
                                        array_push($physEyesDDArray,$physEyesDDSQL[$i]['Long_Name']);
                                    }
                        
                                    $physEyesDD = $Form->dropDown('phys-Eyes',$physEyesDDArray,$physEyesDDArray,$patient['PAT_GCS_EYES']);
                                    echo $physEyesDD;
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td>Motor</td>
                            <td>
                                <?php
                                    $physMotorDDSQL = $Mela_SQL->tbl_LoadItems('GCS Motor');
                                    $physMotorDDArray = array();
                                    for ($i = 1; $i < (count($physMotorDDSQL)+1); $i++) {
                                        array_push($physMotorDDArray,$physMotorDDSQL[$i]['Long_Name']);
                                    }
                        
                                    $physMotorDD = $Form->dropDown('phys-Motor',$physMotorDDArray,$physMotorDDArray,$patient['PAT_GCS_MOTOR']);
                                    echo $physMotorDD;
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td>Verbal</td>
                            <td>
                                <?php
                                    $physVerbalDDSQL = $Mela_SQL->tbl_LoadItems('GCS Verbal');
                                    $physVerbalDDArray = array();
                                    for ($i = 1; $i < (count($physVerbalDDSQL)+1); $i++) {
                                        array_push($physVerbalDDArray,$physVerbalDDSQL[$i]['Long_Name']);
                                    }
                        
                                    $physVerbalDD = $Form->dropDown('phys-Verbal',$physVerbalDDArray,$physVerbalDDArray,$patient['PAT_GCS_VERBAL']);
                                    echo $physVerbalDD;
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>
                                <?php
                                    $physGCS = $Form->textBox('phys-GCS',$patient['PAT_GCS']);
                                    echo $physGCS;
                                ?>    
                            </td>
                        </tr>
                    </table>
            </td>
            <?php } ?>
            
            <?php if ($preferences['Limbs'] == 'true') { ?>
            <td class='middleEarth_rightShire' valign="top" align="right">
                    <table class='temp rightShire'>
                        <tbody>
                        <tr><td colspan='100' class='linebreak_top'>Limbs</td></tr>
                        <tr style='line-height:4px;'><td>&nbsp;</td></tr>
                            <tr>
                                <td>Left Arm</td>
                                <td>
                                    <?php
                                        $physLeftArmScore = $Form->textBoxPhysiology('phys-LimbLeftArmScore','','',1);
                                        echo $physLeftArmScore;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $physLeftArmDDSQL = $Mela_SQL->tbl_LoadItems('Limb movement');
                                        $physLeftArmDDArray = array();
                                        for ($i = 1; $i < (count($physLeftArmDDSQL)+1); $i++) {
                                            array_push($physLeftArmDDArray,$physLeftArmDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $physLeftArmDD = $Form->dropDown('phys-LimbLeftArm',$physLeftArmDDArray,$physLeftArmDDArray,$patient['LIMB_LEFTARM']);
                                        echo $physLeftArmDD;
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Left Leg</td>
                                <td>
                                    <?php
                                        $physLeftLegScore = $Form->textBoxPhysiology('phys-LimbLeftLegScore','','',1);
                                        echo $physLeftLegScore;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $physLeftLegDDSQL = $Mela_SQL->tbl_LoadItems('Limb movement');
                                        $physLeftLegDDArray = array();
                                        for ($i = 1; $i < (count($physLeftLegDDSQL)+1); $i++) {
                                            array_push($physLeftLegDDArray,$physLeftLegDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $physLeftLegDD = $Form->dropDown('phys-LimbLeftLeg',$physLeftLegDDArray,$physLeftLegDDArray,$patient['LIMB_LEFTLEG']);
                                        echo $physLeftLegDD;
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Right Arm</td>
                                <td>
                                    <?php
                                        $physRightArmScore = $Form->textBoxPhysiology('phys-LimbRightArmScore','','',1);
                                        echo $physRightArmScore;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $physRightArmDDSQL = $Mela_SQL->tbl_LoadItems('Limb movement');
                                        $physRightArmDDArray = array();
                                        for ($i = 1; $i < (count($physRightArmDDSQL)+1); $i++) {
                                            array_push($physRightArmDDArray,$physRightArmDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $physRightArmDD = $Form->dropDown('phys-LimbRightArm',$physRightArmDDArray,$physRightArmDDArray,$patient['LIMB_RIGHTARM']);
                                        echo $physRightArmDD;
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Right Leg</td>
                                <td>
                                    <?php
                                        $physRightLegScore = $Form->textBoxPhysiology('phys-LimbRightLegScore','','',1);
                                        echo $physRightLegScore;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $physRightLegDDSQL = $Mela_SQL->tbl_LoadItems('Limb movement');
                                        $physRightLegDDArray = array();
                                        for ($i = 1; $i < (count($physRightLegDDSQL)+1); $i++) {
                                            array_push($physRightLegDDArray,$physRightLegDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $physRightLegDD = $Form->dropDown('phys-LimbRightLeg',$physRightLegDDArray,$physRightLegDDArray,$patient['LIMB_RIGHTLEG']);
                                        echo $physRightLegDD;
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>
                                    <?php
                                        $physLimbTotal = $Form->textBox('phys-LimbTotal',$patient['LIMBTOTAL']);
                                        echo $physLimbTotal;
                                    ?>    
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </td>
            <?php } ?>
        </tr>
    </table>
        <!-- End Second row -->



<br/>





        <!-- Begin third row -->
    <table class='temp '>
        <tr>
            <?php if ($preferences['Seizure_info'] == 'true') { ?>
            <td valign="top" align="right">
                    <table class='temp'>
                        <tr><td colspan='100' class='linebreak_top'>Seizure activity</td></tr>
                        <tr style='line-height:4px;'><td>&nbsp;</td></tr>
                        <tr>
                            <td>Type</td>
                            <td>
                                <?php
                                    $physSeizureTypeDDSQL = $Mela_SQL->tbl_LoadItems('Seizure Type');
                                    $physSeizureTypeDDArray = array();
                                    for ($i = 1; $i < (count($physSeizureTypeDDSQL)+1); $i++) {
                                        array_push($physSeizureTypeDDArray,$physSeizureTypeDDSQL[$i]['Long_Name']);
                                    }
                        
                                    $physSeizureTypeDD = $Form->dropDown('phys-SeizureType',$physSeizureTypeDDArray,$physSeizureTypeDDArray,$patient['SEIZURE_TYPE']);
                                    echo $physSeizureTypeDD;
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>
                                <?php
                                    $physSeizureDescriptionDDSQL = $Mela_SQL->tbl_LoadItems('Seizure Description');
                                    $physSeizureDescriptionDDArray = array();
                                    for ($i = 1; $i < (count($physSeizureDescriptionDDSQL)+1); $i++) {
                                        array_push($physSeizureDescriptionDDArray,$physSeizureDescriptionDDSQL[$i]['Long_Name']);
                                    }
                        
                                    $physSeizureDescriptionDD = $Form->dropDown('phys-SeizureDescription',$physSeizureDescriptionDDArray,$physSeizureDescriptionDDArray,$patient['SEIZURE_DESC']);
                                    echo $physSeizureDescriptionDD;
                                ?> 
                            </td>
                        </tr>
                    </table>
            </td>
            <?php } ?>
            <?php if ($preferences['PupilReact'] == 'true') { ?>
            <td valign="top" align="right">

                    <table class='temp'>

                        <tr><td colspan='100' class='linebreak_top'>Pupils</td></tr>
                        <tr style='line-height:4px;'><td>&nbsp;</td></tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td align="center">Left</td>
                                <td align="center">Right</td>
                            </tr>

                            
                            <tr>
                                <td>Reactivity</td>
                                <td>
                                    <?php
                                        $physPupilReactLeftDDSQL = $Mela_SQL->tbl_LoadItems('Pupil - Reactivity');
                                        $physPupilReactLeftDDArray = array();
                                        for ($i = 1; $i < (count($physPupilReactLeftDDSQL)+1); $i++) {
                                            array_push($physPupilReactLeftDDArray,$physPupilReactLeftDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $physPupilReactLeftDD = $Form->dropDown('phys-PupilReactLeft',$physPupilReactLeftDDArray,$physPupilReactLeftDDArray,$patient['PUPILREACT_LEFT']);
                                        echo $physPupilReactLeftDD;
                                    ?>    
                                </td>
                                <td>
                                    <?php
                                        $physPupilReactRightDDSQL = $Mela_SQL->tbl_LoadItems('Pupil - Reactivity');
                                        $physPupilReactRightDDArray = array();
                                        for ($i = 1; $i < (count($physPupilReactRightDDSQL)+1); $i++) {
                                            array_push($physPupilReactRightDDArray,$physPupilReactRightDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $physPupilReactRightDD = $Form->dropDown('phys-PupilReactRight',$physPupilReactRightDDArray,$physPupilReactRightDDArray,$patient['PUPILREACT_RIGHT']);
                                        echo $physPupilReactRightDD;
                                    ?>    
                                </td>
                            </tr>
                            <tr>
                                <td>Dilation</td>
                                <td>
                                    <?php
                                        $physPupilDilationLeftDDSQL = $Mela_SQL->tbl_LoadItems('Pupil - Dilation');
                                        $physPupilDilationLeftDDArray = array();
                                        for ($i = 1; $i < (count($physPupilDilationLeftDDSQL)+1); $i++) {
                                            array_push($physPupilDilationLeftDDArray,$physPupilDilationLeftDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $physPupilDilationLeftDD = $Form->dropDown('phys-PupilDilationLeft',$physPupilDilationLeftDDArray,$physPupilDilationLeftDDArray,$patient['PUPILDILATION_LEFT']);
                                        echo $physPupilDilationLeftDD;
                                    ?>    
                                </td>
                                <td>
                                    <?php
                                        $physPupilDilationRightDDSQL = $Mela_SQL->tbl_LoadItems('Pupil - Dilation');
                                        $physPupilDilationRightDDArray = array();
                                        for ($i = 1; $i < (count($physPupilDilationRightDDSQL)+1); $i++) {
                                            array_push($physPupilDilationRightDDArray,$physPupilDilationRightDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $physPupilDilationRightDD = $Form->dropDown('phys-PupilDilationRight',$physPupilDilationRightDDArray,$physPupilDilationRightDDArray,$patient['PUPILDILATION_RIGHT']);
                                        echo $physPupilDilationRightDD;
                                    ?>    
                                </td>
                            </tr>                            

                    </table>

            </td>
            <?php } ?>
        </tr>
    </table>
<!-- </fieldset> -->


<br/>


<table class='temp'>
    <tr>
        <?php if ($preferences['MEWS_Anywhere'] == 'true') { ?>
        <td>
            <button type='button' id='EWSScore' data-dlkpatid='<?php echo $patient['DLK_PATID']; ?>' data-lnkid='<?php echo $lnkID; ?>'>
                EWSS Score
            </button>
        </td>
        <td>
            <?php
                $physEWSSScore = $Form->textBox('phys-EWSSScore',$patient['PAT_EWSSFDDCI']);
                echo $physEWSSScore;
            ?>
        </td>
        <?php } ?>
        <?php if ($preferences['SOFAScore'] == 'true') { ?>
        <td>
            <button type='button' id='SOFAScore' data-dlkpatid='<?php echo $patient['DLK_PATID']; ?>' data-dlkid='<?php echo $patient['DLK_ID']; ?>'>
                SOFA Score
            </button>
        </td>
        <td>
            <?php
                $physSOFAScore = $Form->textBox('phys-SOFAScore',$patient['SOFA']);
                echo $physSOFAScore;
            ?>    
        </td>
        <?php } ?>
    </tr>
    <tr>
        <?php if ($preferences['NEWS_PHYS'] == 'true') { ?>
        <td>
            <button type='button' id='NEWSScore' data-dlkid='<?php echo $patient['DLK_ID']; ?>' data-dlkpatid='<?php echo $patient['DLK_PATID']; ?>' data-lnkid='<?php echo $lnkID; ?>'>
                NEWS Score
            </button>
        </td>
        <td>
            <?php
                $physNEWSScore = $Form->textBox('phys-NEWSScore',$patient['NEWS_SCORE']);
                echo $physNEWSScore;
            ?>    
        </td>
        <?php } ?>
        <td colspan='2'>
            <?php
                $ews_Trig = $preferences['PRF_EWSS_NAME'];
                //echo $ews_Trig;
            ?>
        </td>
    </tr>
</table>