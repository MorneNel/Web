    <table class='CO_Table'>
        <tr class='CO_TableRow'>
            <td class='CO_TableCell'>

                <div id="reset">

    <div id="accordian" class="groupsItemsList">
        <ul class='sub-menu'>
            <?php
            $query = "SELECT ID AS GRPID, Description FROM Groups_DailyOutcome WHERE".$Mela_SQL->sqlHUMinMax("ID")." ORDER BY SortNum DESC";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                        while ($painGroups = odbc_fetch_array($result)) {

                            // echo "<li class='category DO' title='".$painGroups['DESCRIPTION']."'>".$painGroups['DESCRIPTION']."<ul>";

                            echo    "<li title='".$painGroups['DESCRIPTION']."' class='category grp_list'>
                                    <h3><span><a class='category DO grp_header'>".$painGroups['DESCRIPTION']."</a></span></h3>
                                    <ul class='sub-menu'>\n";

                            $subquery = "SELECT item_ID, Description FROM Items_DailyOutcome WHERE grp_ID = ".$painGroups['GRPID']."";
                            $subresult = odbc_exec($connect,$subquery);
                            while ($painItems = odbc_fetch_array($subresult)) {


                                echo "<li class='select DO sub_item' title='".$painItems['DESCRIPTION']."'>
                                      <input type='radio' class='addRow' data-abbr='DO' data-destination='dailyOutcome' data-item_id='".$painItems['ITEM_ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-group='".$painItems['DESCRIPTION']."' data-edit='n' id='DO_".$painItems['ITEM_ID']."' value='".$painItems['ITEM_ID']."'>
                                      <label for='DO_".$painItems['ITEM_ID']."'>".$painItems['DESCRIPTION']."</label>
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
    <table class="DOTable temp SelTable" id="dailyOutcome">
        <thead>
            <tr>
                <th>Group</th>
                <th>Item</th>
				<th>Date</th>
				<th>Time</th>
                <th>Notes</th>
                <th></th>
            </tr>
        </thead>
        <tbody>            
            <?php
                $query = "SELECT do.DailyOutcome_ID, do.DailyOutcome_LnkID, do.DailyOutcome_DLnkID, do.DailyOutcome_Notes,
		do.DateOf, do.TimeOf,
                itm.item_ID, itm.grp_ID, itm.Description AS Item_Description,
                grp.ID, grp.Description AS Group_Description
                FROM DailyOutcome do
                LEFT OUTER JOIN Items_DailyOutcome itm ON itm.item_ID = do.DailyOutcome_ID
                LEFT OUTER JOIN Groups_DailyOutcome grp ON grp.ID = itm.grp_ID
                WHERE do.DailyOutcome_DLnkID=".$patient['DLK_ID']." AND do.DailyOutcome_LnkID=".$patient['LNK_ID']."";
                try { 
                    $result = odbc_exec($connect,$query); 
                    if($result){ 
                            while ($existingCLRows = odbc_fetch_array($result)) {
                            	$formDODateClass = array('FormDODate');
                            	$formDOTimeClass = array('FormDOTime');
                                print "<tr>
                                        <td class='cat'>".$existingCLRows['Group_Description']."</td>
                                        <td class='sel'>".$existingCLRows['Item_Description']."</td>
										<td>".$Form->dateField('DODate['.$existingCLRows['DAILYOUTCOME_ID'].']',stringToDateTime($existingCLRows['DATEOF'],2),$formDODateClass)."</td>
										<td>".$Form->timeField('DOTime['.$existingCLRows['DAILYOUTCOME_ID'].']',convert4DTime($existingCLRows['TIMEOF']),$formDOTimeClass)."</td>
                                        <td id='textArea_cell'>";
                                            $notes = $Form->textArea('DOnotes['.$existingCLRows['DAILYOUTCOME_ID'].']',''.$existingCLRows['DAILYOUTCOME_NOTES'].'');
                                            print $notes;
                                print "</td>
                                        <td id='Button_cell'>
                                            <button id='".$existingCLRows['DAILYOUTCOME_ID']."' type='button' class='deleteRow' data-page='dailyOutcome'><img src='Media/img/bin.gif' alt='Delete'/></button>
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



<br/>
<br/>
<div style="clear: both;"></div>

<section>
    <table class='temp'>
	<tbody>
	    <!-- No need for this field according to Adam's notes -->
	    <!--<tr>
		<td>
		    GP Letter given
		</td>
		<td>
		    <?php
		    $GPLetterGivenArr = array('Yes' => ' Yes ');
		    //$GPLetterGivenRadio = $Form->checkBox('GPLetterGiven',$GPLetterGivenArr,$patient['GPLETTER_GIVEN']);
		    $GPLetterGivenRadio = $Form->checkBox('GPLetterGiven',$GPLetterGivenArr[0],'',$patient['GPLETTER_GIVEN'],'');
		    echo $GPLetterGivenRadio;
		    ?>
		</td>
	    </tr>-->
	    <tr>
		<td>
		    <?php
		    $otrActionTakenFirstLetter = $patient['OTR_ACTIONTAKEN'][0];
		    switch($otrActionTakenFirstLetter) {
			case "R":
			    $otrActionTaken = "Referred to";
			break;
		    
			case "T":
			    $otrActionTaken = "Transferred to";
			break;
		    
			case "A":
			    $otrActionTaken = "Action detail";
			break;
		    
			default:
			    $otrActionTaken = "Action detail";
			break;    
		    }
		    echo $otrActionTaken;
		    ?>
		</td>
		<td>
		    <?php
			$DOActionTakenDDSQL = $Mela_SQL->tbl_LoadItems('Action');
			$DOActionTakenDDArray = array();
			for ($i = 1; $i < (count($DOActionTakenDDSQL)+1); $i++) {
			    array_push($DOActionTakenDDArray,$DOActionTakenDDSQL[$i]['Long_Name']);
			}
	    
			$DOActionTakenDD = $Form->dropDown('do-actiontaken',$DOActionTakenDDArray,$DOActionTakenDDArray,$patient['OTR_ACTIONTAKEN']);
			echo $DOActionTakenDD;
		    ?>
		</td>
	    </tr>
	    <tr>
		<td>
		    <?php
		    // get first letter of otr_actiontaken to determine name of this field
		    $DOFirstLetter = $patient['OTR_ACTIONTAKEN'];
		    
		    switch (strtolower($DOFirstLetter[0])) {
			case "r":
			    $DOActionTakenTitle = "Referred to";
			break;
			
			case "t":
			    $DOActionTakenTitle = "Transferred to";
			break;
		    
			case "a":
			    $DOActionTakenTitle = "Action taken";
			break;
		    
			default:
			    $DOActionTakenTitle = "Action taken";
			break;
		    }
		    
		    echo "<div id='doActionTakenSublist'>$DOActionTakenTitle</div>";		    
		    ?>
		</td>
		<td>
		    <?php
			$DOActionTaken2DDSQL = $Mela_SQL->tbl_LoadItems('Action');
			$DOActionTaken2DDArray = array();
			for ($i = 1; $i < (count($DOActionTaken2DDSQL)+1); $i++) {
			    array_push($DOActionTaken2DDArray,$DOActionTaken2DDSQL[$i]['Long_Name']);
			}
	    
			$DOActionTaken2DD = $Form->dropDown('do-actiontaken2',$DOActionTaken2DDArray,$DOActionTaken2DDArray,$patient['OTR_TEAMREFERRAL']);
			echo $DOActionTaken2DD;
		    ?>    
		</td>
	    </tr>
	    <!-- No need for this field according to Adam's notes -->
	    <!--<tr>
		<td>
		    Next appointment
		</td>
		<td>
		    <?php
			$DONextAppointment = $Form->textBox('do-NextAppointment',$patient['CHR_NEXTAPPOINTMENT']);
			echo $DONextAppointment;
		    ?>
		</td>
	    </tr>-->
	    <tr>
		<td>
		    Follow up
		</td>
		<td>
		    <?php
			$DOFollowUpDDSQL = $Mela_SQL->tbl_LoadItems('Suggested Follow Up');
			$DOFollowUpDDArray = array();
			for ($i = 1; $i < (count($DOFollowUpDDSQL)+1); $i++) {
			    array_push($DOFollowUpDDArray,$DOFollowUpDDSQL[$i]['Long_Name']);
			}
	    
			$DOFollowUpDD = $Form->dropDown('do-followup',$DOFollowUpDDArray,$DOFollowUpDDArray,$patient['OTR_SUGGESTEDNEXTASSESS']);
			echo $DOFollowUpDD;
		    ?>    
		</td>
	    </tr>
	    <?php if ($appName == "Outreach") { ?>
		<tr>
		    <td>
			Level of care recommended
		    </td>
		    <td>
			<?php
			    $DOLevelOfCareDDSQL = $Mela_SQL->tbl_LoadItems('Care Level');
			    $DOLevelOfCareDDArray = array();
			    for ($i = 1; $i < (count($DOLevelOfCareDDSQL)+1); $i++) {
				array_push($DOLevelOfCareDDArray,$DOLevelOfCareDDSQL[$i]['Long_Name']);
			    }
			    $DOLevelOfCareDD = $Form->dropDown('do-levelofcare',$DOLevelOfCareDDArray,$DOLevelOfCareDDArray,$patient['OUT_LEVEL_CARE']);
			    echo $DOLevelOfCareDD;
			?>    
		    </td>
		</tr>
	    <?php } ?>
	</tbody>
    </table>
</section>