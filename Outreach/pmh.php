<?php
$keyValue = array( "" => 0, "Yes" => 1, "No" => 2);
$AIDSArray = array();
$lnk_icnID = $Form->hiddenField('lnk_icnID',$patient['LNK_ICNID']);
echo $lnk_icnID;
?>

<td>

    <table>
        <tr>
            <td class="form_labels_pmh">Evidence available to assess</td>
            <td class="RadioTic_pmh">
                <?php
                $evidenceAvailableToAssessOptions = array('Yes' => " Yes ", 'No' => " No ");
                $evidenceAvailableToAssess = $Form->radioBox('pmh-evidenceAvailableToAssess',$evidenceAvailableToAssessOptions,$patient['ICN_EPMH'],'');
                print $evidenceAvailableToAssess;
                ?>
                <!--<input type="radio" class="RadioTic" name="pmh-evidenceAvailableToAssess" value="1"><label class="RadioTic"> Yes </label>
                <input type="radio" class="RadioTic" name="pmh-evidenceAvailableToAssess" value="2"><label class="RadioTic"> No  </label>-->
            </td>
        </tr>
    </table>
    
    <table id="pmh-pmhRadio">
        <tr>
            <td class="form_labels_pmh">Past medical history</td>
            <td class="RadioTic_pmh">
                <?php
                $pastMedicalHistoryOptions = array('Yes' => " Yes ", 'No' => " No ");
                $pastMedicalHistory = $Form->radioBox('pmh-pastMedicalHistory',$pastMedicalHistoryOptions,$patient['ICN_PMHP'],'');
                print $pastMedicalHistory;
                ?>
                <!--<input type="radio" class="RadioTic" name="pmh-pastMedicalHistory" value="1"><label class="RadioTic"> Yes </label>
                <input type="radio" class="RadioTic" name="pmh-pastMedicalHistory" value="2"><label class="RadioTic"> No  </label>-->
            </td>
        </tr>
    </table>
    


                

            <table id="pmh_EvidenceAvailable">
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
            <tr><td colspan='100' class='linebreak_top'>Does the patient have any of these conditions</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>

                <tr>
                    <td class="form_labels_pmh">Biopsy proven cirrhosis</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $Generic_Class = array('pmh_item');
                        $biopsyProvenCirrhosisOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $biopsyProvenCirrhosis = $Form->radioBox('pmh-biopsyProvenCirrhosis',$biopsyProvenCirrhosisOptions,''.$patient['ICN_BPC'].'','',$Generic_Class);
                        print $biopsyProvenCirrhosis;
                        ?>
                    </td>
                    <td class="form_labels_pmh">Radiotherapy</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $radiotherapyOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $radiotherapy = $Form->radioBox('pmh-radiotherapy',$radiotherapyOptions,''.$patient['ICN_RADIOX'].'','',$Generic_Class);
                        print $radiotherapy;
                        ?> 
                    </td>
                </tr>




                <tr>
                    <td class="form_labels_pmh">Portal hypertension</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $portalHypertensionOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $portalHypertension = $Form->radioBox('pmh-portalHypertension',$portalHypertensionOptions,''.$patient['ICN_PH'].'','',$Generic_Class);
                        print $portalHypertension;
                        ?>
                   </td>


                    <td class="form_labels_pmh">Chemotherapy</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $chemotherapyOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $chemotherapy = $Form->radioBox('pmh-chemotherapy',$chemotherapyOptions,''.$patient['ICN_CHEMOX'].'','',$Generic_Class);
                        print $chemotherapy;
                        ?>
                  </td>
                </tr>


                <tr>
                    <td class="form_labels_pmh">Hepatic encephalopathy</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $hepaticEncephalopathyOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $hepaticEncephalopathy = $Form->radioBox('pmh-hepaticEncephalopathy',$hepaticEncephalopathyOptions,''.$patient['ICN_HE'].'','',$Generic_Class);
                        print $hepaticEncephalopathy;
                        ?>
                    </td>

                    <td class="form_labels_pmh">Metastatic disease</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $metastaticDiseaseOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $metastaticDisease = $Form->radioBox('pmh-metastaticDisease',$metastaticDiseaseOptions,''.$patient['ICN_META'].'','',$Generic_Class);
                        print $metastaticDisease;
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class="form_labels_pmh">Very severe cardiovascular disease</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $verySevereCardiovascularDiseaseOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $verySevereCardiovascularDisease = $Form->radioBox('pmh-verySevereCardiovascularDisease',$verySevereCardiovascularDiseaseOptions,''.$patient['ICN_VSCD'].'','',$Generic_Class);
                        print $verySevereCardiovascularDisease;
                        ?>
                    </td>

                    <td class="form_labels_pmh">Acute myelogenous leukaemia, acute lymphocytic leukaemia or multiple myeloma</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $acuteMyelogenousLeukaemiaOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $acuteMyelogenousLeukaemia = $Form->radioBox('pmh-acuteMyelogenousLeukaemia',$acuteMyelogenousLeukaemiaOptions,''.$patient['ICN_AMLALLMM'].'','',$Generic_Class);
                        print $acuteMyelogenousLeukaemia;
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class="form_labels_pmh">Severe respiratory disease</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $severeRespiratoryDiseaseOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $severeRespiratoryDisease = $Form->radioBox('pmh-severeRespiratoryDisease',$severeRespiratoryDiseaseOptions,''.$patient['ICN_SRD'].'','',$Generic_Class);
                        print $severeRespiratoryDisease;
                        ?>
                    </td>

                    <td class="form_labels_pmh">Chronic myelogenous leukaemia or chronic lymphocytic leukaemia</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $chronicMyelogenousLeukaemiaOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $chronicMyelogenousLeukaemia = $Form->radioBox('pmh-chronicMyelogenousLeukaemia',$chronicMyelogenousLeukaemiaOptions,''.$patient['ICN_CMLCLL'].'','',$Generic_Class);
                        print $chronicMyelogenousLeukaemia;
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class="form_labels_pmh">Home ventilation</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $homeVentilationOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $homeVentilation = $Form->radioBox('pmh-homeVentilation',$homeVentilationOptions,''.$patient['ICN_HV'].'','',$Generic_Class);
                        print $homeVentilation;
                        ?>
                    </td>

                    <td class="form_labels_pmh">Lymphoma</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $lymphomaOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $lymphoma = $Form->radioBox('pmh-lymphoma',$lymphomaOptions,''.$patient['ICN_LYM'].'','',$Generic_Class);
                        print $lymphoma;
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class="form_labels_pmh">Chronic renal replacement therapy</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $chronicRenalReplacementTherapyOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $chronicRenalReplacementTherapy = $Form->radioBox('pmh-chronicRenalReplacementTherapy',$chronicRenalReplacementTherapyOptions,''.$patient['ICN_CRRX'].'','',$Generic_Class);
                        print $chronicRenalReplacementTherapy;
                        ?>
                    </td>

                    <td class="form_labels_pmh">Congenital immunohormonal or cellular immune deficiency state</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $congenitalImmunohormonalOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $congenitalImmunohormonal = $Form->radioBox('pmh-congenitalImmunohormonal',$congenitalImmunohormonalOptions,''.$patient['ICN_CICIDS'].'','',$Generic_Class);
                        print $congenitalImmunohormonal;
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class="form_labels_pmh">AIDS</td>
                    <td>
                            <?php
                            $Aids_Class = array('pmh_aids');
                            $dbquery = $Mela_SQL->tbl_LoadItems('AIDS');
                            $AIDSArray = array();
                            $AIDSOptions = array();
                            for ($i = 1; $i < (count($dbquery)+1); $i++) {
                                array_push($AIDSArray,$dbquery[$i]['Long_Name']);
                                array_push($AIDSOptions,$dbquery[$i]['Long_Name']);
                            }
                            
                            $AIDSDD = $Form->dropDown('pmh-AIDS',$AIDSArray,$AIDSOptions,$patient['ICN_AIDS'],'pmh_aids');
                            echo $AIDSDD;
                            ?> 
                    </td>

                    <td class="form_labels_pmh">Steroid treatment</td>
                    <td class="RadioTic_pmh">
                        <?php
                        $steroidTreatmentOptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $steroidTreatment = $Form->radioBox('pmh-steroidTreatment',$steroidTreatmentOptions,''.$patient['ICN_STERX'].'','',$Generic_Class);
                        print $steroidTreatment;
                        ?>
                    </td>
                </tr>
            </table>
</td>