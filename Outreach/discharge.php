<?php
    $lnk_otcID = $Form->hiddenField('lnk_otcID',$patient['LNK_OTCID']);
    echo $lnk_otcID;
?>
    <div class="Row1">
        <table>

            <tr><td colspan='2' class='linebreak_top'>Unit Discharge</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>

				<tr>
				    <td class="form_labels">Outcome</td>
				    <td>
					<?php
					    $outcomeDDSQL = $Mela_SQL->tbl_LoadItems('Outcome');
					    $outcomeDDArray = array();
					    for ($i = 1; $i < (count($outcomeDDSQL)+1); $i++) {
						array_push($outcomeDDArray,$outcomeDDSQL[$i]['Long_Name']);
					    }
		    
					    $outcomeDD = $Form->dropDown('otr-outreachDischargeOutcome',$outcomeDDArray,$outcomeDDArray,$patient['OTC_OUTCOME']);
					    echo $outcomeDD;
					?>
				    </td>
				</tr>

				<?php if ($preferences['HidePainDischStat'] == 'false') { ?>
				<tr>
				    <td>Discharge Status</td>
				    <td>
					<?php
					    $dischargeStatusDDSQL = $Mela_SQL->tbl_LoadItems('Discharge Status');
					    $dischargeStatusDDArray = array();
					    for ($i = 1; $i < (count($dischargeStatusDDSQL)+1); $i++) {
						array_push($dischargeStatusDDArray,$dischargeStatusDDSQL[$i]['Long_Name']);
					    }
		    
					    $dischargeStatusDD = $Form->dropDown('otr-outreachDischargeStatusOutcome',$dischargeStatusDDArray,$dischargeStatusDDArray,$patient['OTC_OTRDISCHARGESTATUS']);
					    echo $dischargeStatusDD;
					?>
				    </td>
				</tr>
				<?php } ?>
				
				<tr id="otr-outreachDischargeDateTR">
				    <td class="form_labels">Discharge Date</td>
				    <td>
					<?php
					    $disDischargeDate = $Form->dateField('otr-outreachDischargeDate',stringToDateTime($patient['OTC_OTRDISCHARGEDATE'],2));
					    echo $disDischargeDate."<br />";
					    echo $Form->textBox('dischargeDay','','',1);
					?>
				    </td>
				</tr>

				<?php if ($preferences['Hide Discharge Time'] == 'false') { ?>
				<tr id="otr-outreachDischargeTime">
				    <td class="form_labels">Discharge Time</td>
				    <td>
					<?php
					    $disDischargeTime = $Form->timeField('otr-outreachDischargeTime',stringToDateTime($patient['OTC_OTRDISCHARGETIME'],3));
					    echo $disDischargeTime;
					?>
				    </td>
				</tr>
				<?php } ?>

				<tr>
				    <td class="form_labels">Length of care</td>
				    <td>
					<?php
					    // Disabled form fields don't get submitted so a hidden form field is needed to submit data
					    $lengthOfCare = $Form->textBox('otr-lengthOfCare',$patient['OTC_LOS'],3,1);
					    $lengthOfCareHidden = $Form->hiddenField('otr-lengthOfCareHidden',$patient['OTC_LOS']);
					    echo $lengthOfCare." day(s)";
					    echo $lengthOfCareHidden;
					?>
				    </td>
				</tr>
				<?php if ($appName == "Outreach") { ?>
				    <?php if ($preferences['prf_OutcomeLevel2Days'] == 'true') { ?>
				    <tr>
					<td class="form_labels">No. of day(s) at level 2</td>
					<td>
					    <?php
						$noDaysLevel2 = $Form->textBox('otr-level2Days',$patient['OTC_LEVEL_2_DAYS'],3);
						echo $noDaysLevel2;
					    ?>
					</td>
				    </tr>
				    <?php } ?>
				<?php } ?>

        </table>
    </div>

    <div class="Row2" id="dis-hospitalDischarge">
        <table>
            <tr><td colspan='2' class='linebreak_top'>Hospital Discharge</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
			<tr id="dis-hospitalDischargeStatus">
		    	<td class="form_labels">Hospital discharge status</td>
			    <td>
				<?php
				    $hospitalDischargeStatusDDSQL = $Mela_SQL->tbl_LoadItems('Discharge Status');
				    $hospitalDischargeStatusDDArray = array();
				    for ($i = 1; $i < (count($hospitalDischargeStatusDDSQL)+1); $i++) {
					array_push($hospitalDischargeStatusDDArray,$hospitalDischargeStatusDDSQL[$i]['Long_Name']);
				    }
	    
				    $hospitalDischargeStatusDD = $Form->dropDown('otr-hospitalDischargeStatus',$hospitalDischargeStatusDDArray,$hospitalDischargeStatusDDArray,$patient['OTC_OTRDISCHARGESTATUS']);
				    echo $hospitalDischargeStatusDD;
				?>
			    </td>
			</tr>
		</table>
	
		<table id="dis-hospitalDischargeStatusAlive">
		    <tr>
				<td class="form_labels">Hospital Discharge Date</td>
				<td>
				    <!--<input type="date" class="FormField" name="otr-hospitalDischargeDate" value="<?php echo stringToDateTime($patient['OTC_DISCHARGEDATE'],2); ?>">-->
				    <?php
					$disHospitalDischargeDate = $Form->dateField('otr-hospitalDischargeDate',stringToDateTime($patient['OTC_DISCHARGEDATE'],2));
					echo $disHospitalDischargeDate;
				    ?>
				</td>
		    </tr>
		    <tr>
				<td class="form_labels">Hospital Discharge Time</td>
				<td>
				    <!--<input type="time" class="FormField" name="otr-hospitalDischargeTime" value="<?php echo stringToDateTime($patient['OTC_HOSPDISCHARGETIME'],3); ?>">-->
				    <?php
					$disHospitalDischargeTime = $Form->timeField('otr-hospitalDischargeTime',stringToDateTime($patient['OTC_HOSPDISCHARGETIME'],3));
					echo $disHospitalDischargeTime;
				    ?>    
				</td>
		    </tr>
		    <tr>
				<td class="form_labels">Length of Hospital Stay</td>
				<td>
				    <?php
					$lengthOfHospitalStay = $Form->textBox('otr-hospitalLengthStay',$patient['OTC_HOSPLOS'],4,1);
					echo $lengthOfHospitalStay." day(s)";
				    ?>
				</td>
		    </tr>
		    <tr>
				<td class="form_labels">Destination</td>
				<td>
				    <?php
					$destinationDDSQL = $Mela_SQL->tbl_LoadItems('Hospital Discharge Destination');
					$destinationDDArray = array();
					for ($i = 1; $i < (count($destinationDDSQL)+1); $i++) {
					    array_push($destinationDDArray,$destinationDDSQL[$i]['Long_Name']);
					}

					$destinationDD = $Form->dropDown('otr-destination',$destinationDDArray,$destinationDDArray,$patient['OTC_HOSPDISCHARGEDESTINATION']);
					echo $destinationDD;
				    ?>
				</td>
		    </tr>
        </table>
	
		<table id="dis-hospitalDischargeStatusDead">
		    <tr>
				<td class="form_labels">Death Date</td>
				<td>
				    <!--<input type="date" class="FormField" name="otr-hospitalDeathDate" value="<?php echo stringToDateTime($patient['OTC_DEATHDATE'],2); ?>">-->
				    <?php
					$disDeathDate = $Form->dateField('otr-hospitalDeathDate',stringToDateTime($patient['OTC_DEATHDATE'],2));
					echo $disDeathDate;
				    ?>
				</td>
		    </tr>
		    <tr>
				<td class="form_labels">Death Time</td>
				<td>
				    <!--<input type="time" class="FormField" name="otr-hospitalDeathTime" value="<?php echo stringToDateTime($patient['OTC_DEATHTIME'],3); ?>">-->
				    <?php
					$disDeathTime = $Form->timeField('otr-hospitalDeathTime',stringToDateTime($patient['OTC_DEATHTIME'],3));
					echo $disDeathTime;
				    ?>
				</td>
		    </tr>
		    <tr>
				<td class="form_labels">Length of Hospital Stay</td>
				<td>
				    <?php
					$lengthOfHospitalStay = $Form->textBox('otr-hospitalLengthStay',$patient['OTC_HOSPLOS'],4,1);
					echo $lengthOfHospitalStay." day(s)";
				    ?>
				</td>
		    </tr>
        </table>
    </div>
    
    <div style="clear:both;"></div>
    





    <div class="Row1">
	<table style="vertical-align: bottom;">
	    <tr><td colspan='2' class='linebreak_top'>Discharge</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
	    <tr>
		<td class="form_labels">
		    Discharge method
		</td>
		<td>
		    
		</td>
	    </tr>
	    <?php if ($appName == "Outreach") { ?>
	    <tr>
		<td class="form_labels">
		    DNR decision documented in the medical records at any time during the outreach care    
		</td>
		<td>
		    <?php
                        $DNROptions = array('Yes' => ' Yes ', 'No' => ' No ');
                        $OTCDNR = $Form->radioBox('otc-DNR',$DNROptions,''.$patient['OTC_DNR'].'','');
                        print $OTCDNR;
                    ?>    
		</td>
	    </tr>
	    <?php } ?>
	</table>

