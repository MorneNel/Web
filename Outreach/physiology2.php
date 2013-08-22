


<table class='Phys2Table'>
    <thead>
        <tr><td colspan='9' class='linebreak_top'>Last 24 Hrs / since last assessment</td></tr>
        <tr style='line-height:4px;'><td colspan='9'>&nbsp;</td></tr>
    </thead>
</table>


<table class="Phys2Table">
    <tr>


        <td>
            <table class="Phys2Table_SubTab">
                <tr>
                    <td>&nbsp;</td>
                    <td>Lowest</td>
                    <td>Highest</td>
                </tr>

                <tr>
                    <td>C. Temp (&deg;C)</td>
                    <td><?php $lowestCTemp = $Form->textBoxPhysiology('ppa-LowestCTemp',$patient['PPA_LOWESTCTEMPERATURE']); echo $lowestCTemp; ?></td>
                    <td><?php $highestCTemp = $Form->textBoxPhysiology('ppa-HighestCTemp',$patient['PPA_HIGHESTCTEMPERATURE']); echo $highestCTemp; ?></td>
                </tr>

                <tr>
                    <td>Non-C Temp (&deg;C)</td>
                    <td><?php $lowestTemp = $Form->textBoxPhysiology('ppa-LowestTemp',$patient['PPA_LOWESTTEMPERATURE']); echo $lowestTemp; ?></td>
                    <td><?php $highestTemp = $Form->textBoxPhysiology('ppa-HighestTemp',$patient['PPA_HIGHESTTEMPERATURE']); echo $highestTemp; ?></td>
                </tr>

                <tr>
                    <td>Systolic BP (mmHg)</td>
                    <td><?php $lowestSystolicBP = $Form->textBoxPhysiology('ppa-LowestSystolicBP',$patient['PPA_LOWESTSYSTOLIC_BP']); echo $lowestSystolicBP; ?></td>
                    <td><?php $highestSystolicBP = $Form->textBoxPhysiology('ppa-HighestSystolicBP',$patient['PPA_HIGHESTSYSTOLIC_BP']); echo $highestSystolicBP; ?></td>
                </tr>

                <tr>
                    <td>Paired DBP (mmHg)</td>
                    <td><?php $lowestPairedDBP = $Form->textBoxPhysiology('ppa-LowestPairedDBP',$patient['PPA_LOWESTPAIREDDIASBP']); echo $lowestPairedDBP; ?></td>
                    <td><?php $highestPairedDBP = $Form->textBoxPhysiology('ppa-HighestPairedDBP',$patient['PPA_HIGHESTPAIREDDIASBP']); echo $highestPairedDBP; ?></td>
                </tr>

                <tr>
                    <td>Diastolic BP (mmHg)</td>
                    <td><?php $lowestDiastolicBP = $Form->textBoxPhysiology('ppa-LowestDiastolicBP',$patient['PPA_LOWESTDIASTOLIC_BP']); echo $lowestDiastolicBP; ?></td>
                    <td><?php $highestDiastolicBP = $Form->textBoxPhysiology('ppa-HighestDiastolicBP',$patient['PPA_HIGHESTDIASTOLIC_BP']); echo $highestDiastolicBP; ?></td>
                </tr>

                <tr>
                    <td>Paired SBP (mmHg)</td>
                    <td><?php $lowestPairedSBP = $Form->textBoxPhysiology('ppa-LowestPairedSBP',$patient['PPA_LOWESTPAIREDSYSBP']); echo $lowestPairedSBP; ?></td>
                    <td><?php $highestPairedSBP = $Form->textBoxPhysiology('ppa-HighestPairedSBP',$patient['PPA_HIGHESTPAIREDSYSBP']); echo $highestPairedSBP; ?></td>
                </tr>

                <tr>
                    <td>HR (b/min)</td>
                    <td><?php $lowestHR = $Form->textBoxPhysiology('ppa-LowestHR',$patient['PPA_LOWESTHEARTRATE']); echo $lowestHR; ?></td>
                    <td><?php $highestHR = $Form->textBoxPhysiology('ppa-HighestHR',$patient['PPA_HIGHESTHEARTRATE']); echo $highestHR; ?></td>
                </tr>

                <tr>
                    <td>RR (/min)</td>
                    <td><?php $lowestRespiratoryRate = $Form->textBoxPhysiology('ppa-LowestRespiratoryRate',$patient['PPA_LOWESTRESPIRATORYRATE']); echo $lowestRespiratoryRate; ?></td>
                    <td><?php $highestRespiratoryRate = $Form->textBoxPhysiology('ppa-HighestRespiratoryRate',$patient['PPA_HIGHESTRESPIRATORYRATE']); echo $highestRespiratoryRate; ?></td>
                </tr>

                <tr>
                    <td>O2 Sat (%)</td>
                    <td><?php $lowestO2Saturation = $Form->textBoxPhysiology('ppa-LowestO2Saturation',$patient['PPA_LOWESTO2SATURATION']); echo $lowestO2Saturation; ?></td>
                    <td><?php $highestO2Saturation = $Form->textBoxPhysiology('ppa-HighestO2Saturation',$patient['PPA_HIGHESTO2SATURATION']); echo $highestO2Saturation; ?></td>
                </tr>

                <tr>
                    <td>Urine Output</td>
                    <td><?php $lowestUrineOutput = $Form->textBoxPhysiology('ppa-LowestUrineOutput',$patient['PPA_LOWESTURINEOUTPUT']); echo $lowestUrineOutput; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td>Fluid Input</td>
                    <td><?php $fluidInput = $Form->textBoxPhysiology('ppa-FluidInput',$patient['PPA_FLUID_INPUT']); echo $fluidInput; ?></td>
                    <td>&nbsp;</td>
                </tr>


            </table>
        </td>


        <td>
            <table class="Phys2Table_SubTab">
                <tr>
                    <td>&nbsp;</td>
                    <td>Lowest</td>
                    <td>Highest</td>
                </tr>

                <tr>
                    <td>S Bicarb (mmol/l)</td>
                    <td><?php $lowestBicarbonate = $Form->textBoxPhysiology('ppa-LowestBicarbonate',$patient['PPA_LOWESTBICARBONATE']); echo $lowestBicarbonate; ?></td>
                    <td><?php $highestBicarbonate = $Form->textBoxPhysiology('ppa-HighestBicarbonate',$patient['PPA_HIGHESTBICARBONATE']); echo $highestBicarbonate; ?></td>
                </tr>

                <tr>
                    <td>S Sodium (mmol/l)</td>
                    <td><?php $lowestSodium = $Form->textBoxPhysiology('ppa-LowestSodium',$patient['PPA_LOWESTNA']); echo $lowestSodium; ?></td>
                    <td><?php $highestSodium = $Form->textBoxPhysiology('ppa-HighestSodium',$patient['PPA_HIGHESTNA']); echo $highestSodium; ?></td>
                </tr>

                <tr>
                    <td>S Potassium (mmol/l)</td>
                    <td><?php $lowestPotassium = $Form->textBoxPhysiology('ppa-LowestPotassium',$patient['PPA_LOWESTK']); echo $lowestPotassium; ?></td>
                    <td><?php $highestPotassium = $Form->textBoxPhysiology('ppa-HighestPotassium',$patient['PPA_HIGHESTK']); echo $highestPotassium; ?></td>
                </tr>

                <tr>
                    <td>S Urea (mmol/l)</td>
                    <td><?php $lowestUrea = $Form->textBoxPhysiology('ppa-LowestUrea',$patient['PPA_LOWESTUREA']); echo $lowestUrea; ?></td>
                    <td><?php $highestUrea = $Form->textBoxPhysiology('ppa-HighestUrea',$patient['PPA_HIGHESTUREA']); echo $highestUrea; ?></td>
                </tr>

                <tr>
                    <td>S Creatinine (&micro; mol/l)</td>
                    <td><?php $lowestCreatinine = $Form->textBoxPhysiology('ppa-LowestCreatinine',$patient['PPA_LOWESTCREATININE']); echo $lowestCreatinine; ?></td>
                    <td><?php $highestCreatinine = $Form->textBoxPhysiology('ppa-HighestCreatinine',$patient['PPA_HIGHESTCREATININE']); echo $highestCreatinine; ?></td>
                </tr>

                <tr>
                    <td>S Glucose (mmol/l)</td>
                    <td><?php $lowestGlucose = $Form->textBoxPhysiology('ppa-LowestGlucose',$patient['PPA_LOWESTGLUCOSE']); echo $lowestGlucose; ?></td>
                    <td><?php $highestGlucose = $Form->textBoxPhysiology('ppa-HighestGlucose',$patient['PPA_HIGHESTGLUCOSE']); echo $highestGlucose; ?></td>
                </tr>

                <tr>
                    <td>S Calcium (mmol/l)</td>
                    <td><?php $lowestCalcium = $Form->textBoxPhysiology('ppa-LowestCalcium',$patient['PPA_LOWESTCALCIUM']); echo $lowestCalcium; ?></td>
                    <td><?php $highestCalcium = $Form->textBoxPhysiology('ppa-HighestCalcium',$patient['PPA_HIGHESTCALCIUM']); echo $highestCalcium; ?></td>
                </tr>

                <tr>
                    <td>S Albumin (g/l)</td>
                    <td><?php $lowestAlbumin = $Form->textBoxPhysiology('ppa-LowestAlbumin',$patient['PPA_LOWESTALBUMIN']); echo $lowestAlbumin; ?></td>
                    <td><?php $highestAlbumin = $Form->textBoxPhysiology('ppa-HighestAlbumin',$patient['PPA_HIGHESTALBUMIN']); echo $highestAlbumin; ?></td>
                </tr>

                <tr>
                    <td>CPAP</td>
                    <td><?php $CPAPoptions = array('Yes' => ' Yes ', 'No' => ' No '); $CPAP = $Form->radioBox('ppa-CPAP',$CPAPoptions,$patient['PPA_CPAP'],''); echo $CPAP; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td>Worst AVPU</td>
                    <td colspan="2"><?php
                            $worstAVPUDDSQL = $Mela_SQL->tbl_LoadItems('AVPU');
                            $worstAVPUDDArray = array();
                            for ($i = 1; $i < (count($worstAVPUDDSQL)+1); $i++) {
                                array_push($worstAVPUDDArray,$worstAVPUDDSQL[$i]['Long_Name']);
                            }
                
                            $worstAVPUDD = $Form->dropDown('ppa-WorstAVPU',$worstAVPUDDArray,$worstAVPUDDArray,$patient['PPA_WORSTAVPU'],'Phys2DDShort');
                            echo $worstAVPUDD;
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Worst Pain</td>
                    <td colspan="2"><?php
                            $worstPainDDSQL = $Mela_SQL->tbl_LoadItems('PAIN');
                            $worstPainDDArray = array();
                            for ($i = 1; $i < (count($worstPainDDSQL)+1); $i++) {
                                array_push($worstPainDDArray,$worstPainDDSQL[$i]['Long_Name']);
                            }
                
                            $worstPainDD = $Form->dropDown('ppa-worstPain',$worstPainDDArray,$worstPainDDArray,$patient['PPA_PAIN'],'Phys2DDShort');
                            echo $worstPainDD;
                        ?>
                    </td>
                </tr>

            </table>
        </td>


        <td>
            <table class="Phys2Table_SubTab">
                <tr>
                    <td>&nbsp;</td>
                    <td>Lowest</td>
                    <td>Highest</td>
                </tr>

                <tr>
                    <td>WBC Count (x10<sup>9</sup>/l)</td>
                    <td><?php $lowestWBC = $Form->textBoxPhysiology('ppa-LowestWhiteCellCount',$patient['PPA_LOWESTWHITECELLCOUNT']); echo $lowestWBC; ?></td>
                    <td><?php $highestWBC = $Form->textBoxPhysiology('ppa-HighestWhiteCellCount',$patient['PPA_HIGHESTWHITECELLCOUNT']); echo $highestWBC; ?></td>
                </tr>

                <tr>
                    <td>Haematocrit (%)</td>
                    <td><?php $lowestHaematocrit = $Form->textBoxPhysiology('ppa-LowestHaematocrit',$patient['PPA_LOWESTHAEMOCRIT']); echo $lowestHaematocrit; ?></td>
                    <td><?php $highestHaematocrit = $Form->textBoxPhysiology('ppa-HighestHaematocrit',$patient['PPA_HIGHESTHAEMOCRIT']); echo $highestHaematocrit;?></td>
                </tr>

                <tr>
                    <td>Haemoglobin (g/dl)</td>
                    <td><?php $lowestHaemoglobin = $Form->textBoxPhysiology('ppa-LowestHaemoglobin',$patient['PPA_LOWESTHB']); echo $lowestHaemoglobin; ?></td>
                    <td><?php $highestHaemoglobin = $Form->textBoxPhysiology('ppa-HighestHaemoglobin',$patient['PPA_HIGHESTHB']); echo $highestHaemoglobin; ?></td>
                </tr>

                <tr>
                    <td>Platelet Count (x10<sup>9</sup>/l)</td>
                    <td><?php $lowestPlateletCount = $Form->textBoxPhysiology('ppa-LowestPlateletCount',$patient['PPA_LOWESTPLATELETCOUNT']); echo $lowestPlateletCount; ?></td>
                    <td><?php $highestPlateletCount = $Form->textBoxPhysiology('ppa-HighestPlateletCount',$patient['PPA_HIGHESTPLATELETCOUNT']); echo $highestPlateletCount; ?></td>
                </tr>

                <tr>
                    <td>Prothrombin <?php echo $preferences['PRF_PROTHROMBIN']; ?></td>
                    <td><?php $lowestProthrombin = $Form->textBoxPhysiology('ppa-LowestProthrombin',$patient['PPA_LOWESTPROTHROMBIN']); echo $lowestProthrombin; ?></td>
                    <td><?php $highestProthrombin = $Form->textBoxPhysiology('ppa-HighestProthrombin',$patient['PPA_HIGHESTPROTHROMBIN']); echo $highestProthrombin; ?></td>
                </tr>

                <tr>
                    <td>APTT (<?php echo $preferences['PRF_THROMBOPLASTIN']; ?>)</td>
                    <td><?php $lowestThromboplastin = $Form->textBoxPhysiology('ppa-LowestThromboplastin',$patient['PPA_LOWESTTHROMBOPLASTIN']); echo $lowestThromboplastin; ?></td>
                    <td><?php $highestThromboplastin = $Form->textBoxPhysiology('ppa-HighestThromboplastin',$patient['PPA_HIGHESTTHROMBOPLASTIN']); echo $highestThromboplastin; ?></td>
                </tr>

                <tr>
                    <td>Trans AST (lU/l)</td>
                    <td><?php $lowestAST = $Form->textBoxPhysiology('ppa-LowestAST',$patient['PPA_LOWESTAST']); echo $lowestAST; ?></td>
                    <td><?php $highestAST = $Form->textBoxPhysiology('ppa-HighestAST',$patient['PPA_HIGHESTAST']); echo $highestAST; ?> </td>
                </tr>

                <tr>
                    <td>Trans ALT (lU/l)</td>
                    <td><?php $lowestALT = $Form->textBoxPhysiology('ppa-LowestALT',$patient['PPA_LOWESTALT']); echo $lowestALT; ?></td>
                    <td><?php $highestALT = $Form->textBoxPhysiology('ppa-HighestALT',$patient['PPA_HIGHESTALT']); echo $highestALT; ?></td>
                </tr>

                <tr>
                    <td>Amylase (lU/l)</td>
                    <td><?php $lowestAmylase = $Form->textBoxPhysiology('ppa-LowestAmylase',$patient['PPA_LOWESTAMYLASE']); echo $lowestAmylase; ?></td>
                    <td><?php $highestAmylase = $Form->textBoxPhysiology('ppa-HighestAmylase',$patient['PPA_HIGHESTAMYLASE']); echo $highestAmylase; ?></td>
                </tr>

                <tr>
                    <td>Alkaline Phosp (lU/l)</td>
                    <td><?php $lowestAlkaline = $Form->textBoxPhysiology('ppa-LowestAlkaline',$patient['PPA_LOWESTALKALINE']); echo $lowestAlkaline; ?></td>
                    <td><?php $highestAlkaline = $Form->textBoxPhysiology('ppa-HighestAlkaline',$patient['PPA_HIGHESTALKALINE']); echo $highestAlkaline; ?></td>
                </tr>


                <tr>
                    <td>S Bilirubin (&micro; mol/l)</td>
                    <td><?php $lowestBilirubin = $Form->textBoxPhysiology('ppa-LowestBilirubin',$patient['PPA_LOWESTBILIRUBIN']); echo $lowestBilirubin; ?></td>
                    <td><?php $highestBilirubin = $Form->textBoxPhysiology('ppa-HighestBilirubin',$patient['PPA_HIGHESTBILIRUBUN']); echo $highestBilirubin; ?></td>
                </tr>



            </table>
        </td>


    </tr>
