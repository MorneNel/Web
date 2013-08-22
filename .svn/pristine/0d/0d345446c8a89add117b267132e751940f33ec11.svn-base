<table class='temp'>
    <tbody>
        <tr>
            <td>
                Referral Date
            </td>
            <td>
                <?php
                        $referralDate = $Form->textBox('ref-ReferralDate',$patient['ADM_REFERRALDATE']);
                        echo $referralDate;
                ?> 
            </td>
        </tr>
        <tr>
            <td>
                Referrer
            </td>
            <td>
                <?php
                    $referrerDDSQL = $Mela_SQL->tbl_LoadItems('Referral Source');
                    $referrerDDArray = array();
                    for ($i = 1; $i < (count($referrerDDSQL)+1); $i++) {
                        array_push($referrerDDArray,$referrerDDSQL[$i]['Long_Name']);
                    }
        
                    $referrerDD = $Form->dropDown('ref-Referrer',$referrerDDArray,$referrerDDArray,$patient['CALLER']);
                    echo $referrerDD;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                OR responder
            </td>
            <td>
                <?php
                    $ORResponderDDSQL = $Mela_SQL->tbl_LoadItems('Referral Source');
                    $ORResponderDDArray = array();
                    for ($i = 1; $i < (count($ORResponderDDSQL)+1); $i++) {
                        array_push($ORResponderDDArray,$ORResponderDDSQL[$i]['Long_Name']);
                    }
        
                    $ORResponderDD = $Form->dropDown('ref-ORResponder',$ORResponderDDArray,$ORResponderDDArray,$patient['CALLER']);
                    echo $ORResponderDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Outreach number
            </td>
            <td>
                <?php
                        $refOutreachNumber = $Form->textBox('ref-outreachNumber',$patient['ADM_NUMBER']);
                        echo $refOutreachNumber;
                ?>     
            </td>
        </tr>
        <tr>
            <td>
                Location
            </td>
            <td>
                <?php
                    $reflocationDDSQL = $Mela_SQL->tbl_LoadItems('Wards');
                    $reflocationDDArray = array();
                    for ($i = 1; $i < (count($reflocationDDSQL)+1); $i++) {
                        array_push($reflocationDDArray,$reflocationDDSQL[$i]['Long_Name']);
                    }
        
                    $reflocationDD = $Form->dropDown('ref-Location',$reflocationDDArray,$reflocationDDArray,$patient['ADM_WARD']);
                    echo $reflocationDD;
                ?>
            </td>
        </tr>        
        <tr>
            <td>
                Research tag
            </td>
            <td>
                <?php
                /* This is not pretty but it works
                 * Fetches both short_name and long_name from Tags
                 * to print then checks against adm_ResearchTag and
                 * checks any matching rows
                 */ 
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
                    echo "<input type='checkbox' name='$key' id='Tag-$key' $checked><label for='Tag-$key'>$name</label><br />"; 
                }
                ?>
            </td>
        </tr>
    </tbody>
</table>