<table class="temp assessmentDetails">
  <tbody>
    <tr>
        <td>
            Assessment Date
        </td>
        <td>
            <?php
            $assessmentHeaderDate = $Form->dateField('assessmentHeaderDate',stringToDateTime($patient['DLK_ASSESSDATE'],2));
            echo $assessmentHeaderDate;
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Start Time
        </td>
        <td>
            <?php
            $assessmentHeaderStartTime = $Form->timeField('assessmentHeaderStartTime',convert4DTime($patient['DLK_ASSESSSTARTTIME']));
            echo $assessmentHeaderStartTime;
            ?>
        </td>
    </tr>
    <tr>
        <td>
            End Time
        </td>
        <td>
            <?php
            $assessmentHeaderEndTime = $Form->timeField('assessmentHeaderEndTime',convert4DTime($patient['DLK_ASSESSENDTIME']));
            echo $assessmentHeaderEndTime;
            
            // Hidden duration calculation field
            $assessmentHeaderDuration = $Form->hiddenField('assessmentHeaderDuration',convert4DTime($patient['DLK_ASSESSDURATION']));
            echo $assessmentHeaderDuration;
            ?>
        </td>
    </tr>
    <?php if ($appName == "Outreach") { ?>
    <tr>
        <td>
            Timeliness of first visit
        </td>
        <td>
            <?php
            $timelinessoptions = array('Timely' => 'Timely', 'Delayed' => 'Delayed');
            $timelinessRadio = $Form->radioBox('ass-timeliness',$timelinessoptions,$patient['TIMELINESS_VISIT'],'');
            echo $timelinessRadio;
            ?>
        </td>
    </tr>
    <tr id="ass-delayed">
        <td>
            Delay
        </td>
        <td>
            <?php
            echo $patient['TIMELINESS_HOURS']." Hours  ";
            echo $patient['TIMELINESS_MINUTES']." Minutes";
            ?>
        </td>
    </tr>
    <?php } ?>
    <tr>
      <td>
        Location
      </td>
      <td>
        <?php
            $locationDDSQL = $Mela_SQL->tbl_LoadItems('Wards');
            $locationDDArray = array();
            for ($i = 1; $i < (count($locationDDSQL)+1); $i++) {
                array_push($locationDDArray,$locationDDSQL[$i]['Long_Name']);
            }

            $locationDD = $Form->dropDown('ass-location',$locationDDArray,$locationDDArray,$patient['OTR_WARD']);
            echo $locationDD;
        ?>
      </td>
    </tr>
    <?php if ($preferences['Location_Bed_and_Bay'] == 'true') { ?>
    <tr>
      <td>
        Bay
      </td>
      <td>
        <?php
            $bayDDSQL = $Mela_SQL->tbl_LoadItems('Location Bays');
            $bayDDArray = array();
            for ($i = 1; $i < (count($bayDDSQL)+1); $i++) {
                array_push($bayDDArray,$bayDDSQL[$i]['Long_Name']);
            }

            $bayDD = $Form->dropDown('ass-bay',$bayDDArray,$bayDDArray,$patient['LOCATION_BAY']);
            echo $bayDD;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Bed
      </td>
      <td>
        <?php
            $bedDDSQL = $Mela_SQL->tbl_LoadItems('Location Beds');
            $bedDDArray = array();
            for ($i = 1; $i < (count($bedDDSQL)+1); $i++) {
                array_push($bedDDArray,$bedDDSQL[$i]['Long_Name']);
            }

            $bedDD = $Form->dropDown('ass-bed',$bedDDArray,$bedDDArray,$patient['LOCATION_BED']);
            echo $bedDD;
        ?>
      </td>
    </tr>
    <?php } ?>
    <?php if ($appName == "Outreach" && ($preferences['prf_Multiple_EWSS'] == 'true')) { ?>
    <tr>
      <td>
        Scoring system
      </td>
      <td>
        <?php
            $scoringDDSQL = $Mela_SQL->tbl_LoadItems('Scoring Systems');
            $scoringDDArray = array();
            for ($i = 1; $i < (count($scoringDDSQL)+1); $i++) {
                array_push($scoringDDArray,$scoringDDSQL[$i]['Long_Name']);
            }

            $scoringDD = $Form->dropDown('ass-scoringSystem',$scoringDDArray,$scoringDDArray,$patient['OTR_SCORINGSYSTEM']);
            echo $scoringDD;
        ?>
      </td>
    </tr>
    <?php } ?>
    <tr>
      <td>
        Assessment reason
      </td>
      <td>
        <?php
            $assessmentReasonDDSQL = $Mela_SQL->tbl_LoadItems('Assessment Reason');
            $assessmentReasonDDArray = array();
            for ($i = 1; $i < (count($assessmentReasonDDSQL)+1); $i++) {
                array_push($assessmentReasonDDArray,$assessmentReasonDDSQL[$i]['Long_Name']);
            }

            $assessmentReasonDD = $Form->dropDown('ass-assessmentReason',$assessmentReasonDDArray,$assessmentReasonDDArray,$patient['OTR_ASSESSMENTREASON']);
            echo $assessmentReasonDD;
        ?>
      </td>
    </tr>
    <tr>
        <td>
            Detail
        </td>
        <td>
        <?php
            $detailDDSQL = $Mela_SQL->tbl_LoadItems('Follow Up');
            $detailDDArray = array();
            for ($i = 1; $i < (count($detailDDSQL)+1); $i++) {
                array_push($detailDDArray,$detailDDSQL[$i]['Long_Name']);
            }

            $detailDD = $Form->dropDown('ass-detail',$detailDDArray,$detailDDArray,$patient['OTR_FOLLOWUP']);
            echo $detailDD;
        ?>
        </td>
    </tr>
    <?php if ($appName == "Outreach") { /* ?>
    <tr>
        <td>
            Reason
        </td>
        <td>
        <?php
            $reasonDDSQL = $Mela_SQL->tbl_LoadItems('Inappropriate Reason');
            $reasonDDArray = array();
            for ($i = 1; $i < (count($reasonDDSQL)+1); $i++) {
                array_push($reasonDDArray,$reasonDDSQL[$i]['Long_Name']);
            }

            $reasonDD = $Form->dropDown('ass-reason',$reasonDDArray,$reasonDDArray,$patient['INAPREASON']);
            echo $reasonDD;
        ?>
        </td>
    </tr>
    <?php */ } ?>
    <tr>
      <td>
        Seen by (role)
      </td>
      <td>
        <?php
            //prf_show3SeenBy
            $seenByRoleDDSQL = $Mela_SQL->tbl_LoadItems('Roles');
            $seenByRoleDDArray = array();
            for ($i = 1; $i < (count($seenByRoleDDSQL)+1); $i++) {
                array_push($seenByRoleDDArray,$seenByRoleDDSQL[$i]['Long_Name']);
            }

            $seenByRoleDD = $Form->dropDown('ass-seenByRole',$seenByRoleDDArray,$seenByRoleDDArray,$patient['OTR_SEENBY']);
            echo $seenByRoleDD;
            
                if ($preferences['prf_show3SeenBy'] == 'true') {
                    $seenByRole1DD = $Form->dropDown('ass-seenByRole1',$seenByRoleDDArray,$seenByRoleDDArray,$patient['OTR_SEENBY1']);
                    echo $seenByRole1DD;
                    
                    $seenByRole2DD = $Form->dropDown('ass-seenByRole2',$seenByRoleDDArray,$seenByRoleDDArray,$patient['OTR_SEENBY2']);
                    echo $seenByRole2DD;
                }
        ?>
      </td>
    </tr>
    <?php if ($preferences['prf_AccompaniedBy'] == 'true') { ?>
    <tr>
        <td>
            Accompanied
        </td>
        <td>
            <?php
            $accompaniedCheck = $Form->checkBox('ass-accompanied','ass-accompanied','',$patient['OTR_ACCOMPANIED_BY'],'');
            echo $accompaniedCheck;
            ?>
        </td>
    </tr>
    <?php } ?>
    <tr>
      <td>
        Seen by (name)
      </td>
      <td>
        <?php            
            $seenByNameDDSQL = $Mela_SQL->getMedicalStaff();
            $seenByNameDDArray = array();
            for ($i = 1; $i < (count($seenByNameDDSQL)+1); $i++) {
                array_push($seenByNameDDArray,$seenByNameDDSQL[$i]['mds_Name']);
            }

            $seenByNameDD = $Form->dropDown('ass-seenByName',$seenByNameDDArray,$seenByNameDDArray,$patient['OTR_SEENBY_NAME']);
            echo $seenByNameDD;
            
                if ($preferences['prf_show3SeenBy'] == 'true') {
                    $seenByName1DD = $Form->dropDown('ass-seenByName1',$seenByNameDDArray,$seenByNameDDArray,$patient['OTR_SEENBY_NAME1']);
                    echo $seenByName1DD;
                    /*if (count($seenByName1DD) <= 1) {
                        $seenByName1DD = "<select class='FormDropDown ' id='ass-seenByName' name='ass-seenByName' ><option value=''>No staff listed</option></select>";    
                    }
                    echo $seenByName1DD;*/
                    
                    $seenByName2DD = $Form->dropDown('ass-seenByName2',$seenByNameDDArray,$seenByNameDDArray,$patient['OTR_SEENBY_NAME2']);
                    echo $seenByName2DD; 
                }
        ?>
      </td>
    </tr>
    <?php if ($preferences['show_ActionTaken'] == 'true') { /* ?>
    <tr>
        <td>
            Action Taken
        </td>
        <td>
            <?php
            $actionTakenDDSQL = $Mela_SQL->tbl_LoadItems('Action');
            $actionTakenDDArray = array();
            for ($i = 1; $i < (count($actionTakenDDSQL)+1); $i++) {
                array_push($actionTakenDDArray,$actionTakenDDSQL[$i]['Long_Name']);
            }

            $actionTakenDD = $Form->dropDown('ass-actionTaken',$actionTakenDDArray,$actionTakenDDArray,$patient['OTR_ACTIONTAKEN']);
            echo $actionTakenDD;
        ?>    
        </td>
    </tr>
    <?php */ } ?>
    <?php if ($preferences['prf_LastSeenBy'] == 'true') { ?>
    <tr>
      <td>
        Last Seen By
      </td>
      <td>
        <?php
            $lastSeenByDDSQL = $Mela_SQL->tbl_LoadItems('Doctor Grades');
            $lastSeenByDDArray = array();
            for ($i = 1; $i < (count($lastSeenByDDSQL)+1); $i++) {
                array_push($lastSeenByDDArray,$lastSeenByDDSQL[$i]['Long_Name']);
            }

            $lastSeenByDD = $Form->dropDown('ass-lastSeenBy',$lastSeenByDDArray,$lastSeenByDDArray,$patient['OTR_LASTSEENBY_GRADE']);
            echo $lastSeenByDD;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Last Seen By Date
      </td>
      <td>
        <?php
            $lastSeenByDate = $Form->dateField('ass-lastSeenByDate',stringToDateTime($patient['OTR_LASTSEENBY_DATE'],2));
            echo $lastSeenByDate;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Last Seen By Time
      </td>
      <td>
        <?php
             $lastSeenByTime = $Form->timeField('ass-lastSeenByTime',convert4DTime($patient['OTR_LASTSEENBY_TIME']));
            echo $lastSeenByTime;
        ?>
      </td>
    </tr>
    <?php } ?>
    <?php /* Apparently these 4 fields are all for Chronic Pain/TV
    <?php if ($appName == "Outreach") { ?>
    <tr>
      <td>
        Visit Type
      </td>
      <td>
        <?php
            $visitTypeDDSQL = $Mela_SQL->tbl_LoadItems('Visit Type');
            $visitTypeDDArray = array();
            for ($i = 1; $i < (count($visitTypeDDSQL)+1); $i++) {
                array_push($visitTypeDDArray,$visitTypeDDSQL[$i]['Long_Name']);
            }

            $visitTypeDD = $Form->dropDown('ass-visitType',$visitTypeDDArray,$visitTypeDDArray,$patient['CHR_VISITTYPE']);
            echo $visitTypeDD;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Appointment Type
      </td>
      <td>
        <?php
            $appointmentTypeDDSQL = $Mela_SQL->tbl_LoadItems('Appointment Type');
            $appointmentTypeDDArray = array();
            for ($i = 1; $i < (count($appointmentTypeDDSQL)+1); $i++) {
                array_push($appointmentTypeDDArray,$appointmentTypeDDSQL[$i]['Long_Name']);
            }

            $appointmentTypeDD = $Form->dropDown('ass-appointmentType',$appointmentTypeDDArray,$appointmentTypeDDArray,$patient['CHR_APPOINTMENTTYPE']);
            echo $appointmentTypeDD;
        ?>
      </td>
    </tr>
    <?php } ?>
    <tr>
      <td>
        Attended
      </td>
      <td>
        <?php
            $attendedOptions = array('True' => ' Yes ', 'False' => ' No ');
            $attended = $Form->radioBox('ass-attended',$attendedOptions,''.$patient['CHR_ATTENDED'].'','');
            print $attended;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Reason
      </td>
      <td>
        <?php
            $reasonNotAttendedDDSQL = $Mela_SQL->tbl_LoadItems('Reason Not Attended');
            $reasonNotAttendedDDArray = array();
            for ($i = 1; $i < (count($reasonNotAttendedDDSQL)+1); $i++) {
                array_push($reasonNotAttendedDDArray,$reasonNotAttendedDDSQL[$i]['Long_Name']);
            }

            $reasonNotAttendedDD = $Form->dropDown('ass-reasonNotAttended',$reasonNotAttendedDDArray,$reasonNotAttendedDDArray,$patient['CHR_WHYNOTATTENDED']);
            echo $reasonNotAttendedDD;
            // The form element below seems out of place but it makes the assessment tag modal window JSON work
        ?>
        <form id="ass-TagsForm">
                        </form>
      </td>
    </tr>
    */ ?>
    <tr>
      <td>
        Assessment Tags
      </td>
      <td>
        <button type='button' style='font-size:small;' id='ass-TagsButton'>Set Tags</button>
            <div id='ass-TagsForm' data-page='secondary' title='Set Assessment Tags'>                       
                <fieldset>
                    <div class="textBox">
                        <form id="ass-TagsForm">
                            <input type="hidden" name="hiddenOTRID" value="<?php echo $patient['DLK_OTRID']; ?>">
                            <?php
                            /* This is not pretty but it works
                             * Fetches both short_name and long_name from Assessment Tags
                             * to print then checks against ResearchTag and
                             * checks any matching rows
                             */ 
                            $researchTagsShortSQL = $Mela_SQL->tbl_LoadItems('Assessment Tags');
                            $researchTagsShortArray = array();
                            for ($i = 1; $i < (count($researchTagsShortSQL)+1); $i++) {
                                array_push($researchTagsShortArray,$researchTagsShortSQL[$i]['Short_Name']);
                            }
                            
                            $researchTagsLongSQL = $Mela_SQL->tbl_LoadItems('Assessment Tags');
                            $researchTagsLongArray = array();
                            for ($i = 1; $i < (count($researchTagsLongSQL)+1); $i++) {
                                array_push($researchTagsLongArray,$researchTagsLongSQL[$i]['Long_Name']);
                            }
                    
                            $patientTags = explode(',',$patient['RESEARCHTAG']);
                            $patientTags = array_map('trim',$patientTags);
                            $researchTagsFull = array_intersect($researchTagsShortArray,$patientTags);
                            
                            foreach ($researchTagsShortArray as $key => $val) {
                                $checked = ($researchTagsFull[$key]) ? "checked" : "";
                                $name = ($researchTagsLongArray[$key]) ? $researchTagsLongArray[$key] : "None";
                                $name = str_replace('>','&gt;',$name);
                                $name = str_replace('<','&lt;',$name);
                                echo "<input type='checkbox' name='ass-Tag_$key' id='assTag_$key' value='".$val."' $checked><label for='assTag_$key'>$name</label><br />"; 
                            }
                            ?>
                        </form>
                            
                        <div id="assTagsResults">                        
                        </div>
                    </div>
                </fieldset>                         
            </div>
      </td>
    </tr>
  </tbody>
</table>
