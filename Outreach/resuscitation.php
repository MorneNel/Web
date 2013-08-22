<table class='temp'>
    <tbody>
        <tr>
            <td>
                Completed by
            </td>
            <td>
                <?php
                    /*$completedByDDSQL = $Mela_SQL->tbl_LoadItems('Hospital Discharge Destination');
                    $completedByDDArray = array();
                    for ($i = 1; $i < (count($completedByDDSQL)+1); $i++) {
                        array_push($completedByDDArray,$completedByDDSQL[$i]['Long_Name']);
                    }
        
                    $completedByDD = $Form->dropDown('rs-completedBy',$completedByDDArray,$completedByDDArray,$patient['COMPLETEDBY']);
                    echo "???"; //echo $completedByDD;;*/
                ?>
                <?php
                $completedByFields = array();
                $completedByValues = array();
                $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE Resus=True AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
                try { 
                    $selectResult = odbc_exec($connect,$sql); 
                        if($selectResult){ 
                                while ($completedBy = odbc_fetch_array($selectResult)) {
                                    array_push($completedByFields, $completedBy['MDS_NAME']);
                                    array_push($completedByValues, $completedBy['MDS_ID']);
                                }
                            }
                        else{ 
                        throw new RuntimeException("Failed to connect."); 
                        } 
                            } 
                        catch (RuntimeException $e) { 
                                print("Exception caught: $e");
                                //exit;
                        }
                $completedByDD = $Form->dropDown('rs-completedBy',$completedByFields,$completedByValues,'','');
                echo $completedByDD;
                ?>
                <button type='button' class='resetButton' data-target='#rs-completedBy'>Reset</button>
            </td>
            <td>
                2222 Call
            </td>
            <td colspan='2'>
                <?php
                        $call2222Arr = array('Yes' => ' Yes ', 'No' => ' No ');
                        $call2222 = $Form->radioBox('rs-call2222',$call2222Arr,$patient['CALL_222CALL'],'');
                        echo $call2222;                        
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Event date
            </td>
            <td>
                <?php
                        $eventDateSplit = explode(' ',$patient['RESUS_DATE']);
                        $eventDate = $Form->textBox('rs-eventDate',$eventDateSplit[0]);
                        $eventDay = $Form->textBox('rs-eventDateDay',getDayFromDate($eventDateSplit[0]),'',1);
                        echo $eventDate . $eventDay;
                ?>
            </td>
            <td>
                Confirmed
            </td>
            <td colspan='2'>
                <?php
                    $rsConfirmedDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Confirmed');
                    $rsConfirmedDDArray = array();
                    for ($i = 1; $i < (count($rsConfirmedDDSQL)+1); $i++) {
                        array_push($rsConfirmedDDArray,$rsConfirmedDDSQL[$i]['Long_Name']);
                    }
        
                    $rsConfirmedDD = $Form->dropDown('rs-Confirmed',$rsConfirmedDDArray,$rsConfirmedDDArray,$patient['RESUS_CONFIRMED']);
                    echo $rsConfirmedDD;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                In hospital event
            </td>
            <td>
                <?php
                        $inHospEventArr = array(1 => ' Yes ', 2 => ' No ');
                        $inHospEvent = $Form->radioBox('rs-inHospEvent',$inHospEventArr,$patient['RESUS_IN_HOSP'],'');
                        echo $inHospEvent;                        
                ?>    
            </td>
            <td>
                Location
            </td>
            <td>
                <?php
                    $rsLocationDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Out Hospital Location');
                    $rsLocationDDArray = array();
                    for ($i = 1; $i < (count($rsLocationDDSQL)+1); $i++) {
                        array_push($rsLocationDDArray,$rsLocationDDSQL[$i]['Long_Name']);
                    }
        
                    $rsLocationDD = $Form->dropDown('rs-Location',$rsLocationDDArray,$rsLocationDDArray,$patient['RESUS_LOCATION']);
                    echo $rsLocationDD;
                ?>    
            </td>
            <td>
                Ambulance called
            </td>
            <td>
                <?php
                        $ambulanceCalled = $Form->textBox('rs-AmbulanceCalled',convert4DTime($patient['AMBULANCE_CALLED']));
                        echo $ambulanceCalled;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Monitored
            </td>
            <td>
                <?php
                        $rsMonitoredArr = array(1 => ' Yes ', 2 => ' No ');
                        $rsMonitored = $Form->radioBox('rs-Monitored',$rsMonitoredArr,$patient['RESUS_MONITORED'],'');
                        echo $rsMonitored;                        
                ?>    
            </td>
            <td>
                Cause of arrest
            </td>
            <td>
                <?php
                    $causeOfArrestDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Cause');
                    $causeOfArrestDDArray = array();
                    for ($i = 1; $i < (count($causeOfArrestDDSQL)+1); $i++) {
                        array_push($causeOfArrestDDArray,$causeOfArrestDDSQL[$i]['Long_Name']);
                    }
        
                    $causeOfArrestDD = $Form->dropDown('rs-causeOfArrest',$causeOfArrestDDArray,$causeOfArrestDDArray,$patient['RESUS_CAUSE']);
                    echo $causeOfArrestDD;
                ?>    
            </td>
            <td>
                Ambulance arrived
            </td>
            <td>
                <?php
                        $ambulanceArrived = $Form->textBox('rs-AmbulanceArrived',convert4DTime($patient['AMBULANCE_ARRIVAL']));
                        echo $ambulanceArrived;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Witnessed
            </td>
            <td>
                <?php
                        $rsWitnessedArr = array(1 => ' Yes ', 2 => ' No ');
                        $rsWitnessed = $Form->radioBox('rs-Witnessed',$rsWitnessedArr,$patient['RESUS_WITNESSED'],'');
                        echo $rsWitnessed;                        
                ?>    
            </td>
            <td>
                Witnessed by
            </td>
            <td>
                <?php
                    $witnessedByDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Witnessed By');
                    $witnessedByDDArray = array();
                    for ($i = 1; $i < (count($witnessedByDDSQL)+1); $i++) {
                        array_push($witnessedByDDArray,$witnessedByDDSQL[$i]['Long_Name']);
                    }
        
                    $witnessedByDD = $Form->dropDown('rs-witnessedBy',$witnessedByDDArray,$witnessedByDDArray,$patient['WITNESSEDBY']);
                    echo $witnessedByDD;
                ?>    
            </td>
            <td>
                Arrival to A&E
            </td>
            <td>
                <?php
                        $arrivalAtAE = $Form->textBox('rs-arrivalAtAE',convert4DTime($patient['ARRIVAL_AT_AE']));
                        echo $arrivalAtAE;
                ?>    
            </td>
        </tr>
        <tr>
            <td>
                Incident type    
            </td>
            <td colspan='5'>
                <?php
                    $incidentTypeDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Incident Type');
                    $incidentTypeDDArray = array();
                    for ($i = 1; $i < (count($incidentTypeDDSQL)+1); $i++) {
                        array_push($incidentTypeDDArray,$incidentTypeDDSQL[$i]['Long_Name']);
                    }
        
                    $incidentTypeDD = $Form->dropDown('rs-incidentType',$incidentTypeDDArray,$incidentTypeDDArray,$patient['INCIDENTTYPE']);
                    echo $incidentTypeDD;
                ?>    
            </td>
        </tr>
    </tbody>
