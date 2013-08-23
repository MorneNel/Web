
<table class='temp'>
    <tbody>

        <tr>
            <td>Source of Infection</td>
            <td>
                <?php
                    $infectionSourceDDSQL = $Mela_SQL->tbl_LoadItems('Source Of Infection');
                    $infectionSourceDDArray = array();
                    for ($i = 1; $i < (count($infectionSourceDDSQL)+1); $i++) {
                        array_push($infectionSourceDDArray,$infectionSourceDDSQL[$i]['Long_Name']);
                    }
        
                    $infectionSourceDD = $Form->dropDown('sps-infectionSource',$infectionSourceDDArray,$infectionSourceDDArray,$patient['INFECTION_SOURCE']);
                    echo $infectionSourceDD;
                ?>  
            </td>
            <td>Sepsis on arrival</td>
            <td>
                <?php
                    $sepsisOnArrivalDDSQL = $Mela_SQL->tbl_LoadItems('Sepsis on arrival');
                    $sepsisOnArrivalDDArray = array();
                    for ($i = 1; $i < (count($sepsisOnArrivalDDSQL)+1); $i++) {
                        array_push($sepsisOnArrivalDDArray,$sepsisOnArrivalDDSQL[$i]['Long_Name']);
                    }
        
                    $sepsisOnArrivalDD = $Form->dropDown('sps-sepsisOnArrival',$sepsisOnArrivalDDArray,$sepsisOnArrivalDDArray,$patient['SEPSISONARIVAL']);
                    echo $sepsisOnArrivalDD;
                ?> 
            </td>
        </tr>
        <tr id='sepsis'>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Likely source</td>
            <td>
                <?php
                    $sepsisSourceDDSQL = $Mela_SQL->tbl_LoadItems('Sepsis Source');
                    $sepsisSourceDDArray = array();
                    for ($i = 1; $i < (count($sepsisSourceDDSQL)+1); $i++) {
                        array_push($sepsisSourceDDArray,$sepsisSourceDDSQL[$i]['Long_Name']);
                    }
        
                    $sepsisSourceDD = $Form->dropDown('sps-sepsisSource',$sepsisSourceDDArray,$sepsisSourceDDArray,$patient['SEPSISSOURCE']);
                    echo $sepsisSourceDD;
                ?>     
            </td>
        </tr>
    </tbody>
</table>


<br/>
<br/>


