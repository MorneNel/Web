    <table class='TA_Table'>
        <tr class='TA_TableRow'>
            <td class='TA_TableCell'>

                <div id="reset">

    <div id="accordian" class="groupsItemsList">
        <ul class='sub-menu'>
            <?php
            $query = "SELECT ID AS GRPID, Description FROM Groups_Tasks WHERE ".$Mela_SQL->sqlHUMinMax("ID")." ORDER BY SortNum DESC";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($groups = odbc_fetch_array($result)) {

                            // echo "<li class='category TA' title='".$groups['DESCRIPTION']."'>".$groups['DESCRIPTION']."<ul>";

                            echo    "<li title='".$groups['DESCRIPTION']."' class='category grp_list'>
                                    <h3><span><a class='category TA grp_header'>".$groups['DESCRIPTION']."</a></span></h3>
                                    <ul class='sub-menu'>\n";

                            $subquery = "SELECT ID AS ITEM_ID, Description FROM Items_Tasks WHERE GrpID = ".$groups['GRPID']."";
                            $subresult = odbc_exec($connect,$subquery);
                            while ($painItems = odbc_fetch_array($subresult)) {

                                echo "<li class='select TA sub_item' title='".$painItems['DESCRIPTION']."'>
                                      <input type='radio' class='addRow' data-abbr='TA' data-destination='tasks' data-item_id='".$painItems['ITEM_ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-group='".$painItems['DESCRIPTION']."' data-edit='y' id='TA_".$painItems['ITEM_ID']."' value='".$painItems['ITEM_ID']."'>
                                      <label for='TA_".$painItems['ITEM_ID']."'>".$painItems['DESCRIPTION']."</label>
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

    <table class="TATable temp SelTable" id="tasks">
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
                $query = "SELECT t.ItmID, t.ID, t.LnkID, t.DLnkID, t.Comments,
                itm.ID AS ITEM_ID, itm.GrpID, itm.Description AS Item_Description,
                grp.ID AS GRPID, grp.Description AS Group_Description
                FROM Tasks t
                LEFT OUTER JOIN Items_Tasks itm ON itm.ID = t.ItmID
                LEFT OUTER JOIN Groups_Tasks grp ON grp.ID = itm.GrpID
                WHERE t.DLnkID=".$patient['DLK_ID']." AND t.LnkID=".$patient['LNK_ID']."";
                try { 
                    $result = odbc_exec($connect,$query); 
                    if($result){ 
                            while ($existingRows = odbc_fetch_array($result)) {
                                print "<tr>
                                        <td class='cat'>".$existingRows['Group_Description']."</td>
                                        <td class='sel'>".$existingRows['Item_Description']."</td>
                                        <td id='textArea_cell'>";
                                            $notes = $Form->textArea('TAnotes['.$existingRows['ITMID'].']',''.$existingRows['COMMENTS'].'');
                                            print $notes;
                                print "</td>
                                        <td id='Button_cell'>
                                            <button id='".$existingRows['ITMID']."' type='button' class='editRow' data-page='tasks'><img src='Media/img/pencil.gif' alt='Edit'/></button>
                                        </td>
					                    <td id='Button_cell'>
                                            <button id='".$existingRows['ITMID']."' type='button' class='deleteRow' data-page='tasks'><img src='Media/img/bin.gif' alt='Delete'/></button>
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