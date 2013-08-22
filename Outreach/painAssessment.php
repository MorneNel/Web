
    <table class='temp PA_Table'>
        <?php if ($appName == "AcutePain") { ?>
        <tr>

            <td class='pa_dd_label_cell'>Pain at rest</td>
            <td class='pa_dd_cell'>
                <?php
                    /*
                     * Preference set changes this scale from 0-3, 0-4 or 0-10
                     */
                    switch ($preferences['PainAtRest_ScoreScale']) {
                        case 0:
                            $painAtRestScale = "Pain Score At Rest (0-3)";
                            $numPrefix = 30;
                        break;
                        
                        case 4:
                            $painAtRestScale = "Pain Score At Rest (0-4)";
                            $numPrefix = 40;
                        break;
                        
                        case 10:
                            $painAtRestScale = "Pain Score At Rest (0-10)";
                            $numPrefix = 1;
                        break;
                    
                        default:
                            $painAtRestScale = "Pain Score At Rest (0-3)";
                            $numPrefix = 30;
                        break;
                    }
                    $painAtRestDDSQL = $Mela_SQL->tbl_LoadItems($painAtRestScale);
                    $painAtRestDDArray = array();
                    $painAtRestShortArray = array();
                    for ($i = 1; $i < (count($painAtRestDDSQL)+1); $i++) {
                        $longShortRestArray = array($painAtRestDDSQL[$i]['Short_Name'] => $painAtRestDDSQL[$i]['Long_Name']);
                        array_push_associative($painAtRestDDArray, $longShortRestArray);
                    }

                    asort($painAtRestDDArray);                   
                    $painAtRestDD = $Form->dropDown('painass-painAtRest',$painAtRestDDArray,$painAtRestDDArray,$painAtRestDDArray[$patient['OTR_PAINATREST']],'PA_DD');
                    echo $painAtRestDD;
                ?>
            </td>


            <td class='pa_dd_label_cell'>Pain with activity</td>
            <td class='pa_dd_cell'>
                <?php
                    /*
                     * Preference set changes this scale from 0-3, 0-4 or 0-10
                     */
                    switch ($preferences['PainAtActivity_ScoreScale']) {
                        case 0:
                            $painAtActivityScale = "Pain Score In Activity (0-3)";
                        break;
                        
                        case 4:
                            $painAtActivityScale = "Pain Score In Activity (0-4)";
                        break;
                        
                        case 10:
                            $painAtActivityScale = "Pain Score In Activity (0-10)";
                        break;
                    
                        default:
                            $painAtActivityScale = "Pain Score In Activity";
                        break;
                    }
                    $painAtActivityDDSQL = $Mela_SQL->tbl_LoadItems($painAtActivityScale);
                    $painAtActivityDDArray = array();
                    for ($i = 1; $i < (count($painAtActivityDDSQL)+1); $i++) {
                        $longShortActivityArray = array($painAtActivityDDSQL[$i]['Short_Name'] => $painAtActivityDDSQL[$i]['Long_Name']);
                        array_push_associative($painAtActivityDDArray, $longShortActivityArray);
                    }
                    asort($painAtActivityDDArray);
                    $painAtActivityDD = $Form->dropDown('painass-painAtActivity',$painAtActivityDDArray,$painAtActivityDDArray,$painAtActivityDDArray[$patient['OTR_PAINATACTIVITY']],'PA_DD');
                    echo $painAtActivityDD;
                ?>
            </td>



            <td class='pa_dd_label_cell'>Pain score/Ward</td>
            <td class='pa_dd_cell'>
                <?php
                    $painScoreWardDDSQL = $Mela_SQL->tbl_LoadItems('Pain Score By Ward');
                    $painScoreWardDDArray = array();
                    for ($i = 1; $i < (count($painScoreWardDDSQL)+1); $i++) {
                        array_push($painScoreWardDDArray,$painScoreWardDDSQL[$i]['Long_Name']);
                    }
                    // This doesn't use numbers for scores so can be left alone
                    $painScoreWardDD = $Form->dropDown('painass-painScoreWard',$painScoreWardDDArray,$painScoreWardDDArray,$patient['OTR_PAINSCOREWARD'],'PA_DD');
                    echo $painScoreWardDD;
                ?>
            </td>
        </tr>
        <?php } ?>
        
        <?php if ($preferences['PeadiatricPainScore'] == 'true') { ?>
        
        <tr>
            <td colspan='6'>
                <iframe id='paedPainIframe' name='paedPainIframe' width='100%' src='paedPainFrame.php?otr_ID=<?php echo $patient['DLK_OTRID']; ?>' frameborder='0' style='min-height:100px;'></iframe>
            </td>
        </tr>
        
        <?php } ?>
        
        <tr>
            <?php if ($preferences['Show_Nausea'] == 'true') { ?>
            <td class='pa_dd_label_cell'>Nausea</td>
            <td class='pa_dd_cell'>
                <?php
                    switch ($preferences['Pain_Nausia_ScoreScale']) {
                        case 0:
                            $nauseaScale = "Pain Score - Nausea (0-3)";
                        break;
                        
                        case 4:
                            $nauseaScale = "Pain Score - Nausea (0-4)";
                        break;
                        
                        case 10:
                            $nauseaScale = "Pain Score - Nausea (0-10)";
                        break;
                    
                        default:
                            $nauseaScale = "Pain Score - Nausea";
                        break;
                    }
                    $nauseaDDSQL = $Mela_SQL->tbl_LoadItems($nauseaScale);
                    $nauseaDDArray = array();
                    for ($i = 1; $i < (count($nauseaDDSQL)+1); $i++) {
                        $longShortNauseaArray = array($nauseaDDSQL[$i]['Short_Name'] => $nauseaDDSQL[$i]['Long_Name']);
                        array_push_associative($nauseaDDArray, $longShortNauseaArray);
                    }
                    asort($nauseaDDArray);
                    $nauseaDD = $Form->dropDown('painass-nausea',$nauseaDDArray,$nauseaDDArray,$nauseaDDArray[$patient['OTR_NAUSEA']],'PA_DD');
                    echo $nauseaDD;
                ?>
            </td>
            <?php } ?>

            <?php if ($preferences['Show_Pruritus'] == 'true') { ?>
            <td class='pa_dd_label_cell'>Pruritus</td>
            <td class='pa_dd_cell'>
                <?php
                    switch ($preferences['Pain_Pruritus_ScoreScale']) {
                        case 0:
                            $pruritusScale = "Pain Score - Pruritus (0-3)";
                        break;
                        
                        case 4:
                            $pruritusScale = "Pain Score - Pruritus (0-4)";
                        break;
                        
                        case 10:
                            $pruritusScale = "Pain Score - Pruritus (0-10)";
                        break;
                    
                        default:
                            $pruritusScale = "Pain Score - Pruritus";
                        break;
                    }
                    $pruritusDDSQL = $Mela_SQL->tbl_LoadItems($pruritusScale);
                    $pruritusDDArray = array();
                    for ($i = 1; $i < (count($pruritusDDSQL)+1); $i++) {
                        $longShortPruritusArray = array($pruritusDDSQL[$i]['Short_Name'] => $pruritusDDSQL[$i]['Long_Name']);
                        array_push_associative($pruritusDDArray, $longShortPruritusArray);
                    }
                    asort($pruritusDDArray);
                    $pruritusDD = $Form->dropDown('painass-pruritus',$pruritusDDArray,$pruritusDDArray,$pruritusDDArray[$patient['OTR_PRURITUS']],'PA_DD');
                    echo $pruritusDD;
                ?>
            </td>
            <?php } ?>
            
            <?php if ($preferences['Show_Sedation'] == 'true') { ?>
            <td class='pa_dd_label_cell'>Sedation</td>
            <td class='pa_dd_cell'>
                <?php
                    switch ($preferences['Pain_Sedation_ScoreScale']) {
                        
                        case 4:
                            $sedationScale = "Pain Score - Sedation (0-4)";
                        break;
                        
                        case 10:
                            $sedationScale = "Pain Score - Sedation (0-10)";
                        break;
                    
                        default:
                            $sedationScale = "Pain Score - Sedation";
                        break;
                    }
                    $sedationDDSQL = $Mela_SQL->tbl_LoadItems($sedationScale);
                    $sedationDDArray = array();
                    for ($i = 1; $i < (count($sedationDDSQL)+1); $i++) {
                        //array_push($sedationDDArray,$sedationDDSQL[$i]['Long_Name']);
                        $longShortSedationArray = array($sedationDDSQL[$i]['Short_Name'] => $sedationDDSQL[$i]['Long_Name']);
                        array_push_associative($sedationDDArray, $longShortSedationArray);
                    }
                    asort($sedationDDArray);
                    $sedationDD = $Form->dropDown('painass-sedation',$sedationDDArray,$sedationDDArray,$sedationDDArray[$patient['OTR_SEDATION']],'PA_DD');
                    echo $sedationDD;
                ?>
            </td>
            <?php } ?>

        </tr>
    </table>
    <?php if ($preferences['Show_PainAss_GI'] == 'true') { ?>
    <table class='PA_Table'>
        <tr class='CO_TableRow'>
            <td class='CO_TableCell'>

                <div id="reset">
                    <div id="accordian" class="groupsItemsList list2">
                        <ul class='sub-menu'>
                            <?php
                            $query = "SELECT grpCL_ID, Description FROM Grp_CL WHERE".$Mela_SQL->sqlHUMinMax("grpCL_ID")." ORDER BY SortNum DESC";
                            try { 
                                $result = odbc_exec($connect,$query); 
                                if($result){ 
                                        while ($painGroups = odbc_fetch_array($result)) {


                                            // echo "<li class='category PA' title='".$painGroups['DESCRIPTION']."'>".$painGroups['DESCRIPTION']."<ul>";

                                            echo    "<li title='".$painGroups['DESCRIPTION']."' class='category grp_list'>
                                                    <h3><span><a class='category PA grp_header'>".$painGroups['DESCRIPTION']."</a></span></h3>
                                                    <ul class='sub-menu'>\n";


                                            $subquery = "SELECT itemCL_ID, Description FROM Item_CL WHERE grpCL_ID = ".$painGroups['GRPCL_ID']."";
                                            $subresult = odbc_exec($connect,$subquery);
                                            while ($painItems = odbc_fetch_array($subresult)) {



                                                echo "<li class='select PA sub_item' title='".$painItems['DESCRIPTION']."'>
                                                    <input type='radio' class='addRow' data-abbr='PA' data-destination='painAssessment' data-item_id='".$painItems['ITEMCL_ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-group='".$painItems['DESCRIPTION']."' data-edit='n' id='".$painItems['ITEMCL_ID']."' value='".$painItems['ITEMCL_ID']."'>
                                                    <label for='".$painItems['ITEMCL_ID']."'>".$painItems['DESCRIPTION']."</label>
                                                    </li>\n";
                                            }
                                            echo    "</ul>
                                                    </li>\n";
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
                            ?>
                        </ul>
                    </div>
                </div>
            </td>


            <!--########    SELECTED ITEMS    ########-->
            <td class="selected_table">
                <table class="PATable temp SelTable" id="main">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Item</th>
                            <th>Notes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                $query = "SELECT cl.CareLevelItem_ID, cl.Notes,
                                itm.itemCL_ID, itm.grpCL_ID, itm.Description AS Item_Description,
                                grp.grpCL_ID, grp.Description AS Group_Description
                                FROM CareLevel cl
                                LEFT OUTER JOIN Item_CL itm ON itm.itemCL_ID = cl.CareLevelItem_ID
                                LEFT OUTER JOIN Grp_CL grp ON grp.grpCL_ID = itm.grpCL_ID
                                WHERE CL_dlkID=".$patient['DLK_ID']." AND lnk_ID=".$patient['LNK_ID']."";
                                try { 
                                    $result = odbc_exec($connect,$query); 
                                    if($result){ 
                                            while ($existingCLRows = odbc_fetch_array($result)) {


                                                print "<tr>
                                                            <td class='cat'>".$existingCLRows['Group_Description']."</td>
                                                            <td class='sel'>".$existingCLRows['Item_Description']."</td>
                                                            <td id='textArea_cell'>";
                                                                $notes = $Form->textArea('panotes['.$existingCLRows['CARELEVELITEM_ID'].']',''.$existingCLRows['NOTES'].'');
                                                                print $notes;
                                                print      "</td>
                                                            <td id='Button_cell'>
                                                                <button id='".$existingCLRows['CARELEVELITEM_ID']."' type='button' class='deleteRow' data-page='painAssessment'><img src='Media/img/bin.gif' alt='Delete'/></button></td>
                                                        </tr>";


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
                	       ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <?php } ?>