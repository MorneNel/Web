<table class='CO_Table'>
    <tr class='CO_TableRow'>
        <td class='CO_TableCell'>

                <div id="reset">

    <div id="accordian" class="groupsItemsList">
        <ul class='sub-menu'>
            <?php
            $query = "SELECT ID AS GRPID, Description FROM Groups_Inv WHERE".$Mela_SQL->sqlHUMinMax("ID").
                "ORDER BY SortNum ASC";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($groups = odbc_fetch_array($result)) {

                            // echo "<li class='category IN' title='".$groups['DESCRIPTION']."'>".$groups['DESCRIPTION']."<ul>";

                            echo    "<li title='".$groups['DESCRIPTION']."' class='category grp_list'>
                                    <h3><span><a class='category IN grp_header'>".$groups['DESCRIPTION']."</a></span></h3>
                                    <ul class='sub-menu'>\n";


                            $subquery = "SELECT ID AS ITEM_ID, Description FROM Items_Inv WHERE grpID = ".$groups['GRPID']."";
                            $subresult = odbc_exec($connect,$subquery);
                            while ($painItems = odbc_fetch_array($subresult)) {



                                echo "<li class='select IN sub_item' title='".$painItems['DESCRIPTION']."'>
                                    <input type='radio' class='addRow' data-abbr='IN' data-destination='interventions' data-item_id='".$painItems['ITEM_ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-group='".$painItems['DESCRIPTION']."' data-edit='y' id='IN_".$painItems['ITEM_ID']."' value='".$painItems['ITEM_ID']."'>
                                    <label for='IN_".$painItems['ITEM_ID']."'>".$painItems['DESCRIPTION']."</label>
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

            <table class="INTable temp SelTable" id="tasks">
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
                        $query = "SELECT i.inv_ID, i.inv_dlkID, i.inv_lnkID, i.inv_Comments,
                        itm.ID AS ITEM_ID, itm.GrpID, itm.Description AS Item_Description,
                        grp.ID AS GRPID, grp.Description AS Group_Description
                        FROM Investigations i
                        LEFT OUTER JOIN Items_Inv itm ON itm.ID = i.inv_ID
                        LEFT OUTER JOIN Groups_Inv grp ON grp.ID = itm.grpID
                        WHERE i.inv_dlkID=".$patient['DLK_ID']." AND i.inv_lnkID=".$patient['LNK_ID']."";
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($existingRows = odbc_fetch_array($result)) {
                                        print "<tr>
                                                <td class='cat'>".$existingRows['Group_Description']."</td>
                                                <td class='sel'>".$existingRows['Item_Description']."</td>
                                                <td id='textArea_cell'>";
                                                    $notes = $Form->textArea('INnotes['.$existingRows['ITEM_ID'].']',''.$existingRows['INV_COMMENTS'].'','','','','gi_text');
                                                    print $notes;
                                        print "</td>
                                                    <td id='Button_cell'>
                                                        <button id='".$existingRows['ITEM_ID']."' type='button' class='editRow' data-page='interventions'><img src='Media/img/pencil.gif' alt='Edit'/></button>
                                                    </td>
                                                    <td id='Button_cell'>
                                                        <button id='".$existingRows['ITEM_ID']."' type='button' class='deleteRow' data-page='interventions'><img src='Media/img/bin.gif' alt='Delete'/></button>
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
                            }	
        	    ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>