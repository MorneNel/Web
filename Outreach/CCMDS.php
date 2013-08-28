<?php
$ccmds_header = array('ccmds_header');
$ccmds_dd_col = 'ccmds_dd_col';
$ccmds_num_col = array('ccmds_num_col');
?>

<table class='temp'>
    <tbody>
        <tr>
            <td class='temp ccmds_header_label'>NHS Number</td>
            <td><?php $NHSNumber = $Form->textBox('ccmds-NHSNumber',$patient['DMG_NHSNUMBER'],'',1,$ccmds_header); echo $NHSNumber; ?></td>
            <td class='temp ccmds_header_label'>DOB</td>
            <td><?php $DOBSplit = explode(' ', $patient['DMG_DATEOFBIRTH']); $DOB = $Form->textBox('ccmds-DOB',$DOBSplit[0],'',1,$ccmds_header); echo $DOB; ?></td>
            <td class='temp ccmds_header_label'>Start Date</td>
            <td><?php $startDateSplit = explode(' ', $patient['ADM_REFERRALDATE']); $startDate = $Form->textBox('ccmds-startDate',$startDateSplit[0]. " " .convert4DTime($patient['TIME_OF_RESPONSE']),'',1,$ccmds_header); echo $startDate; ?></td>
        </tr>
        <tr>
            <td class='temp ccmds_header_label'>GP</td>
            <td><?php $GP = $Form->textBox('ccmds-GP',$patient['ADM_CONSULTANT'],'',1,$ccmds_header); echo $GP; ?></td>
            <td class='temp ccmds_header_label'>Postcode</td>
            <td><?php $ccmdsPostcode = $Form->textBox('ccmds-postcode',$patient['DMG_POSTCODE'],'',1,$ccmds_header); echo $ccmdsPostcode; ?></td>
            <td class='temp ccmds_header_label'>Ready for discharge</td>
            <td><?php $startDateSplit = explode(' ', $patient['ADM_REFERRALDATE']); $readyForDischarge = $Form->textBox('ccmds-readyForDischarge',$patient['R4DISCH_DATE'],'',1,$ccmds_header); echo $readyForDischarge; ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class='temp ccmds_header_label'>Discharge date</td>
            <td><?php $dischargeDate = $Form->textBox('ccmds-dischargeDate',$patient['OTC_OTRDISCHARGEDATE'],'',1,$ccmds_header); echo $dischargeDate; ?></td>
        </tr>
    </tbody>
</table>