</table>

<fieldset>
    <legend>
        Initial Condition
    </legend>
    <table class='temp'>
        <tbody>
            <tr>
                <td>
                    Time of collapse
                </td>
                <td>
                    <?php
                        $timeOfCollapse = $Form->textBox('rs-timeOfCollapse',convert4DTime($patient['RESUS_TIME_COLLAPSE']));
                        echo $timeOfCollapse;
                    ?>    
                </td>
                <td>
                    Not documented
                </td>
                <td>
                    <?php            
                        $TCollapse_NotDoc = $Form->checkBox('rs-TCollapse_NotDoc','rs-TCollapse_NotDoc','',$patient['TCOLLAPSE_NOTDOC'],'');
                        echo $TCollapse_NotDoc;
                    ?>  
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    Arrest team called
                </td>
                <td>
                    <?php
                        $arrestTeamCalled = $Form->textBox('rs-arrestTeamCalled',convert4DTime($patient['RESUS_TIME_TEAM_CALLED']));
                        echo $arrestTeamCalled;
                    ?>    
                </td>
                <td>
                    Not documented
                </td>
                <td>
                    <?php            
                        $TTeamColled_NotDoc = $Form->checkBox('rs-TTeamColled_NotDoc','rs-TTeamColled_NotDoc','',$patient['TTEAMCOLLED_NOTDOC'],'');
                        echo $TTeamColled_NotDoc;
                    ?>  
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    Arrest team arrived
                </td>
                <td>
                    <?php
                        $arrestTeamArrived = $Form->textBox('rs-arrestTeamArrived',convert4DTime($patient['RESUS_TIME_TEAM_ARIVAL']));
                        echo $arrestTeamArrived;
                    ?>    
                </td>
                <td>
                    Not documented
                </td>
                <td>
                    <?php            
                        $TTeamArrived_NotDoc = $Form->checkBox('rs-TTeamArrived_NotDoc','rs-TTeamArrived_NotDoc','',$patient['TTEAMARRIVED_NOTDOC'],'');
                        echo $TTeamArrived_NotDoc;
                    ?>  
                </td>
                <td>
                    Team leader
                </td>
                <td>
                    <?php
                    $teamLeaderFields = array();
                    $teamLeaderValues = array();
                    /*
                     * TO DO
                     * Need to fix this SQL statement
                     * Not sure how Resus Team Leader is selected
                     * Seems to use Resus_event somehow
                     * Example data doesn't show how Team_Leader is stored in DB eg ID, name etc?
                     */ 
                    $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE Resus=True AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
                    try { 
                        $selectResult = odbc_exec($connect,$sql); 
                            if($selectResult){ 
                                    while ($teamLeader = odbc_fetch_array($selectResult)) {
                                        array_push($teamLeaderFields, $teamLeader['MDS_NAME']);
                                        array_push($teamLeaderValues, $teamLeader['MDS_ID']);
                                    }
                                }
                            else{ 
                            throw new RuntimeException("Failed to connect."); 
                            } 
                                } 
                            catch (RuntimeException $e) { 
                                    print("Exception caught: $e");
                                    //exit;
                            }
                    $teamLeaderDD = $Form->dropDown('rs-teamLeader',$teamLeaderFields,$teamLeaderValues,'','');
                    echo $teamLeaderDD;
                    ?>
                    <button type='button' class='resetButton' data-target='#rs-teamLeader'>Reset</button>
                </td>
            </tr>
            <tr>
                <td>
                    Status on arrival
                </td>
                <td colspan='2'>
                    <?php
                    $statusOnArrivalDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Status On Arrival');
                    $statusOnArrivalDDArray = array();
                    for ($i = 1; $i < (count($statusOnArrivalDDSQL)+1); $i++) {
                        array_push($statusOnArrivalDDArray,$statusOnArrivalDDSQL[$i]['Long_Name']);
                    }
        
                    $statusOnArrivalDD = $Form->dropDown('rs-statusOnArrival',$statusOnArrivalDDArray,$statusOnArrivalDDArray,$patient['STATUS_ON_TEAM_ARRIVAL']);
                    echo $statusOnArrivalDD;
                    ?>    
                </td>
                <td>
                    Staff Member
                </td>
                <td>
                    <?php
                    $staffMemberFields = array();
                    $staffMemberValues = array();
                    /*
                     * TO DO
                     * Need to fix this SQL statement
                     * Not sure how Resus Team Leader is selected
                     * Seems to use Resus_event somehow
                     * Example data doesn't show how Team_Leader is stored in DB eg ID, name etc?
                     */ 
                    $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE Resus=True AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
                    try { 
                        $selectResult = odbc_exec($connect,$sql); 
                            if($selectResult){ 
                                    while ($staffMember = odbc_fetch_array($selectResult)) {
                                        array_push($staffMemberFields, $staffMember['MDS_NAME']);
                                        array_push($staffMemberValues, $staffMember['MDS_ID']);
                                    }
                                }
                            else{ 
                            throw new RuntimeException("Failed to connect."); 
                            } 
                                } 
                            catch (RuntimeException $e) { 
                                    print("Exception caught: $e");
                                    //exit;
                            }
                    $staffMemberDD = $Form->dropDown('rs-staffMember',$staffMemberFields,$staffMemberValues,'','');
                    echo $staffMemberDD;
                    ?>
                    <button type='button' class='resetButton' data-target='#rs-staffMember'>Reset</button>
                </td>
            </tr>
            <tr>
                <td>
                    Patient outlier
                </td>
                <td>
                    <?php
                        $patientOutlierDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Outlier');
                        $patientOutlierDDArray = array();
                        for ($i = 1; $i < (count($patientOutlierDDSQL)+1); $i++) {
                            array_push($patientOutlierDDArray,$patientOutlierDDSQL[$i]['Long_Name']);
                        }
            
                        $patientOutlierDD = $Form->dropDown('rs-patientOutlier',$patientOutlierDDArray,$patientOutlierDDArray,$patient['OUTLIER']);
                        echo $patientOutlierDD;
                    ?>    
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    Form completed
                </td>
                <td>
                    <?php
                        $formCompletedDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Form Completed');
                        $formCompletedDDArray = array();
                        for ($i = 1; $i < (count($formCompletedDDSQL)+1); $i++) {
                            array_push($formCompletedDDArray,$formCompletedDDSQL[$i]['Long_Name']);
                        }
            
                        $formCompletedDD = $Form->dropDown('rs-formCompleted',$formCompletedDDArray,$formCompletedDDArray,$patient['FORMCOMPLETED']);
                        echo $formCompletedDD;
                    ?>    
                </td>
                <td>
                    1st documented rhythm
                </td>
                <td>
                    <?php
                        $firstDocumentedRhythmDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Rhythm');
                        $firstDocumentedRhythmDDArray = array();
                        for ($i = 1; $i < (count($firstDocumentedRhythmDDSQL)+1); $i++) {
                            array_push($firstDocumentedRhythmDDArray,$firstDocumentedRhythmDDSQL[$i]['Long_Name']);
                        }
            
                        $firstDocumentedRhythmDD = $Form->dropDown('rs-firstDocumentedRhythm',$firstDocumentedRhythmDDArray,$firstDocumentedRhythmDDArray,$patient['INIT_RHYTHM']);
                        echo $firstDocumentedRhythmDD;
                    ?>     
                </td>
            </tr>
            <tr>
                <td>
                    Arrest confirmed
                </td>
                <td>
                    ???
                </td>
                <td>
                    Reason not attempted
                </td>
                <td>
                    <?php
                        $reasonNotAttemptedDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation CPR Stopped Reason');
                        $reasonNotAttemptedDDArray = array();
                        for ($i = 1; $i < (count($reasonNotAttemptedDDSQL)+1); $i++) {
                            array_push($reasonNotAttemptedDDArray,$reasonNotAttemptedDDSQL[$i]['Long_Name']);
                        }
            
                        $reasonNotAttemptedDD = $Form->dropDown('rs-reasonNotAttempted',$reasonNotAttemptedDDArray,$reasonNotAttemptedDDArray,$patient['RESUS_NOTATTEMT_WHY']);
                        echo $reasonNotAttemptedDD;
                    ?>    
                </td>
            </tr>
            <tr>
                <td>
                    Resus attempted
                </td>
                <td>
                    <?php
                        $resusAttemptedArr = array(1 => ' Yes ', 2 => ' No ');
                        $resusAttempted = $Form->radioBox('rs-resusAttempted',$resusAttemptedArr,$patient['RESUS_ATTEMPTED'],'');
                        echo $resusAttempted;                        
                    ?>    
                </td>
                <td>
                    Resus type
                </td>
                <td>
                    <?php
                        $resusTypeDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Attemted Type');
                        $resusTypeDDArray = array();
                        for ($i = 1; $i < (count($resusTypeDDSQL)+1); $i++) {
                            array_push($resusTypeDDArray,$resusTypeDDSQL[$i]['Long_Name']);
                        }
            
                        $resusTypeDD = $Form->dropDown('rs-resusType',$resusTypeDDArray,$resusTypeDDArray,$patient['RESUS_ATTEMPTED_TYPE']);
                        echo $resusTypeDD;
                    ?>    
                </td>
            </tr>
            <tr>
                <td>
                    CPR started
                </td>
                <td>
                    <?php
                        $CPRStartedDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation CPR Started');
                        $CPRStartedDDArray = array();
                        for ($i = 1; $i < (count($CPRStartedDDSQL)+1); $i++) {
                            array_push($CPRStartedDDArray,$CPRStartedDDSQL[$i]['Long_Name']);
                        }
            
                        $CPRStartedDD = $Form->dropDown('rs-CPRStartedDD',$CPRStartedDDArray,$CPRStartedDDArray,$patient['CPRSTARTED']);
                        echo $CPRStartedDD;
                        
                        $CPRStarted = $Form->textBox('rs-CPRStarted',convert4DTime($patient['RESUS_TIME_CPR_STARTED']));
                        echo $CPRStarted;
                    ?>    
                </td>
                <td>
                    Initial CPR provider
                </td>
                <td>
                    <?php
                        $initialCPRProviderDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation CPR Provider');
                        $initialCPRProviderDDArray = array();
                        for ($i = 1; $i < (count($initialCPRProviderDDSQL)+1); $i++) {
                            array_push($initialCPRProviderDDArray,$initialCPRProviderDDSQL[$i]['Long_Name']);
                        }
            
                        $initialCPRProviderDD = $Form->dropDown('rs-initialCPRProvider',$initialCPRProviderDDArray,$initialCPRProviderDDArray,$patient['RESUS_CPR_PROVIDER']);
                        echo $initialCPRProviderDD;
                    ?>    
                </td>
            </tr>
            <tr>
                <td>
                    Advanced airway
                </td>
                <td>
                    <?php
                        $advancedAirway = $Form->textBox('rs-advancedAirway',convert4DTime($patient['RESUS_TIME_TEAM_ARIVAL']));
                        echo $advancedAirway;
                    ?>    
                </td>
                <td>
                    Airway control
                </td>
                <td>
                    <?php
                        $airwayControlDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Airway Control');
                        $airwayControlDDArray = array();
                        for ($i = 1; $i < (count($airwayControlDDSQL)+1); $i++) {
                            array_push($airwayControlDDArray,$airwayControlDDSQL[$i]['Long_Name']);
                        }
            
                        $airwayControlDD = $Form->dropDown('rs-airwayControl',$airwayControlDDArray,$airwayControlDDArray,$patient['RESUS_AIRWAY_CONTROL']);
                        echo $airwayControlDD;
                    ?>    
                </td>
            </tr>
            <tr>
                <td>
                    1st defib shock
                </td>
                <td>
                    <?php
                        $firstDefibShockDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation 1st Defib Shock');
                        $firstDefibShockDDArray = array();
                        for ($i = 1; $i < (count($firstDefibShockDDSQL)+1); $i++) {
                            array_push($firstDefibShockDDArray,$firstDefibShockDDSQL[$i]['Long_Name']);
                        }
            
                        $firstDefibShockDD = $Form->dropDown('rs-firstDefibShock',$firstDefibShockDDArray,$firstDefibShockDDArray,$patient['FIRSTDEFIBSHOCK']);
                        echo $firstDefibShockDD;
                        
                        $resusTime1stDefib = $Form->textBox('rs-resusTime1stDefib',convert4DTime($patient['RESUS_TIME_1ST_DEFIB']));
                        echo $resusTime1stDefib;
                    ?>    
                </td>
                <td>
                    1st shock delivered by
                </td>
                <td>
                    <?php
                        $firstShockDeliveredByDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Defibrillation Provider');
                        $firstShockDeliveredByDDArray = array();
                        for ($i = 1; $i < (count($firstShockDeliveredByDDSQL)+1); $i++) {
                            array_push($firstShockDeliveredByDDArray,$firstShockDeliveredByDDSQL[$i]['Long_Name']);
                        }
            
                        $firstShockDeliveredByDD = $Form->dropDown('rs-firstShockDeliveredBy',$firstShockDeliveredByDDArray,$firstShockDeliveredByDDArray,$patient['RESUS_DEFIB_PROVIDER']);
                        echo $firstShockDeliveredByDD;
                    ?>    
                </td>
            </tr>
            <tr>
                <td>
                    CPR stopped
                </td>
                <td>
                    <?php
                        $CPRStoppedDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation CPR Started');
                        $CPRStoppedDDArray = array();
                        for ($i = 1; $i < (count($CPRStoppedDDSQL)+1); $i++) {
                            array_push($CPRStoppedDDArray,$CPRStoppedDDSQL[$i]['Long_Name']);
                        }
            
                        $CPRStoppedDD = $Form->dropDown('rs-firstShockDeliveredBy',$CPRStoppedDDArray,$CPRStoppedDDArray,$patient['CPRSTOPPED']);
                        echo $CPRStoppedDD;
                    ?>    
                </td>
                <td>
                    Defib used
                </td>
                <td>
                    <?php
                        $defibUsedDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Defib Used');
                        $defibUsedDDArray = array();
                        for ($i = 1; $i < (count($defibUsedDDSQL)+1); $i++) {
                            array_push($defibUsedDDArray,$defibUsedDDSQL[$i]['Long_Name']);
                        }
            
                        $defibUsedDD = $Form->dropDown('rs-defibUsed',$defibUsedDDArray,$defibUsedDDArray,$patient['CPRSTOPPED']);
                        echo $defibUsedDD;
                    ?>    
                </td>
            </tr>
            <tr>
                <td>
                    Definitive airway
                </td>
                <td>
                    <?php
                        $definitiveAirway = $Form->textBox('rs-definitiveAirway',convert4DTime($patient['TIME_DEFAIRWAY']));
                        echo $definitiveAirway;
                    ?>    
                </td>
                <td>
                    Reason CPR stopped
                </td>
                <td>
                    <?php
                        $reasonCPRStoppedDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation CPR Stopped Reason');
                        $reasonCPRStoppedDDArray = array();
                        for ($i = 1; $i < (count($reasonCPRStoppedDDSQL)+1); $i++) {
                            array_push($reasonCPRStoppedDDArray,$reasonCPRStoppedDDSQL[$i]['Long_Name']);
                        }
            
                        $reasonCPRStoppedDD = $Form->dropDown('rs-reasonCPRStopped',$reasonCPRStoppedDDArray,$reasonCPRStoppedDDArray,$patient['RESUS_CPR_STOPED_REASON']);
                        echo $reasonCPRStoppedDD;
                    ?>    
                </td>
            </tr>
            <tr>
                <td>
                    Arrest team left
                </td>
                <td>
                    <?php
                        $arrestTeamLeft = $Form->textBox('rs-arrestTeamLeft',convert4DTime($patient['END_TIME']));
                        echo $arrestTeamLeft;
                        
                        echo "<br />Duration <br />";
                        $rsDuration = $Form->textBox('rs-duration',convert4DTime($patient['DURATION']));
                        echo $rsDuration;
                    ?>    
                </td>
                <td>
                    Definitive airway used
                </td>
                <td>
                    <?php
                        $definitiveAirwayUsedDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Definitive Airway Used');
                        $definitiveAirwayUsedDDArray = array();
                        for ($i = 1; $i < (count($definitiveAirwayUsedDDSQL)+1); $i++) {
                            array_push($definitiveAirwayUsedDDArray,$definitiveAirwayUsedDDSQL[$i]['Long_Name']);
                        }
            
                        $definitiveAirwayUsedDD = $Form->dropDown('rs-definitiveAirwayUsed',$definitiveAirwayUsedDDArray,$definitiveAirwayUsedDDArray,$patient['DEF_AIRWAY_USED']);
                        echo $definitiveAirwayUsedDD;
                    ?>    
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>