</table>

<br />
<br />

<table class="Phys2Table_mid">
    <tr>
        <td>
            <div class="Phys2Table_mid_div">
            <table class="Phys2Table_mid_sub">

                <tr><td colspan='2' class='linebreak_top'>Worst GCS</td></tr>
                <tr style='line-height:4px;'><td colspan='2'>&nbsp;</td></tr>
                <tr>
                    <td>Eyes</td>
                    <td>
                        <?php
                            $GCSEyesDDSQL = $Mela_SQL->tbl_LoadItems('GCS Eyes');
                            $GCSEyesDDArray = array();
                            for ($i = 1; $i < (count($GCSEyesDDSQL)+1); $i++) {
                                array_push($GCSEyesDDArray,$GCSEyesDDSQL[$i]['Long_Name']);
                            }
                
                            $GCSEyesDD = $Form->dropDown('ppa-GCSEyes',$GCSEyesDDArray,$GCSEyesDDArray,$patient['PPA_GCS_EYES'],'Phys2Table_mid_div');
                            echo $GCSEyesDD;
                        ?>    
                    </td>
                </tr>

                <tr>
                    <td>Motor</td>
                    <td>
                        <?php
                            $GCSMotorDDSQL = $Mela_SQL->tbl_LoadItems('GCS Motor');
                            $GCSMotorDDArray = array();
                            for ($i = 1; $i < (count($GCSMotorDDSQL)+1); $i++) {
                                array_push($GCSMotorDDArray,$GCSMotorDDSQL[$i]['Long_Name']);
                            }
                
                            $GCSMotorDD = $Form->dropDown('ppa-GCSMotor',$GCSMotorDDArray,$GCSMotorDDArray,$patient['PPA_GCS_MOTOR'],'Phys2Table_mid_div');
                            echo $GCSMotorDD;
                        ?>    
                    </td>
                </tr>

                <tr>
                    <td>Verbal</td>
                    <td>
                        <?php
                            $GCSVerbalDDSQL = $Mela_SQL->tbl_LoadItems('GCS Verbal');
                            $GCSVerbalDDArray = array();
                            for ($i = 1; $i < (count($GCSVerbalDDSQL)+1); $i++) {
                                array_push($GCSVerbalDDArray,$GCSVerbalDDSQL[$i]['Long_Name']);
                            }
                
                            $GCSVerbalDD = $Form->dropDown('ppa-GCSVerbal',$GCSVerbalDDArray,$GCSVerbalDDArray,$patient['PPA_GCS_VERBAL'],'Phys2Table_mid_div');
                            echo $GCSVerbalDD;
                        ?>    
                    </td>
                </tr>

                <tr>
                    <td>Total</td>
                    <td>
                        <?php
                                $worstGCS = $Form->textBox('ppa-WorstGCS',$patient['PPA_WORSTGCS'],'','','Phys2Table_mid_div');
                                echo $worstGCS;
                        ?>    
                    </td>
                </tr>

            </table>
            </div>


        </td>

        <td>&nbsp;</td>

        <td>
            <div class="Phys2Table_mid_div">
                <table width="300">
                    <tr><td colspan='2' class='linebreak_top'>Blood Gasses</td></tr>
                    <tr style='line-height:4px;'><td colspan='2'>&nbsp;</td></tr>

                    <tr>
                        <td>PaO2</td>
                        <td><?php $PAO2 = $Form->textBoxPhysiology('ppa-WorstPAO2',$patient['PPA_PAO2']); echo $PAO2 . $preferences['PRF_PAO2']; ?></td>
                    </tr>
                    <tr>
                        <td>Associated FIO2</td>
                        <td><?php $associatedFIO2 = $Form->textBoxPhysiology('ppa-AssociatedFIO2',$patient['PPA_LOWESTFIO2']); echo $associatedFIO2; ?></td>
                    </tr>
                    <tr>
                        <td>Associated PaCO2</td>
                        <td><?php $associatedPacO2 = $Form->textBoxPhysiology('ppa-AssociatedPacO2',$patient['PPA_LOWESTPACO2']); echo $associatedPacO2 . $preferences['PRF_PACO2']; ?></td>
                    </tr>
                    <tr>
                        <td>Associated pH/H+</td>
                        <td><?php $associatedPH = $Form->textBoxPhysiology('ppa-AssociatedPH',$patient['PPA_LOWESTPH']); echo $associatedPH . $preferences['PRF_PH']; ?></td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>

