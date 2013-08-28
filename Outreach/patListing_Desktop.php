
<?php

// print "<a href=MelaClass/logoutAction.php>Click here to logout</a>";
print "<input type='hidden' id='userID' value='".$auth->UsrKeys->UserID."'>";
/*
 * Determines which columns to display based on the rows present in
 * PatientListing_Index. At first I tried to programmatically build
 * the SQL query but there are some awkward dependencies between
 * certain tables that made in more complicated than necessary.
 *
 * Instead, simply select all possible fields and choose which ones to hide/
 * show based on the PatientListing_Index results
 */

// This array maps ColumnName from PatientListing_Index to the field as it is identified from a 4D SQL query
$dbColumns = array(  
					 'Hospital Number' => 'DMG_HOSPITALNUMBER',
					 'First Name' => 'DMG_FIRSTNAME',
					 'Surname' => 'DMG_SURNAME',
					 'Location' => 'LNK_WARD'
		 		  );

$patListingColumns_dsktp = array(  
					 'Hospital Number',
					 'First Name',
					 'Surname',
					 'Location'
		 		  );
asort($patListingColumns_dsktp);


	print "<div class='container clearfix'>
		<div class='form'>

		<table class='list_head'>
			<tr>
				<td>
					Patient Listing
				</td>
			</tr>
		</table>


		<table class='list_nav'>
			<tr>
				<td>
					<button type='button' style='font-size:small;' id='sign-out'>Logout</button>
					<button type='button' style='font-size:small;' id='create-user'>Add new patient</button>
			    </td>
			    <td class='search_cell'>
					Search: <input type='text' name='search'>
				</td>
			</tr>
		</table>"



?>



<div id="Icon-wrapper">

        <div id="Dsk_Adm" class="Dsk_container ui-widget-content">
			<div class="dsk_head_adm">Admission</div>
            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-1">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Demographics
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-2">
                  <img src="media/images/icons/DVR3.gif"><br />
                  Referral
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Co-morbidity
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="diagnosis.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Diagnosis
                </a>
            </div>
        </div>


        <div id="Dsk_Ass" class="Dsk_container ui-widget-content">
            <div class="dsk_head_ass">Assessment</div>
            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-1">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Assess detail
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-2">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Observation
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Investigation
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="diagnosis.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Management
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="diagnosis.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Visit Outcome
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="diagnosis.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Tasks
                </a>
            </div>
        </div>


        <div id="Dsk_Out" class="Dsk_container ui-widget-content">
            <div class="dsk_head_out">Outcome</div>
            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-1">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Discharge
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR3.gif"><br />
                    Summary
                </a>
            </div>
        </div>
</div>