<table>
    <tr>
        <td>
            <table class='temp support_days'>
                <tbody>
                    <tr>
                        <td class='label_column'>Advanced respiratory</td>
                        <td>
                            <?php
                                    $advancedRespiratory = $Form->textBox('ccmds-advancedRespiratory',$patient['ADVRESPSUPP'],'',1,$ccmds_num_col);
                                    echo $advancedRespiratory;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Basic respiratory</td>
                        <td>
                            <?php
                                    $basicRespiratory = $Form->textBox('ccmds-basicRespiratory',$patient['BASICRESPSUPP'],'',1,$ccmds_num_col);
                                    echo $basicRespiratory;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Advanced cardiovascular</td>
                        <td>
                            <?php
                                    $advancedCardiovascular = $Form->textBox('ccmds-advancedCardiovascular',$patient['ADVCARDIOSUPP'],'',1,$ccmds_num_col);
                                    echo $advancedCardiovascular;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Basic cardiovascular</td>
                        <td>
                            <?php
                                    $basicCardiovascular = $Form->textBox('ccmds-basicCardiovascular',$patient['BASICCARDIOSUPP'],'',1,$ccmds_num_col);
                                    echo $basicCardiovascular;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Renal support</td>
                        <td>
                            <?php
                                    $renalSupport = $Form->textBox('ccmds-renalSupport',$patient['RENALSUPP'],'',1,$ccmds_num_col);
                                    echo $renalSupport;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Neurological</td>
                        <td>
                            <?php
                                    $neurological = $Form->textBox('ccmds-neurological',$patient['NEUROSUPP'],'',1,$ccmds_num_col);
                                    echo $neurological;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Dermatological</td>
                        <td>
                            <?php
                                    $dermatological = $Form->textBox('ccmds-dermatological',$patient['DERMASUPP'],'',1,$ccmds_num_col);
                                    echo $dermatological;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Liver</td>
                        <td>
                            <?php
                                    $liver = $Form->textBox('ccmds-liver',$patient['LIVERSUPP'],'',1,$ccmds_num_col);
                                    echo $liver;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Gastro-intestinal</td>
                        <td>
                            <?php
                                    $gastroinstestinal = $Form->textBox('ccmds-gastroinstestinal',$patient['GISUPPORT'],'',1,$ccmds_num_col);
                                    echo $gastroinstestinal;
                            ?>     
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>


        <td>
            <table class='temp ccmds_dd'>
                <tr>
                    <td class='label_column'>Unit function</td>
                    <td>
                        <?php
                            $unitFunctionDDSQL = $Mela_SQL->tbl_LoadItems('CCMDS - Unit Function');
                            $unitFunctionDDArray = array();
                            for ($i = 1; $i < (count($unitFunctionDDSQL)+1); $i++) {
                                //array_push($unitFunctionDDArray,$unitFunctionDDSQL[$i]['Long_Name']);
                                $longShortUnitFunctionArray = array($unitFunctionDDSQL[$i]['Short_Name'] => $unitFunctionDDSQL[$i]['Long_Name']);
                                array_push_associative($unitFunctionDDArray, $longShortUnitFunctionArray);
                            }
                            // Looks like this takes data from CCMDS - saves each option as an INT
                            // The INT corresponds to the 'code' field in dropdown list options which then selects long_name
                            asort($unitFunctionDDArray);
                            // The numbers for the unitFunctionDDArray are zero-padded so need to pad the number in the db to match up
                            $patient['UNITFUNCTION'] = (strlen($patient['UNITFUNCTION']) < 2) ? str_pad($patient['UNITFUNCTION'], 2, '0', STR_PAD_LEFT) : $patient['UNITFUNCTION'];
                            $unitFunctionDD = $Form->dropDown('ccmds-unitFunction',$unitFunctionDDArray,$unitFunctionDDArray,$unitFunctionDDArray[$patient['UNITFUNCTION']],$ccmds_dd_col);
                            echo $unitFunctionDD;
                            //$unitFunctionHiddenDD = $Form
                            //echo "<h1>Unit func is: ".$patient['UNITFUNCTION']." and var is ".$unitFunctionDDArray[$patient['UNITFUNCTION']]." and arr is ".var_dump($unitFunctionDDArray)."</h1>";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class='label_column'>Treatment function</td>
                    <td>
                        <?php
                            $treatmentFunctionDDSQL = $Mela_SQL->tbl_LoadItems('Specialities');
                            $treatmentFunctionDDArray = array();
                            for ($i = 1; $i < (count($treatmentFunctionDDSQL)+1); $i++) {
                                //array_push($treatmentFunctionDDArray,$unitFunctionDDSQL[$i]['Long_Name']);
                                // This is a bit silly but it works so hey
                                $longShortTreatmentFunctionArray = array($treatmentFunctionDDSQL[$i]['Long_Name'] => $treatmentFunctionDDSQL[$i]['Long_Name']);
                                array_push_associative($treatmentFunctionDDArray, $longShortTreatmentFunctionArray);
                            }
                            asort($treatmentFunctionDDArray); //var_dump($treatmentFunctionDDArray);   
                            //$treatmentFunctionDD = $Form->dropDown('ccmds-treatmentFunction',$treatmentFunctionDDArray,$treatmentFunctionDDArray,'');
                            //$patient['TRTSPECIALITYCODE'] = (strlen($patient['TRTSPECIALITYCODE']) < 2) ? str_pad($patient['TRTSPECIALITYCODE'], 2, '0', STR_PAD_LEFT) : $patient['TRTSPECIALITYCODE'];
                            $treatmentFunctionDD = $Form->dropDown('ccmds-treatmentFunction',$treatmentFunctionDDArray,$treatmentFunctionDDArray,$treatmentFunctionDDArray[$patient['TRTSPECIALITYCODE']],$ccmds_dd_col);
                            echo $treatmentFunctionDD;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class='label_column'>Unit bed configuration</td>
                    <td>
                        <?php
                            $unitbedConfigurationDDSQL = $Mela_SQL->tbl_LoadItems('CCMDS - Bed Configuration');
                            $unitbedConfigurationDDArray = array();
                            for ($i = 1; $i < (count($unitbedConfigurationDDSQL)+1); $i++) {
                                //array_push($unitbedConfigurationDDArray,$unitbedConfigurationDDSQL[$i]['Long_Name']);
                                $longShortunitbedFunctionArray = array($unitbedConfigurationDDSQL[$i]['Short_Name'] => $unitbedConfigurationDDSQL[$i]['Long_Name']);
                                array_push_associative($unitbedConfigurationDDArray, $longShortunitbedFunctionArray);
                            }
                            asort($unitbedConfigurationDDArray);
                            //$unitbedConfigurationDD = $Form->dropDown('ccmds-unitBedConfiguration',$unitbedConfigurationDDArray,$unitbedConfigurationDDArray,'');
                            $patient['BEDCONFIG'] = (strlen($patient['BEDCONFIG']) < 2) ? str_pad($patient['BEDCONFIG'], 2, '0', STR_PAD_LEFT) : $patient['BEDCONFIG'];
                            $unitbedConfigurationDD = $Form->dropDown('ccmds-unitBedConfiguration',$unitbedConfigurationDDArray,$unitbedConfigurationDDArray,$unitbedConfigurationDDArray[$patient['BEDCONFIG']],$ccmds_dd_col);
                            echo $unitbedConfigurationDD;
                        ?>    
                    </td>
                </tr>
                <tr>
                    <td class='label_column'>Admission source</td>
                    <td>
                        <?php
                            $admissionSourceDDSQL = $Mela_SQL->tbl_LoadItems('CCMDS - Admission Source');
                            $admissionSourceDDArray = array();
                            for ($i = 1; $i < (count($admissionSourceDDSQL)+1); $i++) {
                                //array_push($admissionSourceDDArray,$admissionSourceDDSQL[$i]['Long_Name']);
                                $longShortAdmissionSourceArray = array($admissionSourceDDSQL[$i]['Short_Name'] => $admissionSourceDDSQL[$i]['Long_Name']);
                                array_push_associative($admissionSourceDDArray, $longShortAdmissionSourceArray);
                            }
                            asort($admissionSourceDDArray);
                            //$admissionSourceDD = $Form->dropDown('ccmds-admissionSource',$admissionSourceDDArray,$admissionSourceDDArray,'');
                            $patient['ADMSRC'] = (strlen($patient['ADMSRC']) < 2) ? str_pad($patient['ADMSRC'], 2, '0', STR_PAD_LEFT) : $patient['ADMSRC'];
                            $admissionSourceDD = $Form->dropDown('ccmds-admissionSource',$admissionSourceDDArray,$admissionSourceDDArray,$admissionSourceDDArray[$patient['ADMSRC']],$ccmds_dd_col);
                            echo $admissionSourceDD;
                        ?>    
                    </td>
                </tr>
                <tr>
                    <td class='label_column'>Source location</td>
                    <td>
                        <?php
                            $sourceLocationDDSQL = $Mela_SQL->tbl_LoadItems('CCMDS - Source Location');
                            $sourceLocationDDArray = array();
                            for ($i = 1; $i < (count($sourceLocationDDSQL)+1); $i++) {
                                //array_push($sourceLocationDDArray,$sourceLocationDDSQL[$i]['Long_Name']);
                                $longShortSourceLocationArray = array($sourceLocationDDSQL[$i]['Short_Name'] => $sourceLocationDDSQL[$i]['Long_Name']);
                                array_push_associative($sourceLocationDDArray, $longShortSourceLocationArray);
                            }
                            asort($sourceLocationDDArray);
                            //$sourceLocationDD = $Form->dropDown('ccmds-sourceLocation',$sourceLocationDDArray,$sourceLocationDDArray,'');
                            $patient['SRCLOCATION'] = (strlen($patient['SRCLOCATION']) < 2) ? str_pad($patient['SRCLOCATION'], 2, '0', STR_PAD_LEFT) : $patient['SRCLOCATION'];
                            $sourceLocationDD = $Form->dropDown('ccmds-sourceLocation',$sourceLocationDDArray,$sourceLocationDDArray,$sourceLocationDDArray[$patient['SRCLOCATION']],$ccmds_dd_col);
                            echo $sourceLocationDD;
                        ?>    
                    </td>
                </tr>
                <tr>
                    <td class='label_column'>Admission type</td>
                    <td>
                        <?php
                            $admissionTypeDDSQL = $Mela_SQL->tbl_LoadItems('CCMDS - Admission Type');
                            $admissionTypeDDArray = array();
                            for ($i = 1; $i < (count($admissionTypeDDSQL)+1); $i++) {
                                //array_push($admissionTypeDDArray,$admissionTypeDDSQL[$i]['Long_Name']);
                                $longShortAdmissionTypeArray = array($admissionTypeDDSQL[$i]['Short_Name'] => $admissionTypeDDSQL[$i]['Long_Name']);
                                array_push_associative($admissionTypeDDArray, $longShortAdmissionTypeArray);
                            }
                            asort($admissionTypeDDArray);
                            //$admissionTypeDD = $Form->dropDown('ccmds-admissionType',$admissionTypeDDArray,$admissionTypeDDArray,'');
                            $patient['ADMTYPE'] = (strlen($patient['ADMTYPE']) < 2) ? str_pad($patient['ADMTYPE'], 2, '0', STR_PAD_LEFT) : $patient['ADMTYPE'];
                            $admissionTypeDD = $Form->dropDown('ccmds-admissionType',$admissionTypeDDArray,$admissionTypeDDArray,$admissionTypeDDArray[$patient['ADMTYPE']],$ccmds_dd_col);
                            echo $admissionTypeDD;
                        ?>    
                    </td>
                </tr>
                <tr>
                    <td class='label_column'>Discharge status</td>
                    <td>
                        <?php
                            $dischargeStatusDDSQL = $Mela_SQL->tbl_LoadItems('CCMDS - Discharge Status');
                            $dischargeStatusDDArray = array();
                            for ($i = 1; $i < (count($dischargeStatusDDSQL)+1); $i++) {
                                //array_push($dischargeStatusDDArray,$dischargeStatusDDSQL[$i]['Long_Name']);
                                $longShortDischargeStatusArray = array($dischargeStatusDDSQL[$i]['Short_Name'] => $dischargeStatusDDSQL[$i]['Long_Name']);
                                array_push_associative($dischargeStatusDDArray, $longShortDischargeStatusArray);
                            }
                            asort($dischargeStatusDDArray);
                            //$dischargeStatusDD = $Form->dropDown('ccmds-dischargeStatus',$dischargeStatusDDArray,$dischargeStatusDDArray,'');
                            $patient['DISCHSTATUS'] = (strlen($patient['DISCHSTATUS']) < 2) ? str_pad($patient['DISCHSTATUS'], 2, '0', STR_PAD_LEFT) : $patient['DISCHSTATUS'];
                            $dischargeStatusDD = $Form->dropDown('ccmds-dischargeStatus',$dischargeStatusDDArray,$dischargeStatusDDArray,$dischargeStatusDDArray[$patient['DISCHSTATUS']],$ccmds_dd_col);
                            echo $dischargeStatusDD;
                        ?>    
                    </td>
                </tr>
                <tr>
                    <td class='label_column'>Discharge destination</td>
                    <td>
                        <?php
                            $dischargeDestinationDDSQL = $Mela_SQL->tbl_LoadItems('CCMDS - Discharge Dest.');
                            $dischargeDestinationDDArray = array();
                            for ($i = 1; $i < (count($dischargeDestinationDDSQL)+1); $i++) {
                                //array_push($dischargeDestinationDDArray,$dischargeDestinationDDSQL[$i]['Long_Name']);
                                $longShortDischargeDestinationArray = array($dischargeDestinationDDSQL[$i]['Short_Name'] => $dischargeDestinationDDSQL[$i]['Long_Name']);
                                array_push_associative($dischargeDestinationDDArray, $longShortDischargeDestinationArray);
                            }
                            asort($dischargeDestinationDDArray);
                            //$dischargeDestinationDD = $Form->dropDown('ccmds-dischargeDestination',$dischargeDestinationDDArray,$dischargeDestinationDDArray,'');
                            $patient['DISCHDEST'] = (strlen($patient['DISCHDEST']) < 2) ? str_pad($patient['DISCHDEST'], 2, '0', STR_PAD_LEFT) : $patient['DISCHDEST'];
                            $dischargeDestinationDD = $Form->dropDown('ccmds-dischargeDestination',$dischargeDestinationDDArray,$dischargeDestinationDDArray,$dischargeDestinationDDArray[$patient['DISCHDEST']],$ccmds_dd_col);
                            echo $dischargeDestinationDD;
                        ?>    
                    </td>
                </tr>
                <tr>
                    <td class='label_column'>Discharge location</td>
                    <td>
                        <?php
                            $dischargeLocationDDSQL = $Mela_SQL->tbl_LoadItems('CCMDS - Discharge Location');
                            $dischargeLocationDDArray = array();
                            for ($i = 1; $i < (count($dischargeLocationDDSQL)+1); $i++) {
                                //array_push($dischargeLocationDDArray,$dischargeLocationDDSQL[$i]['Long_Name']);
                                $longShortDischargeLocationArray = array($dischargeLocationDDSQL[$i]['Short_Name'] => $dischargeLocationDDSQL[$i]['Long_Name']);
                                array_push_associative($dischargeLocationDDArray, $longShortDischargeLocationArray);
                            }
                            asort($dischargeLocationDDArray);
                            //$dischargeLocationDD = $Form->dropDown('ccmds-dischargeLocation',$dischargeLocationDDArray,$dischargeLocationDDArray,'');
                            $patient['DISCHLOCATION'] = (strlen($patient['DISCHLOCATION']) < 2) ? str_pad($patient['DISCHLOCATION'], 2, '0', STR_PAD_LEFT) : $patient['DISCHLOCATION'];
                            $dischargeLocationDD = $Form->dropDown('ccmds-dischargeLocation',$dischargeLocationDDArray,$dischargeLocationDDArray,$dischargeLocationDDArray[$patient['DISCHLOCATION']],$ccmds_dd_col);
                            echo $dischargeLocationDD;
                        ?>    
                    </td>
                </tr>
            </table>  
        </td>
    </tr>
    <tr>
        <td>
            <table class='temp ccmds_totals'>
                <tbody>
                    <tr>
                        <td class='label_column'>Max. organ support</td>
                        <td>
                            <?php
                                    $maxOrganSupport = $Form->textBox('ccmds-maxOrganSupport',$patient['MAXORGANSUPP'],'',1,$ccmds_num_col);
                                    echo $maxOrganSupport;
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Level 3 days</td>
                        <td>
                            <?php
                                    $level3 = $Form->textBox('ccmds-level3',$patient['LEVEL3'],'',1,$ccmds_num_col);
                                    echo $level3;
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Level 2 days</td>
                        <td>
                            <?php
                                    $level2 = $Form->textBox('ccmds-level2',$patient['LEVEL2'],'',1,$ccmds_num_col);
                                    echo $level2;
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Level 1 days</td>
                        <td>
                            <?php
                                    $level1 = $Form->textBox('ccmds-level1',$patient['LEVEL1'],'',1,$ccmds_num_col);
                                    echo $level1;
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class='label_column'>Level 0 days</td>
                        <td>
                            <?php
                                    $level0 = $Form->textBox('ccmds-level0',$patient['LEVEL0'],'',1,$ccmds_num_col);
                                    echo $level0;
                            ?>    
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>