<br />
<br />

<div class="Phys2Table_mid_div">
<table class="Phys2Table">
    <tr>

        <td>
            <table>
                <tr><td colspan='2' class='linebreak_top'>APACHE II</td></tr>
                <tr style='line-height:4px;'><td colspan='2'>&nbsp;</td></tr>
                <tr>
                    <td><button type='button'>Score</button></td>
                    <td><?php $APACHEIIScore = $Form->textBoxPhysiology('ppa-APACHEIIScore',$patient['PPA_APACHEII']); echo $APACHEIIScore; ?></td>
                </tr>
                <tr>
                    <td>Probability</td>
                    <td><?php $APACHEIIProb = $Form->textBoxPhysiology('ppa-APACHEIIProb',$patient['PPA_APACHEII_PROB']); echo $APACHEIIProb; ?></td>
                </tr>
            </table>
        </td>

        <td>&nbsp;</td>

        <td>
            <table>
                <tr><td colspan='2' class='linebreak_top'>SAPS II</td></tr>
                <tr style='line-height:4px;'><td colspan='2'>&nbsp;</td></tr>
                <tr>
                    <td><button type='button'>Score</button></td>
                    <td><?php $SAPSIIScore = $Form->textBoxPhysiology('ppa-SAPSIIScore',$patient['PPA_SAPSII']); echo $SAPSIIScore; ?></td>
                </tr>
                <tr>
                    <td>Probability</td>
                    <td><?php $SAPSIIProb = $Form->textBoxPhysiology('ppa-SAPSIIProb',$patient['PPA_SAPSII_PROB']); echo $SAPSIIProb; ?></td>
                </tr>
            </table>
        </td>

    </tr>
</table>
</div>

