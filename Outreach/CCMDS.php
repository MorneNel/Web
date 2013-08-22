<table class='temp'>
    <tbody>
        <tr>
            <td>
                NHS Number
            </td>
            <td>
                <?php
                        $NHSNumber = $Form->textBox('ccmds-NHSNumber',$patient['DMG_NHSNUMBER'],'',1);
                        echo $NHSNumber;
                ?> 
            </td>
            <td>
                DOB
            </td>
            <td>
                <?php
                        $DOBSplit = explode(' ', $patient['DMG_DATEOFBIRTH']);
                        $DOB = $Form->textBox('ccmds-DOB',$DOBSplit[0],'',1);
                        echo $DOB;
                ?>
            </td>
            <td>
                Start Date
            </td>
            <td>
                <?php
                        $startDateSplit = explode(' ', $patient['ADM_REFERRALDATE']);
                        $startDate = $Form->textBox('ccmds-startDate',$startDateSplit[0]. " " .convert4DTime($patient['TIME_OF_RESPONSE']),'',1);
                        echo $startDate;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                GP
            </td>
            <td>
                <?php
                        $GP = $Form->textBox('ccmds-GP',$patient['ADM_CONSULTANT'],'',1);
                        echo $GP;
                ?>    
            </td>
            <td>
                Postcode
            </td>
            <td>
                <?php
                        $ccmdsPostcode = $Form->textBox('ccmds-postcode',$patient['DMG_POSTCODE'],'',1);
                        echo $ccmdsPostcode;
                ?> 
            </td>
            <td>
                Ready for discharge
            </td>
            <td>
                <?php
                        $startDateSplit = explode(' ', $patient['ADM_REFERRALDATE']);
                        $readyForDischarge = $Form->textBox('ccmds-readyForDischarge',$patient['R4DISCH_DATE'],'',1);
                        echo $readyForDischarge;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                Discharge date
            </td>
            <td>
                <?php
                        $dischargeDate = $Form->textBox('ccmds-dischargeDate',$patient['OTC_OTRDISCHARGEDATE'],'',1);
                        echo $dischargeDate;
                ?>    
            </td>
        </tr>
    </tbody>
</table>

<table class='temp'>
    <tr>
        <td>
            Unit function
        </td>
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
                $unitFunctionDD = $Form->dropDown('ccmds-unitFunction',$unitFunctionDDArray,$unitFunctionDDArray,$unitFunctionDDArray[$patient['UNITFUNCTION']]);
                echo $unitFunctionDD;
                //$unitFunctionHiddenDD = $Form
                //echo "<h1>Unit func is: ".$patient['UNITFUNCTION']." and var is ".$unitFunctionDDArray[$patient['UNITFUNCTION']]." and arr is ".var_dump($unitFunctionDDArray)."</h1>";
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Treatment function
        </td>
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
                $treatmentFunctionDD = $Form->dropDown('ccmds-treatmentFunction',$treatmentFunctionDDArray,$treatmentFunctionDDArray,$treatmentFunctionDDArray[$patient['TRTSPECIALITYCODE']]);
                echo $treatmentFunctionDD;
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Unit bed configuration
        </td>
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
                $unitbedConfigurationDD = $Form->dropDown('ccmds-unitBedConfiguration',$unitbedConfigurationDDArray,$unitbedConfigurationDDArray,$unitbedConfigurationDDArray[$patient['BEDCONFIG']]);
                echo $unitbedConfigurationDD;
            ?>    
        </td>
    </tr>
    <tr>
        <td>
            Admission source
        </td>
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
                $admissionSourceDD = $Form->dropDown('ccmds-admissionSource',$admissionSourceDDArray,$admissionSourceDDArray,$admissionSourceDDArray[$patient['ADMSRC']]);
                echo $admissionSourceDD;
            ?>    
        </td>
    </tr>
    <tr>
        <td>
            Source location
        </td>
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
                $sourceLocationDD = $Form->dropDown('ccmds-sourceLocation',$sourceLocationDDArray,$sourceLocationDDArray,$sourceLocationDDArray[$patient['SRCLOCATION']]);
                echo $sourceLocationDD;
            ?>    
        </td>
    </tr>
    <tr>
        <td>
            Admission type
        </td>
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
                $admissionTypeDD = $Form->dropDown('ccmds-admissionType',$admissionTypeDDArray,$admissionTypeDDArray,$admissionTypeDDArray[$patient['ADMTYPE']]);
                echo $admissionTypeDD;
            ?>    
        </td>
    </tr>
    <tr>
        <td>
            Discharge status
        </td>
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
                $dischargeStatusDD = $Form->dropDown('ccmds-dischargeStatus',$dischargeStatusDDArray,$dischargeStatusDDArray,$dischargeStatusDDArray[$patient['DISCHSTATUS']]);
                echo $dischargeStatusDD;
            ?>    
        </td>
    </tr>
    <tr>
        <td>
            Discharge destination
        </td>
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
                $dischargeDestinationDD = $Form->dropDown('ccmds-dischargeDestination',$dischargeDestinationDDArray,$dischargeDestinationDDArray,$dischargeDestinationDDArray[$patient['DISCHDEST']]);
                echo $dischargeDestinationDD;
            ?>    
        </td>
    </tr>
    <tr>
        <td>
            Discharge location
        </td>
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
                $dischargeLocationDD = $Form->dropDown('ccmds-dischargeLocation',$dischargeLocationDDArray,$dischargeLocationDDArray,$dischargeLocationDDArray[$patient['DISCHLOCATION']]);
                echo $dischargeLocationDD;
            ?>    
        </td>
    </tr>
