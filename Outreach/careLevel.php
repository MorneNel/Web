<?php

if ($preferences['prf_UseCareLevelScore'] == 'true') {
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.CL').click(function() {
            var title = $(this).attr('title');
            
            if (title === 'Level 1') {
                $('#rcl-requiredCareLevel').val('1');
            }
            
            if (title === 'Level 2' || title === '2Level 2') {
                $('#rcl-requiredCareLevel').val('2');
            }
            
            if (title === 'Level 3' || title === '3Level 3') {
                $('#rcl-requiredCareLevel').val('3');
            }
        });
    });
</script>
<?php
}
?>
<table class='temp'>
    <tbody>
        <tr>
            <td>
                <?php
                    $RCLName = ($preferences['ReqdCareLevelName']) ? $preferences['ReqdCareLevelName'] : "Required care level";
                    echo $RCLName;
                ?>
            </td>
            <td>
                <?php
                    $requiredCareLevelDDSQL = $Mela_SQL->tbl_LoadItems('Care Level');
                    $requiredCareLevelDDArray = array();
                    for ($i = 1; $i < (count($requiredCareLevelDDSQL)+1); $i++) {
                        array_push($requiredCareLevelDDArray,$requiredCareLevelDDSQL[$i]['Long_Name']);
                    }
        
                    $requiredCareLevelDD = $Form->dropDown('rcl-requiredCareLevel',$requiredCareLevelDDArray,$requiredCareLevelDDArray,$patient['OTR_CARELEVEL']);
                    echo $requiredCareLevelDD;
                ?>
            </td>
            <!--<td>
                Score
            </td>
            <td>
                <?php
                    $rclScore = $Form->textBox('rcl-Score',$patient['OTR_CLSCORE']);
                    echo $rclScore;
                ?>
            </td>-->
        </tr>
    </tbody>
</table>



<br />


    <table class='CO_Table'>
        <tr class='CO_TableRow'>
            <td class='CO_TableCell'>

                <div id="reset">
                    <div id="accordian" class="groupsItemsList">
                        <ul class='sub-menu'>
            <?php
            $query = "SELECT grpCL_ID, Description FROM Grp_CL WHERE".$Mela_SQL->sqlHUMinMax("grpCL_ID")." ORDER BY SortNum DESC";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($painGroups = odbc_fetch_array($result)) {

                            // echo "<li class='category CL' title='".$painGroups['DESCRIPTION']."'>".$painGroups['DESCRIPTION']."<ul>";

                            echo    "<li title='".$painGroups['DESCRIPTION']."' class='category grp_list'>
                                    <h3><span><a class='category CL grp_header'>".$painGroups['DESCRIPTION']."</a></span></h3>
                                    <ul class='sub-menu'>\n";

                            $subquery = "SELECT itemCL_ID, Description FROM Item_CL WHERE grpCL_ID = ".$painGroups['GRPCL_ID']."";
                            $subresult = odbc_exec($connect,$subquery);
                            while ($painItems = odbc_fetch_array($subresult)) {

                                echo "<li class='select CL sub_item' title='".$painItems['DESCRIPTION']."'>
                                    <input type='radio' class='addRow' data-abbr='CL' data-item_id='".$painItems['ITEMCL_ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-destination='careLevel' data-group='".$painItems['DESCRIPTION']."' data-edit='n' id='".$painItems['ITEMCL_ID']."' value='".$painItems['ITEMCL_ID']."'>
                                    <label for='".$painItems['ITEMCL_ID']."'>".$painItems['DESCRIPTION']."</label>
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


            <!--########    SELECTED ITEMS    ########-->
            <td class="selected_table">

    <table class="CLTable temp" id="careLevel">
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
                                            $notes = $Form->textArea('clnotes['.$existingCLRows['CARELEVELITEM_ID'].']',''.$existingCLRows['NOTES'].'');
                                            print $notes;
                                        print "</td>
                                        <td id='Button_cell'><button id='".$existingCLRows['CARELEVELITEM_ID']."' type='button' class='deleteRow' data-page='careLevel'><img src='Media/img/bin.gif' alt='Delete'/></button>
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


<?php	
/*
 * This is purely for me to come back to when it comes time to
 * submit groups/items data to database upon saving notes
 *
 * Key = clnotes-CLITEM_ID
 * Val = Notes textarea data
foreach ($_POST as $key => $val) {
	    var_dump($key);
	    var_dump($val);
	    
	    print "".$key." == ".$val."<br />";
	}
}
*/
?>