<?php $prefix = array(" mmol / l", " &micro;mol / l", " mg / dl", " vsUnitsProtein", " g / l", " x10 <sup>9</sup> / l", " %", " g / dl", " U / l"); ?>

<table class='temp Phys1B_container_Table'>
    <tr>

        <td class='Phys1B_container_Row'>
            <?php if ($preferences['prf_Show_Test_DateTime'] == 'true') { ?>
            <table class='temp Phys1BTable'>
                <tr style='line-height:14px;'><td colspan='2'>&nbsp;</td></tr>
                <tr><td colspan='2' class='linebreak_top'>Test Date & Time</td></tr>
                <tr style='line-height:4px;'><td colspan='2'>&nbsp;</td></tr>
                <tr>
                    <td class="Phys1BRow">
                        
                        Test Date
                    </td>
                    <td class="Phys1BRow">
                        <?php
                            $physTestDate = $Form->dateField('phys2-testDate',stringToDateTime($patient['PAT_BLOOD_TEST_DATE'],2));
                            echo $physTestDate;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="Phys1BRow">
                    Test Time
                    </td>
                    <td class="Phys1BRow">
                        <?php
                            $physTestTime = $Form->timeField('phys2-testTime',convert4DTime($patient['PAT_BLOOD_TEST_TIME']));
                            echo $physTestTime;
                        ?>
                    </td>
                </tr>
            </table>
            <?php } ?>

            <table class='temp Phys1BTable'>
                    <tr style='line-height:14px;'><td colspan='2'>&nbsp;</td></tr>
                    <tr><td colspan='2' class='linebreak_top'>Serum concentrations</td></tr>
                    <tr style='line-height:4px;'><td colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="Phys1BRow">Serum Bicarbonate</td>
                        <td class="Phys1BRow">
                            <?php
                                $physSerumBicarbonate = $Form->textBoxPhysiology('phys2-serumBicarbonate',$patient['PAT_SERUM_BICARBONATE'],'','','PhysiologyField');
                                echo $physSerumBicarbonate . $prefix[0];
                                //echo $patient['PAT_SERUM_BICARBONATE'] . $prefix[0];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Serum Sodium</td>
                        <td class="Phys1BRow">
                            <?php
                                $physSerumSodium = $Form->textBoxPhysiology('phys2-serumSodium',$patient['PAT_SERUM_NA'],'','','PhysiologyField');
                                echo $physSerumSodium . $prefix[0];
                                //echo $patient['PAT_SERUM_NA'] . $prefix[0];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Serum Potassium</td>
                        <td class="Phys1BRow">
                            <?php
                                $physSerumPotassium = $Form->textBoxPhysiology('phys2-serumPotassium',$patient['PAT_SERUM_K'],'','','PhysiologyField');
                                echo $physSerumPotassium . $prefix[0];
                                //echo $patient['PAT_SERUM_K'] . $prefix[0];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Serum Urea</td>
                        <td class="Phys1BRow">
                            <?php
                                $physSerumUrea = $Form->textBoxPhysiology('phys2-serumUrea',$patient['PAT_SERUM_UREA'],'','','PhysiologyField');
                                echo $physSerumUrea . $prefix[0];
                                //echo $patient['PAT_SERUM_UREA'] . $prefix[0];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Serum Creatinine</td>
                        <td class="Phys1BRow">
                            <?php
                                $physSerumCreatinine = $Form->textBoxPhysiology('phys2-serumCreatinine',$patient['PAT_SERUM_CREATININE'],'','','PhysiologyField');
                                echo $physSerumCreatinine . $prefix[1];
                                //echo $patient['PAT_SERUM_CREATININE'] . $prefix[1];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Serum Glucose</td>
                        <td class="Phys1BRow">
                            <?php
                                $physSerumGlucose = $Form->textBoxPhysiology('phys2-serumGlucose',$patient['PAT_SERUM_GLUCOSE'],'','','PhysiologyField');
                                echo $physSerumGlucose . $prefix[0];
                                //echo $patient['PAT_SERUM_GLUCOSE'] . $prefix[0];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Serum Calcium</td>
                        <td class="Phys1BRow">
                            <?php
                                $physSerumCalcium = $Form->textBoxPhysiology('phys2-serumCalcium',$patient['PAT_SERUM_CA'],'','','PhysiologyField');
                                echo $physSerumCalcium . $prefix[0];
                                //echo $patient['PAT_SERUM_CA'] . $prefix[0];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Inorganic Phosphate</td>
                        <td class="Phys1BRow">
                            <?php
                                $physInorganicPhosphate = $Form->textBoxPhysiology('phys2-InorganicPhosphate',$patient['PAT_INORGANICPHOSPHATE'],'','','PhysiologyField');
                                echo $physInorganicPhosphate . $prefix[2];
                                //echo $patient['PAT_INORGANICPHOSPHATE'] . $prefix[2];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Total Protein</td>
                        <td class="Phys1BRow">
                            <?php
                                $physTotalProtein = $Form->textBoxPhysiology('phys2-TotalProtein',$patient['PAT_TOTALPROTEIN'],'','','PhysiologyField');
                                echo $physTotalProtein . " " . $preferences['TotalProteinUnits'];
                                //echo $patient['PAT_TOTALPROTEIN'] . $preferences['TotalProteinUnits'];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Serum Albumin</td>
                        <td class="Phys1BRow">
                            <?php
                                $physSerumAlbumin = $Form->textBoxPhysiology('phys2-SerumAlbumin',$patient['PAT_SERUM_ALBUMIN'],'','','PhysiologyField');
                                echo $physSerumAlbumin . $prefix[4];
                                //echo $patient['PAT_SERUM_ALBUMIN'] . $prefix[4];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Serum Magnesium</td>
                        <td class="Phys1BRow">
                            <?php
                                $physSerumMagnesium = $Form->textBoxPhysiology('phys2-SerumMagnesium',$patient['PAT_SERUM_MG'],'','','PhysiologyField');
                                echo $physSerumMagnesium . $prefix[0];
                                //echo $patient['PAT_SERUM_MG'] . $prefix[0];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Blood Lactate</td>
                        <td class="Phys1BRow">
                            <?php
                                $physBloodLactate = $Form->textBoxPhysiology('phys2-BloodLactate',$patient['PAT_BLOOD_LACTATE'],'','','PhysiologyField');
                                echo $physBloodLactate. $prefix[0];
                                //echo $patient['PAT_BLOOD_LACTATE'] . $prefix[0];
                            ?>    
                        </td>
                    </tr>
            </table>
        </td>












        <td class='Phys1B_container_Row'>
            <table class='temp Phys1BTable'>
                    <tr style='line-height:14px;'><td colspan="2" class="Phys1BRow">&nbsp;</td></tr>
                    <tr><td colspan='2' class='linebreak_top'>Haematology</td></tr>
                    <tr style='line-height:4px;'><td colspan="2" class="Phys1BRow">&nbsp;</td></tr>
                    <tr>
                        <td class="Phys1BRow">WBC Count</td>
                        <td class="Phys1BRow">
                            <?php
                                $physWBCCount = $Form->textBoxPhysiology('phys2-WBCCount',$patient['PAT_WHITE_CELL_COUNT'],'','','PhysiologyField');
                                echo $physWBCCount. $prefix[5];
                                //echo $patient['PAT_WHITE_CELL_COUNT'] . $prefix[5];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Haematocrit</td>
                        <td class="Phys1BRow">
                            <?php
                                $physHaematocrit = $Form->textBoxPhysiology('phys2-Haematocrit',$patient['PAT_SERUM_HAEMATOCRIT'],'','','PhysiologyField');
                                echo $physHaematocrit. $prefix[6];
                                //echo $patient['PAT_SERUM_HAEMATOCRIT'] . $prefix[6];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Haematoglobin</td>
                        <td class="Phys1BRow">
                            <?php
                                $physHaematoglobin = $Form->textBoxPhysiology('phys2-Haematoglobin',$patient['PAT_SERUM_HB'],'','','PhysiologyField');
                                echo $physHaematoglobin. $prefix[7];
                                //echo $patient['PAT_SERUM_HB'] . $prefix[7];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Platelet Count</td>
                        <td class="Phys1BRow">
                            <?php
                                $physPlateletCount = $Form->textBoxPhysiology('phys2-PlateletCount',$patient['PAT_PLATELET'],'','','PhysiologyField');
                                echo $physPlateletCount. $prefix[5];
                                //echo $patient['PAT_PLATELET'] . $prefix[5];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Prothrombin Time</td>
                        <td class="Phys1BRow">
                            <?php
                                $physProthrombinTime = $Form->textBoxPhysiology('phys2-ProthrombinTime',$patient['PAT_PROTHROMBIN'],'','','PhysiologyField');
                                echo $physProthrombinTime. " " . $preferences['prf_Prothrombin'];
                                //echo $patient['PAT_PROTHROMBIN'] . $preferences['prf_Prothrombin'];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">APTT</td>
                        <td class="Phys1BRow">
                            <?php
                                $physAPTT = $Form->textBoxPhysiology('phys2-APTT',$patient['PAT_THROMBOPLASTIN'],'','','PhysiologyField');
                                echo $physAPTT. " " . $preferences['prf_Thromboplastin'];
                                //echo $patient['PAT_THROMBOPLASTIN'] . $preferences['prf_Thromboplastin'];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">INR</td>
                        <td class="Phys1BRow">
                            <?php
                                $physINR = $Form->textBoxPhysiology('phys2-INR',$patient['PAT_INR'],'','','PhysiologyField');
                                echo $physINR;
                                //echo $patient['PAT_INR'];
                            ?>    
                        </td>
                    </tr>
            </table>


            <table class='temp Phys1BTable'>
                <tr style='line-height:14px;'><td colspan='2'>&nbsp;</td></tr>
                <tr><td colspan='2' class='linebreak_top'>Liver functions</td></tr>
                <tr style='line-height:4px;'><td colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="Phys1BRow">Amylase</td>
                        <td class="Phys1BRow">
                            <?php
                                $physAmylase = $Form->textBoxPhysiology('phys2-Amylase',$patient['PAT_AMYLASE'],'','','PhysiologyField');
                                echo $physAmylase. $prefix[8];
                                //echo $patient['PAT_AMYLASE'] . $prefix[8];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Alkaline Phosphatase ALP</td>
                        <td class="Phys1BRow">
                            <?php
                                $physAlkalinePhosphate = $Form->textBoxPhysiology('phys2-AlkalinePhosphate',$patient['PAT_ALKALINEPO4'],'','','PhysiologyField');
                                echo $physAlkalinePhosphate. $prefix[8];
                                //echo $patient['PAT_ALKALINEPO4'] . $prefix[8];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Transanimase AST</td>
                        <td class="Phys1BRow">
                            <?php
                                $physAST = $Form->textBoxPhysiology('phys2-AST',$patient['PAT_AST'],'','','PhysiologyField');
                                echo $physAST. $prefix[8];
                                //echo $patient['PAT_AST'] . $prefix[8];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Transanimase ALT</td>
                        <td class="Phys1BRow">
                            <?php
                                $physALT = $Form->textBoxPhysiology('phys2-ALT',$patient['PAT_ALT'],'','','PhysiologyField');
                                echo $physALT. $prefix[8];
                                //echo $patient['PAT_ALT'] . $prefix[8];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">Serum Bilirubin</td>
                        <td class="Phys1BRow">
                            <?php
                                $physSerumBilirubin = $Form->textBoxPhysiology('phys2-SerumBilirubin',$patient['PAT_SERUM_BILIRUBIN'],'','','PhysiologyField');
                                echo $physSerumBilirubin. $prefix[1];
                                //echo $patient['PAT_SERUM_BILIRUBIN'] . $prefix[1];
                            ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class="Phys1BRow">GGT</td>
                        <td class="Phys1BRow">
                            <?php
                                $physGGT = $Form->textBoxPhysiology('phys2-GGT',$patient['PAT_GGT'],'','','PhysiologyField');
                                echo $physGGT. $prefix[8];
                                //echo $patient['PAT_GGT'] . $prefix[8];
                            ?>    
                        </td>
                    </tr>
            </table>
        </td>



    </tr>
</table>


    





