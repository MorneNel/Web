<table class='temp'>
    <tbody>
        <tr>
            <td>
                Date of admission
            </td>
            <td>
                <?php
                        $admDate = explode(' ', $patient['ADMDATE']);
                        $dateOfAdmission = $Form->textBox('rso2-admissionDate',$admDate[0]);
                        echo $dateOfAdmission;
                ?> 
            </td>
        </tr>
        <tr>
            <td>
                Reason for admission or visit
            </td>
            <td>
                <?php
                    $admissionReasonDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Reason for admission');
                    $admissionReasonDDArray = array();
                    for ($i = 1; $i < (count($admissionReasonDDSQL)+1); $i++) {
                        array_push($admissionReasonDDArray,$admissionReasonDDSQL[$i]['Long_Name']);
                    }
        
                    $admissionReasonDD = $Form->dropDown('rso2-admissionReason',$admissionReasonDDArray,$admissionReasonDDArray,$patient['REASON_FOR_ADM']);
                    echo $admissionReasonDD;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Transient post arrest location
            </td>
            <td>
                <?php
                    $transientPostArrestLocationDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Post arrest location');
                    $transientPostArrestLocationDDArray = array();
                    for ($i = 1; $i < (count($transientPostArrestLocationDDSQL)+1); $i++) {
                        array_push($transientPostArrestLocationDDArray,$transientPostArrestLocationDDSQL[$i]['Long_Name']);
                    }
        
                    $transientPostArrestLocationDD = $Form->dropDown('rso2-transientPostArrestLocation',$transientPostArrestLocationDDArray,$transientPostArrestLocationDDArray,$patient['REASON_FOR_ADM']);
                    echo $transientPostArrestLocationDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Longer term post arrest location
            </td>
            <td>
                <?php
                    $longerTermPostArrestLocationDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Longer term post arrest location');
                    $longerTermPostArrestLocationDDArray = array();
                    for ($i = 1; $i < (count($longerTermPostArrestLocationDDSQL)+1); $i++) {
                        array_push($longerTermPostArrestLocationDDArray,$longerTermPostArrestLocationDDSQL[$i]['Long_Name']);
                    }
        
                    $longerTermPostArrestLocationDD = $Form->dropDown('rso2-longerTermPostArrestLocation',$longerTermPostArrestLocationDDArray,$longerTermPostArrestLocationDDArray,$patient['RESUS_LONGPOST_ARREST_DEST']);
                    echo $longerTermPostArrestLocationDD;
                ?>    
            </td>
        </tr>
    </tbody>
</table>

<table class='temp'>
    <thead>
        <tr>
            <th colspan='2'>
                Long term / hospital outcome
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Survival to discharge
            </td>
            <td>
                <?php
                    $survivalToDischargeDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation YN');
                    $survivalToDischargeDDArray = array();
                    for ($i = 1; $i < (count($survivalToDischargeDDSQL)+1); $i++) {
                        array_push($survivalToDischargeDDArray,$survivalToDischargeDDSQL[$i]['Long_Name']);
                    }
        
                    $survivalToDischargeDD = $Form->dropDown('rso2-survivalToDischarge',$survivalToDischargeDDArray,$survivalToDischargeDDArray,$patient['SURVIVALTODISCH']);
                    echo $survivalToDischargeDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Discharge date & time
            </td>
            <td>
                <?php
                        $dischargeDateTime = $Form->textBox('rso2-dischargeDateTime',$patient['HOSPDISCHDATE']);
                        echo $dischargeDateTime;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Sedation at discharge
            </td>
            <td>
                <?php
                    $sedationAtDischargeDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation YN');
                    $sedationAtDischargeDDArray = array();
                    for ($i = 1; $i < (count($sedationAtDischargeDDSQL)+1); $i++) {
                        array_push($sedationAtDischargeDDArray,$sedationAtDischargeDDSQL[$i]['Long_Name']);
                    }
        
                    $sedationAtDischargeDD = $Form->dropDown('rso2-sedationAtDischarge',$sedationAtDischargeDDArray,$sedationAtDischargeDDArray,$patient['SURVIVALTODISCH']);
                    echo $sedationAtDischargeDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Discharge status
            </td>
            <td>
                <?php
                    $dischargeStatusDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Status at discharge from hospital');
                    $dischargeStatusDDArray = array();
                    for ($i = 1; $i < (count($dischargeStatusDDSQL)+1); $i++) {
                        array_push($dischargeStatusDDArray,$dischargeStatusDDSQL[$i]['Long_Name']);
                    }
        
                    $dischargeStatusDD = $Form->dropDown('rso2-dischargeStatus',$dischargeStatusDDArray,$dischargeStatusDDArray,$patient['OUTCOME_STATUSHOSP']);
                    echo $dischargeStatusDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Length of hospital stay
            </td>
            <td>
                <?php
                        $admDate = explode(' ', $patient['ADMDATE']);
                        $lengthOfHospitalStay = $Form->textBox('rso2-lengthOfHospitalStay',$patient['HLOS'],'',1);
                        echo $lengthOfHospitalStay;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Destination
            </td>
            <td>
                <?php
                    $rso2DestinationDDSQL = $Mela_SQL->tbl_LoadItems('Hospital Discharge Destination');
                    $rso2DestinationDDArray = array();
                    for ($i = 1; $i < (count($rso2DestinationDDSQL)+1); $i++) {
                        array_push($rso2DestinationDDArray,$rso2DestinationDDSQL[$i]['Long_Name']);
                    }
        
                    $rso2DestinationDD = $Form->dropDown('rso2-destination',$rso2DestinationDDArray,$rso2DestinationDDArray,$patient['DEST']);
                    echo $rso2DestinationDD;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Neuro. status at disch.
            </td>
            <td>
                <?php
                    $neuroStatusAtDischDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation CPC Scale');
                    $neuroStatusAtDischDDArray = array();
                    for ($i = 1; $i < (count($neuroStatusAtDischDDSQL)+1); $i++) {
                        array_push($neuroStatusAtDischDDArray,$neuroStatusAtDischDDSQL[$i]['Long_Name']);
                    }
        
                    $neuroStatusAtDischDD = $Form->dropDown('rso2-neuroStatusAtDisch',$neuroStatusAtDischDDArray,$neuroStatusAtDischDDArray,$patient['NEUROSTATATDISCHCPC']);
                    echo $neuroStatusAtDischDD;
                ?>    
            </td>
        </tr>
    </tbody>
</table>