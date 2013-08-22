<ul id="out">
    
</ul>
    <table class='CO_Table'>
        <tr class='CO_TableRow'>
            <td class='CO_TableCell'>

                <div id="reset">
                    <div id="accordian" class="groupsItemsList">
                        <ul class='sub-menu'>
            <?php
            $query = "SELECT ID AS GRPID, Description AS GRPDESC FROM Group_Crit_Inc WHERE".$Mela_SQL->sqlHUMinMax("ID")." ORDER BY SortNum DESC";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($painGroups = odbc_fetch_array($result)) {


                            // echo "<li class='category CI' title='".$painGroups['GRPDESC']."'>".$painGroups['GRPDESC']."<ul>";

                            echo    "<li title='".$painGroups['GRPDESC']."' class='category grp_list'>
                                    <h3><span><a class='category CI grp_header'>".$painGroups['GRPDESC']."</a></span></h3>
                                    <ul class='sub-menu'>\n";


                            $subquery = "SELECT ID AS ITMID, Description FROM Items_Crit_Inc WHERE grp_ID = ".$painGroups['GRPID']."";
                            $subresult = odbc_exec($connect,$subquery);
                            while ($painItems = odbc_fetch_array($subresult)) {


                                echo "<li class='select CI' title='".$painItems['DESCRIPTION']."'>
                                        <input type='radio' class='addRow' data-abbr='CI' data-item_id='".$painItems['ITMID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-destination='critInc' data-group='".$painGroups['GRPDESC']."' data-edit='y' id='CI_".$painItems['ITMID']."' value='".$painItems['ITMID']."'>
                                        <label for='CI_".$painItems['ITMID']."'>".$painItems['DESCRIPTION']."</label>
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
    <table class="CITable temp SelTable" id="critInc">
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
                $query = "SELECT ci.cc_ID, ci.Comments,
                itm.ID AS Item_ID, itm.Grp_ID, itm.Description AS Item_Description,
                grp.ID AS Group_ID, grp.Description AS Group_Description
                FROM Critical_Inc ci
                LEFT OUTER JOIN Items_Crit_Inc itm ON itm.ID = ci.Itm_ID
                LEFT OUTER JOIN Group_Crit_Inc grp ON grp.ID = itm.Grp_ID
                WHERE ci.cc_dlkID=".$patient['DLK_ID']." AND ci.cc_lnkID=".$patient['LNK_ID']."";
                try { 
                    $result = odbc_exec($connect,$query); 
                    if($result){ 
                            while ($existingCIRows = odbc_fetch_array($result)) {
                                print "<tr>
                                        <td class='cat'>".$existingCIRows['Group_Description']."</td>
                                        <td class='sel'>".$existingCIRows['Item_Description']."</td>
                                        <td id='textArea_cell'>";
                                            $notes = $Form->textArea('cinotes['.$existingCIRows['Item_ID'].']',''.$existingCIRows['COMMENTS'].'','','','','gi_text');
                                            print $notes;
                                        print "</td>
                                        <td id='Button_cell'>
                                            <button id='".$existingCIRows['Item_ID']."' type='button' class='editRow' data-page='critInc'><img src='Media/img/pencil.gif' alt='Edit'/></button>
                                        </td>
                                        <td id='Button_cell'>
                                            <button id='".$existingCIRows['Item_ID']."' type='button' class='deleteRow' data-page='critInc'><img src='Media/img/bin.gif' alt='Delete'/></button>
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