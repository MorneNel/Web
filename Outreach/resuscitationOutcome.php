<table class='temp'>
    <tbody>
        <tr>
            <td>
                ROSC
            </td>
            <td>
                <?php
                    $rsoROSCOptions = array('1' => ' Yes ', '2' => ' No ');
		    $rsoROSC = $Form->radioBox('rso-faceScale',$rsoROSCOptions,$patient['RESUS_RECOVERY'],'');
		    echo $rsoROSC;
                ?> 
            </td>
        </tr>
        <tr>
            <td>
                ROSC duration
            </td>
            <td>
                <?php
                    $rsoROSCDurationDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Remained For');
                    $rsoROSCDurationDDArray = array();
                    for ($i = 1; $i < (count($rsoROSCDurationDDSQL)+1); $i++) {
                        array_push($rsoROSCDurationDDArray,$rsoROSCDurationDDSQL[$i]['Long_Name']);
                    }
        
                    $rsoROSCDurationDD = $Form->dropDown('rso-ROSCDuration',$rsoROSCDurationDDArray,$rsoROSCDurationDDArray,$patient['RESUS_REMAINED_FOR']);
                    echo $rsoROSCDurationDD;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Induced hypothermia protocol
            </td>
            <td>
                <?php
                    $rsoHypothermiaOptions = array('1' => ' Yes ', '2' => ' No ');
		    $rsoHypothermia = $Form->radioBox('rso-inducedHypothermia',$rsoHypothermiaOptions,$patient['RESUS_HYPOTHERMIA_PROTOCOL'],'');
		    echo $rsoHypothermia;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Neurological status
            </td>
            <td>
                <?php
                    $rsoNeuroStatDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation neurological status');
                    $rsoNeuroStatDDArray = array();
                    for ($i = 1; $i < (count($rsoNeuroStatDDSQL)+1); $i++) {
                        array_push($rsoNeuroStatDDArray,$rsoNeuroStatDDSQL[$i]['Long_Name']);
                    }
        
                    $rsoNeuroStatDD = $Form->dropDown('rso-neuroStat',$rsoNeuroStatDDArray,$rsoNeuroStatDDArray,$patient['NEUROSTAT']);
                    echo $rsoNeuroStatDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Ventilation status
            </td>
            <td>
                <?php
                    $rsoVentStatDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation ventilation status');
                    $rsoVentStatDDArray = array();
                    for ($i = 1; $i < (count($rsoVentStatDDSQL)+1); $i++) {
                        array_push($rsoVentStatDDArray,$rsoVentStatDDSQL[$i]['Long_Name']);
                    }
        
                    $rsoVentStatDD = $Form->dropDown('rso-ventStat',$rsoVentStatDDArray,$rsoVentStatDDArray,$patient['VENTSTAT']);
                    echo $rsoVentStatDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Treatment plan
            </td>
            <td>
                <?php
                    $rsoTreatmentPlanDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation treatment plan');
                    $rsoTreatmentPlanDDArray = array();
                    for ($i = 1; $i < (count($rsoTreatmentPlanDDSQL)+1); $i++) {
                        array_push($rsoTreatmentPlanDDArray,$rsoTreatmentPlanDDSQL[$i]['Long_Name']);
                    }
        
                    $rsoTreatmentPlanDD = $Form->dropDown('rso-treatmentPlan',$rsoTreatmentPlanDDArray,$rsoTreatmentPlanDDArray,$patient['TRTPLANAFTERROSC']);
                    echo $rsoTreatmentPlanDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                DNAR after ROSC
            </td>
            <td>
                <?php
                    $rsoDNAROptions = array('1' => ' Yes ', '2' => ' No ');
		    $rsoDNAR = $Form->radioBox('rso-DNARAfterROSC',$rsoDNAROptions,$patient['DNARAFTERROSC'],'');
		    echo $rsoDNAR;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                DNAR
            </td>
            <td>
                <?php
                    $rsoDNARDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation DNAR');
                    $rsoDNARDDArray = array();
                    for ($i = 1; $i < (count($rsoDNARDDSQL)+1); $i++) {
                        array_push($rsoDNARDDArray,$rsoDNARDDSQL[$i]['Long_Name']);
                    }
        
                    $rsoDNARDD = $Form->dropDown('rso-DNAR',$rsoDNARDDArray,$rsoDNARDDArray,$patient['DNAR']);
                    echo $rsoDNARDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Guidelines adhered to
            </td>
            <td>
                <?php
                    $rsoGuidelinesDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation YN');
                    $rsoGuidelinesDDArray = array();
                    for ($i = 1; $i < (count($rsoGuidelinesDDSQL)+1); $i++) {
                        array_push($rsoGuidelinesDDArray,$rsoGuidelinesDDSQL[$i]['Long_Name']);
                    }
        
                    $rsoGuidelinesDD = $Form->dropDown('rso-Guidelines',$rsoGuidelinesDDArray,$rsoGuidelinesDDArray,$patient['GUILDLINES']);
                    echo $rsoGuidelinesDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Consultant in charge
            </td>
            <td>
                TODO
            </td>
        </tr>
        <tr>
            <td>
                Outcome discharge status
            </td>
            <td>
                <?php
                    $rsoOutcomeDischargeDDSQL = $Mela_SQL->tbl_LoadItems('Discharge Status');
                    $rsoOutcomeDischargeDDArray = array();
                    for ($i = 1; $i < (count($rsoOutcomeDischargeDDSQL)+1); $i++) {
                        array_push($rsoOutcomeDischargeDDArray,$rsoOutcomeDischargeDDSQL[$i]['Long_Name']);
                    }
        
                    $rsoOutcomeDischargeDD = $Form->dropDown('rso-DischargeOutcome',$rsoOutcomeDischargeDDArray,$rsoOutcomeDischargeDDArray,$patient['OUTCOME_STATUS']);
                    echo $rsoOutcomeDischargeDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Date of death
            </td>
            <td>
                <?php
                    $rsoDateOfDeath = $Form->dateField('rso-DateOfDeath',$patient['DEATHDATE']);
                    echo $rsoDateOfDeath;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Time of death
            </td>
            <td>
                <?php
                    $rsoTimeOfDeath = $Form->timeField('rso-TimeOfDeath',$patient['DEATHTIME']);
                    $rsoTODNotDocumented = $Form->checkBox('rso-TimeOfDeathNotDocumented','rso-TimeOfDeathNotDocumented', 'Not documented',$patient['TOD_NOTDOCUMENTED']);
                    echo $rsoTimeOfDeath;
                    echo $rsoTODNotDocumented;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Critical Incident form completed
            </td>
            <td>
                <?php
                    $rsoCritIncFormCompleteOptions = array('1' => ' Yes ', '2' => ' No ');
		    $rsoCritIncFormComplete = $Form->radioBox('rso-CriticalIncidentFormCompleted',$rsoCritIncFormCompleteOptions,$patient['DISCH_CRITINCFORMCOMP'],'');
		    echo $rsoCritIncFormComplete;
                ?>  
            </td>
        </tr>
        <tr>
            <td>
                Incident number
            </td>
            <td>
                <?php
                    $rsoIncidentNumber = $Form->textBox('rso-IncidentNumber',$patient['INCIDENT_FORM_NO']);
                    echo $rsoIncidentNumber;
                ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
        <tr><td colspan='100' class='linebreak_top'></td></tr>
        <tr style='line-height:4px;'><td>&nbsp;</td></tr>

        <tr>      
	    <td width="25%">
		<div class="categoryBox">
		    <?php
			$physExDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation outcome headings');
			$physExDDArray = array();
			for ($i = 1; $i < (count($physExDDSQL)+1); $i++) {
			    array_push($physExDDArray,$physExDDSQL[$i]['Long_Name']);
			}

			foreach($physExDDArray AS $row) {
				echo "<div class='tag' data-type='resusOutcome'>
				      <label class='form_labels'>
				      ".$row."
				      </label>
				      </div>";
			}
                    ?>
		</div>
	    </td>
	    <td>
		<div class="textbox">
		    <textarea class="categoryBox_text" id="resusOutcomeTextArea" name="rso-resusOutcome" rows="15" cols="500"><?php echo $patient['OUTCOMECOMMENTS']; ?></textarea>
		</div>
	    </td>
        </tr>
</table>