</table>
<br />
<table class='temp'>
    <tbody>
        <tr>
            <td>
                Advanced respiratory
            </td>
            <td>
                <?php
                        $advancedRespiratory = $Form->textBox('ccmds-advancedRespiratory',$patient['ADVRESPSUPP'],'',1);
                        echo $advancedRespiratory;
                ?>     
            </td>
        </tr>
        <tr>
            <td>
                Basic respiratory
            </td>
            <td>
                <?php
                        $basicRespiratory = $Form->textBox('ccmds-basicRespiratory',$patient['BASICRESPSUPP'],'',1);
                        echo $basicRespiratory;
                ?>     
            </td>
        </tr>
        <tr>
            <td>
                Advanced cardiovascular
            </td>
            <td>
                <?php
                        $advancedCardiovascular = $Form->textBox('ccmds-advancedCardiovascular',$patient['ADVCARDIOSUPP'],'',1);
                        echo $advancedCardiovascular;
                ?>     
            </td>
        </tr>
        <tr>
            <td>
                Basic cardiovascular
            </td>
            <td>
                <?php
                        $basicCardiovascular = $Form->textBox('ccmds-basicCardiovascular',$patient['BASICCARDIOSUPP'],'',1);
                        echo $basicCardiovascular;
                ?>     
            </td>
        </tr>
        <tr>
            <td>
                Renal support
            </td>
            <td>
                <?php
                        $renalSupport = $Form->textBox('ccmds-renalSupport',$patient['RENALSUPP'],'',1);
                        echo $renalSupport;
                ?>     
            </td>
        </tr>
        <tr>
            <td>
                Neurological
            </td>
            <td>
                <?php
                        $neurological = $Form->textBox('ccmds-neurological',$patient['NEUROSUPP'],'',1);
                        echo $neurological;
                ?>     
            </td>
        </tr>
        <tr>
            <td>
                Dermatological
            </td>
            <td>
                <?php
                        $dermatological = $Form->textBox('ccmds-dermatological',$patient['DERMASUPP'],'',1);
                        echo $dermatological;
                ?>     
            </td>
        </tr>
        <tr>
            <td>
                Liver
            </td>
            <td>
                <?php
                        $liver = $Form->textBox('ccmds-liver',$patient['LIVERSUPP'],'',1);
                        echo $liver;
                ?>     
            </td>
        </tr>
        <tr>
            <td>
                Gastro-intestinal
            </td>
            <td>
                <?php
                        $gastroinstestinal = $Form->textBox('ccmds-gastroinstestinal',$patient['GISUPPORT'],'',1);
                        echo $gastroinstestinal;
                ?>     
            </td>
        </tr>
    </tbody>
</table>
<br />
<table class='temp'>
    <tbody>
        <tr>
            <td>
                Max. organ support
            </td>
            <td>
                <?php
                        $maxOrganSupport = $Form->textBox('ccmds-maxOrganSupport',$patient['MAXORGANSUPP'],'',1);
                        echo $maxOrganSupport;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Level 3 days
            </td>
            <td>
                <?php
                        $level3 = $Form->textBox('ccmds-level3',$patient['LEVEL3'],'',1);
                        echo $level3;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Level 2 days
            </td>
            <td>
                <?php
                        $level2 = $Form->textBox('ccmds-level2',$patient['LEVEL2'],'',1);
                        echo $level2;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Level 1 days
            </td>
            <td>
                <?php
                        $level1 = $Form->textBox('ccmds-level1',$patient['LEVEL1'],'',1);
                        echo $level1;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Level 0 days
            </td>
            <td>
                <?php
                        $level0 = $Form->textBox('ccmds-level0',$patient['LEVEL0'],'',1);
                        echo $level0;
                ?>    
            </td>
        </tr>
    </tbody>
</table>