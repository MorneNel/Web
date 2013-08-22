<td>
    <table class='CO_Table'>
        <tr class='CO_TableRow'>
            <td class='CO_TableCell'>

                    <div id="reset">

        <div id="accordian" class="groupsItemsList">
            <ul class='sub-menu'>
                <?php
                $query = "SELECT ID AS GRPID, Description FROM Groups_Surg WHERE ".$Mela_SQL->sqlHUMinMax("ID")." ORDER BY SortNum ASC";
                try { 
                    $result = odbc_exec($connect,$query); 
                    if($result){ 
    		    while ($groups = odbc_fetch_array($result)) {

    			// echo "<li class='category SU' title='".$groups['DESCRIPTION']."'>".$groups['DESCRIPTION']."<ul>";

                echo    "<li title='".$groups['DESCRIPTION']."' class='category grp_list'>
                        <h3><span><a class='category SU grp_header'>".$groups['DESCRIPTION']."</a></span></h3>
                        <ul class='sub-menu'>\n";


    			$subquery = "SELECT ID AS ITEM_ID, Description FROM Items_Surg WHERE gpsID = ".$groups['GRPID']."";
    			$subresult = odbc_exec($connect,$subquery);
    			while ($painItems = odbc_fetch_array($subresult)) {


    			    echo "<li class='select SU' title='".$painItems['DESCRIPTION']."'>
    				    <input type='radio' class='addRow' data-abbr='SU' data-destination='surgery' data-item_id='".$painItems['ITEM_ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-group='".$painItems['DESCRIPTION']."' data-edit='y' id='".$painItems['ITEM_ID']."' value='".$painItems['ITEM_ID']."'>
    					<label for='".$painItems['ITEM_ID']."'>
    					    ".$painItems['DESCRIPTION']."
    					</label>
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
                    }
                ?>
                            </ul>
                        </div>
                    </div>
                </td>

                <!--########    SELECTED ITEMS    ########-->
                <td class="selected_table">
        <table class="SUTable temp SelTable" id="tasks">
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
                    $query = "SELECT srg.srg_ID, srg.srg_lnkID, srg.srg_dlkID, srg.srg_Notes,
                    itm.ID AS ITEM_ID, itm.gpsID, itm.Description AS Item_Description,
                    grp.ID AS GROUP_ID, grp.Description AS Group_Description
                    FROM Surgery srg
                    LEFT OUTER JOIN Items_Surg itm ON itm.ID = srg.srg_ID
                    LEFT OUTER JOIN Groups_Surg grp ON grp.ID = itm.gpsID
                    WHERE srg.srg_lnkID=".$patient['LNK_ID']."";
                    try { 
                        $result = odbc_exec($connect,$query); 
                        if($result){ 
    			while ($existingRows = odbc_fetch_array($result)) {
    			    print "<tr>
        				    <td class='cat'>".$existingRows['Group_Description']."</td>
        				    <td class='sel'>".$existingRows['Item_Description']."</td>
    				        <td id='textArea_cell'>";
    					       $notes = $Form->textArea('sunotes['.$existingRows['ITEM_ID'].']',''.$existingRows['SRG_NOTES'].'');
    					 print $notes;
    				 print "</td>
    				        <td id='Button_cell'>
    					       <button id='".$existingRows['ITEM_ID']."' type='button' class='editRow' data-page='surgery'><img src='Media/img/pencil.gif' alt='Edit'/></button>
    				        </td>
    				        <td id='Button_cell'>
    					       <button id='".$existingRows['ITEM_ID']."' type='button' class='deleteRow' data-page='surgery'><img src='Media/img/bin.gif' alt='Delete'/></button>
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
    
</td>