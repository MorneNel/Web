<?php
$consultantFields = array();
$consultantValues = array();
$gpFields = array();
$gpValues = array();
$dieticianFields = array();
$dieticianValues = array();
$physioFields = array();
$physioValues = array();
$commNurseFields = array();
$commNurseValues = array();
$socialWorkerFields = array();
$socialWorkerValues = array();
$healthVisitorFields = array();
$healthVisitorValues = array();
$outreachTeamFields = array();
$outreachTeamValues = array();
$speechTherapistFields = array();
$speechTherapistValues = array();
$psychologistFields = array();
$psychologistValues = array();
$directorateFields = array();
$directorateValues = array();
?>

<table class="temp">
    <tr>
        <td>
            Consultant
        </td>
        <td>
            <?php
            $sql = "SELECT mds_ID, mds_Name, Consultant FROM MedStaff WHERE Consultant=True AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $selectResult = odbc_exec($connect,$sql); 
                    if($selectResult){ 
                            while ($consultants = odbc_fetch_array($selectResult)) {
                                array_push($consultantFields, $consultants['MDS_NAME']);
                                array_push($consultantValues, $consultants['MDS_ID']);
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
            $consultantDD = $Form->dropDown('ms_Consultant',$consultantFields,$consultantValues,'','');
            //$consultantReset = $Form->resetButton();
            echo $consultantDD;
            //echo $consultantReset;
            ?>
            <button type='button' class='resetButton' data-target='#ms_Consultant'>Reset</button>
        </td>
    </tr>
    <tr>
        <td>
            GP Name
        </td>
        <td>
            <?php
            $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE mds_Role='GP' AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $selectResult = odbc_exec($connect,$sql); 
                    if($selectResult){ 
                            while ($gp = odbc_fetch_array($selectResult)) {
                                array_push($gpFields, $gp['MDS_NAME']);
                                array_push($gpValues, $gp['MDS_ID']);
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
            $gpDD = $Form->dropDown('ms_GP',$gpFields,$gpValues,'','');
            echo $gpDD;
            ?>
            <button type='button' class='resetButton' data-target='#ms_GP'>Reset</button>
        </td>
    </tr>
    <tr>
        <td>
            Dietician
        </td>
        <td>
            <?php
            $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE mds_Role='Dietician' AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $selectResult = odbc_exec($connect,$sql); 
                    if($selectResult){ 
                            while ($dietician = odbc_fetch_array($selectResult)) {
                                array_push($dieticianFields, $dietician['MDS_NAME']);
                                array_push($dieticianValues, $dietician['MDS_ID']);
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
            $dieticianDD = $Form->dropDown('ms_Dietician',$dieticianFields,$dieticianValues,'','');
            echo $dieticianDD;
            ?>
            <button type='button' class='resetButton' data-target='#ms_Dietician'>Reset</button>
        </td>
    </tr>
    <tr>
        <td>
            Physio
        </td>
        <td>
            <?php
            $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE mds_Role='Physio%' AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $selectResult = odbc_exec($connect,$sql); 
                    if($selectResult){ 
                            while ($physio = odbc_fetch_array($selectResult)) {
                                array_push($physioFields, $physio['MDS_NAME']);
                                array_push($physioValues, $physio['MDS_ID']);
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
            $physioDD = $Form->dropDown('ms_Physio',$physioFields,$physioValues,'','');
            echo $physioDD;
            ?>
            <button type='button' class='resetButton' data-target='#ms_Physio'>Reset</button>
        </td>
    </tr>
    <tr>
        <td>
            Comm. Nurse
        </td>
        <td>
            <?php
            $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE mds_Role='Com%Nurse' AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $selectResult = odbc_exec($connect,$sql); 
                    if($selectResult){ 
                            while ($commNurse = odbc_fetch_array($selectResult)) {
                                array_push($commNurseFields, $commNurse['MDS_NAME']);
                                array_push($commNurseValues, $commNurse['MDS_ID']);
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
            $commNurseDD = $Form->dropDown('ms_commNurse',$commNurseFields,$commNurseValues,'','');
            echo $commNurseDD;
            ?>
            <button type='button' class='resetButton' data-target='#ms_commNurse'>Reset</button>
        </td>
    </tr>
    <tr>
        <td>
            Social Worker
        </td>
        <td>
            <?php
            $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE mds_Role='Social Worker' AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $selectResult = odbc_exec($connect,$sql); 
                    if($selectResult){ 
                            while ($socialWorker = odbc_fetch_array($selectResult)) {
                                array_push($socialWorkerFields, $socialWorker['MDS_NAME']);
                                array_push($socialWorkerValues, $socialWorker['MDS_ID']);
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
            $socialWorkerDD = $Form->dropDown('ms_socialWorker',$socialWorkerFields,$socialWorkerValues,'','');
            echo $socialWorkerDD;
            ?>
            <button type='button' class='resetButton' data-target='#ms_socialWorker'>Reset</button>
        </td>
    </tr>
    <tr>
        <td>
            Health Visitor
        </td>
        <td>
            <?php
            $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE mds_Role='Health Visitor' AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $selectResult = odbc_exec($connect,$sql); 
                    if($selectResult){ 
                            while ($healthVisitor = odbc_fetch_array($selectResult)) {
                                array_push($healthVisitorFields, $healthVisitor['MDS_NAME']);
                                array_push($healthVisitorValues, $healthVisitor['MDS_ID']);
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
            $healthVisitorDD = $Form->dropDown('ms_healthVisitor',$healthVisitorFields,$healthVisitorValues,'','');
            echo $healthVisitorDD;
            ?>
            <button type='button' class='resetButton' data-target='#ms_healthVisitor'>Reset</button>
        </td>
    </tr>
    <tr>
        <td>
            Outreach Team
        </td>
        <td>
            <?php
            $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE Outreach_Team=True AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $selectResult = odbc_exec($connect,$sql); 
                    if($selectResult){ 
                            while ($outreachTeam = odbc_fetch_array($selectResult)) {
                                array_push($outreachTeamFields, $outreachTeam['MDS_NAME']);
                                array_push($outreachTeamValues, $outreachTeam['MDS_ID']);
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
            $outreachTeamDD = $Form->dropDown('ms_outreachTeam',$outreachTeamFields,$outreachTeamValues,'','');
            echo $outreachTeamDD;
            ?>
            <button type='button' class='resetButton' data-target='#ms_outreachTeam'>Reset</button>
        </td>
    </tr>
    <tr>
        <td>
            Speech Therapist
        </td>
        <td>
            <?php
            $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE mds_Role='Speech Therapist' AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $selectResult = odbc_exec($connect,$sql); 
                    if($selectResult){ 
                            while ($speechTherapist = odbc_fetch_array($selectResult)) {
                                array_push($speechTherapistFields, $speechTherapist['MDS_NAME']);
                                array_push($speechTherapistValues, $speechTherapist['MDS_ID']);
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
            $speechTherapistDD = $Form->dropDown('ms_speechTherapist',$speechTherapistFields,$speechTherapistValues,'','');
            echo $speechTherapistDD;
            ?>
            <button type='button' class='resetButton' data-target='#ms_speechTherapist'>Reset</button>
        </td>
    </tr>
    <tr>
        <td>
            Psychologist
        </td>
        <td>
            <?php
            $sql = "SELECT mds_ID, mds_Name FROM MedStaff WHERE mds_Role='Psychologist' AND Active=True AND".$Mela_SQL->sqlHUMinMax("mds_ID");
            try { 
                $selectResult = odbc_exec($connect,$sql); 
                    if($selectResult){ 
                            while ($psychologist = odbc_fetch_array($selectResult)) {
                                array_push($psychologistFields, $psychologist['MDS_NAME']);
                                array_push($psychologistValues, $psychologist['MDS_ID']);
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
            $psychologistDD = $Form->dropDown('ms_psychologist',$psychologistFields,$psychologistValues,'','');
            echo $psychologistDD;
            ?>
            <button type='button' class='resetButton' data-target='#ms_psychologist'>Reset</button>
        </td>
    </tr>
</table>