<?php
		print "<div id='dialog-form' title='Add new patient'>
		<p class='validateTips'>All form fields are required.</p>
	       
		    <form>
		    <fieldset>
			<label for='hospNum'>Hospital Number</label>
			<input type='text' name='hospNum' id='hospNum' class='text ui-widget-content ui-corner-all hospNo-form' />
		    </fieldset>
		    </form>
		</div>

		
		<div class='div_Listing_Content'>
		<table class='Listing_Content_desktop'>
			<tr class='desktop_summary_row'>
				<td>

			<div class='listing_div_desktop'>
					    <table class='patientselect_desktop'>
						    <thead>
								<tr class='header'>";
								    for ($i = 0; $i < count($patListingColumns_dsktp); $i++) {
								    	if($patListingColumns_dsktp[$i]=="x"){
								    		print "<th class='header_cell'></th>";
								    	} else {
								    		print "<th class='header_cell'>".$patListingColumns_dsktp[$i]."</th>";
								    	}


												
								    }
								print "</tr>
						    </thead>
					    	
					    	<tbody id='patlisting' class='desktop'>";
					    	

						$sql = "SELECT dmg.dmg_ID,
							dmg.dmg_FirstName,
							dmg.dmg_Surname,
							dmg.dmg_AgeYears,
							dmg.dmg_NHSNumber,
							dmg.dmg_HospitalNumber,
							dmg.Patient_In_Unit,
							lnk.lnk_ID,
							lnk.first_Modality,
							lnk.first_Operation,
							lnk.current_Modality,
							lnk.lnk_NextAssDate,
							lnk.lnk_NextAssTime,
							lnk.CurrentMedications,
							lnk.DaysPastOpTillDisch,
							lnk.Last_ChrAttended,
							lnk.DaysPostOpAssessment,
							lnk.CurrentCritInc,
							lnk.First_ICD10,
							adm.AdmStatus,
							adm.adm_Ward,
							adm.adm_ReferralDate,
							adm.adm_Location_bay,
							adm.adm_Location_bed,
							adm.adm_HospitalAdmission,
							adm_ResearchTag,
							adm.Hosp,
							adm.adm_Number,
							dgn.dgn_Reason1_Condition,
							otc.otc_HospDischargeDate,
							otc.otc_DeathDate,
							otc.otc_OTRDischargeDate,
							orc.Time_Of_Call
						FROM Demographic dmg
								LEFT OUTER JOIN LINK lnk ON dmg.dmg_ID = lnk.lnk_dmgID
								Right OUTER JOIN Admission adm ON adm.adm_ID = lnk.lnk_admID
								LEFT OUTER JOIN Diagnosis dgn ON dgn.dgn_ID = lnk.lnk_dgnID
								Right OUTER JOIN Outcome otc ON otc.otc_ID = lnk.lnk_otcID
								LEFT OUTER JOIN OR_Call orc ON orc.cal_ID = adm.adm_calID
						WHERE adm.AdmStatus = 'Admitted'
						AND (otc.otc_HospDischargeDate < '01/01/0001 00:00:00')
						AND (otc.otc_DeathDate < '01/01/0001 00:00:00')
						AND (otc.otc_OTRDischargeDate < '01/01/0001 00:00:00')
						AND".$Mela_SQL->sqlHUMinMax("lnk.lnk_ID").
						"ORDER BY adm.adm_Number DESC";

					$n = 1;
					try { 
					    $selectResult = odbc_exec($connect,$sql); 
						if($selectResult){ 
							while ($listingFields = odbc_fetch_array($selectResult)) {
								if ($n % 2 == 0) {
									$oddEven = 'even';
									$n++;
								} else {
									$oddEven = 'odd';
									$n++;
								}
							    print "<tr class='select data-row ".$oddEven."' data-href='patDmg.php?lnkID=".$listingFields['LNK_ID']."' data-lnkid='".$listingFields['LNK_ID']."'>";
								    for ($i = 0; $i < count($patListingColumns_dsktp); $i++) {

									    // Some fields need some extra formatting for time purposes
									    switch ($patListingColumns_dsktp[$i]) {

										case "Hospital Number":
											print "<td class='listing_cell'><div class='plCell_desktop'>
												   <input type='radio' class='' data-lnk_ID='".$listingFields['LNK_ID']."' data-group='".$listingFields[$dbColumns[$patListingColumns_dsktp[$i]]]."'>
												   <label for='".$listingFields['LNK_ID']."'>".$listingFields[$dbColumns[$patListingColumns_dsktp[$i]]]."</label>
												   </div></td>";
											break;

										case "First Name":
											print "<td class='listing_cell'><div class='plCell_desktop'>
												   <input type='radio' class='' data-lnk_ID='".$listingFields['LNK_ID']."' data-group='".$listingFields[$dbColumns[$patListingColumns_dsktp[$i]]]."'>
												   <label for='".$listingFields['LNK_ID']."'>".$listingFields[$dbColumns[$patListingColumns_dsktp[$i]]]."</label>
												   </div></td>";
											break;

										case "Surname":
											print "<td class='listing_cell'><div class='plCell_desktop'>
												   <input type='radio' class='' data-lnk_ID='".$listingFields['LNK_ID']."' data-group='".$listingFields[$dbColumns[$patListingColumns_dsktp[$i]]]."'>
												   <label for='".$listingFields['LNK_ID']."'>".$listingFields[$dbColumns[$patListingColumns_dsktp[$i]]]."</label>
												   </div></td>";
											break;

										case "Location":
											print "<td class='listing_cell'><div class='plCell_desktop'>
												   <input type='radio' class='' data-lnk_ID='".$listingFields['LNK_ID']."' data-group='".$listingFields[$dbColumns[$patListingColumns_dsktp[$i]]]."'>
												   <label for='".$listingFields['LNK_ID']."'>".$listingFields[$dbColumns[$patListingColumns_dsktp[$i]]]."</label>
												   </div></td>";
											break;

										case "Next Assessment date":
										case "Discharge Date":
										case "Hospital Admission Date":
										case "Next Assessment time":
										case "Referral Time":
										case "Location":

										default:
										    // print "<td class='listing_cell'><div class='plCell'>".$listingFields[$dbColumns[$patListingColumns_dsktp[$i]['Name']]]."</div></td>";
										break;
									    }
									
								    }			    
							    print "</tr>".PHP_EOL;
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
					    print "</tbody>
					    </table>
				    </div>

				</td>


				<td class='desktop_summary_column'>
					<div class='desktop_summary_column_div dsk_head_out'>
						Patient Overview
					</div>
				</td>
			</tr>

			<tr>
				<td colspan='2'><hr class='desktop_hr'><td>
			</tr>

			<tr class='holder_row'>
				<td colspan='2' class='page_cell'>
			 		<div class='holder_desktop'></div>
			 	</td>
			</tr>
		</table>
		</div>
		</div>
    </div>";
?>


  <script>
      $(function() {
        $( "#Dsk_Adm" ).draggable({ containment: "parent" });
        $( "#Dsk_Out" ).draggable({ containment: "parent" });
        $( "#Dsk_Ass" ).draggable({ containment: "parent" });

        $( ".Dsk_Icon" ).draggable({ containment: "parent" });
        $( ".Dsk_Icon" ).draggable({ revert: true });
      });
  </script>

