<script type="text/javascript">
    $(document).ready(function(){
	$('#example').tablesorter({  });
	
        $('tbody tr[data-href] td:not(:last-child)').hover( function() { 
           $(this).css('cursor','pointer');
        });
        
        /*$('tbody tr[data-href] td:not(:last-child)').click( function() { 
            if (!$('td').hasClass("noClick")) {
                window.location = $(this).attr('data-href');
            }
        });*/
        
        jQuery.expr[':'].contains = function(a,i,m){
	    return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
	};
        
        $('input[name="search"]').keyup(function(event){ 
		
	var searchterm = $(this).val();
	
	if(searchterm.length > 2) {
		var match = $('tr.data-row:contains("' + searchterm + '")');
		var nomatch = $('tr.data-row:not(:contains("' + searchterm + '"))');
		//match.children().addClass('selected-cell');
		match.addClass('selected');
		nomatch.css("display", "none");
	} else {
		$('tr.data-row').css("display", "");
		$('tr.data-row').removeClass('selected');
		//$('tr.data-row td').removeClass('selected-cell');
	}
    });
    });
</script>

<!-- Add new assessment button and form -->
<!-- <div class='list_nav'>
    <button type='button' style='font-size:small;' id='addNewAssessment' style='margin-bottom:5px;'>Add new assessment</button>
    Search: <input type='text' name='search'>
</div> -->

<table class='list_nav'>
    <tr>
        <td>
            <button type='button' style='font-size:small;' id='addNewAssessment' style='margin-bottom:5px;'>Add new assessment</button>
        </td>
        <td class='search_cell'>
            Search: <input type='text' name='search'>
        </td>
    </tr>
</table>






<div id='addNewAssessmentForm' title='Add new assessment'>
<!--     <form> -->
<!--         <fieldset> -->
            <label for='newassDate'>Date</label>
            <input type='date' name='newassDate' id='newassDate' class='text ui-widget-content ui-corner-all' />
            <input type='hidden' name='newAssessment_lnkID' id='newAssessment_lnkID' value='<?php echo $patient['LNK_ID']; ?>'>
            <br />
            <label for='newassTime'>Time</label>
            <input type='time' name='newassTime' id='newassTime' class='text ui-widget-content ui-corner-all' />
            <br />
            <br />
            <label for='newassDaysRef'>Day(s) since referral</label>
            <input type='text' name='newassDaysRef' id='newassDaysRef' class='text ui-widget-content ui-corner-all' />
<!--         </fieldset> -->
<!--     </form> -->
</div>




<!-- End add new assessment button and form-->
<table id="example" class="pl_class" style="margin-top: 15px;">
    <thead>
        <tr>
            <th class="pl_header"><p><a href="#">Assessment Date</a></p></th>
            <th class="pl_header"><p><a href="#">Start Time</a></p></th>
            <th class="pl_header"><p><a href="#">End Time</a></p></th>
            <th class="pl_header"><p><a href="#">Duration</a></p></th>
            <th class="pl_header"><p><a href="#">Location</a></p></th>
            <th class="pl_header"><p><a href="#">Follow-Up</a></p></th>
            <?php if ($appName == "AcutePain") { ?>
                <th class="pl_header"><p><a href="#">Appointment Type</a></p></th>
                <th class="pl_header"><p><a href="#">Visit Type</a></p></th>
            <?php } ?>
            <th class="pl_header"><p><a href="#">Tags</a></p></th>
            <th class="pl_header"><p><a href="#">Assessment Reason</a></p></th>
            <th class="pl_header"><p><a href="#"></a></p></th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Get assessment details for selected patient
        $query = "SELECT dlk.dlk_ID, dlk.dlk_lnkID, dlk.dlk_AssessDate, dlk.dlk_AssessStartTime, dlk.dlk_AssessEndTime, dlk.dlk_AssessDuration, dlk.AssessReason,
                  otr.otr_Ward, otr.otr_SuggestedNextAssess, otr.ResearchTag , otr.chr_AppointmentType, otr.chr_VisitType 
                  FROM DAILY_LINK dlk
                  LEFT OUTER JOIN Outreach otr ON dlk.dlk_otrID=otr.otr_ID
                  WHERE dlk.dlk_lnkID=".$patient['LNK_ID']."";
        try { 
            $assessmentResult = odbc_exec($connect,$query); 
            if($assessmentResult){ 
                    while ($assessments = odbc_fetch_array($assessmentResult)) {
                      echo "<tr class='assessments data-row' data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>
                                <td data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>".substr($assessments['DLK_ASSESSDATE'],0,-9)."</td>
                                <td data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>".convert4DTime($assessments['DLK_ASSESSSTARTTIME'])."</td>
                                <td data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>".convert4DTime($assessments['DLK_ASSESSENDTIME'])."</td>
                                <td data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>".convert4DTime($assessments['DLK_ASSESSDURATION'])."</td>
                                <td data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>".$assessments['OTR_WARD']."</td>
                                <td data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>".$assessments['OTR_SUGGESTEDNEXTASSESS']."</td>";
                                
                                if ($appName == "AcutePain") {
                                    print "<td data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>".$assessments['CHR_APPOINTMENTTYPE']."</td>
                                    <td data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>".$assessments['CHR_VISITTYPE']."</td>";
                                }
        
                                print "<td data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>".$assessments['RESEARCHTAG']."</td>
                                <td data-href='assessment.php?lnkID=".$patient['LNK_ID']."&assessment=".$assessments['DLK_ID']."'>".$assessments['ASSESSREASON']."</td>
                                <td class='noClick'><button type='button' class='deleteAssessment' data-dlkid='".$assessments['DLK_ID']."'><img src='Media/img/bin.gif' alt='Delete'/></button></td>
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



