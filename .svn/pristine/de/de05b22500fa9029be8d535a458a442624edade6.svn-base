    <table class='CO_Table'>
        <tr class='CO_TableRow'>
            <td class='CO_TableCell'>

                <div id="reset">
                    <div id="accordian" class="groupsItemsList">
                        <ul class='sub-menu'>

                            <?php
                            $query = "SELECT ID AS GRPID, Description FROM Groups_com WHERE".$Mela_SQL->sqlHUMinMax("ID")." ORDER BY SortNum DESC";
                            try { 
                                $result = odbc_exec($connect,$query); 
                                if($result){ 
                		    while ($groups = odbc_fetch_array($result)) {


                            // echo    "<li class='grp_list category CO' title='".$groups['DESCRIPTION']."'>
                            //         <h3><span><a class='CO category2 grp_header'>".$groups['DESCRIPTION']."</a></span></h3>";

                            echo    "<li title='".$groups['DESCRIPTION']."' class='category grp_list'>
                                    <h3><span><a class='category CO grp_header'>".$groups['DESCRIPTION']."</a></span></h3>
                                    <ul class='sub-menu'>\n";


                			$subquery = "SELECT ID AS ITEM_ID, Description FROM Items_com WHERE grpID = ".$groups['GRPID']."";
                			$subresult = odbc_exec($connect,$subquery);
                			while ($painItems = odbc_fetch_array($subresult)) {


                			    echo "<li class='select CO sub_item' title='".$painItems['DESCRIPTION']."'>
                				    <input type='radio' class='addRow' data-abbr='CO' data-destination='comorbidity' data-item_id='".$painItems['ITEM_ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-group='".$painItems['DESCRIPTION']."' data-edit='n' id='".$painItems['ITEM_ID']."' value='".$painItems['ITEM_ID']."'>
                					<label for='".$painItems['ITEM_ID']."'>".$painItems['DESCRIPTION']."</label>
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

                <table class="COTable temp SelTable" id="tasks">
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
                                /*var_dump($patient);*/

                                $query = "SELECT m.com_ID, m.lnk_ID, m.com_Notes,
                                itm.ID AS ITEM_ID, itm.grpID, itm.Description AS Item_Description,
                                grp.ID AS GROUP_ID, grp.Description AS Group_Description
                                FROM Co_Morbidity m
                                LEFT OUTER JOIN Items_com itm ON itm.ID = m.com_ID
                                LEFT OUTER JOIN Groups_com grp ON grp.ID = itm.grpID
                                WHERE m.lnk_ID=".$patient['LNK_ID']."";
                                try { 
                                    $result = odbc_exec($connect,$query); 
                                    if($result){ 
                            while ($existingRows = odbc_fetch_array($result)) {
                            print  "<tr>
                                     
                                        <td class='cat'>".$existingRows['Group_Description']."</td>
                                        <td class='sel'>".$existingRows['Item_Description']."</td>
                                        <td id='textArea_cell'>";
                                            $notes = $Form->textArea('COnotes['.$existingRows['ITEM_ID'].']',''.$existingRows['COM_NOTES'].'','','','','gi_text');
                                            print $notes;
                            print      "</td>
                                        <td id='Button_cell'>
                                            <button id='".$existingRows['ITEM_ID']."' type='button' class='deleteRow' data-page='comorbidity'><img src='Media/img/bin.gif' alt='Delete'/></button>
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