<table class='CO_Table'>
    <tr class='CO_TableRow'>
        <td class='CO_TableCell'>
            <h3 class="CO_Table_h3">Sepsis</h3>
            <div id="reset">
                <div id="accordian" class="groupsItemsList">
                    <ul class='sub-menu'>
                        <?php
                        $query = "SELECT ID, Description FROM Groups_site WHERE ".$Mela_SQL->sqlHUMinMax("ID")." ORDER BY SortNum ASC";
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($painGroups = odbc_fetch_array($result)) {

                                        // echo "<li class='category SI' title='".$painGroups['DESCRIPTION']."'>".$painGroups['DESCRIPTION']."<ul>";

                                        echo "<li class='category grp_list' title='".$painGroups['DESCRIPTION']."'>
                                              <h3><span><a class='category SI grp_header'>".$painGroups['DESCRIPTION']."</a></span></h3>
                                              <ul class='sub-menu'>\n";

                                        $subquery = "SELECT ID, grpID, Description FROM Items_site WHERE grpID = ".$painGroups['ID']."";
                                        $subresult = odbc_exec($connect,$subquery);
                                        while ($painItems = odbc_fetch_array($subresult)) {

                                        echo "<li class='select SI sub_item' title='".$painItems['DESCRIPTION']."'>
                                                <input type='radio' class='addRow' data-abbr='SI' data-destination='site' data-item_id='".$painItems['ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-edit='n' data-group='".$painItems['DESCRIPTION']."' id='SI".$painItems['ID']."' value='".$painItems['ID']."'>
                                                <label for='SI".$painItems['ID']."'>".$painItems['DESCRIPTION']."</label>
                                              </li>";

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



        <!--########    SELECTED ITEMS    #########-->
        <td class="selected_table">
            <table class="SITable temp SelTable" id="sepsis">
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
                        $query = "SELECT si.ID AS SITE_ID, si.site_dlkID, si.site_lnkID, si.Site_Comments,
                        itm.ID AS ITMID, itm.grpID, itm.Description AS Items_Description,
                        grp.ID AS GRPID, grp.Description AS Group_Description
                        FROM Infection_Site si
                        LEFT OUTER JOIN Items_site itm ON itm.ID = si.ID
                        LEFT OUTER JOIN Groups_site grp ON grp.ID = itm.grpID
                        WHERE si.site_dlkID=".$patient['DLK_ID']." AND si.site_lnkID=".$patient['LNK_ID']."";
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($existingCLRows = odbc_fetch_array($result)) {
                                     print "<tr>
                                                <td class='cat'>".$existingCLRows['Group_Description']."</td>
                                                <td class='sel'>".$existingCLRows['Items_Description']."</td>
                                                <td id='textArea_cell'>";
                                                    $notes = $Form->textArea('SInotes['.$existingCLRows['SITE_ID'].']',''.$existingCLRows['SITE_COMMENTS'].'');
                                                    print $notes;
                                         print "</td>
                                                <td id='Button_cell'>
                                                    <button id='".$existingCLRows['SITE_ID']."' type='button' class='deleteRow' data-page='site'><img src='Media/img/bin.gif' alt='Delete'/></button>
                                                </td>
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


<tr style='line-height:4px;'><td>&nbsp;</td></tr>
<!--     <tr>
        <td><h3 class="CO_Table_h3">Agent</h3></td>
        <td class="selected_table">
            <table class="SITable temp SelTable" id="sepsis">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Item</th>
                        <th>Notes</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </td>
    </tr> --> <!-- ****************************   -->



    <tr class='CO_TableRow'>
        <td class='CO_TableCell'>
            <h3 class="CO_Table_h3">Agent</h3>
            <div id="reset">
                <div id="accordian" class="groupsItemsList">
                    <ul class='sub-menu'>            
                        <?php
                        $query = "SELECT ID, Description FROM Groups_agents WHERE ".$Mela_SQL->sqlHUMinMax("ID")." ORDER BY SortNum ASC";
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($painGroups = odbc_fetch_array($result)) {

                                        // echo "<li class='category AG' title='".$painGroups['DESCRIPTION']."'>".$painGroups['DESCRIPTION']."<ul>";

                                        echo "<li class='category grp_list' title='".$painGroups['DESCRIPTION']."'>
                                              <h3><span><a class='category AG grp_header'>".$painGroups['DESCRIPTION']."</a></span></h3>
                                              <ul class='sub-menu'>\n";


                                        $subquery = "SELECT ID, grpID, Description FROM Items_agents WHERE grpID = ".$painGroups['ID']."";
                                        $subresult = odbc_exec($connect,$subquery);
                                        while ($painItems = odbc_fetch_array($subresult)) {

                                            // echo "<li class='select AG sub_item' title='".$painItems['DESCRIPTION']."'>
                                            //         <input type='radio' class='addRow' data-abbr='AG' data-destination='agents' data-item_id='".$painItems['ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-edit='y' data-group='".$painItems['DESCRIPTION']."' id='AG".$painItems['ID']."' value='".$painItems['ID']."'>
                                            //             <label for='AG".$painItems['ID']."'>
                                            //                 ".$painItems['DESCRIPTION']."
                                            //             </label>
                                            //       </li>";

                                            echo "<li class='select AG sub_item' title='".$painItems['DESCRIPTION']."'>
                                                <input type='radio' class='addRow' data-abbr='AG' data-destination='agents' data-item_id='".$painItems['ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-group='".$painItems['DESCRIPTION']."' data-edit='y' id='AG".$painItems['ID']."' value='".$painItems['ID']."'>
                                                <label for='AG".$painItems['ID']."'>".$painItems['DESCRIPTION']."</label>
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


        <td class="selected_table">
            <table class="AGTable temp SelTable" id="careLevel">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Item</th>
                        <th>Notes</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>            
                    <?php
                        $query = "SELECT ag.ID AS AGENT_ID, ag.agent_dlkID, ag.agent_lnkID, ag.Agents_Comments,
                        itm.ID AS ITMID, itm.grpID, itm.Description AS Items_Description,
                        grp.ID AS GRPID, grp.Description AS Group_Description
                        FROM Infection_Agents ag
                        LEFT OUTER JOIN Items_agents itm ON itm.ID = ag.ID
                        LEFT OUTER JOIN Groups_agents grp ON grp.ID = itm.grpID
                        WHERE ag.agent_dlkID=".$patient['DLK_ID']." AND ag.agent_lnkID=".$patient['LNK_ID']."";
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($existingCLRows = odbc_fetch_array($result)) {
                                        print "<tr>
                                                <td class='cat'>".$existingCLRows['Group_Description']."</td>
                                                <td class='sel'>".$existingCLRows['Items_Description']."</td>
                                                <td id='textArea_cell'>";
                                                    $notes = $Form->textArea('AGnotes['.$existingCLRows['AGENT_ID'].']',''.$existingCLRows['AGENTS_COMMENTS'].'');
                                                    print $notes;
                                        print "</td>
                                                <td id='Button_cell'>
                                                    <button id='".$existingCLRows['AGENT_ID']."' type='button' class='editRow' data-page='agents'><img src='Media/img/pencil.gif' alt='Edit'/></button>
                                                </td>
                                                <td id='Button_cell'>
                                                    <button id='".$existingCLRows['AGENT_ID']."' type='button' class='deleteRow' data-page='agents'><img src='Media/img/bin.gif' alt='Delete'/></button>
                                                </td>
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


<tr style='line-height:4px;'><td>&nbsp;</td></tr>
<!--     <tr>
        <td><h3 class="CO_Table_h3">Drugs</h3></td>
        <td class="selected_table">
            <table class="SITable temp SelTable" id="sepsis">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Item</th>
                        <th>Notes</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </td>
    </tr> --> <!-- ****************************   -->



    <tr class='CO_TableRow'>
        <td class='CO_TableCell'>
            <h3 class="CO_Table_h3">Drugs</h3>
            <div id="reset">
                <div id="accordian" class="groupsItemsList">
                    <ul class='sub-menu'>  
                        <?php
                        $query = "SELECT ID, Description FROM Groups_antibiotics WHERE ".$Mela_SQL->sqlHUMinMax("ID")." ORDER BY SortNum ASC";
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($painGroups = odbc_fetch_array($result)) {

                                        echo "<li class='category grp_list' title='".$painGroups['DESCRIPTION']."'>
                                              <h3><span><a class='category DR grp_header'>".$painGroups['DESCRIPTION']."</a></span></h3>
                                              <ul class='sub-menu'>\n";

                                        $subquery = "SELECT ID, grpID, Description FROM Items_antibiotics WHERE grpID = ".$painGroups['ID']."";
                                        $subresult = odbc_exec($connect,$subquery);
                                        while ($painItems = odbc_fetch_array($subresult)) {

                                            echo "<li class='select DR sub_item' title='".$painItems['DESCRIPTION']."'>
                                                <input type='radio' class='addRow' data-abbr='DR' data-destination='drugs' data-item_id='".$painItems['ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-group='".$painItems['DESCRIPTION']."' data-edit='y' id='DR".$painItems['ID']."' value='".$painItems['ID']."'>
                                                <label for='DR".$painItems['ID']."'>".$painItems['DESCRIPTION']."</label>
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


        <td class="selected_table">
            <table class="DRTable temp SelTable" id="careLevel">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Item</th>
                        <th>Notes</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>            
                    <?php
                        $query = "SELECT ab.ID AS ANTIBIOTICS_ID, ab.antibiotics_dlkID, ab.antibiotics_lnkID, ab.Antibiotics_Comments,
                        itm.ID AS ITMID, itm.grpID, itm.Description AS Items_Description,
                        grp.ID AS GRPID, grp.Description AS Group_Description
                        FROM Infection_Antibiotics ab
                        LEFT OUTER JOIN Items_antibiotics itm ON itm.ID = ab.ID
                        LEFT OUTER JOIN Groups_antibiotics grp ON grp.ID = itm.grpID
                        WHERE ab.antibiotics_dlkID=".$patient['DLK_ID']." AND ab.antibiotics_lnkID=".$patient['LNK_ID']."";
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($existingCLRows = odbc_fetch_array($result)) {
                                        print "<tr>
                                                <td class='cat'>".$existingCLRows['Group_Description']."</td>
                                                <td class='sel'>".$existingCLRows['Items_Description']."</td>
                                                <td id='textArea_cell'>";
                                                    $notes = $Form->textArea('DRnotes['.$existingCLRows['ANTIBIOTICS_ID'].']',''.$existingCLRows['ANTIBIOTICS_COMMENTS'].'');
                                                    print $notes;
                                         print "</td>
                                                <td id='Button_cell'>
                                                    <button id='".$existingCLRows['ANTIBIOTICS_ID']."' type='button' class='editRow' data-page='drugs'><img src='Media/img/pencil.gif' alt='Edit'/></button>
                                                </td>
                                                <td id='Button_cell'>
                                                    <button id='".$existingCLRows['ANTIBIOTICS_ID']."' type='button' class='deleteRow' data-page='drugs'><img src='Media/img/bin.gif' alt='Delete'/></button>
                                                </td>
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





    