<br />


        <?php if ($appName == "Outreach") { ?>
		<table>

            <tr><td colspan='2' class='linebreak_top'>Score2Door</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>

			<tr>
			    <td class="form_labels">Triggered</td>
			    <td>
				<?php
					$scoClass = array("scoClass_Date");
				    $s2dTriggeredDate = $Form->textBox('otr-s2dTriggeredDate',$patient['SCORE_DATE'],'','',$scoClass);
				    echo $s2dTriggeredDate;
				    $scoClass = array("scoClass_Time");
				    $s2dTriggeredTime = $Form->textBox('otr-s2dTriggeredTime',convert4DTime($patient['SCORE_TIME']),'','',$scoClass);
				    echo $s2dTriggeredTime;
				?>
			    </td>
			</tr>

			<tr>
			    <td>Arrival at ICU</td>
			    <td>
				<?php
				$scoClass = array("scoClass_Date");
				    $s2dArrivalDate = $Form->textBox('otr-s2dArrivalDate',$patient['DR2SCR_ARIVE_DATE'],'','',$scoClass);
				    echo $s2dArrivalDate;
				    $scoClass = array("scoClass_Time");
				    $s2dArrivalTime = $Form->textBox('otr-s2dArrivalTime',convert4DTime($patient['DR2SCR_ARIVE_TIME']),'','',$scoClass);
				    echo $s2dArrivalTime;
				?>
			    </td>
			</tr>

			<tr>
			    <td class="form_labels">Calculated Score-2-Door</td>
			    <td>
				<?php
					$scoClass = array("scoClass_Tot");
				    $s2dTotalTime = $Form->textBox('otr-s2dTotalTime',$patient['DR2SCR_TOTAL_TIME'],'','',$scoClass);
				    echo $s2dTotalTime;
				?>
			    </td>
			</tr>

        </table>
	<?php } ?>
	
    </div>





    <div >
	<?php if ($appName == "Outreach") { ?>
		<table class='CO_Table'>
			<tr><td colspan='100' class='linebreak_top'>Score2Door - Delay Reason</td></tr>
			<!-- <tr style='line-height:4px;'><td>&nbsp;</td></tr> -->
		    <tr class='CO_TableRow'>
		        <td class='CO_TableCell'>
		            <div id="reset">
		                <div id="accordian" class="groupsItemsList">
		                    <ul class='sub-menu'>
								<?php
								$query = "SELECT ID AS GRPID, Description FROM Groups_Sco2Door WHERE".$Mela_SQL->sqlHUMinMax("ID")." ORDER BY Sort ASC";
								try { 
								    $result = odbc_exec($connect,$query); 
								    if($result){ 
									while ($groups = odbc_fetch_array($result)) {

				                        echo    "<li class='category grp_list' title='".$groups['DESCRIPTION']."'>
				                                <h3><span><a class='category S2D grp_header'>".$groups['DESCRIPTION']."</a></span></h3>
				                                <ul class='sub-menu'>\n";

									    $subquery = "SELECT ID AS ITEM_ID, Description FROM Items_Sco2Door WHERE Grp_ID = ".$groups['GRPID']."";
									    $subresult = odbc_exec($connect,$subquery);
									    while ($painItems = odbc_fetch_array($subresult)) {

		                            echo "<li class='select S2D sub_item' title='".$painItems['DESCRIPTION']."'>
		                                	<input type='radio' class='addRow' data-abbr='S2D' data-destination='score2door' data-item_id='".$painItems['ITEM_ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-group='".$painItems['DESCRIPTION']."' data-edit='n' id='S2D_".$painItems['ITEM_ID']."' value='".$painItems['ITEM_ID']."'>
		                                	<label for='S2D_".$painItems['ITEM_ID']."'>".$painItems['DESCRIPTION']."</label>
		                                	</li>\n";

									    }
									    print "</ul></li>";
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


		        <!--########    SELECTED ITEMS    #########-->
		        <td class="selected_table">

						<table class="S2DTable temp" id="tasks">
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
							    $query = "SELECT s2d.ID, s2d.Link_ID, s2d.Note,
							    itm.ID AS ITEM_ID, itm.Grp_ID, itm.Description AS Item_Description,
							    grp.ID AS GROUP_ID, grp.Description AS Group_Description
							    FROM Sco2Door_Reason s2d
							    LEFT OUTER JOIN Items_Sco2Door itm ON itm.ID = s2d.Item_ID
							    LEFT OUTER JOIN Groups_Sco2Door grp ON grp.ID = itm.Grp_ID
							    WHERE s2d.Link_ID=".$patient['LNK_ID']."";
							    try { 
								$result = odbc_exec($connect,$query); 
								if($result){ 
								    while ($existingRows = odbc_fetch_array($result)) {
									print "<tr>
											<td class='cat'>".$existingRows['Group_Description']."</td>
											<td class='sel'>".$existingRows['Item_Description']."</td>
											<td id='textArea_cell'>";
											    $notes = $Form->textArea('s2dnotes['.$existingRows['ITEM_ID'].']',''.$existingRows['COMMENTS'].'');
											    print $notes;
									print " </td>
											<td id='Button_cell'>
											    <button id='".$existingRows['ITEM_ID']."' type='button' class='deleteRow' data-page='score2door'><img src='Media/img/bin.gif' alt='Delete'/></button>
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
	<?php } ?>
    </div>

<br />

    <table>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
        <tr><td colspan='2' class='linebreak_top'>Summary</td></tr>
        <tr style='line-height:4px;'><td>&nbsp;</td></tr>

        <tr>
    		<td width="25%">
                <div class="categoryBox">
                    <?php
			$dischargeSummaryDDSQL = $Mela_SQL->tbl_LoadItems('Systems');
			$dischargeSummaryDDArray = array();
			for ($i = 1; $i < (count($dischargeSummaryDDSQL)+1); $i++) {
			    array_push($dischargeSummaryDDArray,$dischargeSummaryDDSQL[$i]['Long_Name']);
			}

			foreach($dischargeSummaryDDArray AS $row) {
				echo "<div class='tag' data-type='discharge'>
				      <label class='form_labels'>
				      ".$row."
				      </label>
				      </div>";
			}
                    ?>
                </div>
        	</td>
            	<td>
		    <div class="textbox">
			<textarea class="categoryBox_text" id="dischargeTextArea" name="otr-summary" rows="15" cols="500"><?php  ?></textarea>
		    </div>
		</td>
        	
        </tr>
	<tr>
	    <td>
		&nbsp;
	    </td>
	    <td>
		<button type='button' style='font-size:small;' id='clearDischargeSummary'>Clear field</button>
	    </td>
	</tr>
    </table>