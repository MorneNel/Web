    <table class='CO_Table'>
        <tr class='CO_TableRow'>
            <td class='CO_TableCell'>

                <div id="reset">
                    <div id="accordian" class="groupsItemsList">	
                        <ul class='sub-menu'>
                            <?php
                            $query = "SELECT ID AS GRPID, Description FROM Groups_Med WHERE".$Mela_SQL->sqlHUMinMax("ID")." ORDER BY SortNum DESC";
                            try { 
                                $result = odbc_exec($connect,$query); 
                                if($result){ 
                                        while ($groups = odbc_fetch_array($result)) {

                                            echo    "<li title='".$groups['DESCRIPTION']."' class='category ME grp_list'>
                                                    <h3><span><a class='category ME grp_header'>".$groups['DESCRIPTION']."</a></span></h3>
                                                    <ul class='sub-menu'>\n";

                                            $subquery = "SELECT ID AS ITEM_ID, Description FROM Items_Med WHERE GrpID = ".$groups['GRPID']."";
                                            $subresult = odbc_exec($connect,$subquery);
                                            while ($painItems = odbc_fetch_array($subresult)) {

                                                echo "<li class='select ME sub_item' title='".$painItems['DESCRIPTION']."'>
                                                    <input type='radio' class='addRow' data-med='1' data-abbr='ME' data-destination='medications' data-item_id='".$painItems['ITEM_ID']."' data-lnk_ID='".$patient['LNK_ID']."' data-dlk_ID='".$patient['DLK_ID']."' data-group='".$painItems['DESCRIPTION']."' data-edit='y' id='".$painItems['ITEM_ID']."' value='".$painItems['ITEM_ID']."'>
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

<div class="medicationAccordion">

    <h3>Current Medication</h3>
    <div class="curMed_div MediAccordian">
	<table class="myContainer myContainerMedication">
	<tr>
	    <td class="myContainer_cell">
		<div class="myDiv">
		    <table class="myContent METable temp SelTable" id="tasks">
			<thead>
			    <tr>
					<th>Group</th>
					<th>Description</th>
					<th>Dose</th>
					<th>Units</th>
					<th>Frequency</th>
					<th>Route</th>
					<th>Outcome</th>
					<th>Discontinued</th>
					<th>Comments</th>
					<th class="headcol1_med"></th>
					<th class="headcol2_med"></th>
			    </tr>
			</thead>

			<tbody>            
			    <?php
				// Get arrays necessary for the dose/units/frequency etc dropdown menus
				$medUnitsDDSQL = $Mela_SQL->tbl_LoadItems('Dose Units');
				$medUnitsDDArray = array();
				for ($i = 1; $i < (count($medUnitsDDSQL)+1); $i++) {
				    array_push($medUnitsDDArray,$medUnitsDDSQL[$i]['Long_Name']);
				}
				
				$medFrequencyDDSQL = $Mela_SQL->tbl_LoadItems('Frequency');
				$medFrequencyDDArray = array();
				for ($i = 1; $i < (count($medFrequencyDDSQL)+1); $i++) {
				    array_push($medFrequencyDDArray,$medFrequencyDDSQL[$i]['Long_Name']);
				}
				
				$medRouteDDSQL = $Mela_SQL->tbl_LoadItems('Route');
				$medRouteDDArray = array();
				for ($i = 1; $i < (count($medRouteDDSQL)+1); $i++) {
				    array_push($medRouteDDArray,$medRouteDDSQL[$i]['Long_Name']);
				}
				
				$medOutcomeDDSQL = $Mela_SQL->tbl_LoadItems('Medicine Outcome');
				$medOutcomeDDArray = array();
				for ($i = 1; $i < (count($medOutcomeDDSQL)+1); $i++) {
				    array_push($medOutcomeDDArray,$medOutcomeDDSQL[$i]['Long_Name']);
				}
				
				$query = "SELECT m.itm_ID, m.med_lnkID, m.med_dlkID, m.med_Comments, m.med_Dose, m.Unit, m.med_Frequency, m.med_Route, m.Outcome, m.Duration_Time, DATE_TO_CHAR(m.End_Date,'yyyy-Mm-Dd') AS ENDDATE,
				itm.ID AS ITEM_ID, itm.GrpID, itm.Description AS Item_Description,
				grp.ID AS GRPID, grp.Description AS Group_Description
				FROM Medication m
				LEFT OUTER JOIN Items_Med itm ON itm.ID = m.itm_ID
				LEFT OUTER JOIN Groups_Med grp ON grp.ID = itm.GrpID
				WHERE m.med_dlkID=".$patient['DLK_ID']." AND m.med_lnkID=".$patient['LNK_ID']." AND m.med_Type=1";
				try { 
				    $result = odbc_exec($connect,$query); 
				    if($result){ 
					while ($existingRows = odbc_fetch_array($result)) {
					    print  "<tr>
							<td class='cat'>".$existingRows['Group_Description']."</td>
							<td class='sel'>".$existingRows['Item_Description']."</td>
							<td>".$Form->textBox('med-Dose['.$existingRows['ITM_ID'].']',$existingRows['MED_DOSE'])."</td>
							<td>".$medUnitsDD = $Form->dropDown('med-doseUnits['.$existingRows['ITM_ID'].']',$medUnitsDDArray,$medUnitsDDArray,$existingRows['UNIT'])."</td>
							<td>".$medFrequencyDD = $Form->dropDown('med-Frequency['.$existingRows['ITM_ID'].']',$medFrequencyDDArray,$medFrequencyDDArray,$existingRows['MED_FREQUENCY'])."</td>
							<td>".$medRouteDD = $Form->dropDown('med-Route['.$existingRows['ITM_ID'].']',$medRouteDDArray,$medRouteDDArray,$existingRows['MED_ROUTE'])."</td>
							<td>".$medOutcomeDD = $Form->dropDown('med-Outcome['.$existingRows['ITM_ID'].']',$medOutcomeDDArray,$medOutcomeDDArray,$existingRows['OUTCOME'])."</td>
							<td>".$Form->dateField('med-Discontinued['.$existingRows['ITM_ID'].']',stringToDateTime($existingRows['END_DATE'],2))."</td>
							<td id='textArea_cell'><span>";
							    $notes = $Form->textArea('mednotes['.$existingRows['ITM_ID'].']',''.$existingRows['MED_COMMENTS'].'','','','','gi_text','duchman');
					    print           $notes;
					    print       "</span></td>
							<td id='Button_cell' class='MedButClass'><button id='".$existingRows['ITM_ID']."' type='button' class='editRow ContentCol1_med' data-page='medications'><img src='Media/img/pencil.gif' alt='Edit'/></button></td>
							<td id='Button_cell' class='MedButClass'><button id='".$existingRows['ITM_ID']."' type='button' class='deleteRow ContentCol2_med' data-page='medications'><img src='Media/img/bin.gif' alt='Delete'/></button></td>
						   </tr>";
					}
				    } 
				    else { 
					throw new RuntimeException("Failed to connect."); 
				    } 
				} 
				catch (RuntimeException $e) { 
				    print("Exception caught: $e");
				}   
			?>
			</tbody>
		    </table>
		</div>
		<div id="col_height">&nbsp;</div>
	    </td>
	</tr>
	</table>
    </div>
    
    <h3>Prescribed Today</h3>
    <div class="preMed_div MediAccordian">
	<table class="myContainer myContainerMedication">
	<tr>
	    <td class="myContainer_cell">
		<div class="myDiv">
		    <table class="myContent PRMEDTable temp SelTable" id="tasks">
			<thead>
			    <tr>
					<th>Group</th>
					<th>Description</th>
					<th>Dose</th>
					<th>Units</th>
					<th>Frequency</th>
					<th>Route</th>
					<th>Comments</th>
					<th class="headcol1_med"></th>
					<th class="headcol2_med"></th>
			    </tr>
			</thead>

			<tbody>            
			    <?php			    
				$query = "SELECT m.itm_ID, m.med_lnkID, m.med_dlkID, m.med_Comments, m.med_Dose, m.Unit, m.med_Frequency, m.med_Route, m.Outcome, m.Duration_Time, m.End_Date,
				itm.ID AS ITEM_ID, itm.GrpID, itm.Description AS Item_Description,
				grp.ID AS GRPID, grp.Description AS Group_Description
				FROM Medication m
				LEFT OUTER JOIN Items_Med itm ON itm.ID = m.itm_ID
				LEFT OUTER JOIN Groups_Med grp ON grp.ID = itm.GrpID
				WHERE m.med_dlkID=".$patient['DLK_ID']." AND m.med_lnkID=".$patient['LNK_ID']." AND m.med_Type=2";
				try { 
				    $result = odbc_exec($connect,$query); 
				    if($result){ 
					    while ($existingRows = odbc_fetch_array($result)) {
						print "<tr>
							<td class='cat'>".$existingRows['Group_Description']."</td>
							<td class='sel'>".$existingRows['Item_Description']."</td>
							<td>".$Form->textBox('med-Dose['.$existingRows['ITM_ID'].']',$existingRows['MED_DOSE'])."</td>
							<td>".$medUnitsDD = $Form->dropDown('med-doseUnits['.$existingRows['ITM_ID'].']',$medUnitsDDArray,$medUnitsDDArray,$existingRows['UNIT'])."</td>
							<td>".$medFrequencyDD = $Form->dropDown('med-Frequency['.$existingRows['ITM_ID'].']',$medFrequencyDDArray,$medFrequencyDDArray,$existingRows['MED_FREQUENCY'])."</td>
							<td>".$medRouteDD = $Form->dropDown('med-Route['.$existingRows['ITM_ID'].']',$medRouteDDArray,$medRouteDDArray,$existingRows['MED_ROUTE'])."</td>
							<td id='textArea_cell'>";
							    $notes = $Form->textArea('premednotes['.$existingRows['ITM_ID'].']',''.$existingRows['MED_COMMENTS'].'');
							print $notes;
							print "</td>
							<td id='Button_cell' class='MedButClass'><button id='".$existingRows['ITM_ID']."' type='button' class='editRow ContentCol1_med' data-page='medications'><img src='Media/img/pencil.gif' alt='Edit'/></button></td>
							<td id='Button_cell' class='MedButClass'><button id='".$existingRows['ITM_ID']."' type='button' class='deleteRow ContentCol2_med' data-page='medications'><img src='Media/img/bin.gif' alt='Delete'/></button></td>
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
    		</div>
    		<div id="col_height">&nbsp;</div>
	    </td>
	</tr>
	</table>
    </div>

    <h3>Recommended Medication</h3>
    <div class="recMed_div MediAccordian">
    <table class="myContainer myContainerMedication">
	<tr>
	    <td class="myContainer_cell">
		<div class="myDiv">
		    <table class="myContent REMEDTable temp SelTable" id="tasks">
				<thead>
				    <tr>
						<th>Group</th>
						<th>Description</th>
						<th>Dose</th>
						<th>Units</th>
						<th>Frequency</th>
						<th>Route</th>
						<th>Comments</th>
						<th class="headcol1_med"></th>
						<th class="headcol2_med"></th>
				    </tr>
				</thead>

			<tbody>            
			    <?php
				$query = "SELECT m.itm_ID, m.med_lnkID, m.med_dlkID, m.med_Comments, m.med_Dose, m.Unit, m.med_Frequency, m.med_Route, m.Outcome, m.Duration_Time, m.End_Date,
				itm.ID AS ITEM_ID, itm.GrpID, itm.Description AS Item_Description,
				grp.ID AS GRPID, grp.Description AS Group_Description
				FROM Medication m
				LEFT OUTER JOIN Items_Med itm ON itm.ID = m.itm_ID
				LEFT OUTER JOIN Groups_Med grp ON grp.ID = itm.GrpID
				WHERE m.med_dlkID=".$patient['DLK_ID']." AND m.med_lnkID=".$patient['LNK_ID']." AND m.med_Type=3";
				try { 
				    $result = odbc_exec($connect,$query); 
				    if($result){ 
					    while ($existingRows = odbc_fetch_array($result)) {
						print "<tr>
							<td class='cat'>".$existingRows['Group_Description']."</td>
							<td class='sel'>".$existingRows['Item_Description']."</td>
							<td>".$Form->textBox('med-Dose['.$existingRows['ITM_ID'].']',$existingRows['MED_DOSE'])."</td>
							<td>".$medUnitsDD = $Form->dropDown('med-doseUnits['.$existingRows['ITM_ID'].']',$medUnitsDDArray,$medUnitsDDArray,$existingRows['UNIT'])."</td>
							<td>".$medFrequencyDD = $Form->dropDown('med-Frequency['.$existingRows['ITM_ID'].']',$medFrequencyDDArray,$medFrequencyDDArray,$existingRows['MED_FREQUENCY'])."</td>
							<td>".$medRouteDD = $Form->dropDown('med-Route['.$existingRows['ITM_ID'].']',$medRouteDDArray,$medRouteDDArray,$existingRows['MED_ROUTE'])."</td>
							<td id='textArea_cell'>";
							    $notes = $Form->textArea('premednotes['.$existingRows['ITM_ID'].']',''.$existingRows['MED_COMMENTS'].'');
							    print $notes;
							print "</td>
							<td id='Button_cell' class='MedButClass'><button id='".$existingRows['ITM_ID']."' type='button' class='editRow ContentCol1_med' data-page='medications'><img src='Media/img/pencil.gif' alt='Edit'/></button></td>
							<td id='Button_cell' class='MedButClass'><button id='".$existingRows['ITM_ID']."' type='button' class='deleteRow ContentCol2_med' data-page='medications'><img src='Media/img/bin.gif' alt='Delete'/></button></td>
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
    		</div>
    		<div id="col_height">&nbsp;</div>
	    </td>
	</tr>
	</table>
    </div>

</div>






<script>
// $(ctrl).parent('tr').next();


    $(".sel").click(function () {
        var cnt = 0;
        var CalcHeight = 124;
        
        var rows = $("#tasks tr:gt(0)"); // skip the header row

        rows.each(function() {
            cnt += 1
            $(".myContainer_cell").append("<div id='Flying_Dutchman"+cnt+"' class='FDM' value='"+cnt+"'></div>")
            var fd = "Flying_Dutchman"+cnt;
                

            var BrowserDiff = 0;
            var mBrowse = "webkit";
            var height = $(this).height()+BrowserDiff;
            alert(fd+", 9,"+CalcHeight+", "+height+", 92");
            placeDiv(fd, 9,CalcHeight, height, 92);
            CalcHeight = CalcHeight + height;

            /*drawForBrowser();*/
        });
    });



     function drawForBrowser(){
        $.browser.webkit
        $.browser.safari
        $.browser.opera
        $.browser.msie
        $.browser.mozilla

        if($.browser.msie == true) {
            var mBrowse = "IE";
            var BrowserDiff = 3
            var height = $(this).height()+BrowserDiff;
            placeDiv(12,123, height, 89);


        } else if($.browser.mozilla == true){
            var mBrowse = "FireFox";
            var BrowserDiff = 3;
            var height = $(this).height()+BrowserDiff;
            placeDiv(10,143, height, 91);


        } else if($.browser.safari == true){
            var mBrowse = "safari";
            var BrowserDiff = 3;
            var height = $(this).height()+BrowserDiff;
            placeDiv(12,123, height, 89);


        } else if($.browser.webkit == true){
            var BrowserDiff = 0;
            var mBrowse = "webkit";
            var height = $(this).height()+BrowserDiff;
            alert(fd+", 9,"+CalcHeight+", "+height+", 92");
            placeDiv(fd, 9,CalcHeight, height, 92);
            CalcHeight = CalcHeight + height;

        } else if($.browser.opera == true){
            var mBrowse = "opera";
            var BrowserDiff = 3;
        }
         // showHeight("row", $(this).height(), mBrowse);
     };


    function placeDiv(fd, x_pos, y_pos, dHeight, dWidth) {
      var d = document.getElementById(fd);
      d.style.position = "absolute";
      d.style.right = x_pos;
      d.style.top = y_pos;
      d.style.height = dHeight;
      d.style.width = dWidth;
    }
    // function showHeight(ele, h, b) {
    //   $("#col_height").text("The height for the " + ele +" is " + h + "px. Im using " + b + " as my browser.");
    // }


    // $(".cat").click(function () {
    //     // $(".myContainer_cell").append("<div id='Flying_Dutchman+"+cnt+"+'></div>")
        
    //     $.browser.webkit
    //     $.browser.safari
    //     $.browser.opera
    //     $.browser.msie
    //     $.browser.mozilla

    //     if($.browser.msie == true) {
    //         var mBrowse = "IE";
    //         var BrowserDiff = 3
    //         var height = $(this).height()+BrowserDiff;
    //         placeDiv(12,123, height, 89);
    //     } else if($.browser.mozilla == true){
    //         var mBrowse = "FireFox";
    //         var BrowserDiff = 3;
    //         var height = $(this).height()+BrowserDiff;
    //         placeDiv(10,143, height, 91);
    //     } else if($.browser.safari == true){
    //         var mBrowse = "safari";
    //         var BrowserDiff = 3;
    //         var height = $(this).height()+BrowserDiff;
    //         placeDiv(12,123, height, 89);
    //     } else if($.browser.webkit == true){
    //         var mBrowse = "webkit";
    //         var BrowserDiff = 3;
    //         var height = $(this).height()+BrowserDiff;
    //         placeDiv(9,124, height, 92);
    //     } else if($.browser.opera == true){
    //         var mBrowse = "opera";
    //         var BrowserDiff = 3;
    //     }
    //      showHeight("row", $(this).height(), mBrowse);
    // });
</script>
            </td>
        </tr>
    </table>
